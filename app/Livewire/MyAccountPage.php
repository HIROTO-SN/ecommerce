<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

#[ Title( 'My Account' ) ]

class MyAccountPage extends Component {

    use WithFileUploads;

    public $photo;
    public $avatar_url;

    protected $rules = [
        'photo' => 'nullable|image|max:2048',
    ];

    protected $listeners = [ 'avatar-updated' => 'refreshUser' ];

    public function render() {
        $user = auth()->user();

        if ( $user->avatar_url ) {
            $this->photo = $user->avatar_url;
        }

        return view( 'livewire.my-account-page', [
            'user' => $user,
            'orders_count' => $user->orders()->count(),
            'delivered_count' => $user->orders()->where( 'status', 'delivered' )->count(),
            'canceled_count' => $user->orders()->where( 'status', 'canceled' )->count(),
            'recent_orders' => $user->orders()->latest()->take( 5 )->get(),
            'default_address' => $user->orders()->latest()->first()?->address,
        ] );
    }

    public function updatedPhoto() {
        $this->validate();
        $user = User::find( auth()->id() );

        // 旧画像を削除（任意）
        if ( $user->avatar_url && Storage::disk( 'public' )->exists( $user->avatar_url ) ) {
            Storage::disk( 'public' )->delete( $user->avatar_url );
        }

        // 画像を保存（publicディスク）
        $path = $this->photo->store( 'avatars', 'public' );

        // ✅ データベース更新
        $user->avatar_url = $path;
        $user->save();

        // フロント再描画用イベント発火
        $this->dispatch( 'avatar-updated' );

        // 一時ファイルをリセット
        $this->photo = null;

        LivewireAlert::title( 'Success' )
        ->text( 'Your profile picture has been updated successfully!' )
        ->position( 'center' )
        ->timer( 2000 )
        ->success()
        ->show();
    }
}