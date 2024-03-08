<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpLpoRequestApproval;
use common\models\ErpLpoRequest;
use common\models\Erpdoc;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ErpLpoRequestApprovalFlow;
use common\models\ErpdocApproval;
use common\models\User;
use common\models\ErpTransmissionSlip;
use common\models\ErpTransmissionSlipComments;

date_default_timezone_set('Africa/Cairo'); 

/**
 * ErpLpoRequestApprovalController implements the CRUD actions for ErpLpoRequestApproval model.
 */
class ErpLpoRequestApprovalController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function actionTest(){
        
        $currentStep=ErpLpoRequestApprovalFlow::find()->where(['approver'=>49,'lpo_request'=>943])->orderBy(['timestamp' => SORT_DESC])->One();
        var_dump($currentStep->id);
    }

    /**
     * Lists all ErpLpoRequestApproval models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ErpLpoRequestApproval::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpLpoRequestApproval model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
       //--------------------------------===================apprvode==========----------------------------------------------------------
    public function actionWorkFlow(){
   
    $model = new ErpLpoRequestApproval();
    $lpo_request_id=Yii::$app->request->get('lpo_request');
    $lpo_request=ErpLpoRequest::findOne($lpo_request_id);
    
    
   
    if(!empty($_POST['ErpLpoRequestApproval'])){
     
     $data=$_POST['ErpLpoRequestApproval'];
     $employees=array();
   
    
     $action=$data['action'];
     $remark=$data['remark'];
     if(isset($data['employee']) && is_array($data['employee'])){
      $employees=array_merge($employees,$data['employee']);   
     }else{
       $employees[]=$data['employee'];   
     }
    
     $cc=$data['employee_cc'];
     $lpo_request=$data['lpo_request'];
     $user=Yii::$app->user->identity->user_id;
    
     
     
 $model1=ErpLpoRequest::find()->where(['id'=>$lpo_request])->one();
 $model2=ErpTransmissionSlip::find()->where(['type'=>'LPO','type_id'=>$model1->id])->one() ; 
 $previousStep=ErpLpoRequestApprovalFlow::find()->where(['approver'=>$user,'lpo_request'=>$model1->id])->orderBy(['timestamp' => SORT_DESC])->One();


 $msg='';
 
    
   
   
   
 
 
 //-------------------------------------------------work flow approvals-----------------------------------------------
     if($action=='approve'){
     
      //--  ----------------------final approval by DAF--------------------------------------->                
 $q7=" SELECT u.user_id FROM  user as u  inner join   erp_persons_in_position as pp on u.user_id=pp.person_id 
 inner join erp_org_positions as p  on p.id=pp.position_id
  where  p.position='Director Finance Unit' ";
  $command7= Yii::$app->db->createCommand($q7);
  $row7 = $command7->queryOne();
 
  
   $approvalDate = date('Y-m-d');
  $approvalDate=date('Y-m-d', strtotime($approvalDate));
  
  //----------------------------check if interim for------------------------------------------>
/*$q8="SELECT * from erp_person_interim where  person_in_interim='".$user."' and person_interim_for='".$row7['user_id']."' 
and date_from <= '$approvalDate' and date_to >= '$approvalDate'";
$command8= Yii::$app->db->createCommand($q8);*/

$row8 =Yii::$app->muser->getInterim($user,$row7['user_id'],$approvalDate);


