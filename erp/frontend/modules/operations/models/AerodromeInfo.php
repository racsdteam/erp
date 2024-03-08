<?php

namespace frontend\modules\operations\models;

use Yii;

/**
 * This is the model class for table "aerodrome_info".
 *
 * @property int $id
 * @property string $aerodrome
 * @property string $lower_runway_designator
 * @property string $initial
 * @property int $airport_code
 * @property string $created_at
 */
class AerodromeInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aerodrome_info';
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
            [['aerodrome', 'lower_runway_designator', 'airport_code'], 'required'],
            [['aerodrome'], 'string', 'max' => 4],
            [['lower_runway_designator', 'initial'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aerodrome' => 'Aerodrome',
            'lower_runway_designator' => 'Lower Runway Designator',
            'initial' => 'Initial',
            'airport_code' => 'Airport Code',
            'created_at' => 'Created At',
        ];
    }
}
