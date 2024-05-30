<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $tender_stage_code
 * @property string $tender_stage_setting_code
 * @property integer $sequence_number
 * @property boolean $is_active
 * @property integer $user_id
 * @property string $timestamp
 */
class TenderStageSequenceSetting extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['tender_stage_code', 'tender_stage_setting_code', 'sequence_number', 'is_active', 'user_id', 'timestamp'];
}
