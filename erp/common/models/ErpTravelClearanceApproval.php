<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "erp_travel_clearance_approval".
 *
 * @property int $id
 * @property int $travel_clearance
 * @property string $approved
 * @property int $approved_by
 * @property string $approval_status
 * @property string $remark
 * @property int $is_new
 */
class ErpTravelClearanceApproval extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_travel_clearance_approval';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['travel_clearance', 'approved_by', 'approval_status', 'remark'], 'required'],
            [['travel_clearance', 'approved_by', 'is_new'], 'integer'],
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
            'travel_clearance' => 'Travel Clearance',
            'approved' => 'Approved',
            'approved_by' => 'Approved By',
            'approval_status' => 'Approval Status',
            'remark' => 'Remark',
            'is_new' => 'Is New',
        ];
    }
}
