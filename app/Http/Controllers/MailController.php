<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\NewTest;

class MailController extends Controller
{
    public function index()
    {
        $data = [
            'name' => 'Test Email'
        ];

        Mail::to('zara.bostock@mega-electrical.co.uk')->send(new NewTest($data));
    }
}
