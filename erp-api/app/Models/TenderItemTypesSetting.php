<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property integer $user_id
 * @property string $timestamp
 */
class TenderItemTypesSetting extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'code', 'description', 'user_id', 'timestamp'];
}
