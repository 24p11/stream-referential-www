<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Log;

class LogController extends Controller
{
    public function log()
    {
        $logs = Log::orderBy('created_at', 'desc')->simplePaginate(250);
        return view('admin.log.log', [
            'logs' => $logs
        ]);
    }
}
