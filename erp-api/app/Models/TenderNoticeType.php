<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class TenderNoticeType extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'description'];
}
