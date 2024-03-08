<?php
namespace frontend\modules\hr\components;


use Yii;
use yii\base\Component;
use yii\data\ActiveDataProvider;
use frontend\modules\hr\models\EmpUserDetails;
use frontend\modules\hr\models\Employees;
use frontend\modules\hr\models\EmpTypes;
use frontend\modules\hr\models\EmpStatutoryDetails;
use frontend\modules\hr\models\EmployeeStatuses;

class EmployeeUtil extends Component {
 
 public function getEmpByUser($user){
 
 $employee =Employees::find()->alias('e')
        ->select('`e`.*')
        ->innerJoin('emp_user_details  u', '`u`.`employee` = `e`.`id`')
        ->where([
            'u.user_id' =>$user
        ])
      ->one();
return $employee;
 
 }
 
  public function getNoJob(){
 
  $query =Employees::find()->alias('e')
        ->select('`e`.*')
        ->leftJoin('emp_employment t', '`t`.`employee` = `e`.`id`')
        ->where([
            't.id' => null,
        ]);
$provider = new ActiveDataProvider([
    'query' => $query,
    'pagination' =>false,
    
]);
                 
return $provider;
 
 }
 
   public function getNoSalary(){
 
  $query =Employees::find()->alias('e')
        ->select('`e`.*')
        ->leftJoin('emp_pay_details p', '`p`.`employee` = `e`.`id`')
        ->where([
            'p.id' => null,
        ]);
$provider = new ActiveDataProvider([
    'query' => $query,
    'pagination' =>false,
    
]);
                 
return $provider;
 
 }
 public function getDuplicates(){
 
$subQuery = EmpStatutoryDetails::find()->alias('s')
         ->select(['s.employee','s.emp_pension_no','COUNT(*)'])
        ->groupBy(['s.emp_pension_no'])
         ->having([ '>', 'COUNT(*)', 1 ]);
   
 
  $query =Employees::find()->alias('e')
         ->select(['e.*'])
         ->innerJoin(['m' => $subQuery], 'e.id= m.employee');
$provider = new ActiveDataProvider([
    'query' => $query,
    'pagination' =>false,
    'sort' => [
        'defaultOrder' => [
            'employee_no' => SORT_ASC,
          
        ]
    ],
]);
                 
return $provider;
 
 }

 
  public function getEmpCountByEmplType($type,$count=0){
 
  $count= Employees::find()->select(['id'=>'emp_id'])->innerJoinWith([
    'employmentDetails' => function($q)use($type) {
      $q->andOnCondition(['employment_type' =>$type]);
    }
])->count();

return $count;
 
 }
 
   public function getEmpCountByType($type,$status=EmployeeStatuses::STATUS_TYPE_ACT, $count=0){
 
  $count =Employees::find()->alias('e')
                           ->where([
            'e.employee_type' =>$type,
            'status'=>empty($status) ? EmployeeStatuses::STATUS_TYPE_ACT : $status
        ])->count();

                 
return $count;
 
 }
 
  public function generateEmpNo($emplType){
      
      $query = (new \yii\db\Query());
     $query->select(['SUBSTRING_INDEX(employee_no, "-", 1) AS prefix_part', 'SUBSTRING_INDEX(employee_no, "-", -1) AS number_part'])
           ->from('emp_employment')
           ->where(['employment_type'=>$emplType])
           ->andWhere(["not",["employee_no"=> null]])
           ->orderBy(['employee_no' => SORT_DESC]);
      
      $result=$query->one(\Yii::$app->db4);
      $pad_base=1;
      
      
      if(!empty($result)){
         $num_part=$result['number_part'];
         $pad_base=$pad_base+(int) filter_var($num_part, FILTER_SANITIZE_NUMBER_INT);
         
        }
        
        $prefix=$emplType=='PERM'?'EMP':$result['prefix_part'];
      
        return $prefix."-".str_pad($pad_base, 3, '0', STR_PAD_LEFT);
      
   
 
 }
  public function generateEmpNo1($empType){
      $category = EmpTypes::find()->where(["code"=>$empType])->one()->category0;
      if($category->code=="EMP"){
          $cond=['emp_types.category'=> $category->code];
          $prefex= $category->code;
          
      }
      else{
         $cond= ['e.employee_type'=> $empType] ;
           $prefex= $empType;
      }
           $pad_base=1;
           $lastEmp=Employees::find()->select(['e.id','e.employee_type','e.employee_no'])
                                   ->alias('e')
                                   ->innerJoinWith('empType')
                                   ->where($cond)
                                  ->andWhere(["not",["e.employee_no"=> null]])
                                   ->orderBy(['employee_no' => SORT_DESC])->one();
                               
        if($lastEmp!=null && !empty($lastEmp->employee_no)){
            $number=explode("-",$lastEmp->employee_no);
         $pad_base=(int) filter_var($number[1], FILTER_SANITIZE_NUMBER_INT);
         ++$pad_base;
        } 
        return $prefex."-".str_pad($pad_base, 3, '0', STR_PAD_LEFT);
 
 }
  
  public function generateEmpNo2($empType){
         $pad_base=1;
         $default=9999;
         $lastEmp=Employees::find()->select(['e.id','e.employee_type','e.employee_no'])
                                   ->alias('e')
                                   ->where([ 'e.employee_type' =>$empType])
                                    ->andWhere(['not', ['e.employee_no' => null]])
                                   ->orderBy(['id' => SORT_DESC])->one();
                               
       
        if($lastEmp!=null){
         $default=(int) filter_var($lastEmp->employee_no, FILTER_SANITIZE_NUMBER_INT);    
         ++$default;
        }
     return $empType.mt_rand($default-1,$default);   
 }

 } 
?>