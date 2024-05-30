<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $min_period
 * @property integer $max_period
 * @property string $stage_outcome
 * @property string $color_code
 * @property string $in_charge
 * @property string $params
 * @property integer $user_id
 * @property string $timestamp
 */
class TenderStageSetting extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'code', 'min_period', 'max_period', 'stage_outcome', 'color_code', 'in_charge', 'params', 'user_id', 'timestamp'];
}
