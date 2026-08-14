<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['phone', 'email', 'address', 'latitude', 'longitude', 'hours'])]
class Contact extends Model
{
    //
}
