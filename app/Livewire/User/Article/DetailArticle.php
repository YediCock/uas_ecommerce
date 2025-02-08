<?php

namespace App\Livewire\User\Article;

use App\Models\Cart as ModelCart;
use App\Models\Article;
use Livewire\Component;

class DetailArticle extends Component
{
    public $name,$desc,$url_yt;
    public $article;
    public $activeTab = 'null';
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
    public function mount($id)
    {
        $this->article = Article::where('id',$id)->first();

        if ($this->article) {
            $this->name = $this->article->name;
            $this->desc = $this->article->desc;
            $this->url_yt = $this->article->url_yt;
        }
    }
    public function render()
    {
        return view('livewire.user.article.detail-article');
    }
}
