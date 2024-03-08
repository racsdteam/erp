<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_travel_request".
 *
 * @property int $id
 * @property int $type
 * @property string $request_code
 * @property string $purpose
 * @property string $departure_date
 * @property string $return_date
 * @property string $destination
 * @property int $memo
 * @property string $created
 * @property int $created_by
 * @property string $status
 * @property int $is_new
 */
class ErpTravelRequest extends \yii\db\ActiveRecord
{
    
    public $position;  
    public $action;
    public $remark; 
    public $employee;
    
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_travel_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee','type', 'tr_code', 'purpose', 'departure_date', 'return_date', 'destination','means_of_transport','flight','tr_expenses','created_by'], 'required'],
            [[ 'memo', 'created_by', 'is_new'], 'integer'],
            [['type','purpose', 'status'], 'string'],
            [['departure_date', 'return_date', 'created','position','employee'], 'safe'],
            [['tr_code', 'destination','means_of_transport','flight','tr_expenses'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Travel Type',
            'request_code' => 'Request Code',
            'purpose' => 'Purpose',
            'departure_date' => 'Departure Date',
            'return_date' => 'Return Date',
            'destination' => 'Destination',
            'memo' => 'Memo',
            'created' => 'Created',
            'created_by' => 'Created By',
            'status' => 'Status',
            'is_new' => 'Is New',
            'position'=>'Position(s)',
            'employee'=>'Employee(s)',
            'tr_expenses'=>'Travel Expenses',
           
        ];
    }
}
