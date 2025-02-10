<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
    public function generatePDF(Request $request)
    {
        // Existing PDF generation code...
    }

    public function generateExcel(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'filter' => 'required|in:product,pendapatan'
        ]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set judul laporan
        $title = $request->filter == 'product' ? 'LAPORAN DATA PRODUK' : 'LAPORAN PENDAPATAN';
        $sheet->setCellValue('A1', $title);
        $sheet->mergeCells('A1:E1');

        // Set periode
        $periode = sprintf(
            "Periode: %s - %s",
            Carbon::parse($request->start_date)->format('d M Y'),
            Carbon::parse($request->end_date)->format('d M Y')
        );
        $sheet->setCellValue('A2', $periode);
        $sheet->mergeCells('A2:E2');

        // Style header
        $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        if ($request->filter == 'product') {
            // Header untuk data produk
            $sheet->setCellValue('A4', 'No');
            $sheet->setCellValue('B4', 'Nama Produk');
            $sheet->setCellValue('C4', 'Kategori');
            $sheet->setCellValue('D4', 'Harga');
            $sheet->setCellValue('E4', 'Tanggal Dibuat');

            $products = Product::with('getCategory')
                ->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ])
                ->get();

            $row = 5;
            foreach ($products as $index => $product) {
                $sheet->setCellValue('A' . $row, $index + 1);
                $sheet->setCellValue('B' . $row, $product->name);
                $sheet->setCellValue('C' . $row, $product->getCategory->name);
                $sheet->setCellValue('D' . $row, 'Rp ' . number_format($product->price, 0, ',', '.'));
                $sheet->setCellValue('E' . $row, Carbon::parse($product->created_at)->format('d M Y H:i'));
                $row++;
            }
        } else {
            // Header untuk data pendapatan
            $sheet->setCellValue('A4', 'No');
            $sheet->setCellValue('B4', 'Order ID');
            $sheet->setCellValue('C4', 'Nama Customer');
            $sheet->setCellValue('D4', 'No. Telepon');
            $sheet->setCellValue('E4', 'Status');
            $sheet->setCellValue('F4', 'Total Harga');
            $sheet->setCellValue('G4', 'No. Resi');
            $sheet->setCellValue('H4', 'Tanggal Order');

            $query = Order::with('getCart')
                ->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ]);
            
            if ($request->status) {
                $query->where('status', $request->status);
            }

            $orders = $query->get();
            $totalPendapatan = $orders->sum('final_price');

            $row = 5;
            foreach ($orders as $index => $order) {
                $sheet->setCellValue('A' . $row, $index + 1);
                $sheet->setCellValue('B' . $row, $order->id);
                $sheet->setCellValue('C' . $row, $order->customer_name);
                $sheet->setCellValue('D' . $row, $order->phone);
                $sheet->setCellValue('E' . $row, $order->status);
                $sheet->setCellValue('F' . $row, 'Rp ' . number_format($order->final_price, 0, ',', '.'));
                $sheet->setCellValue('G' . $row, $order->track_number);
                $sheet->setCellValue('H' . $row, Carbon::parse($order->created_at)->format('d M Y H:i'));
                $row++;
            }

            // Tambah total pendapatan
            $sheet->setCellValue('E' . $row, 'Total Pendapatan:');
            $sheet->setCellValue('F' . $row, 'Rp ' . number_format($totalPendapatan, 0, ',', '.'));
            $sheet->getStyle('E' . $row . ':F' . $row)->getFont()->setBold(true);
        }

        // Style tabel
        $lastColumn = $request->filter == 'product' ? 'E' : 'H';
        $lastRow = $row;
        
        $tableRange = 'A4:' . $lastColumn . $lastRow;
        $sheet->getStyle($tableRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A4:' . $lastColumn . '4')->getFont()->setBold(true);

        // Auto-size columns
        foreach (range('A', $lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Create Excel file
        $writer = new Xlsx($spreadsheet);
        $fileName = sprintf(
            "Laporan_%s_%s_sd_%s.xlsx",
            $request->filter == 'product' ? 'Produk' : 'Pendapatan',
            Carbon::parse($request->start_date)->format('d-m-Y'),
            Carbon::parse($request->end_date)->format('d-m-Y')
        );

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}