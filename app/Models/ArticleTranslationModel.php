<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\ArticleModel;

class ArticleTranslationModel extends AdminModel
{
    use HasFactory;
    protected $table = 'article_translations';
    protected $fillable = ['article_id', 'locale', 'name', 'slug', 'content'];

    public function article()
    {
        return $this->belongsTo(ArticleModel::class, 'article_id', 'id');
    }
}
