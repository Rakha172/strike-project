<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\PaymentTypes;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PaymentTypeController extends Controller
{
    public function paymenttypesIndex(Request $request)
    {
        $title = Setting::firstOrFail();
        $paymenttypes = PaymentTypes::all();

        return view('payment.index', compact('paymenttypes', 'title'));
    }

    public function create()
    {
        $title = Setting::firstOrFail();
        return view('payment.create', compact('title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'owner' => 'required',
            'account_number' => 'required',
            'username' => 'required',
            'status' => 'required',
        ]);

        PaymentTypes::create($validated);

        return redirect()->route('paymenttypesIndex')->with('berhasil', "$request->name Berhasil ditambahkan");
    }
    public function edit(PaymentTypes $paymenttypes)
    {
        $title = Setting::firstOrFail();
        return view('payment.edit', compact('paymenttypes', 'title'));
    }

    public function paytypeupdate(Request $request, PaymentTypes $paymenttypes)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'owner' => 'required',
            'account_number' => 'required',
            'username' => 'required',
            'status' => 'nullable',
        ]);

        $paymenttypes->update($validated);

        return redirect()->route('paymenttypesIndex')->with('berhasil', "$request->name Berhasil diubah");
    }

    public function destroy(PaymentTypes $paymenttypes)
    {
        $paymenttypes->delete();
        return redirect()->route('paymenttypesIndex')->with('berhasil', "$paymenttypes->name Berhasil dihapus");
    }
}

