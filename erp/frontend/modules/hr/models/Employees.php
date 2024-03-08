<?php

namespace frontend\modules\hr\models;

use Yii;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "employees".
 *
 * @property int $id
 * @property string $employee_no
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property int $nationality
 * @property string $birthday
 * @property string $gender
 * @property string $marital_status
 * @property string $rssb_pension
 * @property string $nic_num
 * @property string $other_id
 * @property string $status
 *
 * @property EmpCertifications[] $empCertifications
 * @property Certifications[] $certifications
 * @property EmpDocuments[] $empDocuments
 * @property EmpEducations[] $empEducations
 * @property EmpLanguages[] $empLanguages
 * @property Languages[] $languages
 * @property EmpSalaryDetails[] $empSalaryDetails
 * @property EmpSkills[] $empSkills
 * @property Skills[] $skills
 * @property Payrollemployees $payrollemployees
 */
class Employees extends \yii\db\ActiveRecord
{
     public $bulk_upload_file;
     
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees';
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
            [['first_name','last_name','employee_type'], 'required'],
            [['nationality'], 'string'],
            [['birthday'], 'safe'],
            [['gender', 'marital_status', 'status'], 'string'],
            [['employee_no','employee_type'], 'string', 'max' => 50],
            [['first_name', 'middle_name', 'last_name',  'nic_num', 'other_id'], 'string', 'max' => 100],
            [['employee_no'], 'unique'],//'nic_num' unique constraint tempoary removed
            ['nic_num', 'required', 'when' => function ($model) {
    return ($model->nationality!=null) && ($model->nationality =='RW');
}, 'whenClient' => "function (attribute, value) {
    return ($('#nat-id').val() !='')  && ($('#nat-id').val() == 'RW');
}"],
      ['other_id', 'required', 'when' => function ($model) {
    return ($model->nationality!=null) && ($model->nationality !=='RW');
}, 'whenClient' => "function (attribute, value) {
    return ($('#nat-id').val() !='') && ($('#nat-id').val() !== 'RW');
}"],
            [['bulk_upload_file'], 'file', 'extensions'=>'xlsx, xls,csv','skipOnEmpty'=>true,'maxFiles' => 1,'minFiles'=>1],//validating inputfile
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_no' => 'Employee No',
            'employee_type' => 'Employee Type',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'nationality' => 'Nationality',
            'birthday' => 'Date of Birth',
            'gender' => 'Gender',
            'marital_status' => 'Marital Status',
           'nic_num' => 'National Identity Card Number',
           
