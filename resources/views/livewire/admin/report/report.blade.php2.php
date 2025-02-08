<div>
    
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/product/list-product">Produk</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Produk</li>
            </ol>
        </nav>
    </div>

    <div class="col-lg-12 layout-spacing layout-top-spacing">

        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <form class="" wire:submit="reportSystem">
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <label>Start Date</label>
                            <input wire:model="start_date" type="date" class="form-control" id="post-title">
                            @error('start_date') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                        <div class="col-sm-4">
                            <label>End Date</label>
                            <input wire:model="end_date" type="date" class="form-control" id="post-title">
                            @error('end_date') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                        <div class="col-sm-4">
                            <label for="inputState" class="form-label">Filter</label>
                            <select wire:model="filter" id="inputState" class="form-select">
                                <option selected>Pilih salah satu</option>
                                <option value="product" {{ old('filter') == 'product' ? 'selected' : '' }}>Produk</option>
                                <option value="pencapatan" {{ old('filter') == 'pencapatan' ? 'selected' : '' }}>Pendapatan</option>
                            </select>
                            @error('filter') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                        <button class='btn btn-primary' type="submit">Tampilkan Laporan</button>
                    </div>
                </form>
                @if ($filter == 'product')
                    <h4>Laporan Produk terjual</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    {{-- <td>@dd($product->getCategory)</td> --}}
                                    {{-- <td>{{ $product->getCategory->name }}</td> --}}
                                    <td>{{ $product->price }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif ($filter == 'pencapatan')
                    <livewire:admin.report.pencapatan-report :start_date="$start_date" :end_date="$end_date" />
                @endif
            </div>
        </div>
    </div>
</div>
