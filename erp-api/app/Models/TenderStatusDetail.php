<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $tender
 * @property string $status
 * @property string $ status_update_date
 * @property integer $user
 */
class TenderStatusDetail extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['tender', 'status', ' status_update_date', 'user'];
}
