<?php

namespace App\Livewire\Admin\Report;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;

class Report extends Component
{
    public $start_date;
    public $end_date;
    public $filter;
    public $status = '';
    
    public $products = [];
    public $orders = [];
    public $totalPendapatan = 0;

    #[Layout('components.layouts.admin')]

    public function mount()
    {
        // Set default dates to current month
        $this->start_date = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->end_date = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.admin.report.report', [
            'products' => $this->products,
            'orders' => $this->orders,
            'totalPendapatan' => $this->totalPendapatan
        ]);
    }

    public function reportSystem()
    {
        $this->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'filter' => 'required|in:product,pendapatan'
        ]);

        if ($this->filter == 'product') {
            $query = Product::with('getCategory')
                ->whereBetween('created_at', [
                    $this->start_date . ' 00:00:00',
                    $this->end_date . ' 23:59:59'
                ]);

            $this->products = $query->get();
            $this->orders = collect([]); // Reset orders
            $this->totalPendapatan = 0;
        }

        if ($this->filter == 'pendapatan') {
            $query = Order::with('getCart')
                ->whereBetween('created_at', [
                    $this->start_date . ' 00:00:00',
                    $this->end_date . ' 23:59:59'
                ]);
                
            if ($this->status) {
                $query->where('status', $this->status);
            }

            $this->orders = $query->get();
            $this->totalPendapatan = $this->orders->sum('final_price');
            $this->products = collect([]); // Reset products
        }
    }
}