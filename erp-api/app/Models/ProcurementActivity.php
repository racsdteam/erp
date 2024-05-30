<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property integer $planId
 * @property integer $end_user_org_unit
 * @property string $description
 * @property string $code
 * @property string $procurement_category
 * @property string $procurement_method
 * @property string $estimate_cost
 * @property string $funding_source
 * @property string $status
 * @property integer $user
 * @property string $created
 * @property string $updated
 */
class ProcurementActivity extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['planId', 'end_user_org_unit', 'description', 'code', 'procurement_category', 'procurement_method', 'estimate_cost', 'funding_source', 'status', 'user', 'created', 'updated'];


    public function procurementActivityDate(): HasMany
    {
        return $this->HasMany(ProcurementActivityDate::class,'activity','id');
    }

}
