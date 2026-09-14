<?php

namespace App\Http\Controllers;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Response;

class CaptchaController extends Controller
{
    public function generate(): Response
    {
        $phraseBuilder = new PhraseBuilder(5, 'abcdefghjkmnpqrstuvwxyz23456789');
        $captcha = new CaptchaBuilder(null, $phraseBuilder);
        $captcha->setBackgroundColor(255, 255, 255);
        $captcha->build(150, 50);

        session(['captcha_code' => strtolower($captcha->getPhrase())]);

        return response($captcha->get(), 200, ['Content-Type' => 'image/jpeg']);
    }
}
