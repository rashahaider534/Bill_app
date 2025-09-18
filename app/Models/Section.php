<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    use HasFactory;
    protected $fillable=['name','description','created_by'];
    public function products()
{
    return $this->hasMany(Product::class, 'section_id');
}
public function Bills()
{
    return $this->hasMany(Product::class);
}
public function BillDetail()
{
    return $this->hasMany(Product::class);
}
}
