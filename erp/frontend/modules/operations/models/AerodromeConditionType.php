<?php

namespace frontend\modules\operations\models;

use Yii;

/**
 * This is the model class for table "aerodrome_condition_type".
 *
 * @property int $id
 * @property string $code
 * @property string $state
 */
class AerodromeConditionType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aerodrome_condition_type';
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
            [['code', 'state'], 'required'],
            [['code'], 'string', 'max' => 2],
            [['state'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'state' => 'State',
        ];
    }
}
