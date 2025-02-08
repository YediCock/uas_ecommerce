<!-- resources/views/pdf/report.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .period {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $filter == 'product' ? 'Laporan Data Produk' : 'Laporan Pendapatan' }}</h2>
    </div>

    <div class="period">
        <p>Periode: {{ $start_date }} - {{ $end_date }}</p>
        @if($filter == 'pendapatan' && $status)
            <p>Status: {{ ucfirst($status) }}</p>
        @endif
    </div>

    @if($filter == 'product')
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->getCategory->name }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ Carbon\Carbon::parse($product->created_at)->format('d M Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>Total Produk: {{ $products->count() }}</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Order ID</th>
                    <th>Nama Customer</th>
                    <th>No. Telepon</th>
                    <th>Status</th>
                    <th>Total Harga</th>
                    <th>No. Resi</th>
                    <th>Tanggal Order</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->status }}</td>
                        <td>Rp {{ number_format($order->final_price, 0, ',', '.') }}</td>
                        <td>{{ $order->track_number }}</td>
                        <td>{{ Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="5" style="text-align: right">Total Pendapatan</td>
                    <td colspan="3">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        <p>Total Order: {{ $orders->count() }}</p>
    @endif

    <div style="margin-top: 20px">
        <p>Dicetak pada: {{ Carbon\Carbon::now()->format('d M Y H:i:s') }}</p>
    </div>
</body>
</html>