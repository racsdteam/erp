<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_travel_request_approval_flow".
 *
 * @property int $id
 * @property int $originator
 * @property int $approver
 * @property string $status
 * @property string $remark
 * @property int $is_new
 * @property string $timestamp
 */
class ErpRequisitionApprovalFlow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_requisition_approval_flow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pr_id','originator', 'approver', 'remark'], 'required'],
            [['pr_id','originator', 'approver', 'is_new'], 'integer'],
            [['status', 'remark'], 'string'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'originator' => 'Originator',
            'approver' => 'Approver',
            'status' => 'Status',
            'remark' => 'Remark',
            'is_new' => 'Is New',
            'timestamp' => 'Timestamp',
        ];
    }
    
    public  function getRequisition() {
       
        return $this
        ->hasOne(ErpRequisition::className(), ['id' => 'pr_id']);
       
}

public  function getApproverUser() {
       
        return $this
        ->hasOne(User::className(), ['user_id' => 'approver']);
       
}

public  function getOrginatorUser() {
       
        return $this
        ->hasOne(User::className(), ['user_id' => 'originator']);
       
}

public  function isApprover($user) {
       
        return $this->approver==$user;
        
       
}

public  function isOriginator($user) {
       
        return $this->originator==$user;
        
       
}

}
