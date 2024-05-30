<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $validation
 * @property integer $user_id
 * @property integer $timestamp
 */
class TenderOpeningStetting extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'validation', 'user_id', 'timestamp'];
}
