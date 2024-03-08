<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sub_categories".
 *
 * @property int $id
 * @property string $name
 * @property int $category
 * @property string $identifier
 * @property int $user
 * @property string $timestamp
 */
class SubCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sub_categories';
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
            [['name', 'category', 'identifier', 'user'], 'required'],
            [['category', 'user'], 'integer'],
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
            'category' => 'Category',
            'identifier' => 'Identifier',
            'user' => 'User',
            'timestamp' => 'Timestamp',
             'categories.name' => 'Category',
        ];
    }
    
     public function getCategories()
 {
        return $this->hasOne(Categories::className(), ['id' => 'category']);
 }
}
