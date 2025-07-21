<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Bill extends Model
{
    use HasFactory,SoftDeletes,Notifiable;
    protected $guarded=[];
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    protected $dates = ['deleted_at'];
}
