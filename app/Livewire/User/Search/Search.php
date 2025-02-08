<?php

namespace App\Livewire\User\Search;

use App\Models\Cart as ModelCart;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;

class Search extends Component
{
    public $selectedCategory = null;
    public $selectedFilter = 'all';
    public $products;
    public $limitData;
    public $categories;
    public $activeTab = 'search'; // Default active tab
    public $search = '';
    public function selectTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function getCartCountProperty()
    {
        $user = auth()->user();
        if ($user) {
            return ModelCart::where('user_id', $user->id)->where('status', 'pending')->sum('quantity');
        }
        return 0;
    }
    public function mount($category = null)
    {
        $this->selectedCategory = $category;
        $this->limitData = 10;
        $this->categories = Category::where('status', 'active')->latest()->get();
        $this->loadProducts();
    }
    public function loadProducts()
    {
        $query = Product::where('status', 'active');
        
        // Filter berdasarkan kategori
        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }
    
        // Filter berdasarkan diskon atau urutan harga
        switch ($this->selectedFilter) {
            case 'discount':
                $query->whereNotNull('discount');
                break;
            case 'low_to_high':
                $query->orderBy('price', 'asc');
                break;
            case 'high_to_low':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
        }
    
        $this->products = $query->search($this->search)->limit($this->limitData)->get();
    }    
    
    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->limitData = 10;
        $this->loadProducts();
    }
    public function selectFilter($filter)
    {
        $this->selectedFilter = $filter;
        $this->limitData = 10;
        $this->loadProducts();
    }
    public function resetFilter()
    {
        $this->selectedCategory = null;
        $this->selectedFilter = 'all';
        $this->search = '';
        $this->limitData = 10;
        $this->loadProducts();
    }
    // update jika user mencari product
    public function updatedSearch()
    {
        $this->limitData = 10;
        $this->loadProducts();
    }
    public function addLimitData()
    {
        $this->limitData += 10;
        $this->loadProducts();
    }
    public function render()
    {
        return view('livewire.user.search.search', [
            'products' => $this->products,
            'categories' => $this->categories,
            'selectedCategoryName' => $this->selectedCategory ? Category::find($this->selectedCategory)->name : null
        ]);
    }
}
