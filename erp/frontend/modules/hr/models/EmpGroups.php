<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_groups".
 *
 * @property int $id
 * @property string $name
 * @property int $pay_cycle
 * @property string $description
 */
class EmpGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_groups';
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
            [['name', 'code', 'description'], 'required'],
            [['code'], 'string','max'=>'11'],
            [['name', 'description'], 'string', 'max' => 100],
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
        ];
    }
}
