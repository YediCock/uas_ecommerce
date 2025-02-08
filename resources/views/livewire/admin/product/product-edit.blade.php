<div>
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/product/list-product">Produk</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Produk</li>
            </ol>
        </nav>
    </div>

    <div class="col-lg-12 layout-spacing layout-top-spacing">

        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <form class="" wire:submit="editProduct">
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <label>Nama Produk</label>
                            <input wire:model="name" type="text" class="form-control" id="post-title">
                            @error('name') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                        <div class="col-sm-4">
                            <label for="city">Kategori Produk</label>
                            <select  wire:model="categoryID" id="city" class="form-select">
                                <option selected>pilih kategori</option>
                                @foreach ($categories as $ctg)
                                    <option value="{{$ctg->id}}" {{ $ctg->id == $product->category_id ? 'selected' : '' }}>{{$ctg->name}}</option>
                                @endforeach
                            </select>
                            @error('categoryID') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                        <div class="col-sm-4">
                            <label for="inputState" class="form-label">Apakah produk ini populer?</label>
                            <select wire:model="is_popular" id="inputState" class="form-select">
                                <option selected>pilih salah satu</option>
                                <option value="popular">Ya</option>
                                <option value="notpopular">Tidak</option>
                            </select>
                            @error('is_popular') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <label>Harga Produk</label>
                            <input wire:model="price" type="number" class="form-control" id="post-title">
                            @error('price') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                        <div class="col-sm-4">
                            <label>Poin Pembelian Produk</label>
                            <input wire:model="point" type="number" class="form-control" id="post-title">
                            @error('point') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                        <div class="col-sm-4">
                            <label for="inputState" class="form-label">Status</label>
                            <select wire:model="status" id="inputState" class="form-select">
                                <option selected>pilih salah satu</option>
                                <option value="active">Aktif</option>
                                <option value="nonactive">Tidak Aktif</option>
                            </select>
                            @error('status') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <label>Diskon Produk (%) <span class="text-danger">*optional</span></label>
                            <input wire:model="discount" type="number" class="form-control" id="post-title">
                            @error('discount') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                        <div class="col-sm-4">
                            <label>Berat Produk (gram)</label>
                            <input wire:model="weight" type="number" class="form-control" id="post-title">
                            @error('weight') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-8">
                            <label>Deskripsi Produk</label>
                            <input  id="desc" type="hidden" name="desc">
                            <trix-editor input="desc" wire:model="desc"></trix-editor>
                        </div>
                        @error('desc') <span class="error text-danger ">{{ $message }}</span> @enderror 
                    </div>              
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <label>Upload Gambar Thumbnail Product</label>
                            <input wire:ignore wire:model="img_thumbnail" type="file" class="form-control-file" @error('img_thumbnail') has-error @enderror" placeholder="image" onchange="previewSketsa('.imageDemo1', this.files[0])">
                            <div wire:ignore class="col-md mt-3">
                                <input type="hidden" name="oldImage" value="{{ $product->img_thumbnail }}">
                                @if ($product->img_thumbnail)
                                    <img src="/assets/product/{{ $product->img_thumbnail }}" class="img-preview img-fluid mb-3 col-sm-5 d-block imageDemo1">   
                                @endif
                            </div>
                            @error('img_thumbnail') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                        <div class="col-sm-8">
                            <label class="mb-0">Upload Gambar Product</label>
                            <p class="text-danger mb-0">*maksimal 5 file</p>
                            <input wire:ignore wire:model="product_image"  type="file"  class="form-control-file" @error('product_image') has-error @enderror" placeholder="image" onchange="previewMulti('.imageDemo', this.files)" multiple>
                            @error('product_image') <span class="error text-danger ">{{ $message }}</span> @enderror 
                            <div wire:ignore class="row mt-3 imageDemo">
                            </div>   
                            <div class="row mt-3">
                                <label>Gambar lama</label>
                                @foreach ($product->getAsset as $img)
                                    <div class="col-sm-6 col-md-4">
                                        <img src="/assets/assetImage/{{ $img->image }}" style="max-width: 160px" class="img-preview img-fluid mb-1 d-block"> 
                                        <a wire:click="deleteImageProduct({{ $img->id }})" wire:confirm="Apakah anda yakin ingin menghapus?" class=" btn btn-sm btn-danger mb-1 _effect--ripple waves-effect waves-light">Hapus Gambar</a>
                                    </div>
                                @endforeach
                            </div>                          
                        </div>
                    </div>
                    <div class="row mb-4">
                        @if ($product->type == 'simple')
                            <div class="d-flex">
                                <p class="fs-5 me-3 mt-">Apakah produk ini ada atributnya? </p> 
                                <a wire:click="typeAttribute" class="mb-1 btn btn-success _effect--ripple waves-effect waves-light">YA</a>
                            </div>
                        @else
                            <p class="fs-5 me-3 mt-">Atribute Produk </p> 
                        @endif
                        @if ($produkAttribute == 1 || $product->type == 'attribute')
                            @foreach($dataAttributes as $attribute)
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <p class="fs-5 fw-bold">Atribut {{ $attribute->name }}</p>
                                        <div>
                                            @foreach($attribute->getAttributeValues as $value)
                                                <div class="form-check d-flex align-items-center gap-2 mb-3">
                                                    <input style="width: 8%" class="form-check-input mb-1" type="checkbox" id="attribute_{{ $value->id }}" 
                                                        wire:model.defer="selectedAttributes.{{ $attribute->id }}.{{ $value->id }}.checked" 
                                                        value="{{ $value->id }}">
                                                    <label style="width: 30%" class="form-check-label mb-0" for="attribute_{{ $value->id }}">
                                                        {{ $value->name }}
                                                    </label>
                                                    <input type="number" class="form-control" placeholder="+ harga (opsional)" 
                                                        wire:model.defer="selectedAttributes.{{ $attribute->id }}.{{ $value->id }}.price">
                                                    <input type="number" class="form-control" placeholder="+ berat(gram)(opsional)" 
                                                        wire:model.defer="selectedAttributes.{{ $attribute->id }}.{{ $value->id }}.weight">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach 
                        @endif
                    </div>
                    <button class="btn btn-primary btn-lg mb-2 me-4 _effect--ripple waves-effect waves-light" wire:loading><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin me-2"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>  Loading</button>
                    <button type="submit" class="btn btn-primary _effect--ripple waves-effect waves-light " wire:loading.remove>Edit Produk</button>
                </form>
            </div>
        </div>
    </div>
</div>

