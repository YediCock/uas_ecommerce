<?php

namespace App\Livewire\Admin\Report;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Order;
use App\Models\Product;

class Report extends Component
{
    public $start_date;
    public $end_date;
    public $filter;
    
    #[Layout('components.layouts.admin')]


    public function render()
    {
        $products = Order::where('status', 'finish')->get();
        return view('livewire.admin.report.report', compact('products'));
    }

    public function reportSystem()
    {
        $products = Product::with('getCategory')->get();
        $orders = Order::where('status', 'finish')->get();
        if($this->filter == 'product'){
            $products = Product::with('getCategory')->whereBetween('created_at', [$this->start_date, $this->end_date])->get();
        }
        if($this->filter == 'pendapatan'){
            $pendapatan = Order::whereBetween('created_at', [$this->start_date, $this->end_date])->where('status', 'finish')->get();
            $totalPendapatan = $pendapatan->sum('final_price');
        }
        return view('livewire.admin.report.report', compact('products'));
    }

}
