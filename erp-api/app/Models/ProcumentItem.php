<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property mixed $types
 * @property string $description
 * @property integer $user_id
 * @property boolean $active
 * @property integer $timestamp
 */
class ProcumentItem extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'types', 'description', 'user_id', 'active', 'timestamp'];
}
