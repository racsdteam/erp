<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_lpo_request".
 *
 * @property int $id
 * @property int $requisition_id
 * @property int $requested
 * @property int $requested_by
 * @property int $status
 */
class ErpLpoRequest extends \yii\db\ActiveRecord
{
    
public $employee;
public $position;


//==================================================

public $action;
public $remark;
public $severity1;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_lpo_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['requested', 'requested_by', 'status','position','employee','description','type','title'], 'required'],
            [['request_id', 'requested', 'requested_by', 'status','is_new'], 'integer'],
            [['position','employee'], 'safe'],
            [['remark','action','severity','description','type','severity1'],'string'],
            ['request_id', 'required', 'when' => function ($model) {
        return $model;
    }, 'whenClient' => "function (attribute, value) {
        return $('#request-type-select').val()!='O' && ($('#pr-select').val() == '' && $('#tr-select').val()=='');
    }"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'requisition_id' => 'Requisition ID',
            'requested' => 'Requested',
            'requested_by' => 'Requested By',
            'status' => 'Status',
            'severity'=>'Status'
        ];
    }
    
    public function getTransSlip()
{
    return $this->hasOne(ErpTransmissionSlip::className(), ['type_id' => 'id'])->andOnCondition(['type' => 'LPO']);;
}
 public function beforeSave($insert) {
    
    if(empty($this->type)){
     $this->type='O';   
    }
    
     return parent::beforeSave($insert);
      
     
    }
    
}
