<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    public function generatePDF(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'filter' => 'required|in:product,pendapatan'
        ]);

        $data = [
            'start_date' => Carbon::parse($request->start_date)->format('d M Y'),
            'end_date' => Carbon::parse($request->end_date)->format('d M Y'),
            'filter' => $request->filter,
            'status' => $request->status
        ];

        if ($request->filter == 'product') {
            $data['products'] = Product::with('getCategory')
                ->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ])
                ->get();
        } else {
            $query = Order::with('getCart')
                ->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ]);
            
            if ($request->status) {
                $query->where('status', $request->status);
            }

            $orders = $query->get();
            $data['orders'] = $orders;
            $data['totalPendapatan'] = $orders->sum('final_price');
        }

        $pdf = PDF::loadView('pdf.report', $data);
        
        $fileName = sprintf(
            "Laporan_%s_%s_sd_%s.pdf",
            $request->filter == 'product' ? 'Produk' : 'Pendapatan',
            Carbon::parse($request->start_date)->format('d-m-Y'),
            Carbon::parse($request->end_date)->format('d-m-Y')
        );

        return $pdf->download($fileName);
    }
}