if($row7['user_id']==$user || $row8!=null  ){
    
   $model1->status='approved';
   
   if($approved=$model1->save(false)){
      $step_action='approved';
      $step_status='final'; 
      $msg="Lpo Request Approved";
      
   }else{
       
      throw new \yii\web\HttpException(451,
          'LPO Request could not be approved
              (please try again).');   
       
         }
  
   }
   else{
      $step_action='approved';
      $step_status='middlemen';
      $msg='Your Approval Saved';   
     }
     
     
  
  if(isset($step_action)){
      
       if(isset($remark)){
       
     $model3=new ErpTransmissionSlipComments();  
     $model3->trans_slip=$model2->id;
     $model3->author=$user;
     $model3->comment=$remark;
     $model3->save(false);
       
   }
     
     $this->ApprovalActionLog($model1->id,$user,$step_action,$step_status,$remark);
      
  }
  
   
 
if(!empty($employees)){
        
        $forwarded=$this->isForwarded($employees,$cc,$model1->id,$user,$remark);
        if($forwarded){
        
            if($approved){
               $msg.=' And  forwarded!';   
            }else{
                 $msg.=' And LPO forwarded!';  
            }
         
       }else{
           
          if($approved){
               $msg.=' but could not be forwarded!';   
            }else{
                 $msg.=' but LPO could not be forwarded!';  
            }
       }
       
       }

  
     }
               
    if($action=='cforward'){
 
          //--  ----------------------final approval by DAF--------------------------------------->                
 $q7=" SELECT u.user_id FROM  user as u  inner join   erp_persons_in_position as pp on u.user_id=pp.person_id 
 inner join erp_org_positions as p  on p.id=pp.position_id
  where  p.position='Director Finance Unit' ";
  $command7= Yii::$app->db->createCommand($q7);
  $row7 = $command7->queryOne();
 
  
   $approvalDate = date('Y-m-d');
  $approvalDate=date('Y-m-d', strtotime($approvalDate));
  //----------------------------check if interim for------------------------------------------>
$q8="SELECT * from erp_person_interim where  person_in_interim='".$user."' and person_interim_for='".$row7['user_id']."' 
and date_from <= '$approvalDate' and date_to >= '$approvalDate'";
$command8= Yii::$app->db->createCommand($q8);
$row8 = $command8->queryOne();


if($row7['user_id']==$user || !empty($row8)  ){
    
   $model1->status='approved';
   
   if($approved=$model1->save(false)){
      $step_action='approved';
      $step_status='final'; 
      $msg="Lpo Request Approved";
      
   }else{
       
      throw new \yii\web\HttpException(451,
          'LPO Request could not be approved
              (please try again).');   
       
         }
  
   }
    
    
    
     if(isset($remark) && $model1->requested_by!=$user){
       
     $model3=new ErpTransmissionSlipComments();  
     $model3->trans_slip=$model2->id;
     $model3->author=$user;
     $model3->comment=$remark;
     $model3->save(false);
       
   }
    
    if($this->isForwarded($employees,$cc,$model1->id,$user,$remark)){
        
        $step_action='forwarded';
        $step_status='middlemen';
       
        if($approved){
          $msg="LPO Request Approved And Forwarded!";   
        }else{
           $msg="LPO Request Forwarded !"; 
        }
        
        Yii::$app->session->setFlash('success',$msg);
       
       $this->ApprovalActionLog($model1->id,$user,$step_action,$step_status,$remark);
        
     
       
     
     if($model1->status=='drafting'){
           
           $model1->status='processing';
           $model1->save(false);
           return $this->redirect(['erp-lpo-request/drafts']); 
       }
       
       if($model1->status=='Returned'){
           
           $model1->status='processing';
           $model1->save(false);
      
      
          } 
       
         
    }else{
        
      throw new \yii\web\HttpException(451,
          'The LPO Request could not be forwarded
              (please try again).'); 
        
    }
 
      }
    
 if($action=='rfa'){
        
       
       if( $model1->status!="approved")
       {
                      $model1->status='Returned';
                      $model1->save(false);
       }
    if($this->isForwarded($employees,$cc,$model1->id,$user,$remark)){
     
     $step_action='returned';
     $step_status='middlemen';
     $msg='LPO Request sent back Successfully...';   
     $this->ApprovalActionLog($model1->id,$user,$step_action,$step_status,$remark);  
       
         //-------------------all done------------------------------------------------------------
  
   Yii::$app->session->setFlash('success',$msg);
   $done=  Yii::$app->db->createCommand()
                      ->update('erp_lpo_request_approval_flow', ['status' =>'returned'], ['approver'=>$user,'lpo_request'=>$model1->id])
                      ->execute(); 
   
   return $this->redirect(['erp-lpo-request/pending-requests']);  
           
      
      
       }else{
        
      throw new \yii\web\HttpException(451,
          'The LPO request could not be sent back
              (please try again).'); 
        
    } 
        
        
        
     }
     
     

 //---------------------all went well--------------------------------------------
 
  Yii::$app->session->setFlash('success',$msg);
  
  if($previousStep!=null){
      
    $done=  Yii::$app->db->createCommand()
                      ->update('erp_lpo_request_approval_flow', ['status' =>'done'], ['id'=>$previousStep->id])
                      ->execute();   
  }
   
   
   return $this->redirect(['erp-lpo-request/pending-requests']); 
   
}

     if(Yii::$app->request->isAjax){
         
      return $this->renderAjax('approval-work-flow',[ 'model' =>$model,'lpo_request'=>$lpo_request]); 
         
     }
    return $this->render('approval-work-flow',[ 'model' =>$model,'lpo_request'=>$lpo_request]);

   }
   
   //--------------------log fucntion---------------------------------------
 
 public function ApprovalActionLog($id,$user,$step_action,$step_status,$remark){
 
    $approval=new ErpLpoRequestApproval();
    $approval->lpo_request=$id;
    $approval->approved_by=$user;
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
     
    $recipientModel=new ErpLpoRequestApprovalFlow();
    $recipientModel->lpo_request=$id;
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
   
    $q6="SELECT p.id as position_id FROM user as u 
     inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
     inner join erp_org_positions as p on p.id=pp.position_id where u.user_id={$employee} and pp.status<>0";
     $command6= Yii::$app->db->createCommand($q6);
     $row6 = $command6->queryOne();
    
$q7=" SELECT u.user_id FROM erp_org_positions as p 
inner join erp_org_positions as p1 on p1.id=p.report_to 
inner join erp_persons_in_position as pp on pp.position_id=p.id inner join user as u on u.user_id=pp.person_id 
inner join erp_units_positions as up on up.position_id=p.id where p.report_to={$row6['position_id']} and up.position_level='pa' and pp.status<>0";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();

if(!empty($row7)){
    
    $recipientModel=new ErpLpoRequestApprovalFlow();
    $recipientModel->lpo_request=$id;
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
 
   public function sendEmail($from,$to,$req_id){
     
     
    
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
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>'LPO Request','date'=>date("Y-m-d H:i:s"),'remark'=>$remark
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$to])
->setSubject('ERP Notification')
//->setTextBody('You Can Change Login Password After Sign in')
->send();


                                            
    
   return $flag1;
     
     
 }
   //-------------------------------------------redirect Approval-------------------------------------------------------//
 
  public function actionReassign(){
      
      
      
      $model=new   ErpLpoRequestApproval();
      //-----------------create approval request
      $flowModel=new  ErpLpoRequestApprovalFlow();
      
       if(Yii::$app->request->post()){
        
      
     
        $data=$_POST['ErpLpoRequestApproval'];
      
        
        if(!isset($data['lpo_request'])){
        Yii::$app->session->setFlash('error',"Invalid doc ID");   
        return $this->redirect(['erp-lpo-request/index']);
       
        }
        
        if(!isset($data['redirect_flow_id'])){
         Yii::$app->session->setFlash('error',"Invalid approval flow ID");    
        return $this->redirect(['erp-lpo-request/doc-tracking','id'=>$data['lpo_request']]);
          }
         
        
       $f=ErpLpoRequestApprovalFlow::find()->where(['id'=>$data['redirect_flow_id']])->One();
       
       if($f==null){
          Yii::$app->session->setFlash('error',"Invalid approval flow ID"); 
         return $this->redirect(['erp-lpo-request/doc-tracking','id'=>$data['lpo_request']]);   
           
       }
       
     //-----------check if assigned employee is in interim- of the original approver---------------------------  
  $approvalDate = date('Y-m-d');
  $approvalDate=date('Y-m-d', strtotime($approvalDate));
  $interim=Yii::$app->muser->getInterim($data['employee'],$f['approver'],$approvalDate); 
 /* if($interim =null){
    Yii::$app->session->setFlash('error',"The assigned User is not in Interm !");    
    return $this->redirect(['erp-lpo-request/doc-tracking','id'=>$data['lpo_request']]);     
     } */
      
      
    
           
    $flowModel=new ErpLpoRequestApprovalFlow();
    $flowModel->setAttributes($f->attributes);
    $flowModel->approver=$data['employee'];
    $flowModel->timestamp=date("Y-m-d H:i:s");
    
    if(!$flowModel->save()){
        
        Yii::$app->session->setFlash('error',Html::errorSummary($flowModel));
        return $this->redirect(['erp-lpo-request/doc-tracking','id'=>$f->lpo_request]); 
    }
        $f->status='reassigned';
        $f->save(false);
        
        Yii::$app->session->setFlash('success',"doc Reassigned successfully !");
        return $this->redirect(['erp-lpo-request/doc-tracking','id'=>$data['lpo_request']]); 
           
       }
      
   if(Yii::$app->request->isAjax){
         
      return $this->renderAjax('redirect-work-flow',[ 'model' =>$model,'f_id'=>$_GET['f_id'],'id'=>$_GET['lpo_request']]); 
         
     }else{
         
        return $this->render('redirect-work-flow',[ 'model' =>$model,'f_id'=>$_GET['f_id'],'id'=>$_GET['lpo_request']]);   
     }   
      
  }

    /**
     * Creates a new ErpLpoRequestApproval model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpLpoRequestApproval();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ErpLpoRequestApproval model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ErpLpoRequestApproval model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ErpLpoRequestApproval model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpLpoRequestApproval the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpLpoRequestApproval::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
