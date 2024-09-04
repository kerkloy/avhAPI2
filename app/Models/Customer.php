<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'custName',
        'custCon',
        'custAdr'
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
