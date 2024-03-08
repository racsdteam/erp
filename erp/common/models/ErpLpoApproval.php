<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_lpo_approval".
 *
 * @property int $id
 * @property int $lpo
 * @property string $approved
 * @property int $approved_by
 * @property string $approval_status
 * @property string $remark
 * @property int $is_new
 */
class ErpLpoApproval extends \yii\db\ActiveRecord
{
    //----------------------approval action-----------------
    public $action;
    //------------------------next approver--------------------------
    public $position;  
    public $employee;
  
    public $position_cc;  
    public $employee_cc;
   
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_lpo_approval';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpo', 'approved_by', 'approval_status'], 'required'],
             [['position'], 'required','message'=>'Please select the position to forward to'],
            ['employee', 'required', 'when' => function ($model) {
    return empty(array_filter($model->employee));
}, 'whenClient' => "function (attribute, value) {
   
    return $('.employee-select').val().trim() == '';
}"],
            [['lpo', 'approved_by', 'is_new'], 'integer'],
            [['approved','position','employee','position_cc','employee_cc'], 'safe'],
            [['approval_status', 'remark'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lpo' => 'Lpo Request',
            'approved' => 'Approved',
            'approved_by' => 'Approved By',
            'approval_status' => 'Approval Status',
            'remark' => 'Remark',
            'is_new' => 'Is New',
        ];
    }
}
