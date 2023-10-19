<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::all();

        return view('setting.index', ['setting' => $setting]);
    }

    public function create()
    {

        return view('setting.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'history' => 'required',
            'image' => 'required|image|mimes:png,jpg|max:2040',
        ]);

        // Upload gambar untuk field 'image'
        $image = $request->image;
        $slugimage = Str::slug($image->getClientOriginalName());
        $new_image = time() . '_' . $slugimage;
        $image->move('upload/setting-app/', $new_image);

        $setting = new Setting;
        $setting->image = 'upload/setting-app/' . $new_image;
        $setting->name = $request->name;
        $setting->history = $request->history;
        $setting->save();

        return redirect('/setting')->with('succes', 'data ditambah');
    }

    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        return view('setting.edit', compact('setting'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'history' => 'required',
            'image' => 'required|image|mimes:png,jpg|max:2040',
        ]);

        // edit gambar untuk field 'image'
        $image = $request->image;
        $slugimage = Str::slug($image->getClientOriginalName());
        $new_image = time() . '_' . $slugimage;
        $image->move('upload/setting-app/', $new_image);

        $setting = Setting::find($id);
        $setting->image = 'upload/setting-app/' . $new_image;
        $setting->name = $request->name;
        $setting->history = $request->history;
        $setting->save();

        return to_route('setting.index')->with('succes', 'data ditambah');
    }

    public function destroy($id)
    {
        $setting = Setting::find($id);
        $setting->delete();

        return back()->with('succes', 'data dihapus');
    }
}