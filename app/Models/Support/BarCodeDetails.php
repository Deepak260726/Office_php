<?php

namespace App\Models\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarCodeDetails extends Model
{

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'barcode_details';
    
    public $incrementing = true;

}
