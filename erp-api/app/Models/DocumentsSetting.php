<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $section_code
 * @property string $params
 * @property integer $user_id
 * @property string $timestamp
 */
class DocumentsSetting extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'code', 'section_code', 'params', 'user_id', 'timestamp'];
}
