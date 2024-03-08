<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pa_approval".
 *
 * @property int $id
 * @property int $request
 * @property string $approved
 * @property int $approved_by
 * @property int $approver_position
 * @property string $approval_action
 * @property string $approval_status
 * @property string $remark
 * @property int $is_new
 *
 * @property PaEvaluation $request0
 */
class PcApproval extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc_approval';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request', 'approved_by', 'approval_action', 'approval_status'], 'required'],
            [['request', 'approved_by', 'approver_position', 'is_new'], 'integer'],
            [['approved'], 'safe'],
            [['approval_action', 'approval_status', 'remark'], 'string'],
            [['request'], 'exist', 'skipOnError' => true, 'targetClass' => PaEvaluation::className(), 'targetAttribute' => ['request' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request' => 'Request',
            'approved' => 'Approved',
            'approved_by' => 'Approved By',
            'approver_position' => 'Approver Position',
            'approval_action' => 'Approval Action',
            'approval_status' => 'Approval Status',
            'remark' => 'Remark',
            'is_new' => 'Is New',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest0()
    {
        return $this->hasOne(PaEvaluation::className(), ['id' => 'request']);
    }
}
