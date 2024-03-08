<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reception_approval_flow".
 *
 * @property int $id
 * @property int $reception
 * @property int $originator
 * @property int $approver
 * @property string $status
 * @property string $remark
 * @property int $is_new
 * @property int $is_copy
 * @property string $timestamp
 */
class ReceptionApprovalFlow extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reception_approval_flow';
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
            [['reception', 'originator', 'approver'], 'required'],
            [['reception', 'originator', 'approver', 'is_new', 'is_copy'], 'integer'],
            [['status', 'remark'], 'string'],
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
            'reception' => 'Reception',
            'originator' => 'Originator',
            'approver' => 'Approver',
            'status' => 'Status',
            'remark' => 'Remark',
            'is_new' => 'Is New',
            'is_copy' => 'Is Copy',
            'timestamp' => 'Timestamp',
        ];
    }
}
