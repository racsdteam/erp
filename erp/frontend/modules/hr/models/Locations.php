<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "locations".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 */
class Locations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'locations';
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
            [['name','code', 'address'], 'required'],
            [['address'], 'string'],
            [['name','code'], 'string', 'max' => 255],
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
            'address' => 'Address',
            'code' => 'Code',
        ];
    }
}
