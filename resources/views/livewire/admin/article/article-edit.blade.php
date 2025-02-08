<div>
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/article/list-article">Artikel</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Artikel</li>
            </ol>
        </nav>
    </div>

    <div class="col-lg-12 layout-spacing layout-top-spacing">

        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <form class="" wire:submit="editArticle">
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <label>Nama Artikel</label>
                            <input wire:model="name" type="text" class="form-control" id="post-title">
                            @error('name') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                        <div class="col-sm-4">
                            <label>Url Youtube</label>
                            <input wire:model="url_yt" type="text" class="form-control" id="post-title">
                            @error('url_yt') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-8">
                            <label>Deskripsi Artikel</label>
                            <input  id="desc" type="hidden" name="desc">
                            <trix-editor input="desc" wire:model="desc"></trix-editor>
                        </div>
                        @error('desc') <span class="error text-danger ">{{ $message }}</span> @enderror 
                    </div>              
                    <div class="row mb-4">
                        <div class="col-sm-4">
                            <label>Upload Gambar Thumbnail Artikel</label>
                            <input wire:ignore wire:model="img_thumbnail" type="file" class="form-control-file" @error('img_thumbnail') has-error @enderror" placeholder="image" onchange="previewSketsa('.imageDemo1', this.files[0])">
                            <div wire:ignore class="col-md mt-3">
                                <input type="hidden" name="oldImage" value="{{ $article->img_thumbnail }}">
                                @if ($article->img_thumbnail)
                                    <img src="/assets/article/{{ $article->img_thumbnail }}" class="img-preview img-fluid mb-3 col-sm-5 d-block imageDemo1">   
                                @endif
                            </div>
                            @error('img_thumbnail') <span class="error text-danger ">{{ $message }}</span> @enderror 
                        </div>
                        <div class="col-sm-8">
                            <label class="mb-0">Upload Gambar Artikel</label>
                            <p class="text-danger mb-0">*maksimal 5 file</p>
                            <input wire:ignore wire:model="article_image"  type="file"  class="form-control-file" @error('article_image') has-error @enderror" placeholder="image" onchange="previewMulti('.imageDemo', this.files)" multiple>
                            @error('article_image') <span class="error text-danger ">{{ $message }}</span> @enderror 
                            <div wire:ignore class="row mt-3 imageDemo">
                            </div>   
                            <div class="row mt-3">
                                <label>Gambar lama</label>
                                @foreach ($article->getAsset as $img)
                                    <div class="col-sm-6 col-md-4">
                                        <img src="/assets/assetImage/{{ $img->image }}" style="max-width: 160px" class="img-preview img-fluid mb-1 d-block"> 
                                        <a wire:click="deleteImageArticle({{ $img->id }})" wire:confirm="Apakah anda yakin ingin menghapus?" class=" btn btn-sm btn-danger mb-1 _effect--ripple waves-effect waves-light">Hapus Gambar</a>
                                    </div>
                                @endforeach
                            </div>                          
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg mb-2 me-4 _effect--ripple waves-effect waves-light" wire:loading><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin me-2"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>  Loading</button>
                    <button type="submit" class="btn btn-primary _effect--ripple waves-effect waves-light " wire:loading.remove>Edit Artikel</button>
                </form>
            </div>
        </div>
    </div>
</div>

