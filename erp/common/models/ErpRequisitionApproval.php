<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_requisition_approval".
 *
 * @property int $id
 * @property string $approved
 * @property int $approved_by
 * @property string $approval_status
 * @property int $is_new
 */
class ErpRequisitionApproval extends \yii\db\ActiveRecord
{
    public $position;  
    public $action;
   
    public $employee;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_requisition_approval';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['approved'], 'safe'],
            [['approved_by', 'approval_status','approval_action', 'is_new','requisition_id','employee','position'], 'required'],
            [['approved_by', 'is_new','requisition_id'], 'integer'],
            [['approval_status','approval_action','remark'], 'string'],
              [['position','employee'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'approved' => 'Approved',
            'approved_by' => 'Approved By',
            'approval_status' => 'Approval Status',
            'is_new' => 'Is New',
        ];
    }
}
