<?php
namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpTravelRequestApproval;
use common\models\ErpTravelRequestApprovalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ErpTravelClearance;
use common\models\ErpClaimForm;
use common\models\ErpTravelRequest;
use yii\helpers\Html;
use common\models\ErpTravelRequestRequestForAction;
use common\models\ErpTravelRequestApprovalFlow;
use common\models\User;

/**
 * ErpTravelRequestApprovalController implements the CRUD actions for ErpTravelRequestApproval model.
 */
class ErpTravelRequestApprovalController extends Controller
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
     * Lists all ErpTravelRequestApproval models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpTravelRequestApprovalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpTravelRequestApproval model.
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

    /**
     * Creates a new ErpTravelRequestApproval model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpTravelRequestApproval();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
     //--------------------------------===================apprvode==========----------------------------------------------------------
    public function actionWorkFlow(){
   
    $model = new ErpTravelRequestApproval();
   
    if(isset($_POST['ErpTravelRequestApproval'])){
     
     $data=$_POST['ErpTravelRequestApproval'];
  
    
     $action=$data['action'];
     $remark=$data['remark'];
     $employees=$data['employee'];
     $tr_id=$data['tr_id'];
     $user=Yii::$app->user->identity->user_id;
    
   
 $model1=ErpTravelRequest::find()->where(['id'=>$tr_id])->one();
 $model2=ErpTravelClearance::find()->where(['tr_id'=>$tr_id])->All();
 $model3=ErpClaimForm::find()->where(['tr_id'=>$tr_id])->All();   
     
     if($action=='approve'){
 
//--  ----------------------final approval by MD--------------------------------------->                
 $q7=" SELECT u.user_id FROM  user as u  inner join   erp_persons_in_position as pp on u.user_id=pp.person_id 
 inner join erp_org_positions as p  on p.id=pp.position_id
  where  p.position='Managing Director' ";
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
 
 
 //-----------------------check if final approval--------------------------------------------------------     
     if($row7['user_id']==$user  || $row8 != null ){
    
     $model1->status='approved';
   
   if($approved=$model1->save(false)){
      $step_action='approved';
      $step_status='final'; 
      $msg="Travel Request Approved";
      $this->ApprovalActionLog($model1->id,$user,$step_action,$step_status,$remark);
      
      //------------------------update travel clearance to approved-----------------------
      if(!empty($model2)){
          foreach( $model2 as $tc){
              
             $tc->status='approved';
             $tc->save(false);
          }
      }
      
      
        //------------------------update claim form to approved-----------------------
       if(!empty($model3)){
          foreach( $model3 as $cf){
              
             $cf->status='approved';
             $cf->save(false);
          }
      }
      
   }else{
       
      throw new \yii\web\HttpException(451,
          'Travel Request could not be approved
              (please try again).');   
       
         }
  
   }
  
   else{
      $step_action='approved';
      $step_status='middlemen';
      $msg='Your Approval Saved'; 
      $this->ApprovalActionLog($model1->id,$user,$step_action,$step_status,$remark);
     }
  
 
 
if(!empty($employees)){
        
        $forwarded=$this->isForwarded($employees,$cc,$model1->id,$user,$remark);
        if($forwarded){
        
            if($approved){
               $msg.=' And  forwarded!';   
            }else{
                 $msg.=' And Travel Request forwarded!';  
            }
         
       }else{
           
          if($approved){
               $msg.=' but could not be forwarded!';   
            }else{
                 $msg.=' but Travel Request could not be forwarded!';  
            }
       }
       
       }
        
    
     }
     
    if($action=='cforward'){
       
 if($this->isForwarded($employees,$cc,$model1->id,$user,$remark)){
       
      
      
             
              $step_action='forwarded';
              $step_status='middlemen';
              $this->ApprovalActionLog($model1->id,$user,$step_action,$step_status,$remark);    
        
        
       
       $msg="Travel Request  Forwarded "; 
        
      Yii::$app->session->setFlash('success',$msg);
    
     if($model1->status=='drafting'){
           
           $model1->status='processing';
           $model1->save(false);
           return $this->redirect(['erp-travel-request/drafts']); 
       }
       
      
      
       if($model1->status=='Returned'){
           
           $model1->status='processing';
           $model1->save(false);
      
      
          } 
       
         
    }else{
        
      throw new \yii\web\HttpException(451,
          'The Travel Request  could not be forwarded
              (please try again).'); 
        
    }
    
    
    
    
      }
    
    
    
    
 if($action=='rfa'){
       
     
     $model1->status='Returned';
                      $model1->save(false);
     
    if($this->isForwarded($employees,$cc,$model1->id,$user,$remark)){
     
     $step_action='returned';
     $step_status='middlemen';
     $msg='Travel Request sent back Successfully...';   
     $this->ApprovalActionLog($model1->id,$user,$step_action,$step_status,$remark);  
       
         //-------------------all done------------------------------------------------------------
  
   Yii::$app->session->setFlash('success',$msg);
   $done=  Yii::$app->db->createCommand()
                      ->update('erp_travel_request_approval_flow', ['status' =>'returned'], ['approver'=>$user,'tr_id'=>$model1->id])
                      ->execute(); 
   
   return $this->redirect(['erp-travel-request/pending']);  
           
      
      
       }else{
        
      throw new \yii\web\HttpException(451,
          'The Travel Request   could not be sent back
              (please try again).'); 
        
    }
    
      
     
     
     
     
     
 }

  
  
  
 
   
     
 //---------------------------end-----------------------
 

  Yii::$app->session->setFlash('success',$msg);
  
  $done=  Yii::$app->db->createCommand()
                      ->update('erp_travel_request_approval_flow', ['status' =>'done'], ['approver'=>$user,'tr_id'=>$tr_id])
                      ->execute(); 
   return $this->redirect(['erp-travel-request/pending']); 
   
}

     if(Yii::$app->request->isAjax){
         
      return $this->renderAjax('approval-work-flow',[ 'model' =>$model,'tr_id'=>$_GET['tr_id']]); 
         
     }
return $this->render('approval-work-flow',[ 'model' =>$model,'tr_id'=>$_GET['tr_id']]);

   }
   
   
   //--------------------------------approval action log---------------------------------------- 
    public function ApprovalActionLog($tr_id,$user,$step_action,$step_status,$remark){
 
 
    $approval=new ErpTravelRequestApproval();
    $approval->tr_id=$tr_id;
    $approval->approver=$user;
    $approval->approval_action=$step_action;
    $approval->approval_status=$step_status;
    $approval->remark=$remark;
    $approval_saved=$approval->save(false);  
  
       
 }
 public function isForwarded($employees,$cc,$tr_id,$user,$remark){
   
   $forwardDate = date('Y-m-d');
       $forwardDate=date('Y-m-d', strtotime($forwardDate));  
    
     if(!empty($employees)){
 foreach($employees as $key=>$employee){
   
   
   //-----------check if person is out---------------------------------------------  
     $q8="SELECT * from erp_person_interim where  person_interim_for='".$employee."' 
      and date_from <= '$forwardDate' and date_to >= '$forwardDate'";
     $command8= Yii::$app->db->createCommand($q8);
     $row8 = $command8->queryOne(); 
   
    $flowModel=new ErpTravelRequestApprovalFlow();
    $flowModel->tr_id=$tr_id;
    $flowModel->approver=$employee;
    $flowModel->originator=$user;
    $flowModel->remark =$remark;
    
    
   if(!empty($row8)){
        
         $flowModel->is_copy =1; 
    }
   
    if(!$forwarded=$flowModel->save(false)){
      
    
      break; 
      
      return false;
        
    }
   
     $flag1=$this->sendEmail($user,$employee,$tr_id);

      //---------------copy AA--------------------------------
   
    $q6="SELECT p.id as position_id FROM user as u 
     inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
     inner join erp_org_positions as p on p.id=pp.position_id where u.user_id={$employee}";
     $command6= Yii::$app->db->createCommand($q6);
     $row6 = $command6->queryOne();
    
$q7=" SELECT u.user_id FROM erp_org_positions as p 
inner join erp_org_positions as p1 on p1.id=p.report_to 
inner join erp_persons_in_position as pp on pp.position_id=p.id inner join user as u on u.user_id=pp.person_id 
inner join erp_units_positions as up on up.position_id=p.id where p.report_to={$row6['position_id']} and up.position_level='pa' and pp.status<>0";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();

//----------------prevent sending to him self

if(!empty($row7) && $row7['user_id']!=$user){
    
    $flowModel=new ErpTravelRequestApprovalFlow();
    $flowModel->tr_id=$tr_id;
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
 
  public function sendEmail($from,$to,$tr_id){
     
     
    
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
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>'Travel Request','date'=>date("Y-m-d H:i:s"),'remark'=>$remark
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$to])
->setSubject('ERP Notification')
//->setTextBody('You Can Change Login Password After Sign in')
->send();


                                            
    
   return $flag1;
     
     
 }
  
    

    /**
     * Updates an existing ErpTravelRequestApproval model.
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
     * Deletes an existing ErpTravelRequestApproval model.
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
     * Finds the ErpTravelRequestApproval model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpTravelRequestApproval the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpTravelRequestApproval::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
