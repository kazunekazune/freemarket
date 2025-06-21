<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;

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


        // 商品情報取得
        $item = \App\Models\Item::findOrFail($itemId);

        // 支払い方法がカード払いの場合
        if ($request->input('payment_method') === 'credit_card') {
            //dd(env('STRIPE_SECRET'));
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item->name,
                        ],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('purchase.success', ['item' => $item->id]),
                'cancel_url' => route('purchase.show', ['item' => $item->id]),
            ]);

            // Stripeの決済画面にリダイレクト
            return redirect($session->url);
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

    /**
     * 配送先住所の変更画面を表示
     */
    public function editAddress(Item $item)
    {
        $user = Auth::user();
        return view('purchase.address', compact('item', 'user'));
    }

    /**
     * 配送先住所を更新
     */
    public function updateAddress(Request $request, Item $item)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'postal_code' => 'required|string|max:8',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        // 更新後、元の購入画面に戻る
        return redirect()->route('purchase.show', $item)->with('success', '配送先を更新しました。');
    }

    public function success($itemId)
    {
        // 購入処理（DB登録など）をここで行う
        // 例:
        // Purchase::create([...]);
        // $item = Item::findOrFail($itemId);
        // $item->sold_at = now();
        // $item->save();

        return redirect()->route('items.show', $itemId)->with('success', 'カード決済が完了しました');
    }
}
