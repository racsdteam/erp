<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reception_approval".
 *
 * @property int $id
 * @property int $reception
 * @property string $approved
 * @property int $approved_by
 * @property int $approver_position
 * @property string $approval_action
 * @property string $approval_status
 * @property string $remark
 * @property int $is_new
 */
class ReceptionApproval extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
       //----------------------approval action-----------------
    public $action;
    //------------------------next approver--------------------------
    public $position;  
    public $employee;
  
    public $position_cc;  
    public $employee_cc;
    public static function tableName()
    {
        return 'reception_approval';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reception', 'approved_by', 'approval_action', 'approval_status'], 'required'],
            [['reception', 'approved_by', 'approver_position', 'is_new'], 'integer'],
            [['approved'], 'safe'],
            [['approval_action', 'approval_status', 'remark'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reception' => 'Reception',
            'approved' => 'Approved',
            'approved_by' => 'Approved By',
            'approver_position' => 'Approver Position',
            'approval_action' => 'Approval Action',
            'approval_status' => 'Approval Status',
            'remark' => 'Remark',
            'is_new' => 'Is New',
        ];
    }
}
