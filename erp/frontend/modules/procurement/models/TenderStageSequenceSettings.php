<?php

namespace frontend\modules\procurement\models;

use Yii;

/**
 * This is the model class for table "tender_stage_sequence_settings".
 *
 * @property int $id
 * @property string tender_stage_code
 * @property int $sequence_number
 * @property int $is_active
 * @property int $user_id
 * @property string $timestamp
 */
class TenderStageSequenceSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tender_stage_sequence_settings';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db8');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tender_stage_code','tender_stage_setting_code', 'sequence_number', 'user_id'], 'required'],
            [['sequence_number', 'is_active', 'user_id'], 'integer'],
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
            'tender_stage_code' => 'Tender Stage Code',
            'tender_stage_setting_code' => 'Tender Stage Setting Code',
            'sequence_number' => 'Sequence Number',
            'is_active' => 'Is Active',
            'user_id' => 'User ID',
            'timestamp' => 'Timestamp',
        ];
    }
}
