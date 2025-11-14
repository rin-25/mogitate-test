<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mogitate</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Noto Sans JP', sans-serif;
            background-color: #fafafa;
        }

        header {
            padding: 20px 40px;
            background: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
        }

        header .logo {
            font-size: 26px;
            font-weight: bold;
            color: #f2a900;
            text-decoration: none;
        }

        .container {
            display: flex;
            padding: 40px;
            gap: 40px;
        }

        aside {
            width: 260px;
        }

        main {
            flex: 1;
        }

        /* 商品カード */
        .product-card {
            background: #fff;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: inherit;
        }

        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .product-card .info {
            padding: 10px 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* 検索ボックス */
        .search-input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 20px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .search-button {
            width: 100%;
            padding: 10px 0;
            border: none;
            border-radius: 4px;
            background: #f2a900;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
            margin-top: 6px;
        }

        /* 並び替えセレクト */
        .sort-select {
            width: 100%;
            padding: 8px 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 14px;
            background: #fff;
        }

        /* 並び替えバッジ */
        .sort-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 20px;
            border: 1px solid #f2a900;
            background: #fff7da;
            font-size: 12px;
            color: #555;
            margin-bottom: 12px;
        }

        /* 追加ボタン */
        .add-button {
            background:#f2a900;
            color:#fff;
            padding:10px 18px;
            border-radius:4px;
            text-decoration:none;
            font-size:14px;
        }
    </style>

</head>
<body>

    <header>
        <a href="{{ route('products.index') }}" class="logo">mogitate</a>

        <a href="{{ route('products.create') }}" class="add-button">＋ 商品を追加</a>
    </header>

    {{-- コンテンツ表示部分 --}}
    @yield('content')

</body>
</html>
