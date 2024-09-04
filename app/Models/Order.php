<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "prodName",
        "prodType",
        "prodBrand",
        "ordQty",
        "prodOPrice",
        "prodSPrice",
        "totalOrderPrice",
        "ordDate",
        "status"
     ];

     use SoftDeletes;

    protected $dates = ['deleted_at']; 
}
