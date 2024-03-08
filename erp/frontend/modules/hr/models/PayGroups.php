<?php

namespace frontend\modules\hr\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "pay_groups".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 *
 * @property Deductions[] $deductions
 * @property Payrollemployees[] $payrollemployees
 */
class PayGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pay_groups';
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
            [['name','code', 'run_type'], 'required'],
            [['code','run_type','run_frequency'], 'string', 'max' => 11],
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
            'description' => 'Description',
            'run_frequency'=>'Frequency'
        ];
    }
 /**
     * {@inheritdoc}
     * @return PayGroupsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PayGroupsQuery(get_called_class());
    }


function getEmpOnRegPayRun(){

//return $this->hasMany(Employees::className(), ['id' => 'employee'])->viaTable(EmpPayDetails::tableName(), ['pay_group' => 'code'])->Oncondition(['<>','status','TERM']);
// return $this->hasMany(Employees::className(), ['id' => 'employee'])->viaTable(EmpPayDetails::tableName(), ['pay_group' => 'code'])
//                                                                   ->onCondition(['<>', 'employees.status', 'TERM'])
//                                                                   ->andOnCondition(['emp_pay_details.active' =>1]);
  $subquery = (new Query())
            ->select('employee')
            ->from(EmpPayDetails::tableName())
            ->where(['pay_group'=>$this->code,'active' =>1]);

        return Employees::find()
            ->where(['IN', 'id', $subquery])
            ->andWhere(['<>', 'status', 'TERM'])
            ->all();                                                                 
                                                                   
}

function getEmpOnSupplPayRun(){

return $this->hasMany(Employees::className(), ['id' => 'employee'])->viaTable(EmpPaySupplements::tableName(), ['pay_group' => 'code']);

}

function findEmpByRunType(){
    
     switch($this->run_type){
       
        case 'REG':
            return $this->empOnRegPayRun;
            break;
       case 'SUP':
           return $this->empOnSupplPayRun;
           break;
           
           default:
           return $this->empOnRegPayRun;
       
   }
}



function getRunType0(){

return $this->hasOne(PayrollRunTypes::className(), ['code' => 'run_type']) ;

}

function getFrequency0(){

return $this->hasOne(Payfrequency::className(), ['code' => 'run_frequency']) ;

}

function getPayTemplate(){

return $this->hasOne(PayTemplates::className(), ['pay_group' => 'id']) ;

}

public  static function findByCode($code){
 $query=self::find();
 if(is_array($code))
 return $query->where(['in','code',$code])->all();
 
 return $query->where(['code'=>$code])->One() ;  
    
}


}
