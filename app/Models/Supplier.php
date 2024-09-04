<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'supName',
        'supBrand',
        'supBrdType',
        'supAdr',
        'supCon',
    ]; 

    use SoftDeletes;

    protected $dates = ['deleted_at'];


}
