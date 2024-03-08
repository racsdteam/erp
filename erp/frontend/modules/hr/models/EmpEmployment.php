<?php

namespace frontend\modules\hr\models;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use Yii;

/**
 * This is the model class for table "emp_employement".
 *
 * @property int $id
 * @property int $employee
 * @property int $org_unit (org_unit or department)
 * @property int $position
 * @property int $pay_type (weekly,monthly,semi-monthly)
 * @property int $pay_group civilan , police, rib
 * @property int $pay_grade eng,managers,directors,coordinators,..
 * @property string $start_date
 * @property string $end_date
 * @property int $employment_type parmanent,contract,..
 * @property int $supervisor
 * @property string $work_location
 */
class EmpEmployment extends \yii\db\ActiveRecord
{
     public $employee_type;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'emp_employment';
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
            [['employee',  'start_date', 'employment_type','employee_type','employee_no'], 'required'],
             [['org_unit', 'position'], 'required', 
        
        'when' => function ($model)//----------validation on server side
        {
          return $model->employee_type ==EmpTypes::EMP_TYPE_EMP;
        }, 
        'whenClient' => "employeeTypeChecked" //-----------valiadtion function on client side
    
    ],
          
      
            [['employee', 'org_unit', 'position',   'supervisor','active'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['employment_type',], 'string','max'=>11],
            [['work_location','employee_type','employee_no'], 'string'],
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
            'org_unit' => 'Department/Unit/Office',
            'position' => 'Position',
            'start_date' => 'Date Started',
            'end_date' => 'Date Ended',
            'employment_type' => 'Employement Type',
            'supervisor' => 'Supervisor',
            'work_location' => 'Work Location',
        ];
    }
    
     
     public function getEmployee0()
    {
        return $this->hasOne(Employees::className(), ['id' => 'employee']);
    }
    
    
     public function getOrgUnitDetails()
    {
        return $this->hasOne(ErpOrgUnits::className(), ['id' => 'org_unit'])->where(['active'=>1]);
    }
    
  
     public function getPositionDetails()
    {
        return $this->hasOne(ErpOrgPositions::className(), ['id' => 'position']);
    }
    
     public function getEmploymentType()
    {
        return $this->hasOne(EmploymentType::className(), ['code' => 'employment_type']);
    }
   
    

     public function getWorkLocation()
    {
        return $this->hasOne(Locations::className(), ['id' => 'work_location']);
    }
    
     public function getSupervisor0()
    {
        return $this->hasOne(ErpOrgPositions::className(), ['id' => 'supervisor']);
    }
    
    public function isActing(){
 
     return $this->employment_type==EmploymentType::EMPL_TYPE_ACT;   
    
    }
    public static function findByEmpId($id){
   
   $query=self::find();
   is_array($id) ? $query->where(['in','employee',$id]) : $query->where(['employee'=>$id]);
   $query->andWhere(['active'=>1]);
   $query->orderBy(['id' => SORT_DESC]);
   return $query->all();
  
     }
       
}
