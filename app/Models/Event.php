<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id', 'type', 'actor', 'repo', 'created_at'];

    public function actor()
    {
        return $this->hasMany(Actor::class);
    }

    public function repo()
    {
        return $this->hasMany(Repo::class);
    }


    public function scopeParseDate()
    {
        $date = Carbon::parse($this->created_at, 'UTC');
        $newDate = $date->isoFormat('YYYY-MM-DD');
        return $newDate;
    }
}
