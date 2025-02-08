<?php

namespace App\Livewire\Admin\History;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Order;


class History extends Component
{
    #[Layout('components.layouts.admin')]

    
    public function render()
    {
        $history = Order::where('status', 'finish')->get();

        return view('livewire.admin.history.history', compact('history'));
        
    }
}
