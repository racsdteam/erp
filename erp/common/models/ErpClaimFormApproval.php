<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_claim_form_approval".
 *
 * @property int $id
 * @property int $claim_form
 * @property string $approved
 * @property int $approved_by
 * @property string $approval_status
 * @property string $remark
 * @property int $is_new
 */
class ErpClaimFormApproval extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_claim_form_approval';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['claim_form', 'approved_by', 'approval_status', 'remark'], 'required'],
            [['claim_form', 'approved_by', 'is_new'], 'integer'],
            [['approved'], 'safe'],
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
            'claim_form' => 'Claim Form',
            'approved' => 'Approved',
            'approved_by' => 'Approved By',
            'approval_status' => 'Approval Status',
            'remark' => 'Remark',
            'is_new' => 'Is New',
        ];
    }
}
