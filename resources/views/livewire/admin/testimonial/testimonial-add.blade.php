<div>
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/testimonial/list-testimonial">Testimonial</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Testimonial</li>
            </ol>
        </nav>
    </div>

    <div class="col-lg-12 layout-spacing layout-top-spacing">

        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <form class="" wire:submit="addTestimonial">
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <label>Nama</label>
                            <input wire:model="name" type="text" class="form-control" id="post-title">
                            @error('name') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-8">
                            <label for="exampleFormControlTextarea1">Deskripsi</label>
                            <textarea wire:model="desc" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            @error('desc') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>            
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <label>Upload Gambar</label>
                            <input wire:ignore wire:model="image" type="file" class="form-control-file" @error('image') has-error @enderror" placeholder="image" onchange="previewSketsa('.imageDemo1', this.files[0])">
                            <div wire:ignore class="col-md mt-3">
                                <img src="" alt="" class="img-preview img-fluid mb-3 col-sm-5 d-block imageDemo1">
                            </div>
                            @error('image') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg mb-2 me-4 _effect--ripple waves-effect waves-light" wire:loading><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin me-2"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>  Loading</button>
                    <button type="submit" class="btn btn-primary _effect--ripple waves-effect waves-light " wire:loading.remove>Tambah Testimonial</button>
                </form>
            </div>
        </div>
    </div>
</div>

