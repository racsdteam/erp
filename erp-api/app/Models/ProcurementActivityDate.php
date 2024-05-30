<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $activity
 * @property string $date_type
 * @property string $planned_date
 * @property string $actual_date
 * @property integer $sequence
 * @property string $created
 * @property string $updated
 * @property integer $user
 */
class ProcurementActivityDate extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['activity', 'date_type', 'planned_date', 'actual_date', 'sequence', 'created', 'updated', 'user'];
}
