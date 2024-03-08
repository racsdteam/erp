<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpLpoApproval;
use common\models\ErpLpo;
use common\models\ErpMemo;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ErpLpoApprovalFlow;
use common\models\ErpMemoApproval;
use common\models\User;
use common\models\ErpLpoRequest;
/**
 * ErpLpoApprovalController implements the CRUD actions for ErpLpoApproval model.
 */
class ErpLpoApprovalController extends Controller
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
     * Lists all ErpLpoApproval models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ErpLpoApproval::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpLpoApproval model.
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
   
    $model = new ErpLpoApproval();
   
    if(isset($_POST['ErpLpoApproval'])){
     
     $data=$_POST['ErpLpoApproval'];
    
    //var_dump($_POST['ErpLpoApproval']);die();
    
     $action=$data['action'];
     $remark=$data['remark'];
     $employees[]=$data['employee'];
     $cc=$data['employee_cc'];
     $lpo=$data['lpo'];
     $user=Yii::$app->user->identity->user_id;
     
     
    $model1=ErpLpo::find()->where(['id'=>$lpo])->one();

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
      
   
   if($row7['user_id']==$user  || $row8!=null ){
    
   $model1->status='approved';
   
   if($approved=$model1->save(false)){
      $step_action='approved';
      $step_status='final'; 
      $msg="LPO Approved";
     
      //----------------set LPO request fullfilled--------------------------
      $model2=ErpLpoRequest::find()->where(['id'=>$model1->lpo_request_id])->one();
      
      if($model2!=null){
        $model2->status='completed';
        $model2->save(false);  
          
      }
      
      
   }else{
       
      throw new \yii\web\HttpException(451,
          'Lpo could not be approved
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
 
if(!empty($employees)){
        
        $forwarded=$this->isForwarded($employees,$cc,$model1->id,$user,$remark);
        if($forwarded){
        
            if($approved){
               $msg.=' And  forwarded!';   
            }else{
                 $msg.=' And LPO forwarded!';  
            }
            
             
      if($model1->status=='Returned'){
           
           $model1->status='processing';
           $model1->save(false);
      
      
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
   
    
    if($this->isForwarded($employees,$cc,$model1->id,$user,$remark)){
        
         $step_action='forwarded';
         $step_status='middlemen';
         $msg="LPO Forwarded !";
         
       
        if($model1->created_by!=$user){
            
          $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
        }
        Yii::$app->session->setFlash('success',$msg);
    
     if($model1->status=='drafting' && $model1->created_by==$user){
           
           $model1->status='processing';
           $model1->save(false);
           return $this->redirect(['erp-lpo/drafts']); 
       }
       
        if($model1->status=='Returned'){
           
           $model1->status='processing';
           $model1->save(false);
      
      
          } 
       
         
    }else{
        
      throw new \yii\web\HttpException(451,
          'The LPO  could not be forwarded
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
     $msg='LPO sent back Successfully...';   
     $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);  
       
         //-------------------all done------------------------------------------------------------
  
   Yii::$app->session->setFlash('success',$msg);
   $done=  Yii::$app->db->createCommand()
                      ->update('erp_lpo_approval_flow', ['status' =>'returned'], ['approver'=>$user,'lpo'=>$model1->id])
                      ->execute(); 
   
   return $this->redirect(['erp-lpo/pending']);  
           
      
      
       }else{
        
      throw new \yii\web\HttpException(451,
          'The LPO could not be sent back
              (please try again).'); 
        
    }
    
    
    
    
    
     }
     
     
if($action=='close'){
        $model1->status='closed';
       $closed= $model1->save(false);
       if($closed){
           $this->ApprovalActionLog($model->id,$user,$row5['pos_id'],"closded",$remark);
           $msg="LPO  Closed";
       }else{
          throw new \yii\web\HttpException(451,
          'The lPO could not be Closed
              (please try again).');  
           
       }
     }
 
 //---------------------all went well--------------------------------------------
 
  Yii::$app->session->setFlash('success',$msg);
  
  
  
   
   $done=  Yii::$app->db->createCommand()
                      ->update('erp_lpo_approval_flow', ['status' =>'done'], ['approver'=>$user,'lpo'=>$model1->id])
                      ->execute(); 
   return $this->redirect(['erp-lpo/pending']); 
   
}

     if(Yii::$app->request->isAjax){
         
      return $this->renderAjax('approval-work-flow',[ 'model' =>$model,'lpo'=>$_GET['lpo']]); 
         
     }
    return $this->render('approval-work-flow',[ 'model' =>$model,'lpo'=>$_GET['lpo']]);

   }
   
   
   
   //--------------------log fucntion---------------------------------------
 
 public function ApprovalActionLog($id,$user,$pos,$step_action,$step_status,$remark){
 
    
    $approval=new ErpLpoApproval();
    $approval->lpo=$id;
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
     
     
    $recipientModel=new ErpLpoApprovalFlow();
    $recipientModel->lpo=$id;
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
    
   
    $recipientModel=new ErpLpoApprovalFlow();
    $recipientModel->lpo=$id;
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
 
 public function sendEmail($from,$to,$lpo){
     
     
    
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
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>'LPO','date'=>date("Y-m-d H:i:s"),'remark'=>$remark
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$to])
->setSubject('ERP Notification')
//->setTextBody('You Can Change Login Password After Sign in')
->send();


                                            
    
   return $flag1;
     
     
 }
   


    /**
     * Creates a new ErpLpoApproval model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpLpoApproval();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ErpLpoApproval model.
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
     * Deletes an existing ErpLpoApproval model.
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
     * Finds the ErpLpoApproval model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpLpoApproval the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpLpoApproval::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
