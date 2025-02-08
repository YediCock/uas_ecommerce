<?php

namespace App\Livewire\User\Home;

use App\Models\Cart as ModelCart;
use App\Models\Banner;
use App\Models\Article;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Testimonial;

class Home extends Component
{
    public $activeTab = 'home'; // Default active tab

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
    public function render()
    {
        $banners = Banner::latest()->get();
        $categories = Category::where('status', 'active')->latest()->get();
        $testimonials = Testimonial::latest()->get();
        $articles = Article::latest()->take(7)->get();
        $productPopulars = Product::where('status', 'active')->where('is_popular','popular')->latest()->get();
        $productNotPopulars = Product::where('status', 'active')->where('is_popular','notpopular')->latest()->take(6)->get();
        return view('livewire.user.home.home',compact('banners','categories','productPopulars','productNotPopulars','testimonials','articles'));
    }
}
