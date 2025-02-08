<div>
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/report">Laporan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Filter Laporan</li>
            </ol>
        </nav>
    </div>

    <div class="col-lg-12 layout-spacing layout-top-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <form wire:submit="reportSystem">
                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <label>Tanggal Mulai</label>
                            <input wire:model="start_date" type="date" class="form-control">
                            @error('start_date') <span class="error text-danger">{{ $message }}</span> @enderror 
                        </div>
                        <div class="col-sm-3">
                            <label>Tanggal Akhir</label>
                            <input wire:model="end_date" type="date" class="form-control">
                            @error('end_date') <span class="error text-danger">{{ $message }}</span> @enderror 
                        </div>
                        <div class="col-sm-3">
                            <label>Jenis Laporan</label>
                            <select wire:model="filter" class="form-select">
                                <option value="">Pilih jenis laporan</option>
                                <option value="product">Data Produk</option>
                                <option value="pendapatan">Data Order</option>
                            </select>
                            @error('filter') <span class="error text-danger">{{ $message }}</span> @enderror 
                        </div>
                        <div class="col-sm-3" @if($filter != 'pendapatan') style="display: none;" @endif>
                            <label>Status Order</label>
                            <select wire:model="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="finish">Selesai</option>
                                <option value="pending">Pending</option>
                                <!-- Add other status options as needed -->
                            </select>
                        </div>
                        <div class="col-12 mt-3">
                            {{-- <button class="btn btn-primary" type="submit">Tampilkan Laporan</button> --}}
                            <div class="col-12 mt-3">
                                <button class="btn btn-primary" type="submit">Tampilkan Laporan</button>
                                @if(($filter == 'product' && count($products) > 0) || ($filter == 'pendapatan' && count($orders) > 0))
                                    <a href="{{ route('admin.report.pdf', [
                                        'start_date' => $start_date,
                                        'end_date' => $end_date,
                                        'filter' => $filter,
                                        'status' => $status
                                    ]) }}" class="btn btn-success ms-2" target="_blank">
                                        Cetak PDF
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>

                @if ($filter == 'product' && count($products) > 0)
                    <div class="table-responsive">
                        <h4>Data Produk</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Tanggal Dibuat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->getCategory->name }}</td>
                                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td>{{ Carbon\Carbon::parse($product->created_at)->format('d M Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if ($filter == 'pendapatan' && count($orders) > 0)
                    <div class="table-responsive">
                        <h4>Data Order</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
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
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->phone }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>Rp {{ number_format($order->final_price, 0, ',', '.') }}</td>
                                        <td>{{ $order->track_number }}</td>
                                        <td>{{ Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}</td>
                                    </tr>
                                @endforeach
                                <tr class="table-primary">
                                    <td colspan="4" class="text-end fw-bold">Total Pendapatan</td>
                                    <td colspan="3" class="fw-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

                @if (($filter == 'product' && count($products) == 0) || ($filter == 'pendapatan' && count($orders) == 0))
                    <div class="alert alert-info">
                        Tidak ada data untuk periode yang dipilih
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>