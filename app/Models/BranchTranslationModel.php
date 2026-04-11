<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\ArticleModel;

class BranchTranslationModel extends AdminModel
{
    use HasFactory;
    protected $table = 'branch_translations';
    protected $fillable = ['branch_id', 'locale', 'name', 'address'];

    public function branch()
    {
        return $this->belongsTo(BranchModel::class, 'branch_id', 'id');
    }
}
