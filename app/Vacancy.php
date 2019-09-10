<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'vacancy_name', 'workers_amount', 'organization_id', 'salary'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_vacancy');
    }
}
