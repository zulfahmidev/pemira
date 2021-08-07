<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function init() {
        $settings = [
            "start_voting" => null,
            "end_voting" => null,
        ];

        foreach ($settings as $k => $v) {
            $setting = new Setting();
            $setting->key = $k;
            $setting->value = $v;
            $setting->save();
        }

        return response()->json([
            "message" => "Inisialisasi setting berhasil",
            "body" => $settings,
        ]);
    }

    public function set(Request $request) {
        $val = Validator::make($request->all(), [
            "key" => "required",
            "value" => "required",
        ]);
        if ($val->fails()) {
            return response()->json([
                "message" => "Invalid field",
                "body" => $val->errors(),
            ], 403);
        }
        $setting = Setting::where('key', $request->key)->first();
        if ($setting) {
            $setting->value = $request->value;
            $setting->save();
            return response()->json([
                "message" => "Perubahan berhasil disimpan",
                "body" => $setting->value,
            ]);
        }   
        return response()->json([
            "message" => "Kunci setting ini tidak ditemukan",
            "body" => null,
        ], 404);
    }

    public function get($key) {
        $setting = Setting::where('key', $key)->first();
        if ($setting) {
            return response()->json([
                "message" => "Berhasil mengambil data setting",
                "body" => $setting->value,
            ]);
        }
        return response()->json([
            "message" => "Kunci setting ini tidak ditemukan",
            "body" => null,
        ], 404);
    }

}
