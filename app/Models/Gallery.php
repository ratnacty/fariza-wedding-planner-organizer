<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['package_id', 'title', 'category', 'cover_color', 'image_path', 'order'])]
class Gallery extends Model
{
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function imageUrl(): ?string
    {
        return $this->image_path ? asset('storage/'.$this->image_path) : null;
    }
}
