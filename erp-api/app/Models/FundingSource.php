<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $description
 */
class FundingSource extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'code', 'description'];
}
