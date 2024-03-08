<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "banks".
 *
 * @property int $id
 * @property string $name
 * @property string $sort_code
 */
class Banks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banks';
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
            [['name', 'sort_code'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['sort_code'], 'string', 'max' => 11],
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
            'sort_code' => 'Sort Code',
        ];
    }
}
