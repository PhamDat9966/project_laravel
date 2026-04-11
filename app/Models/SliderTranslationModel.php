<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\ArticleModel;

class SliderTranslationModel extends AdminModel
{
    use HasFactory;
    protected $table = 'slider_translations';
    protected $fillable = ['slider_id', 'locale', 'name', 'description'];

    public function article()
    {
        return $this->belongsTo(SliderModel::class, 'slider_id', 'id');
    }
}
