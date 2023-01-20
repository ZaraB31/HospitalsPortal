<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use File;
use App\Models\Download;
use App\Models\Test;

class DownloadController extends Controller
{
    public function downloadTest($id) {
        $test = Test::findOrFail($id);
        $userID = Auth()->user()->id;
        $boardID = $test['board_id'];

        Download::create(['user_id' => $userID,
                          'test_id' => $id]);
        
        $file = $test['file'];
        $filePath = public_path('/tests/'.$file);

        return redirect()->route('showBoard', $boardID)->Response()->download($filePath);
    }
}
