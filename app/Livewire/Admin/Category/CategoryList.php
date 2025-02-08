<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
class CategoryList extends Component
{
    use LivewireAlert;
    #[Layout('components.layouts.admin')]
    public $limitData;
    public $search = '';
    public function mount()
    {
        $this->limitData = 10;
    }
    public function render()
    {
        $categories = Category::where('status', '!=', 'deleted')->latest()->search($this->search)->limit($this->limitData)->get();
        return view('livewire.admin.category.category-list', compact('categories'));
    }
    public function addLimitData()
    {
        $this->limitData += 10;
    }
    public function deleteCategory($id)
    {
        $category = Category::where('id', $id)->first();

        $category->status = "deleted";
        $category->save();

        $this->alert('success', 'Berhasil menghapus kategori ini');
        return back();
    }
}
