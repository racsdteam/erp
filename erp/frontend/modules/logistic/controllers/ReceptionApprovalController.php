<?php

namespace frontend\modules\logistic\controllers;
use Yii;
use common\models\ReceptionApproval;
use common\models\ReceptionGoods;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ReceptionApprovalFlow;
use common\models\User;


class ReceptionApprovalController extends \yii\web\Controller
{
           //--------------------------------===================apprvode==========----------------------------------------------------------
    public function actionWorkFlow(){
   
    $model = new ReceptionApproval();
   
    if(isset($_POST['ReceptionApproval'])){
     
     $data=$_POST['ReceptionApproval'];
   
     $action=$data['approval_action'];
     $remark=$data['remark'];
     $employees=$data['employee'];
     $cc=$data['employee_cc'];
     $reception=$data['reception'];
     $user=Yii::$app->user->identity->user_id;
    
     
    $model1=ReceptionGoods::find()->where(['id'=>$reception])->one();

 $msg='';
 
 $q6="SELECT p.id as pos_id ,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".$user."'";
$command6= Yii::$app->db->createCommand($q6);
$row5 = $command6->queryOne();

               
   //-------------------------------------------------work flow approvals-----------------------------------------------
     if($action=='approve'){
     
     
     //--  ----------------------final approval by MD--------------------------------------->                
 $q7=" SELECT u.user_id FROM  user as u  inner join   erp_persons_in_position as pp on u.user_id=pp.person_id 
 inner join erp_org_positions as p  on p.id=pp.position_id
  where  p.position_code='MGRLGX' ";
  $command7= Yii::$app->db->createCommand($q7);
  $row7 = $command7->queryOne();
  
  
  //----------------------------check if interim for------------------------------------------>

   $approvalDate = date('Y-m-d');
  $approvalDate=date('Y-m-d', strtotime($approvalDate));
  //----------------------------check if interim for------------------------------------------>
$q8="SELECT * from erp_person_interim where  person_in_interim='".$user."' and person_interim_for='".$row7['user_id']."' 
and date_from <= '$approvalDate' and date_to >= '$approvalDate'";
$command8= Yii::$app->db->createCommand($q8);
$row8 = $command8->queryOne();
      
   
   if($row7['user_id']==$user  || !empty($row8) ){
    
   $model1->status='approved';
   
   if($approved=$model1->save(false)){
       $q88="update  items_reception  set status='approved' where reception_good=".$model1->id."";
       $command88= Yii::$app->db1->createCommand($q88);
       $row88 = $command88->execute();
      $step_action='approved';
      $step_status='final'; 
      $msg="Received Goods Approved";
   }else{
       
      throw new \yii\web\HttpException(451,
          'Received Goods could not be approved
              (please try again).');   
       
         }
  
   }
   else{
      $step_action='approved';
      $step_status='middlemen';
      $msg='Your Approval Saved';
     
     }
  
  if(isset($step_action)){
     $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
     
  }
      
       
       }


               
    if($action=='cforward'){
  
    
    if($this->isForwarded($employees,$cc,$model1->id,$user,$remark)){
        
         $step_action='forwarded';
         $step_status='middlemen';
         $msg="Received Goods Forwarded !";
          $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
        Yii::$app->session->setFlash('success',$msg);
    
     if($model1->status=='drafting' && $model1->user==$user){
           
           $model1->status='processing';
           $model1->save(false);
           return $this->redirect(['reception-goods/draft']); 
       }
       
        if($model1->status=='Returned'){
           
           $model1->status='processing';
           $model1->save(false);
      return $this->redirect(['reception-goods/pending']); 
          } 
       
         
    }else{
        
      throw new \yii\web\HttpException(451,
          'The Received Goods  could not be forwarded
              (please try again).'); 
        
    }
 
      }
    
 if($action=='rfa'){
       
                      
                      if($model1->status!='approved'){
                           $model1->status='Returned';
                           $model1->save(false);
                      }
                      
       
                      
     
    if($this->isForwarded($employees,$cc,$model1->id,$user,$remark)){
     
     $step_action='returned';
     $step_status='middlemen';
     $msg='Received Goods sent back Successfully...';   
     $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);  
       
         //-------------------all done------------------------------------------------------------
  
   Yii::$app->session->setFlash('success',$msg);
   $done=  Yii::$app->db->createCommand()
                      ->update('reception_approval_flow', ['status' =>'returned'], ['approver'=>$user,'reception'=>$model1->id])
                      ->execute(); 
   
   return $this->redirect(['reception-goods/pending']);  
           
      
      
       }else{
        
      throw new \yii\web\HttpException(451,
          'The Received Goods could not be sent back
              (please try again).'); 
        
    }
    
    
    
    
    
     }
     
     
if($action=='close'){
        $model1->status='closed';
       $closed= $model1->save(false);
       if($closed){
           $this->ApprovalActionLog($model->id,$user,$row5['pos_id'],"closded",$remark);
           $msg="Received Goods  Closed";
       }else{
          throw new \yii\web\HttpException(451,
          'The Received Goods could not be Closed
              (please try again).');  
           
       }
     }
 
 //---------------------all went well--------------------------------------------
 
  Yii::$app->session->setFlash('success',$msg);
  
  
  
   
   $done=  Yii::$app->db1->createCommand()
                      ->update('reception_approval_flow', ['status' =>'done'], ['approver'=>$user,'reception'=>$model1->id])
                      ->execute(); 
   return $this->redirect(['reception-goods/pending']); 
   
}

     if(Yii::$app->request->isAjax){
         
      return $this->renderAjax('work-flow',[ 'model' =>$model,'reception'=>$_GET['reception']]); 
         
     }
    return $this->render('work-flow',[ 'model' =>$model,'reception'=>$_GET['reception']]);

   }
   
   
   
   //--------------------log fucntion---------------------------------------
 
 public function ApprovalActionLog($id,$user,$pos,$step_action,$step_status,$remark){
 
    
    $approval=new ReceptionApproval();
    $approval->reception=$id;
    $approval->approved_by=$user;
    $approval->approver_position=$pos;
    $approval->approval_action=$step_action;
    $approval->approval_status=$step_status;
    $approval->remark=$remark;
    $approval_saved=$approval->save(false);     
       
 }
 
 public function isForwarded($employees,$cc,$id,$user,$remark){
     
      $forwardDate = date('Y-m-d');
       $forwardDate=date('Y-m-d', strtotime($forwardDate));
    
     if(!empty($employees)){
 foreach($employees as $key=>$employee){
   
   
   //-----------check if person is out---------------------------------------------  
     $q8="SELECT * from erp_person_interim where  person_interim_for='".$employee."' 
      and date_from <= '$forwardDate' and date_to >= '$forwardDate'";
     $command8= Yii::$app->db->createCommand($q8);
     $row8 = $command8->queryOne(); 
     
     
    $recipientModel=new ReceptionApprovalFlow();
    $recipientModel->reception=$id;
    $recipientModel->approver=$employee;
    $recipientModel->originator=$user;
    $recipientModel->remark =$remark;
    
   if(!empty($row8)){
        
        $recipientModel->is_copy =1; 
    }
   
    if(!$forwarded=$recipientModel->save(false)){
      
    
      break; 
      
      return false;
        
    }
   
  $flag1=$this->sendEmail($user,$employee,$id);

      //---------------copy AA--------------------------------
   
    $q6="SELECT p.id as position_id,p.position_code FROM user as u 
     inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
     inner join erp_org_positions as p on p.id=pp.position_id where u.user_id={$employee}";
     $command6= Yii::$app->db->createCommand($q6);
     $row6 = $command6->queryOne();
     
     
         
      $q7=" SELECT u.user_id FROM erp_org_positions as p 
inner join erp_org_positions as p1 on p1.id=p.report_to 
inner join erp_persons_in_position as pp on pp.position_id=p.id inner join user as u on u.user_id=pp.person_id 
inner join erp_units_positions as up on up.position_id=p.id where p.report_to={$row6['position_id']} and up.position_level='pa'";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 


if(!empty($row7) && $row7['user_id']!=$user){
    
   
    $recipientModel=new ReceptionApprovalFlow();
    $recipientModel->reception=$id;
    $recipientModel->approver=$row7['user_id'];
    $recipientModel->originator=$user;
    $recipientModel->remark =$remark;
    $recipientModel->is_copy =1; 
    
      if($recipientModel->save(false)){
       $flag=$this->sendEmail($user,$row7['user_id'],$id) ;
        
    }
   
  
    
}                                                 
  
     
    


  
   
    
    
 }
 
     } 
     
     return $forwarded;
     
 }
 
 public function sendEmail($from,$to,$reception){
     
     
    
    $q7=" SELECT u.first_name,u.last_name,p.position FROM user as u  inner join erp_persons_in_position as pp  on u.user_id=pp.person_id
    inner join erp_org_positions as p  on pp.position_id=p.id  where pp.person_id='".$from."' ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           
                                           //-------------------sender-----------------------------------------------
                                           $sender=$row7['first_name']." ".$row7['last_name']." /".$row7['position'];
                                        
                                           //-------------------------receiver---------------------------
                                            $user2=User::find()->where(['user_id'=>$to])->One();
                                            
                                            $recipient=$user2->first_name." ".$user2->last_name;
                                            //---------------------------doc type--------------------------
           
           
                                           
                                            
                                           
                                               
                                                   
                                                $flag1= Yii::$app->mailer->compose( ['html' =>'userNotification-html'],
    [
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>'Goods Received Note','date'=>date("Y-m-d H:i:s"),'remark'=>$remark
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$to])
->setSubject('ERP Notification')
//->setTextBody('You Can Change Login Password After Sign in')
->send();


                                            
    
   return $flag1;
     
     
 }
   

}
