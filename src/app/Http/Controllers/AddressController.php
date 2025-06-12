<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function edit(Request $request)
    {
        $user = Auth::user();
        $item_id = $request->input('item_id');
        return view('address.edit', compact('user', 'item_id'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->address = $request->input('address');
        $user->postal_code = $request->input('postal_code');
        $user->building = $request->input('building');
        $user->save();

        return redirect()->route('purchase.show', ['item' => $request->input('item_id')])
            ->with('success', '住所を更新しました');
    }
}
