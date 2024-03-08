<?php

namespace frontend\modules\hr\controllers;
use Yii;
use frontend\modules\hr\models\PerformanceContract;
use frontend\modules\hr\models\PcApproval;
use frontend\modules\hr\models\PcAppMsg;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\hr\models\PcApprovalFlow;
use common\models\User;
use common\models\UserHelper;

class PcApprovalController extends \yii\web\Controller
{
    
    
    public function actionIniSubmit($pc,$user,$next)
    {
        
         $q88="select count(*) as signe from pc_annotations where author=".$user." and 	type='Stamp' ";
       $command88= Yii::$app->db4->createCommand($q88);
       $count = $command88->queryOne();
       if($count['signe']!=0)
       {
              $model1=PerformanceContract::find()->where(['id'=>$pc])->one();
              $model1->status='submitted';
              $done= $model1->save(false);
        
        $employees[]=$next;
        $cc=array();
        $remark="Imihigo form for approval!";
          if($this->isForwarded($employees,$cc,$model1->id,$user,$remark)){
        
         $step_action='submit';
         $step_status='middlemen';
         $msg="Imihigo form for approval!";
          
 $q6="SELECT p.id as pos_id ,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".$user."' and pp.status=1";
$command6= Yii::$app->db->createCommand($q6);
$row5 = $command6->queryOne();
          $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
        Yii::$app->session->setFlash('success',$msg);

            $responce["message"]="Forwarded for Approval";
          $responce["flag"]=true;
          return json_encode($responce);
       
       
    }
    else{
        
       $responce["message"]="Not Forwarded. Please try again!";
          $responce["flag"]=false;
          return json_encode($responce);
        
    }
}
else
{
          $responce["message"]="Please Sign before submittion.";
          $responce["flag"]=false;
          return json_encode($responce);
} 
      
    }
        public function actionManagerApproval($pc,$user)
    {
        

         $q88="select count(*) as signe from pc_annotations where author=".$user." and 	type='Stamp' and doc=".$pc."";
       $command88= Yii::$app->db4->createCommand($q88);
       $count = $command88->queryOne();
       if($count['signe']!=0)
       {
              $model1=PerformanceContract::find()->where(['id'=>$pc])->one();
              $model1->status='Manager approved';
              $done= $model1->save(false);
        $pos=UserHelper::getPositionInfo($user);
        $director_pos=Yii::$app->muser->getDirectorPos($pos["id"]);
        if($director_pos->position_code !="MD" && $director_pos->position_code !="DMD")
        {
        $employees[]=$director->user_id;
        $cc=array();
       $remark="imihogo form for approval";
          if($this->isForwarded($employees,$cc,$model1->id,$user,$remark)){
        
         $step_action='Approved';
         $step_status='middlemen';
         $msg="Imihigo form for approval!";
          $remark="Manager approved!";
           
 $q6="SELECT p.id as pos_id ,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".$user."' and pp.status=1";
$command6= Yii::$app->db->createCommand($q6);
$row5 = $command6->queryOne();
          $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
 }
    else{
        
       $responce["message"]="Not Forwarded. Please try again!";
          $responce["flag"]=false;
          return json_encode($responce);
        
    } 
        }
        else{
               $model1=PerformanceContract::find()->where(['id'=>$pc])->one();
              $model1->final_status=1;
              $done= $model1->save(false);   
         $step_action='Approved';
         $step_status='Final Approved';
         $msg="Imihigo form for approval!";
          $remark="Manager approved!";
           
 $q6="SELECT p.id as pos_id ,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".$user."' and pp.status=1";
$command6= Yii::$app->db->createCommand($q6);
$row5 = $command6->queryOne();
          $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
        }
         Yii::$app->session->setFlash('success',$msg);
            $responce["message"]="Forwarded for Approval";
          $responce["flag"]=true;
          
          
          $done=  Yii::$app->db4->createCommand()
                      ->update('pc_approval_flow', ['status' =>'done'], ['approver'=>$user,'request'=>$model1->id])
                      ->execute(); 
          return json_encode($responce);
       
       
   
}
else
{
          $responce["message"]="Please Sign before submittion.";
          $responce["flag"]=false;
          return json_encode($responce);
} 
      
    }
    
    
         public function actionDirectorApproval($pc,$user)
    {
        
$director=Yii::$app->muser->getDirector($user);
         $q88="select count(*) as signe from pc_annotations where author=".$user." and 	type='Stamp' ";
       $command88= Yii::$app->db4->createCommand($q88);
       $count = $command88->queryOne();
       if($count['signe']!=0)
       {
              $model1=PerformanceContract::find()->where(['id'=>$pc])->one();
              $model1->status='Director approved';
              $model1->final_status=1;
              $done= $model1->save(false);
         $step_action='Approved';
         $step_status='Final Approved';
         $msg="Imihigo form for approval!";
          $remark="Director approved!";
           
 $q6="SELECT p.id as pos_id ,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".$user."' and pp.status=1";
$command6= Yii::$app->db->createCommand($q6);
$row5 = $command6->queryOne();
          $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
        Yii::$app->session->setFlash('success',$msg);

            $responce["message"]="Aproved and forward for next approval";
          $responce["flag"]=true;
          
           $done=  Yii::$app->db4->createCommand()
                      ->update('pc_approval_flow', ['status' =>'done'], ['approver'=>$user,'request'=>$model1->id])
                      ->execute(); 
          return json_encode($responce);
}
else
{
          $responce["message"]="Please Sign before submittion.";
          $responce["flag"]=false;
          return json_encode($responce);
} 
      
    }
           public function actionDmdApproval($pc,$user)
    {
        
         $q88="select count(*) as signe from pc_annotations where author=".$user." and 	type='Stamp' ";
       $command88= Yii::$app->db4->createCommand($q88);
       $count = $command88->queryOne();
       if($count['signe']!=0)
       {
              $model1=PerformanceContract::find()->where(['id'=>$pc])->one();
              $model1->status='DMD approved';
              $model1->final_status=1;
              $done= $model1->save(false);
        

         $step_action='Approved';
         $step_status='Final Approved';
          $remark="DMD approved!";
           
 $q6="SELECT p.id as pos_id ,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".$user."' and pp.status=1";
$command6= Yii::$app->db->createCommand($q6);
$row5 = $command6->queryOne();
          $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
        Yii::$app->session->setFlash('success',$msg);

            $responce["message"]="Aproved and forward for next approval";
          $responce["flag"]=true;
           $done=  Yii::$app->db4->createCommand()
                      ->update('pc_approval_flow', ['status' =>'done'], ['approver'=>$user,'request'=>$model1->id])
                      ->execute(); 
          return json_encode($responce);
       
}
else
{
          $responce["message"]="Please Sign before submittion.";
          $responce["flag"]=false;
          return json_encode($responce);
} 
      
    }
    
