<?php

namespace App\Http\Controllers;

use App\Models\BEMCandidate;
use App\Models\DPMCandidate;
use App\Models\Voter;
use Illuminate\Http\Request;

class QuickCountController extends Controller
{
    public function index(Request $request) {
        if ($request->jurusan) {
            $voters = Voter::where('jurusan', $request->jurusan)->select('cdpm_id', 'cbem_id')->get()->toArray();
        }else {
            $voters = Voter::select('cdpm_id', 'cbem_id')->get()->toArray();
        }

        $dpmCadidates = DPMCandidate::all()->toArray();
        $dpmHasVote = 0;
        foreach($dpmCadidates as $i => $v) {
            $count = 0;
            foreach ($voters as $voter) if ($voter['cdpm_id'] == $v['id']) $count++;
            $dpmCadidates[$i]['voters'] = $count;
            $dpmHasVote += $count;
        }
        
        $bemCadidates = BEMCandidate::all()->toArray();
        $bemHasVote = 0;
        foreach($bemCadidates as $i => $v) {
            $count = 0;
            foreach ($voters as $voter) {
                if ($voter['cbem_id'] == $v['id']) $count++;
            };
            $bemCadidates[$i]['voters'] = $count;
            $bemHasVote += $count;
        }

        $data = [
            "dpm" => [
                "candidates" => $dpmCadidates,
                "hasVotes" => $dpmHasVote,
            ],
            "bem" => [
                "candidates" => $bemCadidates,
                "hasVotes" => $bemHasVote,
            ],
            "voters" => count($voters),
        ];
        return response()->json([
            "message" => "Data Quickcount",
            "body" => $data,
        ]);
    }
}
