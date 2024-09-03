<?php

namespace App\Models\Calendar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $guarded =  false;

    protected $fillable = [
        'name'
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
