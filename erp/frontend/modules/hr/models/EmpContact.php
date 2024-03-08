<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_contact".
 *
 * @property int $id
 * @property int $employee
 * @property string $work_phone
 * @property string $mobile_phone
 * @property string $work_email
 * @property string $personal_email
 */
class EmpContact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_contact';
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
            [['employee',  'mobile_phone', 'personal_email'], 'required'],
           // [['employee', 'mobile_phone'], 'required', 'on'=>['create','update']],
            [['employee'], 'integer'],
            [['work_phone', 'mobile_phone'], 'string', 'max' => 10],
            [['work_email', 'personal_email'], 'email'],
            
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
            'work_phone' => 'Work Phone',
            'mobile_phone' => 'Mobile Phone',
            'work_email' => 'Work Email',
            'personal_email' => 'Personal Email',
        ];
    }
}
