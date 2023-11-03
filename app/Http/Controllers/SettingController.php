<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = Setting::firstOrFail();
        $setting = Setting::all();
        return view('setting.index', compact('setting', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show($id)
    {
        $title = Setting::firstOrFail();
        $setting = Setting::first();

        return view('setting.show', compact('setting', 'title'));
    }

    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        $title = Setting::firstOrFail();
        $setting = Setting::first();

        return view('setting.edit', compact('setting', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'history' => 'required',
            'location' => 'required',
            'logo' => 'required|nullable|image',
        ], [
            'logo.image' => "Foto harus berupa image",
        ]);
        // dd($request->name);
        if ($request->hasFile('logo')) {
            // Hapus gambar lama
            $oldLogoPath = public_path('logo/' . $id->logo);
            if (file_exists($oldLogoPath)) {
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

        return redirect()->route('setting.index')->with(['info' => $request->name . " Berhasil Di Update"]);
    }
}
