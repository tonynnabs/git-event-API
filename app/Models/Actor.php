<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'login', 'avatar_url', 'event_id'];

    public function events()
    {
        return $this->hasMany(Event::class, 'actor');
    }

}
