<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property string $name
 * @property string $fiscal_year
 * @property string $status
 * @property integer $user
 * @property string $created_at
 * @property string $updated_at
 */
class ProcurementPlan extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'fiscal_year', 'status', 'user', 'created_at', 'updated_at'];

    public function procurementActivity(): HasMany
    {
        return $this->HasMany(ProcurementActivity::class,'planId','id');
    }
}
