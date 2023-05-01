<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Good;
use App\Models\User;
use App\Models\Customer;
class Sale extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'seller_id',
        'customer_id',
        'good_id',
        'good_unit_price',
        'good_quantity',
        'total',
    ];
    public $timestamps=false;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function customers(){
        return $this->hasMany(Customer::class);
    }
    public function goods(){
        return $this->hasMany(Good::class);
    }
}
