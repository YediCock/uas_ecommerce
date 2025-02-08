<?php

namespace App\Livewire\Admin\Testimonial;

use App\Models\Testimonial;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Intervention\Image\ImageManagerStatic as Image;
class TestimonialEdit extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    #[Layout('components.layouts.admin')]
    public $name, $desc, $image;
    public $testimonial;
    public function mount($id)
    {
        $this->testimonial = Testimonial::where('id',$id)->first();

        if ($this->testimonial) {
            $this->name = $this->testimonial->name;
            $this->desc = $this->testimonial->desc;
        }
    }
    public function render()
    {
        return view('livewire.admin.testimonial.testimonial-edit');
    }
    public function editTestimonial()
    {
        // Validasi input
        $validatedData = $this->validate([
            'name' => 'required|string|max:255|unique:testimonials,name,' . $this->testimonial->id,
            'desc' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validatedData) {
            // Handle store thumbnail image
            if ($this->image) {
                // Hapus gambar lama jika ada
                if (file_exists(public_path('assets/testimonial/' . $this->testimonial->image))) {
                    unlink(public_path('assets/testimonial/' . $this->testimonial->image));
                }

                $random = Str::random(20);
                $imgTestimonial = $this->image;
                $imageSave = $random . '.' . $imgTestimonial->getClientOriginalExtension();
                $location = 'assets/testimonial/';
                $path = ($location . $imageSave);
                $upload = Image::make($imgTestimonial->path())->resize(256, 256);
                $upload->save($path);    

                // Update thumbnail image
                $this->testimonial->update(['image' => $imageSave]);
            }

            // Handle store creation
            $this->testimonial->update([
                'name' => $this->name,
                'desc' => $this->desc,
            ]);
        }

        $this->flash('success', 'Testimonial berhasil diperbarui');
        return redirect()->to('/admin/testimonial/list-testimonial');
    }
}
