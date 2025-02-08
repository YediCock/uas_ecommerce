<?php

namespace App\Livewire\Admin\Category;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Intervention\Image\ImageManagerStatic as Image;

class CategoryEdit extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    #[Layout('components.layouts.admin')]
    public $name, $status, $icon, $category;
    public function mount($id)
    {
        $this->category = Category::where('id',$id)->first();

        if ($this->category) {
            $this->name = $this->category->name;
            $this->status = $this->category->status;
        }
    }
    public function render()
    {
        return view('livewire.admin.category.category-edit');
    }
    public function editCategory()
    {
        $validatedData = $this->validate([
            'name' => 'required|unique:categories,name,' . $this->category->id,
            'status' => 'required|in:active,nonactive',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        
        if ($validatedData) {
            // Cari kategori berdasarkan ID
            $category = Category::where('id', $this->category->id)->first();
            if (!$category) {
                // Handle jika tidak ditemukan
                $this->flash('error', 'Kategori tidak ditemukan');
                return;
            }
            // Handle icon update jika ada
            if ($this->icon) {
                // Hapus gambar lama jika ada
                if (file_exists(public_path('assets/category/' . $category->icon))) {
                    unlink(public_path('assets/category/' . $category->icon));
                }
                $random = Str::random(20);
                $imgInput = $this->icon;
                $imgUpdate = $random . '.' . $imgInput->getClientOriginalExtension();
                $location = 'assets/category/';
                $path = ($location . $imgUpdate);
                $upload = Image::make($imgInput->path())->resize(250, 250);
                $upload->save($path);
                
                $category->icon = $imgUpdate;
            }

            $category->name = $this->name;
            $category->status = $this->status;
            $category->save();
        }
        $this->flash('success', 'Kategori berhasil diperbarui');
        return redirect()->to('/admin/category/list-category');
    }

}
