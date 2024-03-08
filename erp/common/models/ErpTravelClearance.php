<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_travel_clearance".
 *
 * @property int $id
 * @property int $request_id
 * @property int $employee
 * @property string $Destination
 * @property string $reason
 * @property string $departure_date
 * @property string $return_date
 * @property string $travel_expenses
 * @property string $flight
 * @property string $status
 * @property int $created_by
 * @property string $created_at
 */

class ErpTravelClearance extends \yii\db\ActiveRecord
{
    /*
    public $position;  
     
    public $action;
   
    public $recipients;*/
     public $remark; 
  
    public $recipients_names;
    /**
     * {@inheritdoc}
     * 
     */
     
     
    public static function tableName()
    {
        return 'erp_travel_clearance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tr_id','tc_code', 'employee',  'created_by'], 'required'],
            [['tr_id', 'employee', 'created_by'], 'integer'],
            [['tc_code'], 'string'],
            [[ 'created_at'], 'safe'],
            //[['travel_expenses'], 'string', 'max' => 255],
            //[['flight'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_id' => 'request_id',
            'employee' => 'Employee',
            'Destination' => 'Destination',
            'reason' => 'Reason',
            'departure_date' => 'Departure Date',
            'return_date' => 'Return Date',
            'travel_expenses' => 'Travel Expenses',
            'flight' => 'Flight',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            
        ];
    }
}
