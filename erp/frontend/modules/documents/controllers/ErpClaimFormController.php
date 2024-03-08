<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpClaimForm;
use common\models\ErpClaimFormFlow;
use common\models\ErpClaimFormFlowRecipients;
use common\models\ErpClaimFormApproval;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ErpClaimFormDetails;
use common\models\User;
use yii\data\Pagination;
/**
 * ErpClaimFormController implements the CRUD actions for ErpClaimForm model.
 */
class ErpClaimFormController extends Controller
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
     * Lists all ErpClaimForm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ErpClaimForm::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpClaimForm model.
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
           public function actionPending()
    {
          return $this->render('pending');
    }
    
        public function actionDocTracking($id){

 if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('doc-tracking',['id'=>$id]);
     
     
         }
         else{
             
              return $this->render('doc-tracking',['id'=>$id]);
         }

   
    
    }
              public function actionApproved()
    {
          return $this->render('approved');
    }
             public function actionDraft()
    {
          return $this->render('draft');
    }
           public function actionView2($id)
    {
        return $this->render('view2', [
            'model' => $this->findModel($id),
        ]);
    }
     public function actionPdfData($id)
    {
           
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
        // $mpdf->SetWatermarkImage('img/watermark.png',0.1, array(150, 145), array(-7, 161));
       $mpdf->showWatermarkImage = true;
         $mpdf->WriteHTML($this->renderPartial('view2', [
            'model' => $this->findModel($id),]));
       $content= $mpdf->Output();
       return $content;
        exit;
    }
    
    
    public function actionViewPdf($id)
    {
       return $this->renderAjax('pdf-viewer',['id' => $id]);
    }
    
    public function actionClaimsViewPdf($tr_id){
        
   $query = ErpClaimForm::find()->where(['tr_id' =>$tr_id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
            
          return $this->renderAjax('page-viewer1', [
         'models' => $models,
         'pages' => $pages,
         
    ]);
      
      
          }  
    
    }
    /**
     * Creates a new ErpClaimForm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
         $model = new ErpClaimForm();
         $model2 = new ErpClaimFormDetails();
           
        if (Yii::$app->request->post()) 
        {
           $model->attributes=$_POST['ErpClaimForm'];  
           $model->created_by=Yii::$app->user->identity->user_id;
           
            if(isset($_POST['ErpClaimForm']['tavel_clearance']))
            {
               
     $q22 =" SELECT a.employee FROM erp_travel_clearance as a where a.id=".$_POST['ErpClaimForm']['tavel_clearance']."";
     $command22 =Yii::$app->db->createCommand($q22);
     $row22= $command22->queryOne();
     $model->person=$row22['employee'];
     $model->tavel_clearance=$_POST['ErpClaimForm']['tavel_clearance'];
     $flag=$model->save(false);
            }else{
                
                if($model->save(false)){
                    
                    $model2->attributes=$_POST['ErpClaimFormDetails'];  
                    $model2->claim_form=$model->id;  
                    $flag=$model2->save(false);
                }
               
            }
           
            
             if($flag){
              
              
              
              
            Yii::$app->session->setFlash('success',"Claim Form Saved Successfully !");
           // return $this->redirect(['view','id'=>$model->id]);
            return $this->redirect(['draft']);
              
          }else{
             
              if(Yii::$app->request->isAjax){
              
              if(isset($_GET['t'])){
            Yii::$app->session->setFlash('failure',"Claim Form Could Not be created !");    
            return   $this->redirect(Url::to(['erp-travel-clearance/approved']));
            }
            
           }
           
            Yii::$app->session->setFlash('failure',"Claim Form Could Not be created !");
             return $this->redirect(['form','id'=>$model->id]);   
          }
            
        }
        
        if(Yii::$app->request->isAjax){
            
            if(isset($_GET['t'])){
                
               return $this->renderAjax('_form1', [
                 't' =>$_GET['t'],'model' => $model,
        ]); 
            }
            
        }
         
     
        return $this->render('create', [
            'model' => $model,'model2' => $model2,
        ]);
    }

    /**
     * Updates an existing ErpClaimForm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $q22 =" SELECT * FROM erp_claim_form_details as a where a.claim_form=".$model->id."";
        $command22 =Yii::$app->db->createCommand($q22);
        $row22= $command22->queryOne();
        if(!empty($row22))
        {
             $model2 = $this->findModel2($row22['id']);
        }else{
             $model2 =new ErpClaimFormDetails();
        }
        
        if (Yii::$app->request->post()) 
        {
           $model->attributes=$_POST['ErpClaimForm'];  
           $model->created_by=Yii::$app->user->identity->user_id;
           
            if(isset($_POST['ErpClaimForm']['tavel_clearance']))
            {
               
     $q22 =" SELECT a.employee FROM erp_travel_clearance as a where a.id=".$_POST['ErpClaimForm']['tavel_clearance']."";
     $command22 =Yii::$app->db->createCommand($q22);
     $row22= $command22->queryOne();
     $model->person=$row22['employee'];
     $model->tavel_clearance=$_POST['ErpClaimForm']['tavel_clearance'];
     $flag=$model->save(false);
            }else{
                
                if($model->save(false)){
                    
                    $model2->attributes=$_POST['ErpClaimFormDetails'];  
                    $model2->claim_form=$model->id;  
                    $flag=$model2->save(false);
                }
               
            }
           
            
             if($flag){
            Yii::$app->session->setFlash('success',"Claim Form Saved Successfully !");
            return $this->redirect(['pending']);
              
          }
            
        }

        return $this->render('update', [
            'model' => $model,   'model2' => $model2,
        ]);
    }

    /**
     * Deletes an existing ErpClaimForm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()){
            
            return true;
        }else{
            return false;
        }

      
    }


   /**
     * Finds the ErpClaimForm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpClaimForm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpClaimForm::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
      protected function findModel2($id)
    {
        if (($model2 = ErpClaimFormDetails::findOne($id)) !== null) {
            return $model2;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    

public function actionForwardAction(){
   
   
    if(isset($_POST['ErpClaimForm'])){

     $remark=$_POST['ErpClaimForm']['remark'];
     $recipients=$_POST['ErpClaimForm']['recipients_names'];
     $id=$_POST['ErpClaimForm']['id'];
     $user=Yii::$app->user->identity->user_id;
      
     $models=ErpClaimForm::find()->where(['id'=>$id])->All();
     foreach($models as $model)
     {
     $flow=ErpClaimFormFlow::find()->where(['claim_form'=>$model->id])->One(); 
     
     if($flow==null){
      
       if($model->created_by==$user){
         
          $flow=new ErpClaimFormFlow(); 
         $flow->claim_form=$model->id;
         $flow->creator=$model->created_by;
        $flow->save(false);
     }
     }
     
    $approval=new ErpClaimFormApproval();
    $approval->claim_form=$id;
    $approval->approved_by=$user;
    $approval->approval_status="approved";
    $approval->remark=$remark;
    $approved=$approval->save(false);
  
  
  
   


    
   
        
    
 //================================add recipients to the flow-==================================================
 if(!empty($recipients)){
 foreach($recipients as $key=>$value){
    $recipientModel=new ErpClaimFormFlowRecipients();
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
                                            $doc ="Claim form";
                                            
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
                      ->update('erp_claim_form', ['status' =>'processing'], ['id' =>$model->id])
                      ->execute();
}
}   
}
   

return $this->redirect(['draft']);
}

 
        
      //========================================================travel clearance memo========================================
public function actionApproveAction(){
   
   
    if(isset($_POST['ErpClaimForm'])){
     
     $action=$_POST['ErpClaimForm']['action'];
     $remark=$_POST['ErpClaimForm']['remark'];
     $recipients=$_POST['ErpClaimForm']['recipients_names'];
     $id=$_POST['ErpClaimForm']['id'];
     $user=Yii::$app->user->identity->user_id;
    
      
    //---------------------------------get MD------------------------------------- 
     $q=" SELECT pp.person_id from erp_org_positions as p left join erp_org_positions as p1 on p1.id=p.report_to 
     inner join erp_persons_in_position as pp on pp.position_id=p.id where p.position='Managing Director'";
    $command = Yii::$app->db->createCommand($q);
    $r_MD = $command->queryOne();
    
    //------------------------------------------find req-----------------------------------------
     $tc=ErpClaimForm::find()->where(['id'=>$id])->One();
    
    //---------------------------------------get flow----------------------------------------------
     $tc_flow=ErpClaimFormFlow::find()->where(['claim_form'=>$id])->One();
   
      
   //-------------------------------------get user last pending request-------------------- 
     $q1=" SELECT r.*  FROM erp_claim_form_flow_recipients as r  where
     r.flow_id={$tc_flow->id} and r.recipient={$user} and r.status='processing' order by r.timestamp desc ";
    $command = Yii::$app->db->createCommand($q1);
    $r1 = $command->queryAll(); 
  
   //--------------------------------check if no other received at the same timestamp------------------------------------
   //---------------------------------------approve------------------------------------------------------------------
    $approval=new ErpClaimFormApproval();
    $approval->claim_form=$id;
    $approval->approved_by=$r1[0]['recipient'];
    $approval->approval_status="approved";
    $approval->remark=$remark;
    $approved=$approval->save(false);
    
    
    

    if($r1[0]['recipient']==$r_MD['person_id']){
    
    
    //-------------------------------------------------------requisition level approval-----------------------------  
     $approved=  Yii::$app->db->createCommand()
                      ->update('erp_claim_form', ['status' =>'approved'], ['id'=>$id])
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
                      ->update('erp_claim_form', ['status' =>'approved'], ['id'=>$id])
                      ->execute();
                     
     
    }
    }
  
  
  
 
 
 //================================forwared to next level-==================================================
 if(!empty($recipients)){
 foreach($recipients as $key=>$value){
   
   
   //-----------------------make sure it is not sent back to the creator-----------------------------------
   
   if($value!=$tc->created_by){
       
    $recipientModel=new ErpClaimFormFlowRecipients();
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
                                            $doc ="Claim form";
                                            
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
 }


    
    
  
//----------------------------------------if all went  well---------------------------------------------------
if($approved){

  $msg="Claim Form Approved " ; 
 
 
 
 if($forwarded) {
     
  $msg.="  forwarded for further processing" ;    
 }
 
 
  Yii::$app->session->setFlash('success', $msg);
      
}else{
    
     Yii::$app->session->setFlash('failure',"Requisition could not be Approved or forwarded !");
   
}

Yii::$app->db->createCommand()
                      ->update('erp_claim_form_flow_recipients', ['status' =>'done',], ['id' =>$r1[0]['id']])
                      ->execute();
return $this->redirect(['pending']);

   
}

   }
}
