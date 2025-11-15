@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin: 40px auto;">
    <h1 style="font-size:28px; font-weight:bold; margin-bottom:32px;">商品登録</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 商品名 --}}
        <div style="margin-bottom:20px;">
            <label style="display:flex; align-items:center; font-size:14px; margin-bottom:4px;">
                <span>商品名</span>
                <span style="margin-left:8px; font-size:11px; color:#fff; background:#e74c3c; padding:2px 6px; border-radius:2px;">
                    必須
                </span>
            </label>
            <input type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="商品名を入力"
                    style="width:100%; padding:10px; border-radius:2px; border:1px solid #ddd; font-size:14px;">
            @foreach($errors->get('name') as $message)
                <p style="color:#e74c3c; font-size:12px; margin-top:4px;">{{ $message }}</p>
            @endforeach
        </div>

        {{-- 値段 --}}
        <div style="margin-bottom:20px;">
            <label style="display:flex; align-items:center; font-size:14px; margin-bottom:4px;">
                <span>値段</span>
                <span style="margin-left:8px; font-size:11px; color:#fff; background:#e74c3c; padding:2px 6px; border-radius:2px;">
                    必須
                </span>
            </label>
            <input type="text"
                    name="price"
                    value="{{ old('price') }}"
                    placeholder="値段を入力"
                    style="width:100%; padding:10px; border-radius:2px; border:1px solid #ddd; font-size:14px;">
            @foreach($errors->get('price') as $message)
                <p style="color:#e74c3c; font-size:12px; margin-top:4px;">{{ $message }}</p>
            @endforeach
        </div>
    {{-- 商品画像 --}}
    <div style="margin-bottom:20px;">
            <label style="display:flex; align-items:center; font-size:14px; margin-bottom:4px;">
                <span>商品画像</span>
                <span style="margin-left:8px; font-size:11px; color:#fff; background:#e74c3c; padding:2px 6px; border-radius:2px;">
                    必須
                </span>
            </label>

        {{-- ファイル選択ボタン --}}
        <label style="display:inline-block; padding:6px 12px; background:#e0e0e0; border-radius:2px; cursor:pointer; font-size:13px;">
            ファイルを選択
            <input
            id="image-input"
            type="file"
            name="image"
            accept="image/png,image/jpeg"
            style="display:none;"
            onchange="previewImage(event)"  {{-- ★ ここでプレビュー関数を呼ぶ --}}
            >
        </label>

        @foreach($errors->get('image') as $message)
            <p style="color:#e74c3c; font-size:12px; margin-top:4px;">{{ $message }}</p>
        @endforeach

        {{-- ★ 画像プレビューエリア（最初は非表示） --}}
        <div style="margin-top:12px;">
            <img id="image-preview"
                src=""
                alt="プレビュー"
                style="display:none; max-width:100%; width:100%; max-height:300px; object-fit:cover; border-radius:4px; background:#fff;">
        </div>
    </div>

        {{-- 季節（複数選択） --}}
        <div style="margin-bottom:20px;">
            <div style="display:flex; align-items:center; font-size:14px; margin-bottom:4px;">
                <span>季節</span>
                <span style="margin-left:8px; font-size:11px; color:#fff; background:#e74c3c; padding:2px 6px; border-radius:2px;">
                    必須
                </span>
                <span style="margin-left:8px; font-size:11px; color:#e74c3c;">
                    複数選択可
                </span>
            </div>

            @php
                $oldSeasons = old('seasons', []);  // 初期状態は何も選択されていない
            @endphp

            <div style="display:flex; gap:24px; font-size:14px;">
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

            @foreach($errors->get('seasons') as $message)
                <p style="color:#e74c3c; font-size:12px; margin-top:4px;">{{ $message }}</p>
            @endforeach
        </div>

        {{-- 商品説明 --}}
        <div style="margin-bottom:32px;">
            <label style="display:flex; align-items:center; font-size:14px; margin-bottom:4px;">
                <span>商品説明</span>
                <span style="margin-left:8px; font-size:11px; color:#fff; background:#e74c3c; padding:2px 6px; border-radius:2px;">
                    必須
                </span>
            </label>
            <textarea name="description"
                        rows="4"
                        placeholder="商品の説明を入力"
                        style="width:100%; padding:10px; border-radius:2px; border:1px solid #ddd; font-size:14px; resize:vertical;">{{ old('description') }}</textarea>
            @foreach($errors->get('description') as $message)
                <p style="color:#e74c3c; font-size:12px; margin-top:4px;">{{ $message }}</p>
            @endforeach
        </div>

        {{-- ボタン --}}
        <div style="display:flex; justify-content:center; gap:24px;">
            <a href="{{ route('products.index') }}"
                style="display:inline-block; padding:10px 60px; background:#e0e0e0; border-radius:4px;
                        text-decoration:none; color:#555; font-size:14px; text-align:center;">
                戻る
            </a>
            <button type="submit"
                    style="padding:10px 60px; background:#f2a900; border:none; border-radius:4px;
                            color:#fff; font-size:14px; cursor:pointer;">
                登録
            </button>
        </div>
    </form>
</div>
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('image-preview');

        if (!file) {
            // ファイルが未選択になった場合はプレビューを消す
            preview.style.display = 'none';
            preview.src = '';
            return;
        }

        const url = URL.createObjectURL(file);
        preview.src = url;
        preview.style.display = 'block';
    }
</script>
@endsection
