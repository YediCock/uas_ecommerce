<?php

namespace App\Livewire\Admin\Article;

use App\Models\Article;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ArticleList extends Component
{
    use LivewireAlert;
    #[Layout('components.layouts.admin')]
    public $search = '';
    public $limitData;
    public $selectedArticle;
    public function mount()
    {
        $this->limitData = 10;
    }
    public function render()
    {
        $articles = Article::latest()->search($this->search)->limit($this->limitData)->get();
        return view('livewire.admin.article.article-list', compact('articles'));
    }
    public function addLimitData()
    {
        $this->limitData += 10;
    }
    public function showDetailArticle($articleID)
    {
        $this->selectedArticle = Article::where('id', $articleID)->first();
    }
    public function deleteArticle($id)
    {
        $article = Article::where('id', $id)->first();

        // Hapus gambar properti dari penyimpanan
        foreach ($article->getAsset as $image) {
            $filePath = public_path('/assets/assetImage/' . $image->image);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        // Hapus gambar 
        $image = public_path('/assets/article/' . $article->img_thumbnail);
        if (File::exists($image)) {
            File::delete($image);
        }

        // Hapus entri dari tabel asset image
        $article->getAsset()->delete();

        // Hapus entri dari tabel article
        $article->delete();

        $this->alert('success', 'Berhasil menghapus article ini');
        return back();
    }
}
