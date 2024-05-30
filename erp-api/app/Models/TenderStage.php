<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $Name
 * @property string $code
 * @property string $procurement_methods_code
 * @property string $procurement_categories_code
 * @property integer $user_id
 * @property boolean $is_active
 * @property string $timestamp
 */
class TenderStage extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['Name', 'code', 'procurement_methods_code', 'procurement_categories_code', 'user_id', 'is_active', 'timestamp'];
}
