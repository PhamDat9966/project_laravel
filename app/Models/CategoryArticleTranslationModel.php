<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\ArticleModel;

class CategoryArticleTranslationModel extends AdminModel
{
    use HasFactory;
    protected $table = 'category_article_translations';
    protected $fillable = ['category_article_id', 'locale', 'name'];

    public function CategoryArticle()
    {
        return $this->belongsTo(CategoryArticleModel::class, 'category_article_id', 'id');
    }
}
