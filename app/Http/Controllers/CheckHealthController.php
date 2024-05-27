<?php

namespace App\Http\Controllers;

class CheckHealthController extends Controller
{
    public function index(): array
    {
        return [
            'status' => 'ok',
            /** @var string(datetime) $timestamp the timestamp when the request is made. */
            'timestamp' => now(),
        ];
    }
}
