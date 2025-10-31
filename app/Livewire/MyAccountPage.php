<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Livewire\Component;

#[ Title( 'My Account' ) ]

class MyAccountPage extends Component {

    use WithFileUploads;

    public $photo;

    protected $rules = [
        'photo' => 'nullable|image|max:2048',
    ];

    public function render() {
        $user = auth()->user();

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
        dd( $this->photo );
    }
}