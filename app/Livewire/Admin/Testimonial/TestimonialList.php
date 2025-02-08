<?php

namespace App\Livewire\Admin\Testimonial;

use App\Models\Testimonial;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class TestimonialList extends Component
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
        $testimonials = Testimonial::latest()->search($this->search)->limit($this->limitData)->get();
        return view('livewire.admin.testimonial.testimonial-list', compact('testimonials'));
    }
    public function addLimitData()
    {
        $this->limitData += 10;
    }
    public function deleteTestimonial($id)
    {
        $testimonial = Testimonial::where('id', $id)->first();

        // Hapus gambar 
        $image = public_path('/assets/testimonial/' . $testimonial->image);
        if (File::exists($image)) {
            File::delete($image);
        }

        // Hapus entri dari tabel testimonial
        $testimonial->delete();

        $this->alert('success', 'Berhasil menghapus testimonial ini');
        return back();
    }
}
