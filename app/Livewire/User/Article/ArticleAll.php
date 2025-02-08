<?php

namespace App\Livewire\User\Article;

use App\Models\Cart as ModelCart;
use App\Models\Article;
use Livewire\Component;

class ArticleAll extends Component
{
    public $activeTab = 'null'; // Default active tab
    public $search = '';
    public $limitData;
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
    public function mount()
    {
        $this->limitData = 10;
    }
    public function render()
    {
        $articles = Article::latest()->search($this->search)->limit($this->limitData)->get();
        return view('livewire.user.article.article-all', compact('articles'));
    }
    public function addLimitData()
    {
        $this->limitData += 10;
    }
}
