<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpRequisitionApproval;
use common\models\ErpRequisition;
use common\models\ErpMemo;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ErpRequisitionApprovalFlow;
use common\models\ErpMemoApproval;
use common\models\User;
use common\models\ErpMemoApprovalSettings;
/**
 * ErpRequisitionApprovalController implements the CRUD actions for ErpRequisitionApproval model.
 */
class ErpRequisitionApprovalController extends Controller
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
    
    
  

    /**
     * Lists all ErpRequisitionApproval models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ErpRequisitionApproval::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpRequisitionApproval model.
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
   
    $model = new ErpRequisitionApproval();
   
    if(isset($_POST['ErpRequisitionApproval'])){
     
     $data=$_POST['ErpRequisitionApproval'];
     $employees=array();
   
    
     $action=$data['action'];
     $remark=$data['remark'];
     if(isset($data['employee']) && is_array($data['employee'])){
         
         $employees=array_merge($employees,$data['employee']);
     }else{
         
      $employees[]=$data['employee'];   
     }
     
     $requisition_id=$data['requisition_id'];
     $user=Yii::$app->user->identity->user_id;
     
     
 $model1=ErpRequisition::find()->where(['id'=>$requisition_id])->one();
 $model2=ErpMemo::find()->where(['id'=>$model1->reference_memo])->one();
 $msg='';
 

     if($action=='approve'){
 
//--  ----------------------final approval by MD--------------------------------------->                
 $q7=" SELECT u.user_id FROM  user as u  inner join   erp_persons_in_position as pp on u.user_id=pp.person_id 
 inner join erp_org_positions as p  on p.id=pp.position_id
  where  p.position='Managing Director' and pp.status=1 ";
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
    
   $model1->approve_status='approved';
   
   if($approved=$model1->save(false)){
      $step_action='approved';
      $step_status='final'; 
      $msg="Requisition Approved";
      $this->ApprovalActionLog($model1->id,$user,$step_action,$step_status,$remark);
      
   }else{
       
      throw new \yii\web\HttpException(451,
          'Requisition could not be approved
              (please try again).');   
       
         }
  
   }
   else{
      $step_action='approved';
      $step_status='middlemen';
      $msg='Your Approval Saved';   
      $this->ApprovalActionLog($model1->id,$user,$step_action,$step_status,$remark);
         
      $final_approver_settings=ErpMemoApprovalSettings::find()->where(['memo_id'=>$model2->id])->One(); 
      $final_app=$final_approver_settings->final_approver;
      
      
      if($user==$final_app && $model2->status=='processing'){
        
        $model2->status='approved';
        $model2->save(false);
      
       }
       
   }
  
  
 
if(!empty($employees)){
        
        $forwarded=$this->isForwarded($employees,$cc,$model1->id,$user,$remark);
        if($forwarded){
        
            if($approved){
               $msg.=' And  forwarded!';   
            }else{
                 $msg.=' And Requisition forwarded!';  
            }
         
       }else{
           
          if($approved){
               $msg.=' but could not be forwarded!';   
            }else{
                 $msg.=' but Requisition could not be forwarded!';  
            }
       }
       
       }

//--------------------------------other approvals-----------------------------------------------------------------------
  
     }
               
    if($action=='cforward'){
       
 if($this->isForwarded($employees,$cc,$model1->id,$user,$remark)){
       
               $step_action='forwarded';
              
               $step_status='middlemen'; 
        
              $this->ApprovalActionLog($model1->id,$user,$step_action,$step_status,$remark);    
        
              $msg="Requisition  Forwarded for further processing..."; 
        
              Yii::$app->session->setFlash('success',$msg);
    
     if($model1->approve_status=='drafting'){
           
           $model1->approve_status='processing';
           $model1->save(false);
           
           return $this->redirect(['erp-requisition/drafts']); 
       }
       
       if($model1->approve_status=='Returned'){
           
           $model1->approve_status='processing';
           $model1->save(false);
      
      
          } 
       
       
       
         
    }else{
        
      throw new \yii\web\HttpException(451,
          'The Requisition  could not be forwarded
              (please try again).'); 
        
    }
      }
    
 if($action=='rfa'){
        
    
        
                      if($model1->approve_status!='approved'){
                       
                       $model1->approve_status='Returned';
                       $model1->save(false);   
                      }
                      
     
    if($this->isForwarded($employees,$cc,$model1->id,$user,$remark)){
     
     $step_action='returned';
     $step_status='middlemen';
     $msg='Requisition sent back Successfully...';   
     $this->ApprovalActionLog($model1->id,$user,$step_action,$step_status,$remark);  
       
         //-------------------all done------------------------------------------------------------
  
   Yii::$app->session->setFlash('success',$msg);
   $done=  Yii::$app->db->createCommand()
                      ->update('erp_requisition_approval_flow', ['status' =>'returned'], ['approver'=>$user,'pr_id'=>$model1->id])
                      ->execute(); 
   
   return $this->redirect(['erp-requisition/pending']);  
           
      
      
       }else{
        
      throw new \yii\web\HttpException(451,
          'The Requisition   could not be sent back
              (please try again).'); 
        
    }
    
    
    
    
    
     }
     
     
     
 
  
   Yii::$app->session->setFlash('success',$msg);
   $done=  Yii::$app->db->createCommand()
                      ->update('erp_requisition_approval_flow', ['status' =>'done'], ['approver'=>$user,'pr_id'=>$model1->id])
                      ->execute(); 
   return $this->redirect(['erp-requisition/pending']); 
   
}

     if(Yii::$app->request->isAjax){
         
      return $this->renderAjax('approval-work-flow',[ 'model' =>$model,'requisition_id'=>$_GET['pr_id']]); 
         
     }
    return $this->render('approval-work-flow',[ 'model' =>$model,'requisition_id'=>$_GET['pr_id']]);

   }
   
   //--------------------------------approval action log---------------------------------------- 
    public function ApprovalActionLog($pr_id,$user,$step_action,$step_status,$remark){
 
 
    $approval=new ErpRequisitionApproval();
    $approval->requisition_id=$pr_id;
    $approval->approved_by=$user;
    $approval->approval_action=$step_action;
    $approval->approval_status=$step_status;
    $approval->remark=$remark;
    $approval_saved=$approval->save(false);
  
       
 }
 public function isForwarded($employees,$cc,$pr_id,$user,$remark){
    
      $forwardDate = date('Y-m-d');
      $forwardDate=date('Y-m-d', strtotime($forwardDate));
    
     if(!empty($employees)){
 foreach($employees as $key=>$employee){
   
  //-----------check if person is out---------------------------------------------  
     $q8="SELECT * from erp_person_interim where  person_interim_for='".$employee."' 
      and date_from <= '$forwardDate' and date_to >= '$forwardDate'";
     $command8= Yii::$app->db->createCommand($q8);
     $row8 = $command8->queryOne(); 
    
    
    
    $flowModel=new ErpRequisitionApprovalFlow();
    $flowModel->pr_id=$pr_id;
    $flowModel->approver=$employee;
    $flowModel->originator=$user;
    $flowModel->remark =$remark;
    $forwarded=$flowModel->save(false);
    
    if(!empty($row8)){
        
       $flowModel->is_copy =1; 
       $forwarded=$flowModel->save(false);
    }
   
    if(!$forwarded){
      
    
      break; 
      
      return false;
        
    }
   
   $flag1=$this->sendEmail($user,$employee,$pr_id);

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

if(!empty($row7) && $row7['user_id']!=$user){
    
   
    
    $flowModel=new ErpRequisitionApprovalFlow();
    $flowModel->pr_id=$pr_id;
    $flowModel->approver=$row7['user_id'];
    $flowModel->originator=$user;
    $flowModel->remark =$remark;
    $flowModel->is_copy =1; 
    
      if($flowModel->save(false)){
       $flag=$this->sendEmail($user,$row7['user_id'],$pr_id) ;
        
    }
   
  
    
}            

                                            
    
   
    
    
 }
 
     } 
     
     return $forwarded;
     
 }
 
 public function sendEmail($from,$to,$pr){
     
     
    
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
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>'Requisition','date'=>date("Y-m-d H:i:s"),'remark'=>$remark
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$to])
->setSubject('ERP Notification')
//->setTextBody('You Can Change Login Password After Sign in')
->send();


                                            
    
   return $flag1;
     
     
 }
   

    /**
     * Creates a new ErpRequisitionApproval model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpRequisitionApproval();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ErpRequisitionApproval model.
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
     * Deletes an existing ErpRequisitionApproval model.
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
     * Finds the ErpRequisitionApproval model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpRequisitionApproval the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpRequisitionApproval::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
