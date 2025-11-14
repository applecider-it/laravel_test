<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;

    public $name;
    public $email;

    // バリデーションルール
    protected $rules = [
        'name' => 'required|string|min:3|max:20',
        'email' => 'required|email|max:255',
    ];

    // フィールド名のカスタム表示
    protected $validationAttributes = [
        'name' => '名前',
        'email' => 'メールアドレス',
    ];

    public function submit()
    {
        // バリデーション実行
        $this->validate();

        // 保存処理

        // 通知
        session()->flash('message', 'ユーザーを保存しました');
    }

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
