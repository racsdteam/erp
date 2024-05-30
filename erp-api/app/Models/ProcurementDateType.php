<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $report_name
 * @property string $description
 * @property boolean $active
 */
class ProcurementDateType extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['code', 'name', 'report_name', 'description', 'active'];
}
