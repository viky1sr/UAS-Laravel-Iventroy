<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['product_id','category_id','minggu','bulan'];
    protected $hidden = ['created_at','updated_at'];

    public function product ()
    {
        return $this->belongsTo(Product::class);
    }
    public function category ()
    {
        return$this->belongsTo(Category::class);
    }
}
