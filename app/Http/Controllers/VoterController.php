<?php

namespace App\Http\Controllers;

use App\Mail\MailPassword;
use App\Models\BEMCandidate;
use App\Models\DPMCandidate;
use App\Models\Setting;
use App\Models\User as Voter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class VoterController extends Controller
{
    public function import(Request $request) {
        $val = Validator::make($request->all(), [
            "voters" => "required|json"
        ],[
            "voters.required" => "Kolom voters wajib di isi.",
            "voters.json" => "Konten yang anda masukkan bukan json.",
        ]);
        if ($val->fails()) {
            return response()->json([
                "message" => "Invalid field",
                "body" => $val->errors(),
            ], 403);
        }
        $voters = json_decode($request->voters, true);
        $rows = [];

        foreach ($voters as $v) {
            $voter = new Voter();
            $voter->nama = $v['nama'];
            $voter->nim = $v['nim'];
            $voter->email = $v['email'];
            $voter->jurusan = $v['jurusan'];
            $voter->save();
            $rows[] = $voter;
        }

        return response()->json([
            "message" => "Data berhasil di import",
            "body" => $rows,
        ]);
    }

    public function reset() {
        foreach (Voter::all() as $v) $v->delete();
        return response()->json([
            "message" => "Data berhasil di reset",
            "body" => null,
        ]);
    }

    public function broadcastPassword(Request $request) {
        if ($request->jurusan) {
            $voters = Voter::where('jurusan', $request->jurusan)->get();
        }else {
            $voters = Voter::all();
        }
        foreach ($voters as $v) {
            $password = $this->getPassword();
            $v->password = Hash::make($password);
            $v->save();
            $data = $v->toArray();
            $data['password'] = $password;
            Mail::to($v->email)->send(new MailPassword($data));
        }
        return response()->json([
            "message" => "Password berhasil di broadcast",
            "body" => null,
        ]);
    }

    private function getPassword($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function voteBem(Request $request, $nomor_urut) {
        $candidate = BEMCandidate::where('nomor_urut', $nomor_urut)->first();
        if ($candidate) {
            $voter = Voter::find(Auth::user()->id);
            if ($voter) {
                if (is_null($voter->cbem_id)) {
                    $voter->cbem_id = $candidate->id;
                    $voter->save();
                    return redirect()->route('home');
                }
                return redirect()->route('votedpm')->with("response", [
                    "message" => "Anda sudah melakukan pencoblosan ini",
                ]);
            }
            return redirect()->route('votedpm')->with("response", [
                "message" => "Anda tidak memiliki hak memilih",
            ]);
        }
        return redirect()->route('votedpm')->with("response", [
            "message" => "Kandidat tidak ditemukan",
        ]);
    }
    
    public function voteDpm(Request $request, $nomor_urut) {
        $candidate = DPMCandidate::where('nomor_urut', $nomor_urut)->first();
        if ($candidate) {
            $voter = Voter::find(Auth::user()->id);
            if ($voter) {
                if (is_null($voter->cdpm_id)) {
                    $voter->cdpm_id = $candidate->id;
                    $voter->save();
                    return redirect()->route('votebem');
                }
                return redirect()->route('votedpm')->with("response", [
                    "message" => "Anda sudah melakukan pencoblosan ini",
                ]);
            }
            return redirect()->route('votedpm')->with("response", [
                "message" => "Anda tidak memiliki hak memilih",
            ]);
        }
        return redirect()->route('votedpm')->with("response", [
            "message" => "Kandidat tidak ditemukan",
        ]);
    }
    
    public function logout(Request $request) {
        $voter = Voter::find(Auth::user()->id);
        $voter->login_at = null;
        $voter->save();
        Auth::logout();
        return redirect()->route('home');
    }
}
