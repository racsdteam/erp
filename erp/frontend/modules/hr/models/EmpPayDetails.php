<?php

namespace frontend\modules\hr\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "emp_pay_details".
 *
 * @property int $id
 * @property int $employee
 * @property int $unit
 * @property int $position
 * @property string $pay_basis
 * @property int $pay_frequency
 * @property int $pay_level
 * @property string $base_pay
 * @property int $pay_group
 * @property int $pay_tmpl
 * @property int $created_by
 * @property string $created
 */
class EmpPayDetails extends \yii\db\ActiveRecord implements WageInterface
{
    
     public $salary_grade_wise;
     public const PAY_ENG='E';
     public const PAY_DED='D';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_pay_details';
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
            [[ 'employee', 'pay_basis','base_pay' ,  'pay_group', 'created_by'], 'required'],
            
      /*  [['base_pay',], 'required', 
        
        'when' => function ($model)//----------validation on server side
        {
        return $model->pay_basis =='SAL';
        }, 
        'whenClient' => "salaryTypeSelect" //-----------valiadtion function on client side
    
    ],*/
    
  /*   [['monthly_allowance',], 'required', 
        
        'when' => function ($model)//----------validation on server side
        {
        return $model->pay_basis =='MALW';
        }, 
        'whenClient' => "allowanceTypeSelect" //-----------valiadtion function on client side
    
    ],*/
            [['employee', 'org_unit', 'position','pay_level','created_by','active'], 'integer'],
            [['pay_basis','pay_group' ], 'string'],
            [['created','salary_grade_wise'], 'safe'],
            [['base_pay'], 'string', 'max' => 255],
            [['id'], 'unique'],
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
            'org_unit' => 'Org Unit',
            'position' => 'Position',
            'pay_basis' => 'Pay Basis',
            'pay_level' => 'Pay Grade',
            'salary_grade_wise' => 'Salary based on grade',
            'base_pay' => 'base_pay',
            'pay_group' => 'Pay Group',
            'created_by' => 'Created By',
            'created' => 'Created',
        ];
    }
    
     public function getPayLevel()
    {
        return $this->hasOne(PayLevels::className(), ['id' => 'pay_level']);
    }
 
    
     public function getPayType()
    {
        return $this->hasOne(PayTypes::className(), ['code' => 'pay_basis']);
    }
    
     public function getPayGroup()
    {
        return $this->hasOne(PayGroups::className(), ['code' => 'pay_group']);
    }
    
    
     public function getEmployee0(){
    
      return $this->hasOne(Employees::className(), ['id' => 'employee']);
    }
   
     public function getPayEmployee(){
    
      return $this->hasOne(Employees::className(), ['id' => 'employee']);
    }
      public function getPayOrgUnit()
    {
        return $this->hasOne(\common\models\ErpOrgUnits::className(), ['id' => 'unit']);
    }
    
     public function getPayPosition()
    {
        return $this->hasOne(\common\models\ErpOrgPositions::className(), ['id' => 'position']);
    }
    
  
    public  function getAdditionalPay(){
        
      return $this->hasMany(EmpPayAdditional::className(), ['pay_id' => 'id'])->andOnCondition(['active' =>1]);
    }
   
    public  function getExemptPay(){
    
     return $this->hasMany(EmpPayExempt::className(), ['pay_id' => 'id'])->andOnCondition(['active' =>1]);
     } 
    
    //-----------------static---------------------------
    
 public static function employeeRemovedFromPay($e,$payStr){
     //lates for each group
     $subQuery =EmpPayRemoval::find()->select(['pay_tmpl_item as item','employee as emp', 'MAX(id) AS max_id'])->groupBy('emp,item');
     return EmpPayRemoval::find()->alias('tbl_parent')->innerJoin(['m' => $subQuery], 'tbl_parent.id = m.max_id')
                                ->where(['employee'=>$e,'pay_tmpl'=>$payStr,'state'=>0])->all();
        
     }
   

  public static function findByEmpId($id){
   
   $query=self::find()->select(['*',"cast(REPLACE(base_pay,',','') as unsigned ) as base"]);
   is_array($id) ? $query->where(['in','employee',$id]) : $query->where(['employee'=>$id]);
   $query->andWhere(['active'=>1]);
   $query->orderBy(['base' => SORT_DESC]);
   return $query->all();
  
     }
     
 public function getWageAmount(){
    
    return $this->base_pay;
} 

 public function getWageCode(){
    
    if($this->pay_basis=='SAL'){
        
        return 'BS';
    }
    else if($this->pay_basis=='MALW'){
        
         return 'MALW';
    }
  
}

}
