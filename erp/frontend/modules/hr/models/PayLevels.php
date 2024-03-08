<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "pay_grades".
 *
 * @property int $id
 * @property int $level
 * @property string $description
 * @property string $basic_salary
 */
class PayLevels extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pay_levels';
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
            [['name','number', 'basic_salary'], 'required'],
            [['number'], 'integer'],
            [['description'], 'string'],
            [[ 'basic_salary','name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Level #',
            'description' => 'Description',
            'basic_salary' => 'Basic Salary',
            'name'=>'Level Name'
        ];
    }

   
}
