<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $table = 'media_files';

    protected $guarded = [];

    public function folder(){

        return $this->belongsTo(MediaFolder::class);
    }
}
