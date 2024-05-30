<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $wfInstance
 * @property integer $wfStep
 * @property integer $request
 * @property string $name
 * @property string $description
 * @property integer $assigned_to
 * @property integer $on_behalf_of
 * @property integer $assigned_from
 * @property string $action_required
 * @property string $status
 * @property string $outcome
 * @property boolean $is_new
 * @property string $created_at
 * @property string $started_at
 * @property string $completed_at
 */
class ProcurementPlanApproval extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['wfInstance', 'wfStep', 'request', 'name', 'description', 'assigned_to', 'on_behalf_of', 'assigned_from', 'action_required', 'status', 'outcome', 'is_new', 'created_at', 'started_at', 'completed_at'];
}
