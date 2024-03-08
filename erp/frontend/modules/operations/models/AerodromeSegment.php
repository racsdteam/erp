<?php

namespace frontend\modules\operations\models;

use Yii;

/**
 * This is the model class for table "aerodrome_segment".
 *
 * @property int $id
 * @property string $segment_name
 * @property int $sequence_number
 * @property int $aerodrome_id
 * @property int $status
 * @property string $timestamp
 */
class AerodromeSegment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aerodrome_segment';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db6');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['segment_name', 'sequence_number', 'aerodrome'], 'required'],
            [['sequence_number','status'], 'integer'],
            [['segment_name'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'segment_name' => 'Segment Name',
            'sequence_number' => 'Sequence Number',
            'aerodrome' => 'Aerodrome',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }
}
