# リファレンス

## dwtファイルからlayout.phpを生成する

```bash
$ php artisan layout:make
$ php artisan layout:make --dwt=other.dwt # other.dwtから生成(defaultはmain)
```

## htmlファイルから*.blade.phpを生成する

```bash
$ php artisan view:make index.html home.index
```

## レイアウトを一括更新

```bash
$ php artisan layout:update
packages/primalbase/laravel-view-build/config.phpの定義に従ってファイルを一括更新(layout:make)する
```

## ビューを一括更新

```bash
$ php artisan view:update
packages/primalbase/laravel-view-build/config.phpの定義に従ってファイルを一括更新(view:make)する
```

# Examples

## レイアウトを作成

```bash
$ php artisan layout:make
```

views/layout/base/main.blade.phpとviews/layout/main.blade.phpが作成される

ファイルが既に存在する場合は上書きしない

ベースファイルは常に上書きされる

## レイアウトを作成(ベースファイルなし)

```bash
$  php artisan layout:make --no-base
```

views/layout/main.blade.phpが作成される

ファイルが既に存在する場合は上書き確認[y/N]

## mainMEMBER.dwtからviews/layout/member.blade.phpを作成

```bash
$ php artisan layout:make --source=mainMember.dwt --layout=layout.member
```

## ビューを作成

```bash
$ php artisan view:make index.html home.index
```

views/home/base/index.blade.phpとviews/home/index.blade.phpが作成される

ファイルが既に存在する場合は上書きしない

ベースファイルは常に上書きされる

## ビューを作成(ベースファイルなし)

```bash
$ php artisan view:make index.html home.index --no-base
```

views/home/index.blade.phpが作成される

ファイルが既に存在する場合は上書き確認[y/N]

## ビューを作成(モジュール内、レイアウト指定)

```bash
php artisan view:make member/bbs/detail.html member::board.show --layout=layout.member
```

modules/member/views/home/base/show.blade.phpとmodules/member/views/home/show.blade.phpが作成される

レイアウトは@extends('layout.member')となる
