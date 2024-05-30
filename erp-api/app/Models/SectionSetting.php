<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $envelope_code
 * @property boolean $is_staffing
 * @property integer $user_id
 * @property string $timestamp
 */
class SectionSetting extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'code', 'envelope_code', 'is_staffing', 'user_id', 'timestamp'];
}
