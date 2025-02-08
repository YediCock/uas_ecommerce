<?php

namespace App\Livewire\Admin\Article;

use App\Models\Asset;
use App\Models\Article;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Intervention\Image\ImageManagerStatic as Image;

class ArticleAdd extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    #[Layout('components.layouts.admin')]
    public $name, $discount, $img_thumbnail, $article_image, $url_yt;
    public $desc = '';
    public function render()
    {
        return view('livewire.admin.article.article-add');
    }
    public function addArticle()
    {
        // dd($this->article_image);
        // Validasi input
        $validatedData = $this->validate([
            'name' => 'required|string|max:255|unique:articles',
            'desc' => 'required',
            'img_thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'article_image' => 'required|array|min:1|max:5',
            'article_image.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'url_yt' => [
                'nullable',
                'url',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/', $value)) {
                        $fail('The ' . $attribute . ' must be a valid YouTube URL.');
                    }
                },
            ],
        ]);

        if ($validatedData) {
            // Handle store thumbnail image
            if ($this->img_thumbnail) {
                $random = Str::random(20);
                $imgThumbnail = $this->img_thumbnail;
                $thumbnailArticle = $random . '.' . $imgThumbnail->getClientOriginalExtension();
                $location = 'assets/article/';
                $path = ($location . $thumbnailArticle);
                $upload = Image::make($imgThumbnail->path())->resize(628, 408);
                $upload->save($path);    
            }

            // Handle store creation
            $article = Article::create([
                'name' => $this->name,
                'url_yt' => $this->url_yt,
                'desc' => $this->desc,
                'img_thumbnail' => $thumbnailArticle,
            ]);

            // Handle multiple store images
            if ($this->article_image) {
                foreach ($this->article_image as $image) {
                    $random = Str::random(20);
                    $imageArticle = $random . '.' . $image->getClientOriginalExtension();
                    $location = 'assets/assetImage/';
                    $path = ($location . $imageArticle);
                    $upload = Image::make($image->path())->resize(1380, 596);
                    $upload->save($path);

                    Asset::create([
                        'product_id' => $article->id,
                        'image' => $imageArticle,
                        'type' => 'article',
                    ]);
                }
            }
        }

        $this->flash('success', 'Artikel berhasil ditambahkan');
        return redirect()->to('/admin/article/list-article');
    }
}
