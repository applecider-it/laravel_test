<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Session;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Log;

use App\Models\User\Tweet;

/**
 * Livewire動作確認用
 */
class TestComponent extends Component
{
    //use WithPagination;

    public $id;

    #[Session]
    public $count = 0;

    public $name;

    public $email;

    // フィールド名のカスタム表示
    protected $validationAttributes = [
        'name' => '名前',
        'email' => 'メールアドレス',
    ];

    public function mount($id)
    {
        Log::info('lifewire mount', [$id, $this->id, \Auth::user()->id]);
        //throw new \Exception("Exception Test");
    }

    public function getRules()
    {
        Log::info('lifewire getRules', [$this->id]);
        return [
            'name' => 'required|string|min:3|max:20',
            'email' => 'required|email|max:255|unique:users,email,' . $this->id,
        ];
    }

    public function submit()
    {
        Log::info('lifewire submit', [$this->id]);
        //throw new \Exception("Exception Test");

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
        return view('livewire.test_component', [
            'tweets' => Tweet::paginate(10),
        ]);
    }
}
