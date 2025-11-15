<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // ★ 商品登録画面表示
    public function create()
    {
        $seasons = Season::all(); // 春・夏・秋・冬

        return view('products.create', compact('seasons'));
    }

    // ★ 商品登録処理
    public function store(StoreProductRequest $request)
    {
        // 新規 Product インスタンス
        $product = new Product();
        $product->name        = $request->name;
        $product->price       = $request->price;
        $product->description = $request->description;

        // 画像アップロード（必須）
        $file     = $request->file('image');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

        // storage/app/public/products に保存
        $path = $file->storeAs('products', $fileName, 'public');

        // 一覧で使っている public/fruits-img にもコピーしておく
        $storagePath = storage_path('app/public/' . $path);
        $publicPath  = public_path('fruits-img/' . $fileName);
        File::copy($storagePath, $publicPath);


        // DB にはファイル名だけ保存（一覧／詳細と同じ仕様）
        $product->image = $fileName;

        $product->save();

        // 季節（多対多）
        $product->seasons()->sync($request->input('seasons', []));

        return redirect()->route('products.index');
    }
    // 商品一覧（検索・並び替え込み）
    public function index(Request $request)
    {
        $query = Product::query();

        // 商品名検索（部分一致）
        $keyword = $request->input('keyword');
        if (!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        // 並び替え
        $sort = $request->input('sort');
        if ($sort === 'high') {
            $query->orderBy('price', 'desc');   // 高い順
        } elseif ($sort === 'low') {
            $query->orderBy('price', 'asc');    // 低い順
        } else {
            $query->orderBy('id', 'asc');       // デフォルト表示
        }

        // 6件ごとにページネーション
        $products = $query->paginate(6)->withQueryString();

        return view('products.index', [
            'products' => $products,
            'keyword'  => $keyword,
            'sort'     => $sort,
        ]);
    }

    // 商品詳細
    public function edit($productId)
    {
        $product = Product::with('seasons')->findOrFail($productId);
        $seasons = Season::all();
        $selectedSeasonIds = $product->seasons->pluck('id')->toArray();

        return view('products.show', compact('product', 'seasons', 'selectedSeasonIds'));
    }

    // 更新処理
    public function update(UpdateProductRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $product->name        = $request->name;
        $product->price       = $request->price;
        $product->description = $request->description;

        // 画像アップロード
        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            // storage/app/public/products に保存（シンボリックリンク用）
            $path = $file->storeAs('products', $fileName, 'public');

            // 一覧画面は public/fruits-img/ ファイル名 を見ているので、
            // 同じファイルを public/fruits-img にもコピーしておく
            $storagePath = storage_path('app/public/' . $path);
            $publicPath  = public_path('fruits-img/' . $fileName);
            File::copy($storagePath, $publicPath);

            // DB にはファイル名だけを保存（一覧の既存ロジックを壊さないため）
            $product->image = $fileName;
        }

        $product->save();

        // 季節（多対多）を同期
        $product->seasons()->sync($request->input('seasons', []));

        return redirect()->route('products.index');
    }

    // 削除
    public function destroy($productId)
    {
        dd('destroy 呼び出し');
        $product = Product::findOrFail($productId);
        $product->seasons()->detach();
        $product->delete();

        return redirect()->route('products.index');
    }
}