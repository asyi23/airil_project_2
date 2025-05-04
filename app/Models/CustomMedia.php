<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CustomMedia extends BaseMedia implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'tbl_media';


    public function new_car_gallery() {
        return $this->hasOne('App\Model\NewCarGallery', 'media_id', 'id');
    }
}
