<?php

use App\Models\StellaInstallationManualModel;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('stella-installation:store-photos {id}', function (string $id)
{
    if (!ctype_digit($id))
    {
        $this->line('FAILED invalid id');

        return 1;
    }

    $installation = StellaInstallationManualModel::find((int) $id);

    if (!$installation)
    {
        $this->line('FAILED not found');

        return 1;
    }

    try
    {
        $this->line('OK ' . $installation->storeTelegramPhotos());

        return 0;
    }
    catch (Throwable $error)
    {
        Log::error('stella-installation:store-photos ' . $id . ' gagal', ['error' => $error->getMessage()]);
        $this->line('FAILED store photos');

        return 1;
    }
})->purpose('Unduh foto Telegram Stella Installation, enkripsi AES-256, simpan sebagai .txt');
