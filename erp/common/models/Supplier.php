<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property string $name
 * @property string $country
 * @property string $city
 * @property string $timestamp
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
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
            [['name', 'country', 'city'], 'required'],
            [['timestamp'], 'safe'],
            [['name'], 'string', 'max' => 1024],
            [['country'], 'string', 'max' => 64],
            [['city'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'country' => 'Country',
            'city' => 'City',
            'timestamp' => 'Timestamp',
        ];
    }
}
