<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class ItemController extends Controller
{
    public function index()
    {
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
        $item = \App\Models\Item::findOrFail($id);
        $comments = \App\Models\Comment::where('item_id', $id)->with('user')->latest()->get();
        return view('items.show', compact('item', 'comments'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(ExhibitionRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer',
            'condition' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $item = new \App\Models\Item();
        $item->user_id = auth()->id();
        $item->name = $validated['name'];
        $item->description = $validated['description'] ?? '';
        $item->price = $validated['price'];
        $item->condition = $validated['condition'];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('item_images', 'public');
            $item->image_path = 'storage/' . $path;
        }

        $item->save();

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
}
