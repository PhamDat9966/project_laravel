<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\ArticleModel;

class MenuTranslationModel extends AdminModel
{
    use HasFactory;
    protected $table = 'menu_translations';
    protected $fillable = ['menu_id', 'locale', 'name'];

    public function article()
    {
        return $this->belongsTo(MenuModel::class, 'menu_id', 'id');
    }
}
