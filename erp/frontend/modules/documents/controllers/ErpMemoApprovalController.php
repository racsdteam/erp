<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpMemoApproval;
use common\models\ErpRequisition;
use common\models\ErpMemo;
use common\models\ErpMemoCateg;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ErpMemoApprovalFlow;
use common\models\ErpRequisitionApprovalFlow;
use common\models\ErpRequisitionApproval;
use common\models\User;
use common\models\ErpMemoApprovalSettings;

date_default_timezone_set('Africa/Cairo');

/**
 * ErpMemoApprovalController implements the CRUD actions for ErpMemoApproval model.
 */
class ErpMemoApprovalController extends Controller
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
     * Lists all ErpMemoApproval models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ErpMemoApproval::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpMemoApproval model.
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
    
    public function actionTest(){
        
       $model = new ErpMemoApproval();
    
       $model0=new ErpMemoApprovalSettings(); 
       
       if(Yii::$app->request->post()){
           
        var_dump($_POST);die();
       }
         
        return $this->render('request-approval',[ 'model' =>$model,'model0'=>$model0,'memo_id'=>1972]); 
        
       
    }
    
       //--------------------------------===================apprvode==========----------------------------------------------------------
    public function actionWorkFlow(){
   
    $model = new ErpMemoApproval();
    
    $model0=new ErpMemoApprovalSettings();
   
     $employees=array();
    
    if(Yii::$app->request->post()){
        
    
        
     $data=$_POST['ErpMemoApproval'];
    
    
    
     $action=$data['action'];
     $remark=$data['remark'];
     
     if(isset($data['employee']) && !empty($data['employee'])){
       
       $employees[]=$data['employee'];  
     }
     
     $cc=$data['employee_cc'];
     $memo_id=$data['memo_id'];
     $user=Yii::$app->user->identity->user_id;

      $model1=ErpMemo::find()->where(['id'=>$memo_id])->one();
      $model2=ErpMemoCateg::find()->where(['id'=>$model1->type])->one(); 
    
      $msg='';
 
   //--------------------------user position------------------------------------------------
   

$q6="SELECT up.position_level as level,p.id as pos_id ,p.position_code FROM  erp_units_positions as up inner join erp_org_positions as p on up.position_id=p.id
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where  pp.person_id='".$user."' and pp.status=1";
$command6= Yii::$app->db->createCommand($q6);
$row5 = $command6->queryOne();


 //--------------------------------------------------------------------------------------------------
     if($action=='approve'){
 
 $final_approver_settings=ErpMemoApprovalSettings::find()->where(['memo_id'=>$model1->id])->One(); 
 $final_app=$final_approver_settings->final_approver;
 
  //----------------------------check if interim for------------------------------------------>

 $approvalDate = date('Y-m-d');
 $approvalDate=date('Y-m-d', strtotime($approvalDate));
  
/*$q8="SELECT * from erp_person_interim where  person_in_interim='".$user."' and person_interim_for='".$final_app."' 
and date_from <= '$approvalDate' and date_to >= '$approvalDate'";
$command8= Yii::$app->db->createCommand($q8)*/

$row8 = Yii::$app->muser->getInterim($user,$final_app,$approvalDate);    
    
    
 //------------------------Travel Memo----------------------------------------    
     if($model2->categ_code=='TR'){
         
 //----------MD OR AAMD--OR INTERIM     
   if($final_app==$user  || $row8 !=null){
    
     $model1->status='approved';
   
   if($approved=$model1->save(false)){
      $step_action='approved';
      $step_status='final'; 
      $msg="Memo Approved";
      $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
      
   }else{
       
      throw new \yii\web\HttpException(451,
          'Memo could not be approved
              (please try again).');   
       
         }
  
   }
   else{
       
       $step_action='approved';
       $step_status='middlemen'; 
       $msg="Memo Approved"; 
       $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
       }
  
 
if(!empty($employees)){
        
        $forwarded=$this->isForwarded($employees,$cc,$model1->id,$user,$remark);
        
        if($forwarded){
        
            $msg.=' And  forwarded!';  
            
             
      if($model1->status=='Returned'){
           
           $model1->status='processing';
           $model1->save(false);
      
      
          }
         
       }else{
           
           $msg.=' but could not be forwarded!';  
       }
       
       }

    
    
     }//-------------------------------end travel memo-------------------------------------
     
      //------------------------Travel Memo----------------------------------------    
    else if($model2->categ_code=='O'){
   
   //----------MD OR AAMD--OR INTERIM     
   if($final_app==$user ||$row5['position_code']=='AAMD'  || $row8 != null){
    
     $model1->status='approved';
   
   if($approved=$model1->save(false)){
      $step_action='approved';
      $step_status='final'; 
      $msg="Memo Approved";
      $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
     
      
   }else{
       
      throw new \yii\web\HttpException(451,
          'Memo could not be approved
              (please try again).');   
       
         }
  
   }
   else{
       
       $step_action='approved';
       $step_status='middlemen'; 
       $msg="Memo Approved"; 
       $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
     }
  
 
 
if(!empty($employees)){
        
        $forwarded=$this->isForwarded($employees,$cc,$model1->id,$user,$remark);
        if($forwarded){
        
             $msg.=' And  forwarded!'; 
         
       }else{
           
          $msg.=' but could not be forwarded!';  
       }
       
       }

    
    
     }
     
   //--------------------------Memo for PurcHASE REQUSITION-----------------------  
     
  
      else if($model2->categ_code=='PR'){
    
    
     if($final_app==$user || $row8 != null || ($row5['level']=='director' && $model1->created_by==$user
      ) || $row5['position_code']=='MD'){
         
     $model1->status='approved';
         
         
   if($approved=$model1->save(false)){
      
       
      $step_action='approved';
      $step_status='final'; 
      $msg="Memo Approved";
      $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
      
      $model3=ErpRequisition::find()->where(['reference_memo'=>$model1->id])->one() ;
      
      if($row5['position_code']=='MD'){
     $model3->approve_status='approved'; 
      $model3->save(false);
      }

    
  //-----------------------initiate work flow--------------------------------------------------     
     if(!empty($employees)){
 foreach($employees as $key=>$employee){
    $flowModel=new ErpRequisitionApprovalFlow();
    $flowModel->pr_id= $model3->id;
    $flowModel->approver=$employee;
    $flowModel->originator=$user;
    $flowModel->remark =$remark;
    $forwarded=$flowModel->save(false);
    
 }
 
    if($forwarded){
    
  //--------------------------------pre approve----------------------------------------------------  
    $approval=new ErpRequisitionApproval();
    $approval->requisition_id=$model3->id;
    $approval->approved_by=$user;
    $approval->approval_status='middlemen';
    $approval->remark=$remark;
    $approval_saved=$approval->save(false);
 
 
    
    if($model3->approve_status!='approved'){
       $model3->approve_status='processing';
        $model3->save(false); 
    }
    
    $msg="Requisition Forwarded For further processing !" ;  
    }
 
     }
      
     
      
   }else{
       
       //---------coul not be aoo
       
        throw new \yii\web\HttpException(451,
          'Memo could not be approved
              (please try again).');   
         
   }
         
     }else{
         
         
       $step_action='approved';
       $step_status='middlemen'; 
       $msg="Memo Approved"; 
       $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);
     }
          
   
       }  //------------------END PR APPROVAL

  
      
   
   
    $done=Yii::$app->db->createCommand()
                      ->update('erp_memo_approval_flow', ['status' =>'done'], ['approver'=>$user,'memo_id'=>$model1->id])
                      ->execute(); 
   Yii::$app->session->setFlash('success',$msg);                 
   
   return $this->redirect(['erp-memo/pending']);
    
   
  
     }
     
  //-----------------END APPROVAL PROCESS-----------------------------------------------------     
               
 //--------------------------------------------------BEGIN---FORWARD-PROCESS----------------------------------------------------------------------------   
    
    if($action=='cforward'){
   
    
     $forwardDate = date('Y-m-d');
     $forwardDate=date('Y-m-d', strtotime($forwardDate));
     
     if(isset($_POST['ErpMemoApprovalSettings'])){
         
     $data1=$_POST['ErpMemoApprovalSettings'];
     
 
     
     $fapproval=new ErpMemoApprovalSettings(); 
     $fapproval->final_approver=$data1['approver_name'];
     $fapproval->memo_id=$model1->id;
     $fapproval->user=$user;
     $fapproval->save(false); 
     
     //------------if through was not set---------------------------------------------------
     if(empty($employees) && !empty($data1['approver_name'])){
         
         $employees[]= $data1['approver_name'];
     }
  
  
     }
     
     //-----------------MEMO--automatic approval for position report to DMD-------------------------------------------
     
      if($model2->categ_code=='PR'){
          
  $model3=ErpRequisition::find()->where(['reference_memo'=>$model1->id])->one() ;        
            
$q3="SELECT p.id,p.position_code,p1.position as report_to,p1.position_code as report_to_code, up.position_level  FROM   erp_org_positions p
inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join erp_org_positions p1 on p.report_to=p1.id
inner join erp_units_positions as up  on up.position_id=p.id
where  pp.person_id='".$user."'";
$command3= Yii::$app->db->createCommand($q3);
$row6 = $command3->queryOne();

if(($row6['position_level']=='manager' || $row6['position_level']=='director') && $model1->status=='drafting' && !$fapproval->isFinalApprover($user) ){
    
   //--------go direct to approver-------------------------------- 
   if(empty($employees) && !empty($data1['approver_name'])){
         
        $employees[]=$data1['approver_name'];
     }
  
   
   
   
}

//the requestor is manager and has been left in director interim ->assign to himself
if(($row6['position_level']=='manager') && $model1->status=='drafting' &&  $fapproval->isFinalApprover($user) ){
    
   //--------go direct to approver-------------------------------- 
   $employees[]=$user;
   
   
}



//----------------------------------------report to MD-----------------------------------
if($row6['report_to_code']=='DMD' && $model1->status=='drafting'){
    
  
       if(!empty($employees)){
 foreach($employees as $key=>$employee){
   
 $q8="SELECT * from erp_person_interim where  person_interim_for='".$employee."' 
and date_from <= '$forwardDate' and date_to >= '$forwardDate'";
$command8= Yii::$app->db->createCommand($q8);
$row8 = $command8->queryOne(); 

    
    $flowModel=new ErpMemoApprovalFlow();
    $flowModel->memo_id=$model1->id;
    $flowModel->approver=$employee;
    $flowModel->originator=$user;
    
    if(!empty($row8)){
    
    $flowModel->is_copy=1;
}
    $flowModel->remark =$remark;
    $flowModel->status='processing';
    $forwarded=$flowModel->save(false);
    
    
     if($forwarded){
    
    //--------------------------------MEMO APPROVAL LOG-----------------------------
      $step_action='forwarded';
      $step_status='middlemen'; 
      $msg="Memo forwarded";
      
      $model1->status='processing';
      $model1->save(false);
      
      $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);  
      $msg='Memo Forwarded for further processing...';           
                
     }
    
     
    
    
 }
          }

      
    
  //-----------------------initiate work flow--------------------------------------------------     
     if(!empty($employees)){
 foreach($employees as $key=>$employee){
    
    $q8="SELECT * from erp_person_interim where  person_interim_for='".$employee."' 
   and date_from <= '$forwardDate' and date_to >= '$forwardDate'";
    $command8= Yii::$app->db->createCommand($q8);
     $row8 = $command8->queryOne(); 
    
    
    
    $flowModel=new ErpRequisitionApprovalFlow();
    $flowModel->pr_id= $model3->id;
    $flowModel->approver=$employee;
    $flowModel->originator=$user;
    if(!empty($row8)){
        
       $flowModel->is_copy=1;  
        
    }
    $flowModel->remark =$remark;
    $forwarded=$flowModel->save(false);
    
     if($forwarded){
    
    $model3->approve_status='processing';
    $model3->save(false);
   
    $approval=new ErpRequisitionApproval();
    $approval->requisition_id=$model3->id;
    $approval->approved_by=$user;
    $approval->approval_status='middlemen';
    $approval->approval_action='forwarded';
    $approval->remark=$remark;
    $approval_saved=$approval->save(false);
    $msg='Requisition Forwarded for further processing...';           
                
     }
    
 }
 
 
 
 
 
     }
     
    
Yii::$app->session->setFlash('success',$msg);
            
return $this->redirect(['erp-memo/drafts']); 
        

}//-----------------------END CHECK REPORT TO DMD-----------------------------------

/*if($fapproval->isFinalApprover($user)){
    
       $model1->status='approved';
          if($approved=$model1->save(false)){
    
      
  //-----------------------initiate work flow--------------------------------------------------     
     if(!empty($employees)){
 foreach($employees as $key=>$employee){
    $flowModel=new ErpRequisitionApprovalFlow();
    $flowModel->pr_id= $model3->id;
    $flowModel->approver=$employee;
    $flowModel->originator=$user;
    $flowModel->remark =$remark;
    $forwarded=$flowModel->save(false);
    
 }
 
    if($forwarded){
    
  //--------------------------------pre approve----------------------------------------------------  
    $approval=new ErpRequisitionApproval();
    $approval->requisition_id=$model3->id;
    $approval->approved_by=$user;
    $approval->approval_status='middlemen';
    $approval->remark=$remark;
    $approval_saved=$approval->save(false);
 
 
    
    if($model3->approve_status!='approved'){
       $model3->approve_status='processing';
       $model3->save(false); 
    }
    
    $msg="Requisition Forwarded For further processing !" ;  
    }
 
     }
      
     
      
   }else{
       
       //---------coul not be aoo
       
        throw new \yii\web\HttpException(451,
          'Memo could not be approved
              (please try again).');   
         
   }
    
  }*/



         $model3->approve_status='processing';
         $model3->save(false);
            
       
       
       
       
       
        }//-------------------------END TYPE REQUISITION----------------------
       
  
 //============================other and tr----------------------------------------------------------------------------- 
  
  
  if($this->isForwarded($employees,$cc,$model1->id,$user,$remark)){
     
     $step_action='forwarded';
     $step_status='middlemen';
     $msg='Memo  Forwarded for further processing...'; 
     
      if(($row5['level']=='manager' || $row5['level']=='director')  && $model1->created_by !=$user){
          
          $step_action='confirmed'; 
      }
      
     $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);     
        
    
    if($model1->status=='drafting'){
          
           $model1->status='processing';
           $model1->save(false);
           Yii::$app->session->setFlash('success',$msg);
           return $this->redirect(['erp-memo/drafts']);
     
        
    }
    
if($model1->status=='Returned'){
           
           $model1->status='processing';
           $model1->save(false);
      
      
          } 
        
        
         Yii::$app->session->setFlash('success',$msg);
   $done=  Yii::$app->db->createCommand()
                      ->update('erp_memo_approval_flow', ['status' =>'done'], ['approver'=>$user,'memo_id'=>$model1->id])
                      ->execute(); 
   return $this->redirect(['erp-memo/pending']);  
         
     
     
    
  
   
           
      
      
       }else{
        
      throw new \yii\web\HttpException(451,
          'The Memo  could not be forwarded
              (please try again).'); 
        
    }
       
    
         
    }
    
    if($action=='rfa'){
     
    if($model1->status!="approved")
    {
                      $model1->status='Returned';
                      $model1->save(false);
    }
    if($this->isForwarded($employees,$cc,$model1->id,$user,$remark)){
     
     $step_action='returned';
     $step_status='middlemen';
     $msg='Memo sent back Successfully...';   
     $this->ApprovalActionLog($model1->id,$user,$row5['pos_id'],$step_action,$step_status,$remark);  
       
         //-------------------all done------------------------------------------------------------
  
   Yii::$app->session->setFlash('success',$msg);
   $done=  Yii::$app->db->createCommand()
                      ->update('erp_memo_approval_flow', ['status' =>'returned'], ['approver'=>$user,'memo_id'=>$model1->id])
                      ->execute(); 
   
   return $this->redirect(['erp-memo/pending']);  
           
      
      
       }else{
        
      throw new \yii\web\HttpException(451,
          'The Memo  could not be sent back
              (please try again).'); 
        
    }
    
    
     
 }
 
 
 
   
}//----------------------------END POST

     if(Yii::$app->request->isAjax){
         
      return $this->renderAjax('request-approval',[ 'model' =>$model,'model0'=>$model0,'memo_id'=>$_GET['memo_id']]); 
         
     }else{
         
        return $this->render('request-approval',[ 'model' =>$model,'model0'=>$model0,'memo_id'=>$_GET['memo_id']]);   
     }
   

   }
  
  //--------------------------------approval action log---------------------------------------- 
    public function ApprovalActionLog($id,$user,$pos,$step_action,$step_status,$remark){
     
    $approval=new ErpMemoApproval();
    $approval->memo_id=$id;
    $approval->approved_by=$user;
    $approval->approver_position=$pos;
    $approval->approval_status=$step_status;
    $approval->approval_action=$step_action;
    $approval->remark=$remark;
    $approval_saved=$approval->save(false);     
       
 }
 public function isForwarded($employees,$cc,$id,$user,$remark){
     
     $forwardDate = date('Y-m-d');
     $forwardDate=date('Y-m-d', strtotime($forwardDate));
     
     if(!empty($employees)){
 foreach($employees as $key=>$employee){
   
     $q8="SELECT * from erp_person_interim where  person_interim_for='".$employee."' 
      and date_from <= '$forwardDate' and date_to >= '$forwardDate'";
     $command8= Yii::$app->db->createCommand($q8);
     $row8 = $command8->queryOne(); 
    
    
    $flowModel=new ErpMemoApprovalFlow();
    $flowModel->memo_id=$id;
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
    
   $flag1=$this->sendEmail($user,$employee,$id);

      //---------------copy AA--------------------------------
   
    $q6="SELECT p.id as position_id FROM user as u 
     inner join erp_persons_in_position as pp on u.user_id=pp.person_id 
     inner join erp_org_positions as p on p.id=pp.position_id where u.user_id={$employee} and pp.status<>0 ";
     $command6= Yii::$app->db->createCommand($q6);
     $row6 = $command6->queryOne();
    
$q7=" SELECT u.user_id FROM erp_org_positions as p 
inner join erp_org_positions as p1 on p1.id=p.report_to 
inner join erp_persons_in_position as pp on pp.position_id=p.id inner join user as u on u.user_id=pp.person_id 
inner join erp_units_positions as up on up.position_id=p.id where p.report_to={$row6['position_id']} and up.position_level='pa' and pp.status<>0";
$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne();

if(!empty($row7) && $row7['user_id']!=$user){
    
   
    $flowModel=new ErpMemoApprovalFlow();
    $flowModel->memo_id=$id;
    $flowModel->approver=$row7['user_id'];
    $flowModel->originator=$user;
    $flowModel->remark =$remark;
    $flowModel->is_copy =1; 
    
      if($flowModel->save(false)){
       $flag=$this->sendEmail($user,$row7['user_id'],$id) ;
        
    }
   
  
    
}                                        
    
   
    
    
 }
 
     } 
     
     return $forwarded;
     
 }
 
 public function sendEmail($from,$to,$memo){
     
     
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
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>'Memo','date'=>date("Y-m-d H:i:s"),'remark'=>$remark
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$employee])
->setSubject('ERP Notification')
//->setTextBody('You Can Change Login Password After Sign in')
->send();

return $flag1;
     
     
 }
 
 
 //-------------------------------------------redirect Approval-------------------------------------------------------//
 
  public function actionRedirect(){
      
      
      
      $model=new   ErpMemoApproval();
      $flowModel=new  ErpMemoApprovalFlow();
      
       if(Yii::$app->request->post()){
        
      
     
        $data=$_POST['ErpMemoApproval'];
      
        
        if(!isset($data['memo_id'])){
        Yii::$app->session->setFlash('error',"Invalid Memo ID");   
        return $this->redirect(['erp-memo/index']);
       
        }
        
        if(!isset($data['redirect_flow_id'])){
         Yii::$app->session->setFlash('error',"Invalid approval flow ID");    
        return $this->redirect(['erp-memo/memo-tracking','id'=>$data['memo_id']]);
        }
         
        
       $f=ErpMemoApprovalFlow::find()->where(['id'=>$data['redirect_flow_id']])->One();
       
       if($f==null){
         
         return $this->redirect(['erp-memo/memo-tracking','id'=>$data['memo_id']]);   
           
       }
           
    $flowModel=new ErpMemoApprovalFlow();
    $flowModel->setAttributes($f->attributes);
    $flowModel->approver=$data['employee'];
    $flowModel->timestamp=date("Y-m-d H:i:s");
    
    if(!$flowModel->save()){
        
        Yii::$app->session->setFlash('error',Html::errorSummary($flowModel));
        return $this->redirect(['erp-memo/memo-tracking','id'=>$f->memo_id]); 
    }
        $f->status='redirected';
        $f->save(false);
        
        Yii::$app->session->setFlash('success',"Memo redirected successfully !");
        return $this->redirect(['erp-memo/memo-tracking','id'=>$data['memo_id']]); 
           
       }
      
   if(Yii::$app->request->isAjax){
         
      return $this->renderAjax('redirect-work-flow',[ 'model' =>$model,'f_id'=>$_GET['f_id'],'memo_id'=>$_GET['memo_id']]); 
         
     }else{
         
        return $this->render('redirect-work-flow',[ 'model' =>$model,'f_id'=>$_GET['f_id'],'memo_id'=>$_GET['memo_id']]);   
     }   
      
  }
 
 

    /**
     * Creates a new ErpMemoApproval model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     
     
     
     
    public function actionCreate()
    {
        $model = new ErpMemoApproval();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ErpMemoApproval model.
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
     * Deletes an existing ErpMemoApproval model.
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
     * Finds the ErpMemoApproval model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpMemoApproval the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpMemoApproval::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
