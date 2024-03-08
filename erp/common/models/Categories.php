<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string $indentifier
 * @property int $user
 * @property string $timestamp
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
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
            [['name', 'identifier', 'user'], 'required'],
            [['user'], 'integer'],
            [['name'], 'string', 'max' => 1000],
            [['identifier'], 'string', 'max' => 4],
            ['identifier', 'unique']
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
            'identifier' => 'Identifier',
            'user' => 'User',
            'timestamp' => 'Timestamp',
        ];
    }
}
