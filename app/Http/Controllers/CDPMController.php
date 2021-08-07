<?php

namespace App\Http\Controllers;

use App\Models\DPMCandidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CDPMController extends Controller
{
    public function index() {
        $candidates = DPMCandidate::all()->toArray();
        return response()->json([
            "message" => "Daftar Calon DPM",
            "body" => $candidates,
        ]);
    }

    public function show($nomor_urut) {
        $cadidate = DPMCandidate::where('nomor_urut', $nomor_urut)->first();
        if ($cadidate) {
            return response()->json([
                "message" => "Calon DPM nomor urut $nomor_urut",
                "body" => $cadidate->toArray(),
            ]);
        }
        return response()->json([
            "message" => "Calon DPM nomor urut $nomor_urut tidak ditemukan",
            "body" => null,
        ], 404);
    }

    public function store(Request $request) {
        $val = Validator::make($request->all(), [
            "nomor_urut" => "required|unique:dpm_cadidates,nomor_urut",
            "nama_ketua" => "required",
            "foto_ketua" => "required|image",
            "description" => "required",
        ], [
            "nomor_urut.required" => "Kolom nomor_urut harus di isi.",
            "nomor_urut.unique" => "Nomor urut ini sudah terpakai.",
            "nama_ketua.required" => "Kolom nama_ketua harus di isi.",
            "foto_ketua.required" => "Kolom foto_ketua harus di isi.",
            "description.required" => "Kolom deskripsi harus di isi.",
        ]);

        if ($val->fails()) {
            return response()->json([
                "message" => "Invalid field",
                "body" => $val->errors(),
            ], 403);
        }

        if (!($foto_ketua = $this->uploadImage($request, "foto_ketua", 'uploads/dpm/foto_ketua/'))) {
            return response()->json([
                "message" => "Invalid field, foto_ketua not found!",
                "body" => null,
            ]);
        }

        $cadidate = new DPMCandidate();
        $cadidate->nomor_urut = $request->nomor_urut;
        $cadidate->nama_ketua = $request->nama_ketua;
        $cadidate->foto_ketua = $foto_ketua;
        $cadidate->description = $request->description;
        $cadidate->save();
        
        return response()->json([
            "message" => "Berhasil menambahkan kandidat",
            "body" => $cadidate->toArray(),
        ]);
    }

    private function uploadImage(Request $request, String $attribute, String $dir) {
        if (($file = $request->file($attribute))) {
            $filename = time() . "." . $file->getClientOriginalExtension();
            if (($r = $file->move($dir, $filename))) return $filename;
        }
        return false;
    }
    
    public function update(Request $request, $nomor_urut) {
        $val = Validator::make($request->all(), [
            // "nomor_urut" => "required|unique:dpm_cadidates,nomor_urut",
            "nama_ketua" => "required",
            // "foto_ketua" => "required|image",
            "description" => "required",
        ], [
            // "nomor_urut.required" => "Kolom nomor_urut harus di isi.",
            "nomor_urut.unique" => "Nomor urut ini sudah terpakai.",
            "nama_ketua.required" => "Kolom nama_ketua harus di isi.",
            "foto_ketua.required" => "Kolom foto_ketua harus di isi.",
            "description.required" => "Kolom deskripsi harus di isi.",
        ]);

        if ($val->fails()) {
            return response()->json([
                "message" => "Invalid field",
                "body" => $val->errors(),
            ], 403);
        }

        $cadidate = DPMCandidate::where('nomor_urut', $nomor_urut)->first();
        if ($cadidate) {

            if (($file = $request->file('foto_ketua'))) {
                $filename = time() . "." . $file->getClientOriginalExtension();
                if (File::exists('uploads/dpm/foto_ketua/'.$cadidate->foto_ketua)) {
                    unlink('uploads/dpm/foto_ketua/'.$cadidate->foto_ketua);
                }
                $file->move('uploads/dpm/foto_ketua/', $filename);
                $cadidate->foto_ketua = $filename;
            }

            // $cadidate->nomor_urut = $request->nomor_urut;
            $cadidate->nama_ketua = $request->nama_ketua;
            // $cadidate->foto_ketua = $request->foto_ketua;
            $cadidate->description = $request->description;
            $cadidate->save();
            return response()->json([
                "message" => "Berhasil mengubah data",
                "body" => $cadidate->toArray(),
            ]);
        }
        return response()->json([
            "message" => "Kandidat nomor urut $nomor_urut tidak ditemukan",
            "body" => null,
        ], 404);
    }

    public function destroy($nomor_urut) {
        $cadidate = DPMCandidate::where('nomor_urut', $nomor_urut)->first();
        if ($cadidate) {
            if (File::exists('uploads/dpm/foto_ketua/'.$cadidate->foto_ketua)) {
                unlink('uploads/dpm/foto_ketua/'.$cadidate->foto_ketua);
            }
            $new = $cadidate;
            $cadidate->delete();
            return response()->json([
                "message" => "Berhasil menghapus kandidat",
                "body" => $new,
            ]);
        }   
        return response()->json([
            "message" => "Kandidat nomor urut $nomor_urut tidak ditemukan",
            "body" => null,
        ], 404);
    }
}