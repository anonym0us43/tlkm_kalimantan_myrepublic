<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class StellaInstallationManualModel extends Model
{
    protected $table = 'tb_stella_installation_manual';

    const PHOTO_DIRECTORY = 'stella_installation';

    const ALLOWED_PHOTO_MIME_TYPES = ['image/jpeg', 'image/png', 'image/webp'];

    public $timestamps = false;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'photo_file_ids' => 'array',
            'photo_paths'    => 'array',
        ];
    }

    public function storeTelegramPhotos(): int
    {
        $botToken = DB::table('tb_helpdesk_mora_config')->where('name', 'bot_token')->value('value');

        if (!$botToken)
        {
            throw new RuntimeException('Bot token belum diset di tb_helpdesk_mora_config.');
        }

        $photoDirectory = self::PHOTO_DIRECTORY . '/' . $this->id;
        $storedPaths = [];

        foreach (array_values($this->photo_file_ids ?? []) as $index => $telegramFileId)
        {
            $photoBytes = self::downloadTelegramFile($botToken, $telegramFileId);
            $photoPath = $photoDirectory . '/photo_' . str_pad($index + 1, 2, '0', STR_PAD_LEFT) . '.txt';

            if (!Storage::disk('local')->put($photoPath, Crypt::encryptString($photoBytes)))
            {
                throw new RuntimeException('Gagal menulis ' . $photoPath);
            }

            $storedPaths[] = $photoPath;
        }

        $this->photo_paths = $storedPaths;
        $this->save();

        return count($storedPaths);
    }

    public function decryptPhoto(int $photoNumber): string
    {
        $photoPath = ($this->photo_paths ?? [])[$photoNumber - 1] ?? null;

        if (!$photoPath)
        {
            throw new RuntimeException('Foto ke-' . $photoNumber . ' tidak ada.');
        }

        return Crypt::decryptString(Storage::disk('local')->get($photoPath));
    }

    public function decryptPhotoAsDataUri(int $photoNumber): string
    {
        $photoBytes = $this->decryptPhoto($photoNumber);
        $mimeType = (new \finfo(FILEINFO_MIME_TYPE))->buffer($photoBytes);

        return 'data:' . $mimeType . ';base64,' . base64_encode($photoBytes);
    }

    private static function downloadTelegramFile(string $botToken, string $telegramFileId): string
    {
        if (!preg_match('/^[A-Za-z0-9_\-]{10,200}$/', $telegramFileId))
        {
            throw new RuntimeException('file_id Telegram tidak valid.');
        }

        $fileInfo = Http::timeout(30)
            ->get('https://api.telegram.org/bot' . $botToken . '/getFile', ['file_id' => $telegramFileId])
            ->throw()
            ->json('result.file_path');

        if (!is_string($fileInfo) || !preg_match('/^[A-Za-z0-9_\-\/]+\.[A-Za-z0-9]{2,5}$/', $fileInfo) || str_contains($fileInfo, '..'))
        {
            throw new RuntimeException('file_path Telegram tidak valid.');
        }

        $photoBytes = Http::timeout(60)
            ->get('https://api.telegram.org/file/bot' . $botToken . '/' . $fileInfo)
            ->throw()
            ->body();

        $mimeType = (new \finfo(FILEINFO_MIME_TYPE))->buffer($photoBytes);

        if (!in_array($mimeType, self::ALLOWED_PHOTO_MIME_TYPES, true))
        {
            throw new RuntimeException('File Telegram bukan foto (' . $mimeType . ').');
        }

        return $photoBytes;
    }
}
