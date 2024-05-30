<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $code
 * @property string $currency
 */
class Currency extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['code', 'currency'];
}
