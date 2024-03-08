<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_memo_flow_approvers".
 *
 * @property int $id
 * @property int $lpo_request
 * @property int $approver
 * @property int $originator
 * @property int $is_new
 * @property int $is_forwarded
 * @property string $timestamp
 */
class ErpLpoRequestApprovalFlow extends \yii\db\ActiveRecord
{
  

  
  /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_lpo_request_approval_flow';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpo_request', 'approver', 'originator','status'], 'required'],
            [['lpo_request', 'approver', 'originator', 'is_new'], 'integer'],
            [['status','remark'],'string'],
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
            'lpo_request' => 'Flow ID',
            'approver' => 'approver',
            'originator' => 'originator',
            'is_new' => 'Is New',
            'is_forwarded' => 'Is Forwarded',
            'timestamp' => 'Timestamp',
        ];
    }
    
    public static function currentApprover($request){
        
   return self::find()->select(['recipient'])->where(['lpo_reques'=>$request])->andwhere(['<>','status','is_cpoy'])->orderBy([ 'timestamp' => SORT_DESC])->One();   
        
    }
}
