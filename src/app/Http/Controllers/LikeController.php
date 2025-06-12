<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // いいねする
    public function store($itemId)
    {
        $user = Auth::user();

        // いいねしていなければ作成
        Like::firstOrCreate([
            'user_id' => $user->id,
            'item_id' => $itemId,
        ]);

        return back();
    }

    // いいね解除
    public function destroy($itemId)
    {
        $user = Auth::user();

        Like::where('user_id', $user->id)
            ->where('item_id', $itemId)
            ->delete();

        return back();
    }
}
