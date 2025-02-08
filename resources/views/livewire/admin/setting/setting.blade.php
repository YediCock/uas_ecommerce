<div>
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a>Setting</a></li>
            </ol>
        </nav>
    </div>

    <div class="col-lg-12 layout-spacing layout-top-spacing">

        <div class="statbox widget box box-shadow">
            <div class="widget-content widget-content-area">
                {{-- <div class="filtered-list-search mb-2 w-50">
                    <form class="form-inline my-2 my-lg-0 justify-content-center">
                        <div class="w-100">
                            <input wire:model.live="search" type="text" class="py-2 w-100 form-control product-search br-30" id="input-search" placeholder="Cari kota...">
                        </div>
                    </form>
                </div> --}}
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Value (dalam persen %)</th>
                                <th scope="col">Deskripsi</th>
                                <th class="text-center" scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($settings as $index => $setting)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <form class="" wire:submit.prevent="editSetting({{ $setting->id }})">
                                        <td>
                                            <input wire:model.defer="settingsData.{{ $setting->id }}.name" type="text" class="form-control">
                                        </td>
                                        <td>
                                            <input wire:model.defer="settingsData.{{ $setting->id }}.value" type="text" class="form-control">
                                        </td>
                                        <td>
                                            <input wire:model.defer="settingsData.{{ $setting->id }}.desc" type="text" class="form-control">
                                        </td>
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </td>
                                    </form>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">Tidak ada list setting</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

