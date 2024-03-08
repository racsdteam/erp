<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pa_approval_flow".
 *
 * @property int $id
 * @property int $request
 * @property int $originator
 * @property int $approver
 * @property string $status
 * @property string $remark
 * @property int $is_new
 * @property int $is_copy
 * @property string $timestamp
 *
 * @property PaEvaluation $request0
 */
class PcApprovalFlow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pc_approval_flow';
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
            [['request', 'originator', 'approver'], 'required'],
            [['request', 'originator', 'approver', 'is_new', 'is_copy'], 'integer'],
            [['status', 'remark'], 'string'],
            [['timestamp'], 'safe'],
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
            'originator' => 'Originator',
            'approver' => 'Approver',
            'status' => 'Status',
            'remark' => 'Remark',
            'is_new' => 'Is New',
            'is_copy' => 'Is Copy',
            'timestamp' => 'Timestamp',
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
