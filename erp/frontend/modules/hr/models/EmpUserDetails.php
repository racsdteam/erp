<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_user_details".
 *
 * @property int $id
 * @property int $employee
 * @property int $user_id
 */
class EmpUserDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_user_details';
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
          
            [['employee', 'user_id'], 'required', 'on'=>['create','update']],
            [['employee', 'user_id','active'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee' => 'Employee',
            'user_id' => 'User ID',
        ];
    }
}
