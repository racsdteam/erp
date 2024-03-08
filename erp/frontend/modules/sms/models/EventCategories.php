<?php

namespace frontend\modules\sms\models;

use Yii;

/**
 * This is the model class for table "event_categories".
 *
 * @property int $id
 * @property string $code
 * @property string $category
 * @property string $is_aircraft_related
 * @property string $timestamp
 */
class EventCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_categories';
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
            [['code', 'category'], 'required'],
            [['code'], 'string', 'max' => 4],
            [['category'], 'string', 'max' => 1000],
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
            'category' => 'Category',
            'is_aircraft_related' => 'This Event Category Include Aircraft',
            'timestamp' => 'Timestamp',
        ];
    }
}
