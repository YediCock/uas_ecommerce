<?php

namespace App\Livewire\Admin\Testimonial;

use App\Models\Testimonial;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Intervention\Image\ImageManagerStatic as Image;
class TestimonialAdd extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    #[Layout('components.layouts.admin')]
    public $name, $desc, $image;

    public function render()
    {
        return view('livewire.admin.testimonial.testimonial-add');
    }
    public function addTestimonial()
    {
        // Validasi input
        $validatedData = $this->validate([
            'name' => 'required|string|max:255|unique:testimonials',
            'desc' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validatedData) {
            // Handle store thumbnail image
            if ($this->image) {
                $random = Str::random(20);
                $imgTestimonial = $this->image;
                $imageSave = $random . '.' . $imgTestimonial->getClientOriginalExtension();
                $location = 'assets/testimonial/';
                $path = ($location . $imageSave);
                $upload = Image::make($imgTestimonial->path())->resize(256, 256);
                $upload->save($path);    
            }

            // Handle store creation
            Testimonial::create([
                'name' => $this->name,
                'desc' => $this->desc,
                'image' => $imageSave,
            ]);
        }

        $this->flash('success', 'Testimonial berhasil ditambahkan');
        return redirect()->to('/admin/testimonial/list-testimonial');
    }
}
