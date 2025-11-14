@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1000px; margin: 40px auto;">
    {{-- パンくず --}}
    <div style="margin-bottom: 16px; font-size: 14px;">
        <a href="{{ route('products.index') }}" style="text-decoration:none; color:#3498db;">商品一覧</a>
        <span> &gt; {{ $product->name }}</span>
    </div>

    <form action="{{ route('products.update', ['productId' => $product->id]) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <div style="display:flex; gap:40px; align-items:flex-start;">
            {{-- 左：画像＋ファイル選択 --}}
            <div style="flex:1;">
                {{-- プレビュー画像 --}}
                <div style="margin-bottom:12px;">
                    <img
                        src="{{ asset('fruits-img/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        style="width:100%; max-width:400px; height:auto; border-radius:4px; object-fit:cover; background:#fff;"
                    >
                </div>

                {{-- ファイル選択ボタン & ファイル名表示風 --}}
                <div style="display:flex; align-items:center; gap:8px;">
                    <label style="display:inline-block; padding:6px 12px; background:#e0e0e0; border-radius:2px; cursor:pointer;">
                        ファイルを選択
                        <input type="file" name="image" style="display:none;">
                    </label>
                    <span style="font-size:12px; color:#666;">
                        {{ $product->image }}
                    </span>
                </div>

                {{-- 画像エラー --}}
                @error('image')
                    <p style="color:#e74c3c; font-size:12px; margin-top:6px;">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- 右：テキスト項目 --}}
            <div style="flex:1;">

                {{-- 商品名 --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:14px; margin-bottom:4px;">商品名</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $product->name) }}"
                           placeholder="商品名を入力"
                           style="width:100%; padding:8px 10px; border-radius:2px; border:1px solid #ddd; font-size:14px;">
                    @error('name')
                        <p style="color:#e74c3c; font-size:12px; margin-top:4px;">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- 値段 --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:14px; margin-bottom:4px;">値段</label>
                    <input type="text"
                           name="price"
                           value="{{ old('price', $product->price) }}"
                           placeholder="値段を入力"
                           style="width:100%; padding:8px 10px; border-radius:2px; border:1px solid #ddd; font-size:14px;">
                    @error('price')
                        <p style="color:#e74c3c; font-size:12px; margin-top:4px;">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- 季節（複数選択） --}}
                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:14px; margin-bottom:4px;">季節</label>

                    @php
                        $oldSeasons = old('seasons', $selectedSeasonIds ?? []);
                    @endphp

                    <div style="display:flex; gap:16px; align-items:center; font-size:14px;">
                        @foreach($seasons as $season)
                            <label>
                                <input type="checkbox"
                                       name="seasons[]"
                                       value="{{ $season->id }}"
                                       {{ in_array($season->id, $oldSeasons, true) ? 'checked' : '' }}>
                                {{ $season->name }}
                            </label>
                        @endforeach
                    </div>

                    @error('seasons')
                        <p style="color:#e74c3c; font-size:12px; margin-top:4px;">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- 商品説明 --}}
        <div style="margin-top:24px;">
            <label style="display:block; font-size:14px; margin-bottom:4px;">商品説明</label>
            <textarea name="description"
                      rows="4"
                      placeholder="商品の説明を入力"
                      style="width:100%; padding:10px; border-radius:2px; border:1px solid #ddd; font-size:14px; resize:vertical;">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <p style="color:#e74c3c; font-size:12px; margin-top:4px;">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- ボタン群 --}}
        <div style="margin-top:32px; display:flex; justify-content:space-between; align-items:center;">
            {{-- 戻る --}}
            <a href="{{ route('products.index') }}"
               style="display:inline-block; padding:10px 40px; background:#e0e0e0; border-radius:4px;
                      text-decoration:none; color:#555; font-size:14px;">
                戻る
            </a>

            <div style="display:flex; gap:16px; align-items:center;">
                {{-- 変更を保存 --}}
                <button type="submit"
                        style="padding:10px 40px; background:#f2a900; border:none; border-radius:4px;
                               color:#fff; font-size:14px; cursor:pointer;">
                    変更を保存
                </button>

                {{-- 削除ボタン（ゴミ箱アイコン代わりの赤ボタン） --}}
                <form action="{{ route('products.delete', ['productId' => $product->id]) }}"
                      method="POST"
                      onsubmit="return confirm('本当に削除しますか？');">
                    @csrf
                    <button type="submit"
                            style="width:40px; height:40px; border-radius:50%; border:none;
                                   background:#e74c3c; color:#fff; font-size:18px; cursor:pointer;">
                        🗑
                    </button>
                </form>
            </div>
        </div>
    </form>
</div>
@endsection
