<?php

namespace frontend\modules\sms\models;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property int $id
 * @property string $category_code
 * @property string $place
 * @property string $date
 * @property string $time
 * @property string $description
 * @property string $status
 * @property string $timestamp
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db9');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_code', 'place', 'date', 'time', 'description'], 'required'],
            [['date', 'time'], 'safe'],
            [['description'], 'string'],
            [['category_code'], 'string', 'max' => 4],
            [['place'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_code' => 'Category Code',
            'place' => 'Place',
            'date' => 'Date',
            'time' => 'Time',
            'description' => 'Description',
            'status' => 'Status',
            'timestamp' => 'Timestamp',
        ];
    }
}
