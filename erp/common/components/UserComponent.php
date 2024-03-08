<?php
namespace common\components;

use Yii;
use yii\base\Component;
use common\models\User;
use common\models\ErpOrgUnits;
use common\models\ErpOrgPosition;
use common\models\ErpUnitsPositions;
use common\models\ErpOrgPositions;
use common\models\ErpPersonsInPosition;
use common\models\ErpPersonInterim;


class UserComponent extends Component {

 public function getUserInfo($_user){
  
   
   $cond['user_id']=$_user;
  
   $user= User::find()
    ->where($cond)
    ->One();
 
      
    return $user ;      
    
   }
   
    //-------------------user position-------------------------------------------------------------------------
   public function getPosInfo($_user,$current=true){
  
 $pos=ErpOrgPositions::find()->select('tbl_pos.*')
                            ->alias('tbl_pos')
                            ->innerJoin('erp_persons_in_position tbl_pp', '`tbl_pp`.`position_id` = `tbl_pos`.`id`')
                             ->where(['tbl_pp.person_id'=>$_user])
                             ->orderBy(['tbl_pp.id' => SORT_DESC])->one();
   
    return $pos;
      
    
    
   }
   
  public function getUnitInfo($_user,$current=true){

   $unit = ErpOrgUnits::find()
    ->select(['u.*'])
    ->alias('u')
    ->innerJoin('erp_persons_in_position pp','pp.unit_id = u.id')
    ->where(['pp.person_id'=>$_user])
    ->orderBy(['pp.id' => SORT_DESC])->one();
   
    return $unit;
      
     
    
   }
   
  public function getSignature($_user){
      
      
      $q=" SELECT * from signature where user=".$_user." ";
      $command= Yii::$app->db->createCommand($q);
      $row= $command->queryOne(); 
      return $row;
      
      
  }
  
  public function getInterim($_user,$for,$date){
      
    $cond[]='and'; 
    $cond[]=['<=', 'i.date_from', $date];
    $cond[]=['>=', 'i.date_to', $date];
    $cond[]=['=', 'i.person_in_interim',$_user];
    $cond[]=['=', 'i.person_interim_for',$for];
     $cond[]=['=', 'i.status', "active"];

   $interim = ErpPersonInterim::find()
    ->alias('i')
    ->where($cond)
    ->One();
   
    return $interim;
     
  }   
 
   public function getReportTo($user){
      
    $position=$this->getPosInfo($user);
    
$person_in_position=ErpPersonsInPosition::find()->where(["position_id"=>$position->report_to,"status"=>1] )->orderBy(['id' => SORT_DESC])->one();

if($person_in_position==null)
{
  
 $person_in_position=ErpPersonsInPosition::find()->where(["position_id"=>$position->report_to])->orderBy(['id' => SORT_DESC])->one();
 $position=$this->getPosInfo($person_in_position->person_id,false);
 $person_in_position=ErpPersonsInPosition::find()->where(["position_id"=>$position->report_to,"status"=>1] )->orderBy(['id' => SORT_DESC])->one();
}

$person_level=ErpUnitsPositions::find()->where(["position_id"=>$position->report_to] )->one();
$user=$this->getUserInfo($person_in_position->person_id);
if($person_level!=null && $user!=null)
{
$user->level= $person_level->position_level;
}
    return $user;
     
  }     
   public function getManager($user){
$i=0;
While(true)
{
 if($i==0)
 {
$user=$user;
}
else{
$user=$manager->user_id;
}


$manager= $this->getReportTo($user);
if($manager->level=="manager" || $i==10)
{
  
    break;
    
}
$i++;

}
 return $manager;    
  } 
  
     public function getDirector($user){
$i=0;
While(true)
{
 if($i==0)
 {
$user=$user;
}
else{
$user=$director->user_id;
}


$director= $this->getReportTo($user);
if($director->level=="director" || $i==10)
{
  
    break;
    
}
$i++;

}
 return $director;    
  }
  
  
   public function getReportToPos($position_id){
    
$pos=ErpOrgPositions::find()->where(["id"=>$position_id] )->orderBy(['id' => SORT_DESC])->one();
  
$report_pos=ErpOrgPositions::find()->where(["id"=>$pos->report_to] )->orderBy(['id' => SORT_DESC])->one();

$person_level=ErpUnitsPositions::find()->where(["position_id"=>$report_pos->id] )->one();

if($person_level!=null && $position_id!=null)
{
$report_pos->level= $person_level->position_level;
}
return $report_pos;
     
  }
  public function getDirectorPos($position_id){
$i=0;

While(true)
{
 if($i==0)
 {
$position=$position_id;
}
else{
$position=$director_pos->id;
}

$director_pos= $this->getReportToPos($position);

if($director_pos->level=="director" || $i==10)
{
  
    break;
    
}
$i++;

}
 return $director_pos;    
  }
}

?>