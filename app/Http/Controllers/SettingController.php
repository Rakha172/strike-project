<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();

        return view('setting.index', ['setting' => $settings]);
    }
    public function show($id)
    {
        $setting = Setting::findOrFail($id);

        return view('setting.show', compact('setting'));
    }

    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        return view('setting.edit', compact('setting'));
    }


    public function update(Request $request, Setting $id)
    {
        $request->validate([
            'name' => 'required',
            'history' => 'required',
            'logo' => 'required|image',
            'location' => 'required',
        ]);

        if ($request->hasFile('logo')) {
            // Hapus gambar lama
            $oldLogoPath = public_path('logo/' . $id->logo);
            if (is_file($oldLogoPath)) {
                unlink($oldLogoPath);
            }

            $uploadedLogo = $request->file('logo');
            $newLogoName = 'logo.png'; // Nama tetap "logo.png"

            // Simpan gambar baru dengan nama tetap
            $uploadedLogo->storeAs('public/logo', $newLogoName);

            // Perbarui nama file gambar di database
            $id->logo = $newLogoName;


            $id->name = $request->input('name');
            $id->history = $request->input('history');
            $id->location = $request->input('location');
            $id->save();

            $newLogoPublicPath = public_path('logo/' . $newLogoName);
            if (file_exists($newLogoPublicPath)) {
                unlink($newLogoPublicPath); // Hapus gambar baru jika sudah ada
            }
            copy(storage_path('app/public/logo/' . $newLogoName), $newLogoPublicPath);
        } else {
            $id->name = $request->input('name');
            $id->history = $request->input('history');
            $id->location = $request->input('location');
            $id->save();
        }

        return to_route('setting.index')->with('succes', 'data ditambah');
    }

    public function destroy($id)
    {
        $settings = Setting::find($id);
        $settings->delete();

        return back()->with('succes', 'data dihapus');
    }
}
