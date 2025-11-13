@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- 左側：検索フォーム＆並び替え --}}
        <aside style="width:260px;">
            <h1 style="font-size:24px; font-weight:bold; margin-bottom:20px;">商品一覧</h1>

            <form action="{{ route('products.search') }}" method="GET">
                {{-- 検索キーワード --}}
                <div style="margin-bottom:16px;">
                    <input
                        type="text"
                        name="keyword"
                        placeholder="商品名で検索"
                        value="{{ $keyword }}"
                        class="search-input"
                    >
                </div>

                {{-- 並び替えセレクト --}}
                <div style="margin-bottom:12px;">
                    <label style="font-size:14px; display:block; margin-bottom:6px;">価格順で表示</label>
                    <select name="sort" class="sort-select">
                        <option value="">価格で並び替え</option>
                        <option value="high" {{ $sort === 'high' ? 'selected' : '' }}>高い順に表示</option>
                        <option value="low"  {{ $sort === 'low'  ? 'selected' : '' }}>低い順に表示</option>
                    </select>
                </div>

                {{-- 並び替え条件バッジ（モーダル風） --}}
                @if ($sort === 'high' || $sort === 'low')
                    @php
                        $label = $sort === 'high' ? '高い順に表示' : '低い順に表示';
                    @endphp
                    <div style="margin-bottom:16px;">
                        <span class="sort-badge">
                            {{ $label }}
                            {{-- ×で並び替え解除 --}}
                            <a href="{{ route('products.index', ['keyword' => $keyword]) }}"
                                style="margin-left:8px; text-decoration:none; color:#999; font-weight:bold;">
                                ×
                            </a>
                        </span>
                    </div>
                @endif

                <button type="submit" class="search-button">
                    検索
                </button>
            </form>
        </aside>

        {{-- 右側：商品カード一覧 --}}
        <main style="flex:1;">
            {{-- 検索結果のタイトル --}}
            @if (!empty($keyword))
                <h2 style="font-size:20px; margin-bottom:16px;">
                    “{{ $keyword }}”の商品一覧
                </h2>
            @endif

            <div style="display:grid; grid-template-columns:repeat(3, minmax(0,1fr)); gap:24px;">
                @forelse ($products as $product)
                    <a href="{{ route('products.show', ['productId' => $product->id]) }}"
                        class="product-card">
                        <img src="{{ asset('fruits-img/' . $product->image) }}"
                                alt="{{ $product->name }}">
                        <div class="info">
                            <div style="font-size:14px;">{{ $product->name }}</div>
                            <div style="font-size:14px; font-weight:bold;">
                                ¥{{ number_format($product->price) }}
                            </div>
                        </div>
                    </a>
                @empty
                    <p>該当する商品がありません。</p>
                @endforelse
            </div>

            {{-- ページネーション --}}
            <div style="margin-top:24px;">
                {{ $products->links() }}
            </div>
        </main>
    </div>
@endsection
