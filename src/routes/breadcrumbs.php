<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// 管理画面ホーム
Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('ダッシュボード', route('admin.dashboard'));
});

// ユーザー一覧
Breadcrumbs::for('admin.users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('ユーザー', route('admin.users.index'));
});

// ユーザー新規作成
Breadcrumbs::for('admin.users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.users.index');
    $trail->push('新規作成', route('admin.users.create'));
});

// ユーザー編集
Breadcrumbs::for('admin.users.edit', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('admin.users.index');
    $trail->push($user->name, route('admin.users.edit', $user));
});

// 投稿一覧
Breadcrumbs::for('admin.posts.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('投稿', route('admin.posts.index'));
});

// 投稿新規作成
Breadcrumbs::for('admin.posts.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.posts.index');
    $trail->push('新規作成', route('admin.posts.create'));
});

// 投稿編集
Breadcrumbs::for('admin.posts.edit', function (BreadcrumbTrail $trail, $post) {
    $trail->parent('admin.posts.index');
    $trail->push($post->title, route('admin.posts.edit', $post));
});

// 画像一覧
Breadcrumbs::for('admin.files.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('画像', route('admin.files.index'));
});

// 画像新規作成
Breadcrumbs::for('admin.files.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.files.index');
    $trail->push('新規作成', route('admin.files.create'));
});
