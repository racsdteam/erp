<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $tender
 * @property boolean $access_after_deadline
 * @property boolean $submit_after_deadline
 * @property string $payment_mode
 * @property string $tender_currency
 * @property boolean $lock_box
 */
class TenderSetting extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['tender', 'access_after_deadline', 'submit_after_deadline', 'payment_mode', 'tender_currency', 'lock_box'];
}
