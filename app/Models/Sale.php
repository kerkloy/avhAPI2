<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        "prodID",
        "prodName",
        "prodBrand",
        "prodType",
        "prodSPrice",
        "prodOPrice",
        "qtySold",
        "totalSales",
        "custName",
        "soldDate",
        "transaction_number"
    ] ;

    use SoftDeletes;

    protected $dates = ['deleted_at']; 

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
