<div>
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/order/list-order">Order</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Order</li>
            </ol>
        </nav>
    </div>
    <div class="middle-content container-xxl p-0">
        
        <div class="row invoice layout-top-spacing layout-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                
                <div class="doc-container">

                    <div class="row">

                        <div class="col-xl-12">

                            <div class="invoice-container">
                                <div class="invoice-inbox">
                                    
                                    <div id="ct" class="">
                                        
                                        <div class="invoice-00001">
                                            <div class="content-section">

                                                <div class="mb-3 pb-3 inv--head-section inv--detail-section">
                                                
                                                    <div class="row">

                                                        <div class="col-sm-6 col-12 mr-auto">
                                                            <h4>Detail Pesanan</h4>
                                                            <p class="inv-street-addr mt-2">Status Pesanan : {{ $order->status }}</p>
                                                            <p class="inv-street-addr mt-2">Tanggal Pembelian : {{ $order->created_at->format('d F Y') }}</p>
                                                            <p class="inv-street-addr mt-2">Kurir : {{ $order->shipping_courier }} - {{ $order->shipping_service_name }}</p>
                                                            <p class="inv-street-addr mt-2">Nomer Resi : {{ $order->track_number ?? '-' }}</p>
                                                            <p class="inv-street-addr mt-2">Berat total produk : {{ $order->total_weight }} gram</p>
                                                        </div>                                                            
                                                    </div>
                                                    
                                                </div>

                                                <div class="pb-3 inv--detail-section inv--customer-detail-section">

                                                    <div class="row">
                                                        <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4">
                                                            <h4>Alamat Pengiriman</h4>
                                                            <p class="inv-street-addr mt-2">Nama Customer : {{ $order->customer_name }}</p>
                                                            <p class="inv-street-addr mt-2">Nomer HP : {{ $order->phone }}</p>
                                                            <p class="inv-street-addr mt-2">Kota / Kabupaten : {{ $order->customer_city }}</p>
                                                            <p class="inv-street-addr mt-2">Provinsi : {{ $order->customer_province }}</p>
                                                            <p class="inv-street-addr mt-2">Alamat : {{ $order->address }}</p>
                                                        </div>

                                                    </div>
                                                    
                                                </div>

                                                <div class="py-3 inv--product-table-section">
                                                    <h4 class="ms-4 ps-2">Detail Produk</h4>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead class="">
                                                                <tr>
                                                                    <th scope="col">No</th>
                                                                    <th scope="col">Nama Produk</th>
                                                                    <th scope="col">Variant</th>
                                                                    <th class="" scope="col">Jumlah</th>
                                                                    <th class="text-end" scope="col">Price</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($order->getCart as $index => $cart)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $cart->getProduct->name }}</td>
                                                                    @if($cart->attributes)
                                                                        <td class="">
                                                                            @foreach($cart->attributes as $attribute)
                                                                                {{ $attribute['attribute_name'] }}: {{ $attribute['attribute_value'] }}.
                                                                            @endforeach
                                                                        </td>
                                                                    @else
                                                                        <td class="">-</td>
                                                                    @endif
                                                                    <td class="">{{ $cart->quantity }}</td>
                                                                    <td class="text-end">Rp.{{ number_format($cart->calculateTotalPrice($cart->getProduct->price, $cart->attributes), 0, ',', '.') }}</td>
                                                                </tr>
                                                                @endforeach  
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                
                                                <div class="pb-3 mb-3 inv--total-amounts">
                                                
                                                    <div class="row mt-4">
                                                        <div class="col-sm-5 col-12 order-sm-0 order-1">
                                                        </div>
                                                        <div class="col-sm-7 col-12 order-sm-1 order-0">
                                                            <div class="text-sm-end">
                                                                <div class="row">
                                                                    <div class="col-sm-8 col-7">
                                                                        <p class="">Subtotal ({{ $order->getCart->sum('quantity') }} produk) :</p>
                                                                    </div>
                                                                    <div class="col-sm-4 col-5">
                                                                        <p class="">Rp.{{ number_format($order->total_price, 0, ',', '.') }}</p>
                                                                    </div>
                                                                    <div class="col-sm-8 col-7">
                                                                        <p class="">Total Biaya Pengiriman :</p>
                                                                    </div>
                                                                    <div class="col-sm-4 col-5">
                                                                        <p class="">Rp.{{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
                                                                    </div>
                                                                    <div class="col-sm-8 col-7">
                                                                        <p class=" discount-rate">PPN {{ $order->tax }}% :</p>
                                                                    </div>
                                                                    <div class="col-sm-4 col-5">
                                                                        <p class="">Rp.{{ number_format($order->tax_amount, 0, ',', '.') }}</p>
                                                                    </div>
                                                                    <div class="col-sm-8 col-7 grand-total-title mt-3">
                                                                        <h4 class="text-dark">Total Belanja : </h4>
                                                                    </div>
                                                                    <div class="col-sm-4 col-5 grand-total-amount mt-3">
                                                                        <h4 class="text-dark">Rp.{{ number_format($order->final_price, 0, ',', '.') }}</h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="pt-0 inv--product-table-section">
                                                    <h4 class="ms-4 ps-2">Bukti Transfer</h4>
                                                    <div class="ms-4 ps-2">
                                                        <!-- Thumbnail Image -->
                                                        @if($order->proof_of_payment)
                                                            <img src="/assets/confirmPayment/{{ $order->proof_of_payment }}" alt="Thumbnail" class="img-thumbnail" style="width: 150px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal">
                                                            <br>
                                                            @if ($order->status == 'unpaid')
                                                                <a  wire:confirm="Apakah anda yakin customer ini sudah membayar?" wire:click="confirmPayment({{ $order->id }})" class="mt-4 btn btn-primary">Konfirmasi Bukti Transfer</a>
                                                            @endif
                                                        @else
                                                            <p>Customer belum upload bukti transfer</p>
                                                        @endif
    
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="imageModalLabel">Detail Gambar</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <img src="/assets/confirmPayment/{{ $order->proof_of_payment }}" alt="Full Image" class="img-fluid">
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($order->status == 'paid')
                                                <div class="pt-0 inv--product-table-section">
                                                    <h4 class="ms-4 ps-2">Input Resi Pengiriman Barang</h4>
                                                    <div class="ms-4 ps-2">
                                                        <form class="" wire:submit="editOrder">
                                                            <div class="row mb-4">
                                                                <div class="col-sm-4">
                                                                    <label>Nomer Resi</label>
                                                                    <input wire:model="track_number" type="text" class="form-control" id="post-title">
                                                                    @error('track_number') <span class="error text-danger ">{{ $message }}</span> @enderror 
                                                                </div>
                                                            </div>
                                                            <button class="btn btn-primary btn-lg mb-2 me-4 _effect--ripple waves-effect waves-light" wire:loading><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin me-2"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>  Loading</button>
                                                            <button type="submit" class="btn btn-primary _effect--ripple waves-effect waves-light " wire:loading.remove>Edit Order</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div> 
                                        
                                    </div>


                                </div>

                            </div>

                        </div>


                    </div>
                    
                </div>

            </div>
        </div>

    </div>
</div>