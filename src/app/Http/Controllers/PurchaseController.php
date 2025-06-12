<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    public function store(PurchaseRequest $request, $itemId)
    {
        $validated = $request->validated();
        $user = Auth::user();

        $alreadyPurchased = Purchase::where('user_id', $user->id)
            ->where('item_id', $itemId)
            ->exists();

        if ($alreadyPurchased) {
            return redirect()->route('items.show', $itemId)->with('error', 'すでに購入済みです');
        }

        // 購入処理
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $itemId,
        ]);

        $item = Item::findOrFail($itemId);
        $item->sold_at = now();
        $item->save();

        return redirect()->route('items.show', $itemId)->with('success', '購入が完了しました');
    }

    public function show($itemId)
    {
        $item = \App\Models\Item::findOrFail($itemId);
        $user = auth()->user();
        return view('purchase.show', compact('item', 'user'));
    }
}
