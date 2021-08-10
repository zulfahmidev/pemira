<?php

namespace App\Http\Controllers;

use App\Models\BEMCandidate;
use App\Models\DPMCandidate;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home() {
        $start = (int) Setting::where('key', 'start_voting')->first()->value;
        $end = (int) Setting::where('key', 'end_voting')->first()->value;
        $data['start'] = $start;
        $data['end'] = $end;
        return view('index', $data);
    }
    
    public function voteBem() {
        $data['cadidates'] = BEMCandidate::all();
        return view('votebem', $data);
    }

    public function voteDPM() {
        $data['cadidates'] = DPMCandidate::all();
        return view('votedpm', $data);
    }
    
}
