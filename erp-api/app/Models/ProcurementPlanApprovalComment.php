<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $wfInstance
 * @property integer $wfStep
 * @property integer $request
 * @property string $comment
 * @property string $scope
 * @property integer $user
 * @property string $timestamp
 */
class ProcurementPlanApprovalComment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['wfInstance', 'wfStep', 'request', 'comment', 'scope', 'user', 'timestamp'];
}