              public function actionMdApproval($pc,$user)
    {
         $q88="select count(*) as signe from pc_annotations where author=".$user." and 	type='Stamp' ";
       $command88= Yii::$app->db4->createCommand($q88);
       $count = $command88->queryOne();
       if($count['signe']!=0)
       {
              $model1=PerformanceContract::find()->where(['id'=>$pc])->one();
              $model1->status='MD approved';
              $model1->final_status=1;
              $done= $model1->save(false);
         $step_action='Approved';
         $step_status='Final Approved';
          $remark="MD approved!";
           
 $q6="SELECT p.id as pos_id ,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".$user."' and pp.status=1";
$command6= Yii::$app->db->createCommand($q6);
$row5 = $command6->queryOne();
          $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
        Yii::$app->session->setFlash('success',$msg);

            $responce["message"]="Form approved";
          $responce["flag"]=true;
           $done=  Yii::$app->db4->createCommand()
                      ->update('pc_approval_flow', ['status' =>'done'], ['approver'=>$user,'request'=>$model1->id])
                      ->execute(); 
          return json_encode($responce);
     
}
else
{
          $responce["message"]="Please Sign before submittion.";
          $responce["flag"]=false;
          return json_encode($responce);
} 
      
    }
     

    
      public function actionSendBack($pc,$user,$reason,$next)
    {
              $q88="select count(*) as signe from pc_annotations where author=".$user." and 	type='Stamp' ";
       $command88= Yii::$app->db4->createCommand($q88);
       $count = $command88->queryOne();
       if($count['signe']!=0)
       {
           $msgmodel= new PcAppMsg;
          $msgmodel->pc_id=$pc;
          $msgmodel->emp_id=$user;
          $msgmodel->msg=$reason;
           $msgmodel->save(false);
           
              $model1=PerformanceContract::find()->where(['id'=>$pc])->one();
              $model1->status='submitted';
              $done= $model1->save(false);
        
        $employees[]=$next;
        $cc=array();
        $remark="Imihigo form for approval!";
          if($this->isForwarded($employees,$cc,$model1->id,$user,$remark)){
        
         $step_action='forwarded';
         $step_status='middlemen';
         $msg="Imihigo form for approval!";
          
 $q6="SELECT p.id as pos_id ,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".$user."' and pp.status=1";
$command6= Yii::$app->db->createCommand($q6);
$row5 = $command6->queryOne();

          $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
        Yii::$app->session->setFlash('success',$msg);

            $responce["message"]="Forwarded for Approval";
          $responce["flag"]=true;
          return json_encode($responce);
        
    }
    else{
        
       $responce["message"]="Not Forwarded. Please try again!";
          $responce["flag"]=false;
          return json_encode($responce);
        
    }
}
else
{
          $responce["message"]="Please Sign before submittion.";
          $responce["flag"]=false;
          return json_encode($responce);
} 
            
                    
      
    }
    
