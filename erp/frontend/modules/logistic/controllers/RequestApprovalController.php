<?php
namespace frontend\modules\logistic\controllers;

use Yii;
use common\models\RequestApprovalFlow;
use common\models\RequestApproval;
use common\models\RequestToStock;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;

date_default_timezone_set('Africa/Cairo');
/**
 * RequestApprovalFlowController implements the CRUD actions for RequestApprovalFlow model.
 */
class RequestApprovalController extends Controller
{
    /**
     * {@inheritdoc}
     */
     public function actionWorkFlow(){
   
    $model = new RequestApproval();
   
    if(isset($_POST['RequestApproval'])){
     
     $data=$_POST['RequestApproval'];
   
     $action=$data['approval_action'];
     $remark=$data['remark'];
     $employees[]=$data['employee'];
     $cc=$data['employee_cc'];
     $request=$data['request'];
     $user=Yii::$app->user->identity->user_id;
    
     
    $model1=RequestToStock::find()->where(['reqtostock_id'=>$request])->one();

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
  where  p.position_code='DAF' ";
  $command7= Yii::$app->db->createCommand($q7);
  $row7 = $command7->queryOne();
  
  
  //----------------------------check if interim for------------------------------------------>

   $approvalDate = date('Y-m-d');
  $approvalDate=date('Y-m-d', strtotime($approvalDate));
  //----------------------------check if interim for------------------------------------------>
/*$q8="SELECT * from erp_person_interim where  person_in_interim='".$user."' and person_interim_for='".$row7['user_id']."' 
and date_from <= '$approvalDate' and date_to >= '$approvalDate'";
$command8= Yii::$app->db->createCommand($q8);*/

$row8 = Yii::$app->muser->getInterim($user,$row7['user_id'],$approvalDate);
      
   
   if($row7['user_id']==$user  || $row8 != null ){
    
   $model1->status='approved';
   
   if($approved=$model1->save(false)){
       $q88="update  items_request  set status='approved' where request_id=".$model1->reqtostock_id."";
       $command88= Yii::$app->db1->createCommand($q88);
       $row88 = $command88->execute();
      $step_action='approved';
      $step_status='final'; 
      $msg="voucher Approved";
   }else{
       
      throw new \yii\web\HttpException(451,
          'voucher could not be approved
              (please try again).');   
       
         }
  
   }
   else{
      $model1->status='approved';
   
   if($approved=$model1->save(false)){
       $q88="update  items_request  set status='approved' where request_id=".$model1->reqtostock_id."";
       $command88= Yii::$app->db1->createCommand($q88);
       $row88 = $command88->execute();
      $step_action='approved';
      $step_status='final'; 
      $msg="voucher Approved";
   }else{
       
      throw new \yii\web\HttpException(451,
          'voucher could not be approved
              (please try again).');   
       
         }
     
     }
  
  if($this->isForwarded($employees,$cc,$model1->reqtostock_id,$user,$remark)){
     $this->ApprovalActionLog($model1->reqtostock_id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
     
      $done=  Yii::$app->db1->createCommand()
                      ->update('request_approval_flow', ['status' =>'done'], ['approver'=>$user,'request'=>$model1->reqtostock_id])
                      ->execute(); 
      return $this->redirect(['request-to-stock/draft']); 
  }
      
       
       }


               
    if($action=='cforward'){
  
    
    if($this->isForwarded($employees,$cc,$model1->reqtostock_id,$user,$remark)){
        
         $step_action='forwarded';
         $step_status='middlemen';
         $msg="voucher Forwarded !";
          $this->ApprovalActionLog($model1->reqtostock_id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
        Yii::$app->session->setFlash('success',$msg);
           $model1->save(false);
        if(($model1->status=='Returned'|| $model1->status=='processing')&& $model1->status != 'approved'){
           
           $model1->status='processing';
           $model1->save(false);
           
          $done=  Yii::$app->db1->createCommand()
                      ->update('request_approval_flow', ['status' =>'done'], ['approver'=>$user,'request'=>$model1->reqtostock_id])
                      ->execute();   
           
      return $this->redirect(['request-to-stock/pending']); 
          }
          else if($model1->status=='drafting' ){
                $model1->status='processing';
           $model1->save(false);
           
                 $done=  Yii::$app->db1->createCommand()
                      ->update('request_approval_flow', ['status' =>'done'], ['approver'=>$user,'request'=>$model1->reqtostock_id])
                      ->execute(); 
                 return $this->redirect(['request-to-stock/draft']);
          }
           else{
                 $done=  Yii::$app->db1->createCommand()
                      ->update('request_approval_flow', ['status' =>'done'], ['approver'=>$user,'request'=>$model1->reqtostock_id])
                      ->execute(); 
                 return $this->redirect(['request-to-stock/draft']);
          }
    }else{
        
      throw new \yii\web\HttpException(451,
          'The voucher  could not be forwarded
              (please try again).'); 
        
    }
 
      }
    
 if($action=='rfa'){
       
                      
                      if($model1->status!= 'approved'){
                           $model1->status='Returned';
                           $model1->save(false);
                      }
                      
       
                      
     
    if($this->isForwarded($employees,$cc,$model1->reqtostock_id,$user,$remark)){
     
     $step_action='returned';
     $step_status='middlemen';
     $msg='voucher sent back Successfully...';   
        $this->ApprovalActionLog($model1->reqtostock_id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
        
        Yii::$app->session->setFlash('success',$msg);
        
   $done=Yii::$app->db1->createCommand()
                      ->update('request_approval_flow', ['status' =>'returned'], ['approver'=>$user,'request'=>$model1->reqtostock_id])
                      ->execute(); 
                $done=  Yii::$app->db1->createCommand()
                      ->update('request_approval_flow', ['status' =>'done'], ['approver'=>$user,'request'=>$model1->reqtostock_id])
                      ->execute();        
         return $this->redirect(['request-to-stock/pending']);
       }else{
        
      throw new \yii\web\HttpException(451,
          'The voucher could not be sent back
              (please try again).'); 
        
    }
    
    
    
    
    
     }
     
     
if($action=='close'){
        $model1->status='closed';
       $closed= $model1->save(false);
       if($closed){
           $this->ApprovalActionLog($model->id,$user,$row5['pos_id'],"closded",$remark);
           $msg="voucher  Closed";
       }else{
          throw new \yii\web\HttpException(451,
          'The voucher could not be Closed
              (please try again).');  
           
       }
     }
 
 //---------------------all went well--------------------------------------------
 
  Yii::$app->session->setFlash('success',$msg);
  
  
  
   
   $done=  Yii::$app->db1->createCommand()
                      ->update('request_approval_flow', ['status' =>'done'], ['approver'=>$user,'request'=>$model1->reqtostock_id])
                      ->execute(); 
   return $this->redirect(['request-to-stock/pending']); 
   
}

     if(Yii::$app->request->isAjax){
         
      return $this->renderAjax('work-flow',[ 'model' =>$model,'request'=>$_GET['request']]); 
         
     }
    return $this->render('work-flow',[ 'model' =>$model,'request'=>$_GET['request']]);

   }
   
   
   
   //--------------------log fucntion---------------------------------------
 
 public function ApprovalActionLog($id,$user,$pos,$step_action,$step_status,$remark){
 
    
    $approval=new RequestApproval();
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
      and date_from <= '$forwardDate' and date_to >= '$forwardDate' and status='active' ";
     $command8= Yii::$app->db->createCommand($q8);
     $row8 = $command8->queryOne(); 
     
     
    $recipientModel=new RequestApprovalFlow();
    $recipientModel->request=$id;
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
    
   
    $recipientModel=new RequestApprovalFlow();
    $recipientModel->request=$id;
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
           
           
                                           
                                            
                                           
                                               
                                                   
                                                $flag1= Yii::$app->mailer->compose( ['html' =>'userNotification-html'],
    [
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>'Stock Voucher','date'=>date("Y-m-d H:i:s"),'remark'=>$remark
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$user2->email])
->setSubject('ERP Notification')
//->setTextBody('You Can Change Login Password After Sign in')
->send();


                                            
    
   return $flag1;
     
     
 }
 
 public function actionRedirect(){
      
      
      
      $model=new   RequestApproval();
      $flowModel=new  RequestApprovalFlow();
      
       if(Yii::$app->request->post()){
        
      
     
        $data=$_POST['RequestApproval'];
      
        
        if(!isset($data['request_id'])){
        Yii::$app->session->setFlash('error',"Invalid Request ID");   
        return $this->redirect(['request-to-stock/index']);
       
        }
        
        if(!isset($data['redirect_flow_id'])){
         Yii::$app->session->setFlash('error',"Invalid approval flow ID");    
        return $this->redirect(['request-to-stock/doc-tracking','id'=>$data['request_id']]);
        }
         
        
       $f=RequestApprovalFlow::find()->where(['id'=>$data['redirect_flow_id']])->One();
       
       if($f==null){
         
         return $this->redirect(['request-to-stock/doc-tracking','id'=>$data['request_id']]);   
           
       }
           
    $flowModel=new RequestApprovalFlow();
    $flowModel->setAttributes($f->attributes);
    $flowModel->approver=$data['employee'];
    $flowModel->timestamp=date("Y-m-d H:i:s");
    
    if(!$flowModel->save()){
        
        Yii::$app->session->setFlash('error',Html::errorSummary($flowModel));
        return $this->redirect(['request-to-stock/doc-tracking','id'=>$data['request_id']]); 
    }
        $f->status='redirected';
        $f->save(false);
        
        Yii::$app->session->setFlash('success',"Request redirected successfully !");
        return $this->redirect(['request-to-stock/doc-tracking','id'=>$data['request_id']]); 
           
       }
      
   if(Yii::$app->request->isAjax){
         
      return $this->renderAjax('redirect-work-flow',[ 'model' =>$model,'f_id'=>$_GET['f_id'],'request_id'=>$_GET['request_id']]); 
         
     }else{
         
        return $this->render('redirect-work-flow',[ 'model' =>$model,'f_id'=>$_GET['f_id'],'request_id'=>$_GET['request_id']]);   
     }   
      
  }
 
}
