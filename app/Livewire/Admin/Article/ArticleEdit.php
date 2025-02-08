<?php

namespace App\Livewire\Admin\Article;

use App\Models\Asset;
use App\Models\Article;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Intervention\Image\ImageManagerStatic as Image;

class ArticleEdit extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    #[Layout('components.layouts.admin')]
    public $name, $discount, $img_thumbnail, $article_image, $url_yt;
    public $desc = '';
    public $article;
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
        return view('livewire.admin.article.article-edit');
    }
    public function deleteImageArticle($idImage)
    {
        $imageArticle = Asset::where('product_id', $this->article->id)->where('id',$idImage)->where('type', 'article')->first();
        if ($imageArticle) {
            // Hapus gambar 
            $image = public_path('/assets/assetImage/' . $imageArticle->image);
            if (File::exists($image)) {
                File::delete($image);
            }

            // Hapus entri dari tabel asset
            $imageArticle->delete();
        }
        $this->alert('success', 'Berhasil menghapus gambar artikel ini');
        return back();
    }
    public function editArticle()
    {
        // Validasi input
        $validatedData = $this->validate([
            'name' => 'required|string|max:255|unique:articles,name,' . $this->article->id,
            'desc' => 'required',
            'img_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'article_image' => 'nullable|array|min:1|max:5',
            'article_image.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
                // Hapus gambar lama jika ada
                if (file_exists(public_path('assets/article/' . $this->article->img_thumbnail))) {
                    unlink(public_path('assets/article/' . $this->article->img_thumbnail));
                }

                $random = Str::random(20);
                $imgThumbnail = $this->img_thumbnail;
                $thumbnailArticle = $random . '.' . $imgThumbnail->getClientOriginalExtension();
                $location = 'assets/article/';
                $path = ($location . $thumbnailArticle);
                $upload = Image::make($imgThumbnail->path())->resize(628, 408);
                $upload->save($path);    

                // Update thumbnail image
                $this->article->update(['img_thumbnail' => $thumbnailArticle]);
            }

            // Handle store creation
            $this->article->update([
                'name' => $this->name,
                'url_yt' => $this->url_yt,
                'desc' => $this->desc,
            ]);

            // Handle multiple store images
            if ($this->article_image) {
                $validateArticleImage =  $this->validate([
                    'article_image' => 'array|min:1|max:5',
                    'article_image.*' => 'image|mimes:jpeg,png,jpg|max:2048',
                ]);
                if ($validateArticleImage) {
                    $totalImages = $this->article->getAsset()->count(); // Menghitung jumlah gambar yang sudah ada
                    $maxImages = 5 - $totalImages; // Maksimal gambar yang bisa ditambahkan

                    // Periksa apakah jumlah gambar yang akan ditambahkan melebihi batas maksimum
                    if (count($this->article_image) > $maxImages) {
                        $this->alert('warning', 'Total gambar properti melebihi 5 file'); // back
                        return back();
                    } else {
                        foreach ($this->article_image as $key => $image) {
                            // Cek apakah jumlah gambar yang akan disimpan telah mencapai batas maksimum
                            if ($key < $maxImages) {
                                $random = Str::random(20);
                                $imageArticle = $random . '.' . $image->getClientOriginalExtension();
                                $location = 'assets/assetImage/';
                                $path = ($location . $imageArticle);
                                $upload = Image::make($image->path())->resize(1380, 596);
                                $upload->save($path);
                
                                Asset::create([
                                    'product_id' => $this->article->id,
                                    'image' => $imageArticle,
                                    'type' => 'article',
                                ]);
                            }else {
                                // Jika jumlah gambar sudah mencapai batas maksimum, hentikan iterasi
                                break;
                            }
                        }
                    }
                }
            }
        }

        $this->flash('success', 'Artikel berhasil diperbarui');
        return redirect()->to('/admin/article/list-article');
    }
}
