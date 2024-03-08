<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_travel_request_approval".
 *
 * @property int $id
 * @property int $tr_id
 * @property string $approval_status
 * @property int $approved_by
 * @property string $approved
 * @property string $remark
 * @property int $is_new
 */
class ErpTravelRequestApproval extends \yii\db\ActiveRecord
{
    
    public $position;  
    public $action;
    public $employee;
   
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_travel_request_approval';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tr_id', 'approval_status','approval_action', 'approver', 'employee','position'], 'required'],
            [['tr_id', 'approver', 'is_new'], 'integer'],
            [['approval_status', 'approval_action','remark'], 'string'],
            [['approved','employee','position'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tr_id' => 'Tr ID',
            'approval_status' => 'Approval Status',
            'approved_by' => 'Approved By',
            'approved' => 'Approved',
            'remark' => 'Remark',
            'is_new' => 'Is New',
        ];
    }
}
