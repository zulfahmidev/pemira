<?php

namespace App\Http\Controllers;

use App\Models\BEMCandidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CBEMController extends Controller
{
    public function index() {
        $candidates = BEMCandidate::all()->toArray();
        return response()->json([
            "message" => "Daftar Calon BEM",
            "body" => $candidates,
        ]);
    }

    public function show($nomor_urut) {
        $cadidate = BEMCandidate::where('nomor_urut', $nomor_urut)->first();
        if ($cadidate) {
            return response()->json([
                "message" => "Calon BEM nomor urut $nomor_urut",
                "body" => $cadidate->toArray(),
            ]);
        }
        return response()->json([
            "message" => "Calon BEM nomor urut $nomor_urut tidak ditemukan",
            "body" => null,
        ], 404);
    }

    public function store(Request $request) {
        $val = Validator::make($request->all(), [
            "nomor_urut" => "required|unique:bem_cadidates,nomor_urut",
            "nama_ketua" => "required",
            "nama_wakil" => "required",
            "foto_ketua" => "required|image",
            "foto_wakil" => "required|image",
            "description" => "required",
        ], [
            "nomor_urut.required" => "Kolom nomor_urut harus di isi.",
            "nomor_urut.unique" => "Nomor urut ini sudah terpakai.",
            "nama_ketua.required" => "Kolom nama_ketua harus di isi.",
            "nama_wakil.required" => "Kolom nama_wakil harus di isi.",
            "foto_ketua.required" => "Kolom foto_ketua harus di isi.",
            "foto_wakil.required" => "Kolom foto_wakil harus di isi.",
            "description.required" => "Kolom deskripsi harus di isi.",
        ]);

        if ($val->fails()) {
            return response()->json([
                "message" => "Invalid field",
                "body" => $val->errors(),
            ], 403);
        }

        if (!($foto_ketua = $this->uploadImage($request, "foto_ketua", 'uploads/bem/foto_ketua/'))) {
            return response()->json([
                "message" => "Invalid field, foto_ketua not found!",
                "body" => null,
            ]);
        }
        if (!($foto_wakil = $this->uploadImage($request, "foto_wakil", 'uploads/bem/foto_wakil/'))) {
            return response()->json([
                "message" => "Invalid field, image not found!",
                "body" => null,
            ]);
        }

        $cadidate = new BEMCandidate();
        $cadidate->nomor_urut = $request->nomor_urut;
        $cadidate->nama_ketua = $request->nama_ketua;
        $cadidate->nama_wakil = $request->nama_wakil;
        $cadidate->foto_ketua = $foto_ketua;
        $cadidate->foto_wakil = $foto_wakil;
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
            // "nomor_urut" => "required|unique:bem_cadidates,nomor_urut",
            "nama_ketua" => "required",
            "nama_wakil" => "required",
            // "foto_ketua" => "required|image",
            // "foto_wakil" => "required|image",
            "description" => "required",
        ], [
            // "nomor_urut.required" => "Kolom nomor_urut harus di isi.",
            "nomor_urut.unique" => "Nomor urut ini sudah terpakai.",
            "nama_ketua.required" => "Kolom nama_ketua harus di isi.",
            "nama_wakil.required" => "Kolom nama_wakil harus di isi.",
            "foto_ketua.required" => "Kolom foto_ketua harus di isi.",
            "foto_wakil.required" => "Kolom foto_wakil harus di isi.",
            "description.required" => "Kolom deskripsi harus di isi.",
        ]);

        if ($val->fails()) {
            return response()->json([
                "message" => "Invalid field",
                "body" => $val->errors(),
            ], 403);
        }

        $cadidate = BEMCandidate::where('nomor_urut', $nomor_urut)->first();
        if ($cadidate) {

            if (($file = $request->file('foto_ketua'))) {
                $filename = time() . "." . $file->getClientOriginalExtension();
                if (File::exists('uploads/bem/foto_ketua/'.$cadidate->foto_ketua)) {
                    unlink('uploads/bem/foto_ketua/'.$cadidate->foto_ketua);
                }
                $file->move('uploads/bem/foto_ketua/', $filename);
                $cadidate->foto_ketua = $filename;
            }
            
            if (($file = $request->file('foto_wakil'))) {
                $filename = time() . "." . $file->getClientOriginalExtension();
                if (File::exists('uploads/bem/foto_wakil/'.$cadidate->foto_wakil)) {
                    unlink('uploads/bem/foto_wakil/'.$cadidate->foto_wakil);
                }
                $file->move('uploads/bem/foto_wakil/', $filename);
                $cadidate->foto_wakil = $filename;
            }

            // $cadidate->nomor_urut = $request->nomor_urut;
            $cadidate->nama_ketua = $request->nama_ketua;
            $cadidate->nama_wakil = $request->nama_wakil;
            // $cadidate->foto_ketua = $request->foto_ketua;
            // $cadidate->foto_wakil = $request->foto_wakil;
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
        $cadidate = BEMCandidate::where('nomor_urut', $nomor_urut)->first();
        if ($cadidate) {
            if (File::exists('uploads/bem/foto_ketua/'.$cadidate->foto_ketua)) {
                unlink('uploads/bem/foto_ketua/'.$cadidate->foto_ketua);
            }
            if (File::exists('uploads/bem/foto_wakil/'.$cadidate->foto_wakil)) {
                unlink('uploads/bem/foto_wakil/'.$cadidate->foto_wakil);
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