    public function actionReturn($pc,$user,$reason)
    {
          $status='returned';
          $msgmodel= new PcAppMsg;
          $msgmodel->pc_id=$pc;
          $msgmodel->emp_id=$user;
          $msgmodel->msg=$reason;
           $msgmodel->save(false);
         
         
       
      $q88="delete from pc_annotations where doc=".$pc." and 	type='Stamp' ";
       $command88= Yii::$app->db4->createCommand($q88);
       $delete_sign = $command88->execute();
      $updateStatus=  Yii::$app->db4->createCommand()
                      ->update('pc_approval_flow', ['status' =>'returned'], ['approver'=>$user,'request'=>$pc,'status' =>'pending'])
                      ->execute(); 
      $model1=PerformanceContract::find()->where(['id'=>$pc])->one();
              $model1->status='returned';
             $done = $model1->save(false);          
      $flag=$this->sendNotification($user,$model1->emp_id,$reason,$status) ;                      
        return $done;
    }
   
  
   //--------------------log fucntion---------------------------------------
 
 public function ApprovalActionLog($id,$user,$pos,$step_action,$step_status,$remark){
 
    
    $approval=new PcApproval();
    $approval->request=$id;
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
     
     
    $pcModel=new PcApprovalFlow();
    $pcModel->request=$id;
    $pcModel->approver=$employee;
    $pcModel->originator=$user;
    $pcModel->remark =$remark;
    
   if(!empty($row8)){
        
        $pcModel->is_copy =1; 
    }
   
    if(!$forwarded=$pcModel->save(false)){
      
    
      break; 
      
      return false;
        
    }
   
 // $flag1=$this->sendEmail($user,$employee,$id);

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
    
   
    $pcModel=new PcApprovalFlow();
    $pcModel->request=$id;
    $pcModel->approver=$row7['user_id'];
    $pcModel->originator=$user;
    $pcModel->remark =$remark;
    $pcModel->is_copy =1; 
    
      if($pcModel->save(false)){
      // $flag=$this->sendEmail($user,$row7['user_id'],$id) ;
        
    }
   
  
    
}                                                 
  
     
    


  
   
    
    
 }
 
     } 
     
     return $forwarded;
     
 }
 
 public function sendEmail($from,$to,$request){
     
     
    
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
           
                                              $model1=PerformanceContract::find()->where(['id'=>$request])->one();
           
                                               $user3=User::find()->where(['user_id'=>$model1->emp_id])->One();
                                            
                                            $employee=$user3->first_name." ".$user3->last_name;
                                           $year=$model1->financial_year;
                                            
                                           
                                               
                                                   
                                                $flag1= Yii::$app->mailer->compose( ['html' =>'imihigoNotification-html'],
    [
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>'Imihigo form ','date'=>date("Y-m-d H:i:s"),'remark'=>$remark,'employee'=>$employee,'year'=>$year
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$to])
->setSubject('ERP Notification')
//->setTextBody('You Can Change Login Password After Sign in')
->send();


                                            
    
   return $flag1;
     
     
 }

 public function sendNotification($from,$to,$reason,$status){
     
     
    
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
                                   $model1=PerformanceContract::find()->where(['id'=>$request])->one();
           
                                               $user3=User::find()->where(['user_id'=>$model1->emp_id])->One();
                                            
                                            $employee=$user3->first_name." ".$user3->last_name;
                                            $year=$model1->financial_year;
                                            
                                           
                                               
                                                   
                                                $flag1= Yii::$app->mailer->compose( ['html' =>'imihigoNotification-html'],
    [
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>'Imihigo form ','date'=>date("Y-m-d H:i:s"),'reason'=>$reason,'employee'=>$employee,'year'=>$year
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$to])
->setSubject('Leave Request '.$status)
//->setTextBody('You Can Change Login Password After Sign in')
->send();


                                            
    
   return $flag1;
     
     
 }

}
