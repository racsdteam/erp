<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_memo_approval".
 *
 * @property int $id
 * @property int $memo_id
 * @property string $approved
 * @property int $approved_by
 * @property string $approval_status
 * @property string $remark
 * @property int $is_new
 */
class ErpMemoApproval extends \yii\db\ActiveRecord
{
    public $position; 
    public $position_cc;
    public $action;
   
    public $employee;
    public $employee_cc;
    public $approval_deadline;
    public $final_approval_status;
    public $redirect_flow_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_memo_approval';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['memo_id', 'approved_by', 'approval_status','position','employee','final_approval_status','action'], 'required'],
            [['memo_id', 'approved_by','approver_position', 'is_new','redirect_flow_id'], 'integer'],
            [['approved','approval_deadline'], 'safe'],
            [['approval_status','approval_action', 'remark','action','final_approval_status'], 'string'],
            [['position','position_cc','employee','employee_cc'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'memo_id' => 'Memo ID',
            'approved' => 'Approved',
            'approved_by' => 'Approved By',
            'approval_status' => 'Approval Status',
            'remark' => 'Remark',
            'is_new' => 'Is New',
        ];
    }
}
