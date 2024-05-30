<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $activity_id
 * @property string $name
 * @property string $description
 * @property float $quantity
 * @property float $unity
 * @property float $unit_price
 * @property float $total_price
 * @property string $created_at
 * @property string $updated_at
 * @property integer $user
 */
class ProcurementActivityItem extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['activity_id', 'name', 'description', 'quantity', 'unity', 'unit_price', 'total_price', 'created_at', 'updated_at', 'user'];
}
