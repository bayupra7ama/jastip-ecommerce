<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PinController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'pin' => 'required|digits:6|same:pin_confirmation',
        ]);

        $user = auth()->user();
        $user->transaction_pin = bcrypt($request->pin);
        $user->save();

        session()->forget('must_set_pin');

        return redirect()->back()->with('success', 'PIN transaksi berhasil disimpan!');
    }
}
