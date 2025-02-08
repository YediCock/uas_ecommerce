<?php

namespace App\Livewire\Admin\Banner;

use App\Models\Banner;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Intervention\Image\ImageManagerStatic as Image;
class BannerAdd extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    #[Layout('components.layouts.admin')]
    public $title, $url, $image;
    public function render()
    {
        return view('livewire.admin.banner.banner-add');
    }
    public function addBanner()
    {
        // Validasi input
        $validatedData = $this->validate([
            'title' => 'nullable|string|max:255|unique:banners',
            'url' => 'nullable|url',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validatedData) {
            // Handle store thumbnail image
            if ($this->image) {
                $random = Str::random(20);
                $imgbanner = $this->image;
                $saveImgBanner = $random . '.' . $imgbanner->getClientOriginalExtension();
                $location = 'assets/banner/';
                $path = ($location . $saveImgBanner);
                $upload = Image::make($imgbanner->path())->resize(1328, 760);
                $upload->save($path);    
            }

            // Handle store creation
            Banner::create([
                'title' => $this->title,
                'url' => $this->url,
                'image' => $saveImgBanner,
            ]);
        }

        $this->flash('success', 'Banner berhasil ditambahkan');
        return redirect()->to('/admin/banner/list-banner');
    }
}
