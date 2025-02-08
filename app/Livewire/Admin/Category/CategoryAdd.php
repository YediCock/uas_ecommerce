<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
class CategoryAdd extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    #[Layout('components.layouts.admin')]
    public $name, $status, $icon;
    public function render()
    {
        return view('livewire.admin.category.category-add');
    }
    public function addCategory()
    {
        $validatedData = $this->validate([
            'name' => 'required|unique:categories',
            'status' => 'required|in:active,nonactive',
            'icon' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle store image
        if ($this->icon) {
            $random = Str::random(20);
            $imgInput = $this->icon;
            $imgStore = $random . '.' . $imgInput->getClientOriginalExtension();
            $location = 'assets/category/';
            $path = ($location . $imgStore);
            $upload = Image::make($imgInput->path())->resize(250, 250);
            $upload->save($path);    
        }

        // Handle store creation
        Category::create([
            'name' => $this->name,
            'status' => $this->status,
            'icon' => $imgStore
        ]);

        $this->flash('success', 'Kategory berhasil ditambahkan');
        return redirect()->to('/admin/category/list-category');
    }
}
