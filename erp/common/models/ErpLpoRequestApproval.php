<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_lpo_request_approval".
 *
 * @property int $id
 * @property int $lpo_request
 * @property string $approved
 * @property int $approved_by
 * @property string $approval_status
 * @property string $remark
 * @property int $is_new
 */
class ErpLpoRequestApproval extends \yii\db\ActiveRecord
{
    //----------------------approval action-----------------
    public $action;
    //------------------------next approver--------------------------
    public $position;  
    public $employee;
    //-----------------------remark---------------------------------------
    public $remark;
   
    public $approval_deadline;
    public $final_approval_status;
    public $redirect_flow_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_lpo_request_approval';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpo_request', 'approved_by', 'approval_status', 'position','employee'], 'required'],
            [['lpo_request', 'approved_by', 'is_new'], 'integer'],
            [['approved','position','employee'], 'safe'],
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
            'lpo_request' => 'Lpo Request',
            'approved' => 'Approved',
            'approved_by' => 'Approved By',
            'approval_status' => 'Approval Status',
            'remark' => 'Remark',
            'is_new' => 'Is New',
        ];
    }
}
