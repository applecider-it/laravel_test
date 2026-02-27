<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// ダッシュボード
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('ダッシュボード', route('dashboard'));
});

// 開発者向けページ
Breadcrumbs::for('development.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('開発者向けページ', route('development.index'));
});

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