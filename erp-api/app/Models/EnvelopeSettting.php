<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $procurement_categories_code
 * @property string $procurement_methods_code
 * @property integer $user_id
 * @property string $timestamp
 */
class EnvelopeSettting extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'code', 'procurement_categories_code', 'procurement_methods_code', 'user_id', 'timestamp'];
}
