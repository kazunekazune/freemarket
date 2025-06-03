<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // プロフィール編集画面の表示
    public function edit()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }

    // プロフィール更新処理
    public function update(Request $request)
    {
        $user = Auth::user();

        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        // プロフィール画像アップロード
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        // その他の情報を更新
        $user->name = $validated['name'];
        $user->postal_code = $validated['postal_code'] ?? '';
        $user->address = $validated['address'] ?? '';
        $user->building = $validated['building'] ?? '';
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'プロフィールを更新しました');
    }
}
