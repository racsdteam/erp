<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpMemo;
use common\models\ErpTravelClearance;
use common\models\ErpTravelClearanceFlow;
use common\models\ErpTravelClearanceApproval;
use common\models\ErpTravelClearanceFlowRecipients;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ErpPersonsInPosition;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\User;
use yii\data\Pagination;
use kartik\mpdf\Pdf;
use common\models\ErpTravelRequest;
/**
 * ErpTravelClearanceController implements the CRUD actions for ErpTravelClearance model.
 */
class ErpTravelClearanceController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
                 'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                 
                   [
        'actions' => ['index'],
        'allow' => true,
        'matchCallback' => function ($rule, $action) {
            return \Yii::$app->user->identity->isAdmin();
        },
    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ErpTravelClearance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ErpTravelClearance::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
      public function actionMyTravelClearances()
    {
       

        return $this->render('my-travel-clearances');
    }

    /**
     * Displays a single ErpTravelClearance model.
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
    public function actionView2($id)
    {
        return $this->render('view2', [
            'model' => $this->findModel($id),
        ]);
    }
          public function actionPdfData($id)
    {
         $model=$this->findModel($id);
        
         $model2=ErpTravelRequest::find()->where(['id'=>$model->tr_id])->One();
        
        //-----------------------------international----------------------
         if($model2->type=='I'){
          $view='view2';
          //----------------------------------domestic-------------------
         }elseif($model2->type=='D'){
              $view='view1';
         }else{
      //-------------------------------default--------------------------------       
            $view='view2';  
         }
        
        $url = "css/kv-mpdf-bootstrap.min.css";
        $stylesheet = file_get_contents($url);
        
        $url1 = "css/mpdf.css";
        $stylesheet1 = file_get_contents($url1);
         
      $mpdf = new \Mpdf\Mpdf(['mode' => 'c']);
         //----------------------------add bootsrap classes---------------------------
         $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
         $mpdf->WriteHTML($stylesheet1, \Mpdf\HTMLParserMode::HEADER_CSS);
        //--------------------------setting header-------------------------------------
        $mpdf->SetHTMLFooter('<img src="img/footer.png"/>');
         $mpdf->SetWatermarkImage('img/watermark.png',0.1, array(150, 145), array(-7, 161));
       $mpdf->showWatermarkImage = true;
         $mpdf->WriteHTML($this->renderPartial($view, [
            'model' => $this->findModel($id),]));
       $content= $mpdf->Output();
       return $content;
        exit;
    }
    
    public function actionViewPdf($id)
    {
       return $this->renderAjax('pdf-viewer',[ 'id' => $id]);
    }
    
    public function actionTcsViewPdf($tr_id){
        
    $query = ErpTravelClearance::find()->where(['tr_id'=>$tr_id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
            
          return $this->renderAjax('pdf-viewer2', [
         'models' => $models,
         'pages' => $pages,
        
    ]);
    }
    
    }
    
     public function actionPending()
    {
          return $this->render('pending');
    }
    
             public function actionApproved()
    {
          return $this->render('approved');
    }
    
      
     public function actionFetchTab()
    {
   
     
           
           
          $query = ErpTravelClearance::find()->where(['tr_id' =>$_GET['tr_id']]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
            
                return $this->renderAjax('tc-viewer', [
         'models' => $models,
         'pages' => $pages,
    ]);
        
         
        }else{
            
            
            return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Travel Clearance(s) Found!
              
               </div>';
        }
       
           
               
           
     
   
  
    }
    
    public function actionViewWorkFlow($id){

  if(Yii::$app->request->isAjax){

            return $this->renderAjax('view-work-flow',['id'=>$id]);   
        }
    return $this->render('view-work-flow',['id'=>$id]);
    
    }
    
    
    /**
     * Creates a new ErpTravelClearance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($memo)
    {
          $model = new ErpTravelClearance();
         if (!empty(Yii::$app->request->post())) {
            $data=$_POST['ErpTravelClearance'];
            $employees=$data['employee'];
            foreach($employees as $employee)
            {
                   $model1 = new ErpTravelClearance();
                  $model1->load(Yii::$app->request->post());
                  $model1->created_by=Yii::$app->user->identity->user_id;
                  $model1->employee=$employee;
             $exponent = 3; // Amount of digits
             $min = pow(10,$exponent);
             $max = pow(10,$exponent+1)-1;
             //1
             $value = rand($min, $max);
             $unification="tc-".date("Ymdhms")."-".$value;
             $model1->tc_code=$unification;
                 
                  if(! $flag=$model1->save()){
                     
                     Yii::$app->session->setFlash('failure',Html::errorSummary($model1));  
                    return  $this->redirect(['erp-memo/view', 'id' =>$model1->memo]);
                   
                  }
            }
        
        
        if($flag){
            
             Yii::$app->session->setFlash('success',"Travel Clearance Added Successfully!");  
        }else{
            
            Yii::$app->session->setFlash('failure',"Error Adding Travel Clearances");
        }
        
        $this->redirect(['erp-memo/view', 'id' =>$model1->memo]);
                }

        return $this->renderAjax('create', [
            'model' => $model,'memo'=>$memo,
        ]);
    }

    /**
     * Updates an existing ErpTravelClearance model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model1=ErpPersonsInPosition::find()->where(['person_id'=>$model->employee])->one();
        if($model1!=null){
            
            $model->position=$model1->position_id;
        }
       
        if ($model->load(Yii::$app->request->post())) {
            $data=$_POST['ErpTravelClearance'];
            $employees=$data['employee'];
            $model->created_by=Yii::$app->user->identity->user_id;
            foreach($employees as $employee)
            {
                  $model->employee=$employee;
                  $flag=$model->save();
            }
            if($flag){
                Yii::$app->session->setFlash('success',"Travel Clearance Updated Successfully!");  
            }else{
                Yii::$app->session->setFlash('failure',"Travel Clearance could not be updated!");  
            }
            
        $this->redirect(Url::to(['erp-memo/view', 'id' =>$model->memo]));
                }
    if(Yii::$app->request->IsAjax)
    {
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }else{
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    }

    /**
     * Deletes an existing ErpTravelClearance model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id,$memo)
    {
        
         $model=$this->findModel($id);
        
         
          $flag= $model->delete();
   if($flag){
       return true;
   }else{
       
       return false;
   }
        
     
    }
    
    
    
    public function actionMemoForwardAction(){
   
   
    if(isset($_POST['ErpTravelClearence'])){

     $remark=$_POST['ErpTravelClearence']['remark'];
     $flow1=$_POST['ErpTravelClearence']['flow'];
     $recipients=$_POST['ErpTravelClearence']['recipients_names'];
     $id=$_POST['ErpTravelClearence']['id'];
     $user=Yii::$app->user->identity->user_id;
      
     $models=ErpTravelClearance::find()->where(['memo'=>$id])->All();
     foreach($models as $model)
     {
     $flow=ErpTravelClearanceFlow::find()->where(['travel_clearance'=>$model->id])->One(); 
     
     if($flow==null){
      
       if($model->created_by==$user){
         
          $flow=new ErpTravelClearanceFlow(); 
         $flow->travel_clearance=$model->id;
         $flow->creator=$model->created_by;
        $flow->save(false);
       
     }
     }
     
    
  
  
  
   


    
   
        
    
 //================================add recipients to the flow-==================================================
 if(!empty($recipients)){
 foreach($recipients as $key=>$value){
    $recipientModel=new ErpTravelClearanceFlowRecipients();
    $recipientModel->flow_id=$flow->id;
    $recipientModel->recipient=$value;
    $recipientModel->sender=$user;
    $recipientModel->remark =$remark;
   $flag= $recipientModel->save(false);
   
          //=================================================notification================================================================
   //---------------------------------sender--------------------------------------
   
    $q7=" SELECT u.first_name,u.last_name,p.position FROM user as u  inner join erp_persons_in_position as pp  on u.user_id=pp.person_id
    inner join erp_org_positions as p  on pp.position_id=p.id  where pp.person_id='".$user."' ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           $sender=$row7['first_name']." ".$row7['last_name']." /".$row7['position'];
                                         
                                           //-------------------------receiver---------------------------
                                            $user2=User::find()->where(['user_id'=>$value])->One();
                                            $recipient=$user2->first_name." ".$user2->last_name;
                                            //---------------------------doc type--------------------------
                                            $doc ="Travel Clearance";
                                            
                                            if($flag){
                                                
                                                 $flag1= Yii::$app->mailer->compose( ['html' =>'userNotification-html'],
    [
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>$doc,'date'=>date("Y-m-d H:i:s")
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$recipient])
->setSubject('ERP Notification')
->send();   
                                            }
                                            
//=============================================end notification================================================================================      

    }
 }

 


if($flag){
   
   Yii::$app->db->createCommand()
                      ->update('erp_travel_clearance', ['status' =>'processing'], ['id' =>$model->id])
                      ->execute();
  
   $done=Yii::$app->db->createCommand()
                      ->update('erp_memo_flow_recipients', ['status' =>'done'], ['id'=>$flow1])
                      ->execute();                       
}
}   
}
   

return $this->redirect(Url::to(['erp-travel-clearance/pending']));
}
    /**
     * Finds the ErpTravelClearance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpTravelClearance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpTravelClearance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    
      //========================================================travel clearance memo========================================
public function actionApproveAction(){
   
   
    if(isset($_POST['ErpTravelClearance'])){
     
     $action=$_POST['ErpTravelClearance']['action'];
     $remark=$_POST['ErpTravelClearance']['remark'];
     $recipients=$_POST['ErpTravelClearance']['recipients_names'];
     $id=$_POST['ErpTravelClearance']['id'];
     $user=Yii::$app->user->identity->user_id;
    
      
    //---------------------------------get MD------------------------------------- 
     $q=" SELECT pp.person_id from erp_org_positions as p left join erp_org_positions as p1 on p1.id=p.report_to 
     inner join erp_persons_in_position as pp on pp.position_id=p.id where p.position='Managing Director'";
    $command = Yii::$app->db->createCommand($q);
    $r_MD = $command->queryOne();
    
    //------------------------------------------find req-----------------------------------------
     $tc=ErpTravelClearance::find()->where(['id'=>$id])->One();
    
    //---------------------------------------get flow----------------------------------------------
     $tc_flow=ErpTravelClearanceFlow::find()->where(['travel_clearance'=>$id])->One();
   
      
   //-------------------------------------get user last pending request-------------------- 
     $q1=" SELECT r.*  FROM erp_travel_clearance_flow_recipients as r  where
     r.flow_id={$tc_flow->id} and r.recipient={$user} and r.status='processing' order by r.timestamp desc ";
    $command = Yii::$app->db->createCommand($q1);
    $r1 = $command->queryAll(); 
  
   
   //---------------------------------------approve------------------------------------------------------------------
    $approval=new ErpTravelClearanceApproval();
    $approval->travel_clearance=$id;
    $approval->approved_by=$r1[0]['recipient'];
    $approval->approval_status="approved";
    $approval->remark=$remark;
    $approved=$approval->save(false);
    
    
    

    if($r1[0]['recipient']==$r_MD['person_id']){
    
    
    //-------------------------------------------------------requisition level approval-----------------------------  
     $approved=  Yii::$app->db->createCommand()
                      ->update('erp_travel_clearance', ['status' =>'approved'], ['id'=>$id])
                      ->execute();
                     
     
    }
    else{
        
           $q1=" SELECT person_id  FROM erp_persons_in_position where 	position_id='1' order by id desc ";
                                         $com1= Yii::$app->db->createCommand($q1);
                                          $row1 = $com1->queryOne();
                                          
                                          $q=" SELECT person_in_interim  FROM erp_person_interim where person_interim_for='".$rows1['person_id']."' 
                                          and date_from<='".$date."' and date_to>='".$date."'";
                                         $com= Yii::$app->db->createCommand($q);
                                          $row = $com->queryOne();
                                          
                                           if($r1[0]['recipient']==$row['person_in_interim']){
    
    
    //-------------------------------------------------------requisition level approval-----------------------------  
     $approved=  Yii::$app->db->createCommand()
                      ->update('erp_travel_clearance', ['status' =>'approved'], ['id'=>$id])
                      ->execute();
                     
     
    }
    }
  
  
  
 
 
 //================================forwared to next level-==================================================
 if(!empty($recipients)){
 foreach($recipients as $key=>$value){
   
   

       
    $recipientModel=new ErpTravelClearanceFlowRecipients();
    $recipientModel->flow_id=$tc_flow->id;
    $recipientModel->recipient=$value;
    $recipientModel->sender=$user;
    $recipientModel->remark =$remark;
    $forwarded= $recipientModel->save(false);
 
          //=================================================notification================================================================
   //---------------------------------sender--------------------------------------
   
    $q7=" SELECT u.first_name,u.last_name,p.position FROM user as u  inner join erp_persons_in_position as pp  on u.user_id=pp.person_id
    inner join erp_org_positions as p  on pp.position_id=p.id  where pp.person_id='".$user."' ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           $sender=$row7['first_name']." ".$row7['last_name']." /".$row7['position'];
                                         
                                           //-------------------------receiver---------------------------
                                            $user2=User::find()->where(['user_id'=>$value])->One();
                                            $recipient=$user2->first_name." ".$user2->last_name;
                                            //---------------------------doc type--------------------------
                                            $doc ="Travel Clearance";
                                            
                                            if($flag){
                                                
                                                 $flag1= Yii::$app->mailer->compose( ['html' =>'userNotification-html'],
    [
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>$doc,'date'=>date("Y-m-d H:i:s")
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$recipient])
->setSubject('ERP Notification')
->send();   
                                            }
                                            
//=============================================end notification================================================================================      

  
    }
 }


    
    
  
//----------------------------------------if all went  well---------------------------------------------------
if($approved){

  Yii::$app->db->createCommand()
                      ->update('erp_travel_clearance_flow_recipients', ['status' =>'done',], ['id' =>$r1[0]['id']])
                      ->execute();
  
  
  $msg="TravelClearance Approved " ; 
 
 
 
 if($forwarded) {
  
  Yii::$app->db->createCommand()
                      ->update('erp_travel_clearance_flow_recipients', ['is_forwarded' =>1,], ['id' =>$r1[0]['id']])
                      ->execute();
                      
  $msg.=" & forwarded for further processing" ;    
 }
 
 
  Yii::$app->session->setFlash('success', $msg);
      
}else{
    
     Yii::$app->session->setFlash('failure',"Travel Clearance could not be Approved or forwarded !");
   
}

return $this->render('pending');

   
}

   }
}
