<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaFolder extends Model
{
    use HasFactory;

    protected $table = 'media_folders';

    protected $guarded = [];

    public function mediaFiles(){

        return $this->hasMany(Media::class,  'folder_id');
    }
}
