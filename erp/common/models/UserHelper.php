<?php
namespace common\models;

use Yii;
use frontend\modules\hr\models\EmpUserDetails;
use frontend\modules\hr\models\Employees;
class UserHelper
{
    
    public static function getUserInfo($user)
{
    
$q=" SELECT u.*  FROM  user as u 
where u.user_id='".$user."' ";
$command= Yii::$app->db->createCommand($q);
$row = $command->queryOne(); 
return $row;
   
    
}


    
    public static function getEmployee($user)
{
    
 $employee =Employees::find()->alias('e')
        ->select('`e`.*')
        ->innerJoin('emp_user_details u', '`u`.`employee` = `e`.`id`')
        ->where([
            'u.user_id' =>$user
        ])
      ->one();
                 
return $employee;       
   
    
}



public static function getPositionInfo($_user)
{
    $subquery=ErpPersonsInPosition::find()->select(['position_id'])->where(["person_id"=>$_user,"status"=>1] )->orderBy(['id' => SORT_DESC])->AsArray()->one();
    $pos=ErpOrgPositions::find()->select('tbl_pos.*')
                            ->alias('tbl_pos')
                             ->where(['tbl_pos.id'=> $subquery['position_id']])
                             ->AsArray()->one();
   
    return $pos;
    
}


 public static function getOrgUnitInfo($_user){

   $subquery=ErpPersonsInPosition::find()->select(['unit_id'])->where(["person_id"=>$_user,"status"=>1] )->orderBy(['id' => SORT_DESC])->AsArray()->one();
   $unit = ErpOrgUnits::find()
                      ->alias('org_u1')
                      ->select(['org_u1.unit_name','org_u1.unit_code', 'l1.level_name as unit_type', 
                       'org_u2.unit_name as parent_unit' ,'org_u2.unit_code as parent_code','l2.level_name as parent_type',])
                      ->leftJoin('erp_org_units org_u2','org_u2.id = org_u1.parent_unit')
                      ->innerJoin('erp_org_levels l1','l1.id = org_u1.unit_level')
                      ->leftJoin('erp_org_levels l2','l2.id = org_u2.unit_level')
                      ->where(['org_u1.id'=>$subquery['unit_id']])
                      ->asArray()->One();
   
                        return $unit;
      
     
    
   }
 
 
   public static function getUser($userId)
{
    
return User::findIdentity($userId);
   
    
}

//return org unit as oject
public static function getOrgUnit($userId){

   $subquery=ErpPersonsInPosition::find()->select(['unit_id'])->where(["person_id"=>$userId,"status"=>1] )->orderBy(['id' => SORT_DESC])->AsArray()->one();
   return  ErpOrgUnits::find()->where(['id'=>$subquery['unit_id']])->One();
   

   }

//-----------retur position as object---------------------------------
public static function getPosition($userId)
{
    $subquery=ErpPersonsInPosition::find()->select(['position_id'])->where(["person_id"=>$userId,"status"=>1] )->orderBy(['id' => SORT_DESC])->AsArray()->one();
    return ErpOrgPositions::find()->where(['id'=> $subquery['position_id']])->one();
   
    
    
}

public static function findUserByPosition($pos){
    
 
  $record=ErpPersonsInPosition::find()->where(["position_id"=>$pos,'status'=>1] )->orderBy(['id' => SORT_DESC])->one();
 
   return $record->person_id;   
}

}

?>
