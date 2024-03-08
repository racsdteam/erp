<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\Expression;
use yii\helpers\Json;
use common\models\ErpPersonsInPosition;
use common\models\UserHelper;
use yii\helpers\ArrayHelper;

/**
 * AssigmentUserResolver
 */
class AssignmentUserResolver
{
    
public static function resolveUser($stepNode,$wfContext){
    
$assigmentType=$stepNode->getAssignmentType();
$wfInstance=$wfContext->getWfInstance();


switch($assigmentType->type){
  
  case 'MNGR_HRCHY' :{
      
      $hrchy_start=$assigmentType->hrchy_start=='requester'? $wfInstance->wfInitiator->user_id : null;
      $assignedUser=self::getApproverByMgrtHierarchy( $hrchy_start, $assigmentType->hrchy_stop);
     break; 
  } 
  
  case 'FIXED_POS' :{
      
    $assignedUser=self::getApproverByPosition($assigmentType->value);
    break;
      
  }
  
  case 'WF_INITIATOR' :{
      
    $assignedUser=$wfInstance->wfInitiator->user_id;
    break;
      
  }
  default:
     $assignedUser=$wfInstance->wfInitiator->user_id;
     break;
    
}

     

return   $assignedUser;

 }
 
 protected static function getApproverByMgrtHierarchy($hrchy_user,$supLevel){
 
 $pos=UserHelper::getPositionInfo($hrchy_user);
 $hrchy_start=$pos['report_to'];
 
 if(empty($hrchy_start)) return null;

$connection = Yii::$app->getDb();
$command = $connection->createCommand("SELECT T2.id, T2.position, T1.lvl FROM ( SELECT @r AS _id, 
(SELECT @r := report_to FROM erp_org_positions WHERE id = _id) AS parent_id, @l := @l + 1 AS lvl FROM (SELECT @r :=$hrchy_start, @l := 0) vars, 
erp_org_positions m WHERE @r <> 0) T1 JOIN erp_org_positions T2 ON T1._id = T2.id where T1.lvl=$supLevel ORDER BY T1.lvl DESC"); 
$row=$command->queryOne(); 

return self::getApproverByPosition($row['id']); 
}

protected static function getApproverByPosition($pos){
  
  $record=ErpPersonsInPosition::find()->where(["position_id"=>$pos] )->orderBy(['id' => SORT_DESC])->one();
 
 return $record->person_id;
 
 
    
}
}
