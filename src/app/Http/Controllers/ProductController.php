<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
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
    public function show($productId)
    {
        $product = Product::findOrFail($productId);

        return view('products.show', compact('product'));
    }
}
