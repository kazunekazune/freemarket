<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = Item::query();

        if ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        if (auth()->check()) {
            // ログイン中は自分が出品した商品を除外する
            $items = \App\Models\Item::where('user_id', '!=', auth()->id())->get();
        } else {
            // 未ログインは全商品を表示
            $items = \App\Models\Item::all();
        }
        return view('items.index', compact('items'));
    }

    public function show($id)
    {
        $item = \App\Models\Item::with(['categories', 'user'])->findOrFail($id);
        $comments = \App\Models\Comment::where('item_id', $id)->with('user')->latest()->get();
        return view('items.show', compact('item', 'comments'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('items.create', compact('categories'));
    }

    public function store(ItemRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('items', 'public');
        }

        unset($data['categories']);
        unset($data['image']);

        $item = Item::create($data);

        $item->categories()->sync($request->input('categories', []));

        return redirect()->route('items.index')->with('success', '商品を出品しました');
    }

    public function comment(CommentRequest $request, $itemId)
    {
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $itemId,
            'content' => $request->input('content'),
        ]);

        return redirect()->route('items.show', $itemId)->with('success', 'コメントを投稿しました');
    }

    public function edit(Item $item)
    {
        // 出品者以外は編集できないようにする
        if ($item->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(ItemRequest $request, Item $item)
    {
        // 出品者以外は更新できないようにする
        if ($item->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validated();

        // 画像がアップロードされた場合
        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($item->image && !str_starts_with($item->image, 'http')) {
                Storage::delete('public/' . $item->image);
            }
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        $item->update($data);

        return redirect()->route('items.show', $item)
            ->with('success', '商品を更新しました。');
    }

    public function destroy(Item $item)
    {
        // 出品者以外は削除できないようにする
        if ($item->user_id !== auth()->id()) {
            abort(403);
        }

        // 画像を削除
        if ($item->image && !str_starts_with($item->image, 'http')) {
            Storage::delete('public/' . $item->image);
        }

        $item->delete();

        return redirect()->route('items.index')
            ->with('success', '商品を削除しました。');
    }
}
