<?php

namespace frontend\modules\hr\models;

use Yii;

/**
 * This is the model class for table "emp_banks".
 *
 * @property int $id
 * @property string $bank_name
 * @property string $bank_account
 * @property string $bank_branch
 * @property int $employee
 * @property int $active
 */
class EmpBankDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_bank_details';
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
            [['acct_holder_type','acct_reference','bank_code', 'bank_account', 'employee'], 'required'],
            [['employee', 'active','is_default'], 'integer'],
            [['bank_name', 'bank_branch'], 'string', 'max' => 255],
            [['acct_holder_type','acct_reference'], 'string'],
            [['bank_code'], 'string', 'max' => 11],
            //[['bank_account'], 'unique'],
     /*       [['bank_account'], //unique constraint tempary removed
          'unique',
         'targetAttribute' => ['bank_account'],
         'message' => 'Employee with this bank Account  already exists (bank account should be unique except it is joint account)',
         'when' => function ($model) {
        return !empty($model->acct_holder_type) && $model->acct_holder_type=='SGL';
    }
],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bank_name' => 'Bank Name',
            'bank_account' => 'Bank Account',
            'bank_branch' => 'Bank Branch',
            'employee' => 'Employee',
            'active' => 'Active',
        ];
    }
    
     public function getBank()
    {
        return $this->hasOne(Banks::className(), ['sort_code' => 'bank_code']);
        
       
    }
    
public static function findByEmpAndRef($empId,$ref){

$query=self::find(); 
if(($acc=$query->where(['employee'=>$empId,'acct_reference'=>$ref])->one())!=null){
    return $acc;
}
return self::findDefault($empId);
}

public static function findDefault($empId){
 
 return self::find()->where(['employee'=>$empId,'is_default'=>1])->one();   
    
}

}
