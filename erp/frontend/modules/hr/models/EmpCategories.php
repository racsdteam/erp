<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_categories".
 *
 * @property int $id
 * @property string $name
 */
class EmpCategories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_categories';
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
            [['name','code'], 'required'],
            [['name','code'], 'string', 'max' => 255],
             [['description'], 'string'],
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
            'code'=>'Code'
        ];
    }

    /**
     * {@inheritdoc}
     * @return EmpCategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmpCategoriesQuery(get_called_class());
    }
}
