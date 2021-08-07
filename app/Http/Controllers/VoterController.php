<?php

namespace App\Http\Controllers;

use App\Mail\MailPassword;
use App\Models\BEMCandidate;
use App\Models\DPMCandidate;
use App\Models\Setting;
use App\Models\Voter;
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
            $voter = $request->attributes->get('voter');
            if ($voter) {
                if (is_null($voter->cbem_id)) {
                    $voter->cbem_id = $candidate->id;
                    $voter->save();
                    return response()->json([
                        "message" => "Anda berhasil memilih",
                        "body" => null,
                    ]);
                }
                return response()->json([
                    "message" => "Anda sudah melakukan pencoblosan ini",
                    "body" => null,
                ], 403);
            }
            return response()->json([
                "message" => "Anda tidak memiliki hak memilih",
                "body" => null,
            ], 404);
        }
        return response()->json([
            "message" => "Kandidat tidak ditemukan",
            "body" => null,
        ], 404);
    }
    
    public function voteDpm(Request $request, $nomor_urut) {
        $candidate = DPMCandidate::where('nomor_urut', $nomor_urut)->first();
        if ($candidate) {
            $voter = $request->attributes->get('voter');
            if ($voter) {
                if (is_null($voter->cdpm_id)) {
                    $voter->cdpm_id = $candidate->id;
                    $voter->save();
                    return response()->json([
                        "message" => "Anda berhasil memilih",
                        "body" => null,
                    ]);
                }
                return response()->json([
                    "message" => "Anda sudah melakukan pencoblosan ini",
                    "body" => null,
                ], 403);
            }
            return response()->json([
                "message" => "Anda tidak memiliki hak memilih",
                "body" => null,
            ], 404);
        }
        return response()->json([
            "message" => "Kandidat tidak ditemukan",
            "body" => null,
        ], 404);
    }

    public function login(Request $request) {
        $val = Validator::make($request->all(), [
            "nim" => "required",
            "password" => "required",
        ]);
        if ($val->fails()) {
            return response()->json([
                "message" => "Invalid field",
                "body" => $val->errors(),
            ], 403);
        }

        $voter = Voter::where('nim', $request->nim)->first();
        if (password_verify($request->password, $voter->password)) {
            $setting = Setting::where('key', 'start_voting')->first();
            if (time() > (int) $setting->value) {
                if (is_null($voter->login_token)) {
                    $phase = 0;
                    if (!is_null($voter->cdpm_id)) $phase = 1;
                    else if (!is_null($voter->cbem_id)) $phase = 2;
                    
                    if ($phase < 2) {
                        $token = hash('md5', time().$voter->nim);
                        $voter->login_token = $token;
                        $voter->save();

                        return response()->json([
                            "message" => "Login berhasil",
                            "body" => [
                                "nim" => $voter->nim,
                                "token" => $token,
                                "expired_at" => time() + (60*10), // 10 menit
                                "phase" => $phase,
                            ]
                        ]);
                    }
                    return response()->json([
                        "message" => "Anda telah melakukan semua pencoblosan.",
                        "body" => null
                    ], 403);
                }
                return response()->json([
                    "message" => "Akun anda sedang aktif.",
                    "body" => null
                ], 403);
            }
            return response()->json([
                "message" => "Untuk saat ini login ditutup.",
                "body" => null
            ], 403);
        }
        return response()->json([
            "message" => "Maaf anda belum mempunyai hak pilih.",
            "body" => null
        ], 401);
    }

    public function logout(Request $request) {
        $voter = $request->attributes->get('voter');
        $voter->login_token = null;
        $voter->save();
        return response()->json([
            "message" => "Berhasil logout.",
            "body" => null
        ]);
    }
}
