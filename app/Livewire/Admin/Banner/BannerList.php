<?php

namespace App\Livewire\Admin\Banner;

use App\Models\Banner;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class BannerList extends Component
{
    use LivewireAlert;
    #[Layout('components.layouts.admin')]
    public $search = '';
    public $limitData;
    public function mount()
    {
        $this->limitData = 10;
    }
    public function render()
    {
        $banners = Banner::latest()->search($this->search)->limit($this->limitData)->get();
        return view('livewire.admin.banner.banner-list', compact('banners'));
    }
    public function addLimitData()
    {
        $this->limitData += 10;
    }
    public function deleteBanner($id)
    {
        $banner = Banner::where('id', $id)->first();

        // Hapus gambar 
        $image = public_path('/assets/banner/' . $banner->image);
        if (File::exists($image)) {
            File::delete($image);
        }

        // Hapus entri dari tabel banner
        $banner->delete();

        $this->alert('success', 'Berhasil menghapus banner ini');
        return back();
    }
}