            'other_id' => 'Other ID',
            'status' => 'Status',
            'bulk_upload_file'=>'Upload Excel File'
        ];
    }
    
    /**
     * {@inheritdoc}
     * @return PayItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeesQuery(get_called_class());
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpType()
    {
        return $this->hasOne(EmpTypes::className(), ['code' => 'employee_type']);
    }
    
      /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(EmployeeStatuses::className(), ['code' => 'status']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpCertifications()
    {
        return $this->hasMany(EmpCertifications::className(), ['employee' => 'id']);
    }

 /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatutories()
    {
        return $this->hasMany(EmpStatutoryDetails::className(), ['employee' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCertifications()
    {
        return $this->hasMany(Certifications::className(), ['id' => 'certification_id'])->viaTable('emp_certifications', ['employee' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpDocuments()
    {
        return $this->hasMany(EmpDocuments::className(), ['employee' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpEducations()
    {
        return $this->hasMany(EmpEducations::className(), ['employee' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpLanguages()
    {
        return $this->hasMany(EmpLanguages::className(), ['employee' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Languages::className(), ['id' => 'language_id'])->viaTable('emp_languages', ['employee' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
  
   
     
     public function getEmploymentDetails()
{
    return $this->hasOne(EmpEmployment::className(), ['employee' => 'id'])->andOnCondition([EmpEmployment::tableName().'.active' =>1])
        ->orderBy([EmpEmployment::tableName().'.id'=>SORT_DESC]);
       
}
    public function getFirstEmploymentDetails()
{
    return $this->hasOne(EmpEmployment::className(), ['employee' => 'id'])->orderBy([EmpEmployment::tableName().'.id'=>SORT_ASC]);
       
}
      public function getPaySupplements()
    {
        return $this->hasMany(EmpPaySupplements::className(), ['employee' => 'id'])->andOnCondition(['active' =>1])->orderBy([EmpPaySupplements::tableName().'.id'=>SORT_DESC]);;
      
    }


 public function getPayDetails()
    {
        return $this->hasOne(EmpPayDetails::className(), ['employee' => 'id'])->andOnCondition(['active' =>1])
        ->orderBy(['id'=>SORT_DESC])
        ->one();
    }

     
    public function getBankDetails()
    {
         return $this->hasMany(EmpBankDetails::className(), ['employee' => 'id'])
        ->orderBy(['id'=>SORT_DESC])
        ->one();
    }
    
     public function getBankAccounts()
    {
         return $this->hasMany(EmpBankDetails::className(), ['employee' => 'id'])->orderBy(['id'=>SORT_ASC]);
       
    }
    
    
     
     public function getPaySplits()
    {
         return $this->hasMany(EmpPaySplits::className(), ['employee' => 'id'])->orderBy(['id'=>SORT_ASC]);
       
    }
    
    
      public function getUserDetails()
    {
         return $this->hasOne(EmpUserDetails::className(), ['employee' => 'id'])->one();
       
    }

  
     public function getStatutoryDetails()
    {
         return $this->hasOne(EmpStatutoryDetails::className(), ['employee' => 'id'])->one();
       
    }
  
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpSkills()
    {
        return $this->hasMany(EmpSkills::className(), ['employee' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkills()
    {
        return $this->hasMany(Skills::className(), ['id' => 'skill_id'])->viaTable('emp_skills', ['employee' => 'id']);
    }

 
    
   
     public function getContact(){
    
      return EmpContact::find()->where(['employee' =>$this->id])->one(); 
    }
    
     public function getAddress(){
    
      return EmpAddressCurrent::find()->employee($this->id)->one();  
    }
    
    
     
    
    public function getPhoto(){
        
         return $this->hasMany(EmpPhoto::className(), ['employee' => 'id'])
        ->orderBy(['id'=>SORT_DESC])
        ->one();
     
    }
    
    public static function active($output=array()){
  
      $output= self::find()->innerJoinWith([
    'employmentDetails' => function($q)use($type) {
      $q->andOnCondition(['employment_status' =>EmploymentStatus::STATUS_TYPE_AE]);
    }
])->orderBy([
    'first_name' => SORT_ASC    
])->all();

 return $output;
        
    }
    
public static  function findByEmpType($code,$status=EmployeeStatuses::STATUS_TYPE_ACT){
   
   $output= self::find()->where(['employee_type'=>$code,'status'=>empty($status)?EmployeeStatuses::STATUS_TYPE_ACT : $status ])->orderBy([
    'first_name' => SORT_ASC    
])->all();

 return $output;
 
 /*$output= self::find()->JoinWith(['employmentDetails'])->andwhere(['employees.status'=>EmployeeStatuses::STATUS_TYPE_ACT,'emp_employment.employee_type'=>$code])->orderBy([
    'first_name' => SORT_ASC    
])->all();

 return $output;*/
 
 }
 
 public static  function findByNID($nid){
 
 return self::find()->where(['nic_num'=>$nid])->one();
 
 
 }
 
  public static  function findByEmpNo($no){
 
 return self::find()->where(['employee_no'=>$no])->one();
 
 
 }

  public function beforeValidate()
{
    if (parent::beforeValidate()) {
        
        if(empty($this->employee_no))
         $this->employee_no=Yii::$app->empUtil->generateEmpNo($this->employee_type);
        
        if($this->isNewRecord)
         $this->created_by=Yii::$app->user->identity->user_id; 
        
        
        return true;
    }
    return false;
}

public function isEmployee(){
    
    return $this->employee_type==EmpTypes::EMP_TYPE_EMP;
}

public function beforeSave($insert) {
     
    if(empty($this->status))
    $this->status=EmployeeStatuses::STATUS_TYPE_ACT;

    return parent::beforeSave($insert);
}

function  findWageByRunType($payRun){

   if($payRun->isSuppl()){
      
     return EmpPaySupplements::find()
                                   ->where(['employee'=>$this->id,'item'=>$payRun->supplType->id])
                                   ->andwhere(['active'=>1])
                                ->orderBy(['id' => SORT_DESC ])->one(); 
       
      }
 else if($payRun->isRegular()){
      
      
      return $this->payDetails;
        
          
      }  
    
}

public function isOnPayroll(){
    
  $payslip= Payslips::find()->where(['employee'=>$this->id])
                            ->andwhere(['status'=>'approved'])
                            ->one(); 
  return $payslip !== null;
}

}
