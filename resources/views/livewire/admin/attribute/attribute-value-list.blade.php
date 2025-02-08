<div>
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a>Atribut Value</a></li>
            </ol>
        </nav>
    </div>

    <div class="col-lg-12 layout-spacing layout-top-spacing">

        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="widget-heading">
                            <h5 class="">Tambah Atribut Value {{ $attribute->name }}</h5>
                        </div>
                        <form class="" wire:submit="addAttributeValue">
                            <div class="row mb-4">
                                <div class="col-sm-4">
                                    <label>Nama atribut value</label>
                                    <input wire:model="name" type="text" class="form-control" id="post-title">
                                    @error('name') <span class="error text-danger ">{{ $message }}</span> @enderror 
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
                            <button class="btn btn-primary btn-lg mb-2 me-4 _effect--ripple waves-effect waves-light" wire:loading><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin me-2"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>  Loading</button>
                            <button type="submit" class="btn btn-primary _effect--ripple waves-effect waves-light " wire:loading.remove>Tambah Atribut Value</button>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Status</th>
                                <th class="text-center" scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attributeValues as $index => $attributeValue)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <form class="">
                                        <td>
                                            <input wire:model.defer="attributeValuesData.{{ $attributeValue->id }}.name" type="text" class="form-control">
                                        </td>
                                        <td>
                                            <select wire:model.defer="attributeValuesData.{{ $attributeValue->id }}.status" id="inputState" class="form-select">
                                                <option value="">Pilih salah satu</option>
                                                <option value="active" @if($attributeValuesData[$attributeValue->id]['status'] == 'active') selected @endif>Aktif</option>
                                                <option value="nonactive" @if($attributeValuesData[$attributeValue->id]['status'] == 'nonactive') selected @endif>Tidak Aktif</option>
                                            </select> 
                                        </td>
                                        <td class="text-center">
                                            <a wire:click="editAttributeValue({{ $attributeValue->id }})" class="btn btn-warning">Update</a>
                                            <a wire:confirm="Apakah anda yakin ingin menghapus?" wire:click="deleteAttribute({{ $attributeValue->id }})" class="btn btn-danger">
                                                Hapus
                                            </a>
                                        </td>
                                    </form>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">Tidak ada list atribut value</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

