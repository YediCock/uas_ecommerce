<?php

namespace App\Livewire\Admin\Banner;

use App\Models\Banner;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Intervention\Image\ImageManagerStatic as Image;
class BannerEdit extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    #[Layout('components.layouts.admin')]
    public $title, $url, $image, $banner;
    public function mount($id)
    {
        $this->banner = Banner::where('id',$id)->first();

        if ($this->banner) {
            $this->title = $this->banner->title;
            $this->url = $this->banner->url;
        }
    }
    public function render()
    {
        return view('livewire.admin.banner.banner-edit');
    }
    public function editBanner()
    {
        // Validasi input
        $validatedData = $this->validate([
            'title' => 'nullable|string|max:255|unique:banners,title,' . $this->banner->id,
            'url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validatedData) {
            // Handle store thumbnail image
            if ($this->image) {
                // Hapus gambar lama jika ada
                if (file_exists(public_path('assets/banner/' . $this->banner->image))) {
                    unlink(public_path('assets/banner/' . $this->banner->image));
                }

                $random = Str::random(20);
                $imgbanner = $this->image;
                $saveImgBanner = $random . '.' . $imgbanner->getClientOriginalExtension();
                $location = 'assets/banner/';
                $path = ($location . $saveImgBanner);
                $upload = Image::make($imgbanner->path())->resize(1328, 760);
                $upload->save($path);    

                // Update image
                $this->banner->update(['image' => $saveImgBanner]);
            }

            // Handle store creation
            $this->banner->update([
                'title' => $this->title !== '' ? $this->title : null,
                'url' => $this->url !== '' ? $this->url : null,
            ]);
        }

        $this->flash('success', 'Banner berhasil diperbarui');
        return redirect()->to('/admin/banner/list-banner');
    }
}
