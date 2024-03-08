<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "external_bodies".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property string $address
 * @property string $contact
 */
class ExternalBodies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'external_bodies';
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
            [['name', 'code'], 'required'],
            [['description'], 'string'],
            [['name', 'address', 'contact'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 11],
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
            'code' => 'Code',
            'description' => 'Description',
            'address' => 'Address',
            'contact' => 'Contact',
        ];
    }
}
