<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable =['id', 'name', 'url', 'event_id'];
}
