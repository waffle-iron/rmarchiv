<?php

/*
 * rmarchiv.de
 * (c) 2016-2017 by Marcel 'ryg' Hering
 */

namespace App\Http\Controllers;

use App\Models\Shoutbox;
use App\Notifications\ShoutBoxNotification;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index()
    {
        //'token' => 'MjgzOTU3MzExMDYyNTQwMjg4.C48pjA._BS4vqj6a-DFIFOntDAkSx1A-GM',

    }

    public function webhook()
    {
        $updates = \Telegram::getWebhookUpdates();
    }
}
