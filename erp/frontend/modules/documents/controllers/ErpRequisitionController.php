<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpRequisition;
use common\models\ErpRequisitionSearch;
use common\models\ErpRequisitionItems;
use common\models\ErpRequisitionAttachement;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Model;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\ErpRequisitionFlowRecipients;
use common\models\ErpRequisitionFlow;
use common\models\ErpRequisitionApproval;
use common\models\ErpRequisitionApprovalFlow;
use common\models\User;
use common\models\ErpMemo;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\web\UploadedFile;
use common\models\UserHelper;
/**
 * ErpRequisitionController implements the CRUD actions for ErpRequisition model.
 */
class ErpRequisitionController extends Controller
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
    
    public function actionTest(){
  
 
$query = ErpRequisitionApprovalFlow::find()->alias('main');
$subQuery = ErpRequisitionApprovalFlow::find()->alias('sub')
                                               ->select([new \yii\db\Expression('MAX(id) AS id'),'pr_id'])
                                               ->where(['sub.approver'=>62,'sub.status'=>'pending'])
                                               ->groupBy('pr_id');

   

   
    
   $rows= $query->innerJoin(['m' => $subQuery], 'm.id = main.id ')->all();
    
  var_dump( $rows);
   
    }

    /**
     * Lists all ErpRequisition models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        return $this->render('index');
    }
      public function actionMyRequisition()
    {
        
        return $this->render('my-requisition');
    }
    
       public function actionDone($id)
    {
         $user=Yii::$app->user->identity->user_id;
 
 if(!empty($id)) {
   
   Yii::$app->db->createCommand()
                      ->update('erp_requisition_approval_flow', ['status' =>'completed'], ['pr_id' =>$id,'approver'=>$user,'status' =>'pending'])
                      ->execute();  
                  Yii::$app->session->setFlash('success',"Requistion has been succesfully archived");    
 }
       return $this->redirect(['pending']);
    }
    
            public function actionDocTracking($id){

 if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('tracking2',['id'=>$id]);
     
     
         }
         else{
             
              return $this->render('tracking2',['id'=>$id]);
         }

   
    
    }

    /**
     * Displays a single ErpRequisition model.
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
        $url = "css/kv-mpdf-bootstrap.min.css";
          $stylesheet = file_get_contents($url);
          
          $url1 = "css/mpdf.css";
          $stylesheet1 = file_get_contents($url1);
           
          //$url2 = "css/prince-bootstrap-grid-fix.css";
         // $stylesheet2 = file_get_contents($url2);
          
        $mpdf = new \Mpdf\Mpdf(['format' =>'A4']);
        //----------------------------add bootsrap classes---------------------------
       $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
       //------------------------bootsr grid system---------------------------------
        $mpdf->WriteHTML($stylesheet1, \Mpdf\HTMLParserMode::HEADER_CSS);
       //---------------------make us eof font awesome----------------------------
       $mpdf->WriteHTML('.fa { font-family: fontawesome;}',1);
        //-----------------prevent body overlapping footer-----------------------------------------     
         
         $mpdf->setAutoBottomMargin = 'stretch';
         
     //------------------fix image not showing---------------------------------------------------    
         //$mpdf->showImageErrors = true;
         $mpdf->curlAllowUnsafeSslRequests = true;
       //-----------------sett footer------------------------------
        $mpdf->SetHTMLFooter('<img src="img/footer.png"/>');
        $mpdf->SetCompression(false);
        $mpdf->autoPageBreak = true;
         $mpdf->WriteHTML($this->renderPartial('view2', [
            'model' => $this->findModel($id),]));
       $content= $mpdf->Output();
       return $content;
        exit;
    }
        public function actionViewPdf($id)
    {
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('viewer',[ 'model' => $this->findModel($id)]); 
        }else{
            
             return $this->render('viewer',[ 'model' => $this->findModel($id)]);
        }
        
      
    }
    
    
   public function actionAssetsCode($id){
    
    $model=$this->findModel($id);
    $modelsRequisitionItems=$model->items;
    
    if(isset($_POST['ErpRequisitionItems'])){
        
       $data=$_POST['ErpRequisitionItems'];
       
       if(!empty($data)){
           
         foreach($data as $i=>$item){
             
          
            $itemModel=ErpRequisitionItems::find()->where(['id'=>$item['id']])->One();
            
            if($itemModel!=nulll){
                
              $itemModel->badget_code=$item['badget_code']; 
               
             if(!$flag=$itemModel->save(false)){
                  
               Yii::$app->session->setFlash('error',Html::errorSummary($itemModel)); 
              
               return $this->render('_assets-code',[ 'modelsRequisitionItems' =>$modelsRequisitionItems]);
               
                
            }
            
                
            }
          
         }  
          }
       
       if($flag){
         
         Yii::$app->session->setFlash('success',"Assets Code Added !");   
           
       } 
       
       return $this->redirect(['pending']);
    }
    
    if(Yii::$app->request->isAjax){
        
       return $this->renderAjax('_assets-code',[ 'modelsRequisitionItems' =>$modelsRequisitionItems]);   
    }
    
    return $this->render('_assets-code',[ 'modelsRequisitionItems' =>$modelsRequisitionItems]);
   
        
        
    }
    
    
public function actionTestUser(){
    
  $user=UserHelper::getPosition(1);
  
  var_dump($user);
    
}    
    
    
public  function actionNoLPo(){
  
  $q44=" SELECT pr.* FROM erp_requisition as pr where pr.approve_status='approved' 
  and id NOT IN (select r.request_id from erp_lpo_request as r where pr.id=r.request_id and r.type='PR' and r.status NOT IN ('drafting' ,'Returned'))";
  $com44 = Yii::$app->db->createCommand($q44);
  $rows = $com44->queryall();
  
  foreach( $rows as $row){
   
   
   if(!empty($row)){
       
     $data[]=['id' => $row['id'], 'text' =>$row['requisition_code']." / ".$row['title']];    
       
   }
  } 
 
  return json_encode($data); 
           
}
    
        
     public function actionFetchTab()
    {
    $step_number = $_REQUEST["step_number"];
    
    $model=new ErpRequisition();
   
    if(isset($_GET['active-step'])){
        
        $step_number=$_GET['active-step']; 
    }
    
    if(isset($_GET['pr_id'])){
     
     $model=ErpRequisition::find()->where(['id'=>$_GET['pr_id']])->one() ;
     
     if($model!=null){
         
       
           if($step_number==0){
           
             
      $memo =ErpMemo::find()->where(['id' =>$model->reference_memo])->one();
    
        
          if($memo!=null){
            
          return $this->renderAjax('page-viewer1', [
         'model' => $memo,
         
    ]);
        
         
        }else{
            
            
            return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Memo Found!
              
               </div>';
        }
       
       
           }
    //----------------end step 0     
           
       
     if($step_number==1){
           
      return $this->renderAjax('page-viewer2', [
         'model' => $model,
         
    ]);
         
        }
        
       
       if($step_number==2)
          {
           
             
    $query = ErpRequisitionAttachement::find()->where(['pr_id' =>$model->id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
            
          return $this->renderAjax('page-viewer3', [
         'models' => $models,
         'pages' => $pages,
        'step'=>$step_number,
        'container'=>$step_number+1
    ]);
        
         
        }else{
            
            
            return   '<div class="alert alert-warning alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Attachment(s) Found!
              
               </div>';
        }
       
       
      
         
     }   
        
        
        
       
     }else{
         
         echo 'No Purchase Requisition Found !';
     }
       
          
    }else{
        
      return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Purchase Requisition ID Found!
              
               </div>';
    }
   
    }
   
  //---------------------------------------------get req form------------------------------------------- 
   public function actionViewFormPdf(){
      
       $model=ErpRequisition::find()->where(['id'=>$_GET['pr_id']])->one() ; 
       
       if($model!=null){
          
       return $this->renderAjax('page-viewer2', [
         'model' => $model,
         
    ]);  
      
       }else{
         return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Purchase Requisition  Form Found!
              
               </div>';  
           
       }
      
   }
   
   //--------------------------requisition attach------------------------------------
   public function actionViewAttachements(){
    
             
    $query = ErpRequisitionAttachement::find()->where(['pr_id' =>$_GET['pr_id']]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
            
          return $this->renderAjax('page-viewer3', [
         'models' => $models,
         'pages' => $pages,
        'step'=>$step_number,
        'container'=>$step_number+1
    ]);
        
         
        }else{
            
            
            return   '<div class="alert alert-warning alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Attachment(s) Found!
              
               </div>';
        }
       
       
      
      
   }
   //---------------------------requisition memo----------------------------------------
   
  function actionViewMemo(){
      
      $model=ErpRequisition::find()->where(['id'=>$_GET['pr_id']])->one() ;
     
     $memo =ErpMemo::find()->where(['id' =>$model->reference_memo])->one();
    
        
          if($memo!=null){
            
          return $this->renderAjax('page-viewer1', [
         'model' => $memo,
         
    ]);
        
         
        }else{
            
            
            return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Memo Found!
              
               </div>';
        }
        
     
  }  
    /**
     * Creates a new ErpRequisition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate1()
    {
      return $this->redirect(['erp-memo/categ-pr']);
      
    }
   
public function  actionDrafts1(){
    
    return $this->render('drafts');  
}




public function actionRequisitionApproveAction(){
   
   
    if(isset($_POST['ErpRequisition'])){
     
     $action=$_POST['ErpRequisition']['action'];
     $remark=$_POST['ErpRequisition']['remark'];
     $recipients=$_POST['ErpRequisition']['recipients_names'];
     $id=$_POST['ErpRequisition']['id'];
     $user=Yii::$app->user->identity->user_id;
    
      
    //---------------------------------get MD------------------------------------- 
     $q=" SELECT pp.person_id from erp_org_positions as p left join erp_org_positions as p1 on p1.id=p.report_to 
     inner join erp_persons_in_position as pp on pp.position_id=p.id where p.report_to is NULL";
    $command = Yii::$app->db->createCommand($q);
    $r_MD = $command->queryOne();
    
    //------------------------------------------find req-----------------------------------------
     $req=ErpRequisition::find()->where(['id'=>$id])->One();
    //---------------------------------------get flow----------------------------------------------
     $req_flow=ErpRequisitionFlow::find()->where(['requisition'=>$id])->One();
     
      
   //-------------------------------------get user last pending request-------------------- 
     $q1=" SELECT r.*  FROM erp_requisition_flow_recipients as r  where
     r.flow_id={$req_flow->id} and r.recipient={$user} and r.status='processing' order by r.timestamp desc ";
    $command = Yii::$app->db->createCommand($q1);
    $r1 = $command->queryAll(); 
    
   //--------------------------------check if no other received at the same timestamp------------------------------------
   //---------------------------------------approve------------------------------------------------------------------
    $approval=new ErpRequisitionApproval();
    $approval->requisition_id=$id;
    $approval->approved_by=$r1[0]['recipient'];
    $approval->approval_status="approved";
    $approval->remark=$remark;
    $approved=$approval->save(false);
    
    
    

    if($r1[0]['recipient']==$r_MD['person_id']){
    
    
    //-------------------------------------------------------requisition level approval-----------------------------  
     $approved=  Yii::$app->db->createCommand()
                      ->update('erp_requisition', ['approve_status' =>'approved'], ['id'=>$id])
                      ->execute();
                     
     
    }
  
  
  
 
 
 //================================forwared to next level-==================================================
 if(!empty($recipients)){
 foreach($recipients as $key=>$value){
   
     
    $recipientModel=new ErpRequisitionFlowRecipients();
    $recipientModel->flow_id=$req_flow->id;
    $recipientModel->recipient=$value;
    $recipientModel->sender=$user;
    //$recipientModel->remark =$remark;
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
                                            
                                            
                                            if($flag){
                                                
                                                 $flag1= Yii::$app->mailer->compose( ['html' =>'userNotification-html'],
    [
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>'Requisition','date'=>date("Y-m-d H:i:s")
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$recipient])
->setSubject('ERP Notification')
//->setTextBody('You Can Change Login Password After Sign in')
->send();   
                                            }
                                            
//=============================================end notification================================================================================ 
   

  
    }
 }


    
    
  
//----------------------------------------if all went  well---------------------------------------------------
if($approved){

  $msg="Requisition Approved " ; 
 
 
 
 if($forwarded) {
     
  $msg.=" & forwarded for further processing" ;    
 }
 
 
  Yii::$app->session->setFlash('success', $msg);
      
}else{
    
     Yii::$app->session->setFlash('failure',"Requisition could not be Approved or forwarded !");
   
}

Yii::$app->db->createCommand()
                      ->update('erp_requisition_flow_recipients', ['status' =>'done',], ['id' =>$r1[0]['id']])
                      ->execute();
return $this->redirect(['pending']);

   
}

   }
   //-------------------------------pending requisitions-------------------------------------------------------------------
    public function actionPending(){
        
      return $this->render('pending');  
    }
    
     //-------------------------------my requisitions-------------------------------------------------------------------
    public function actionMyRequisitions(){
        
      return $this->render('my-requisitions');  
    }
   
    public function actionRequestForLpo($id){
        return $this->render('request-for-lpo', [
            'model' => $this->findModel($id),
        ]); 
    
    }
  //-------------------------------approved requisitions-------------------------------------------------------------------
    public function actionApproved(){
        
      return $this->render('approved');  
    }
    /**
     * Updates an existing ErpRequisition model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsRequisitionItems =ErpRequisitionItems::find()->where(['requisition_id'=>$model->id])->all();
        $model1=ErpMemo::find()->where(['id'=>$model->reference_memo])->One();
        if($model1==null){
            $model1=new ErpMemo();
        }
        $model2 = new ErpRequisitionAttachement();
       
        if(Yii::$app->request->post()){
            
           $data=$_POST['ErpRequisition'];
           $model->attributes=$data;
        
          
           
             if($flag=$model->save(false)){
                 
              
                  $oldIDs = ArrayHelper::map($modelsRequisitionItems, 'id', 'id');
                  $modelsRequisitionItems= Model::createMultiple(ErpRequisitionItems::classname(), $modelsRequisitionItems);
                  
                  Model::loadMultiple($modelsRequisitionItems , Yii::$app->request->post()); 
                  $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsRequisitionItems, 'id', 'id')));
          
                 
                 if(!empty($modelsRequisitionItems)){
                 
                  if (!empty($deletedIDs)) {
                        ErpRequisitionItems::deleteAll(['id' => $deletedIDs]);
                    }
                   
                 
                  $transaction = \Yii::$app->db->beginTransaction();
                try {
                    
                    
                       
                       
                         foreach ($modelsRequisitionItems as $modelItem) {
                           
                          
                            if($modelItem!=new ErpRequisitionItems){
                                
                                  $modelItem->requisition_id =$model->id ;
                                 $modelItem->user=Yii::$app->user->identity->user_id;
                            
                            if (! ($flag = $modelItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            }
                           
                          
                        }
                       
                           
                           
                       
                 
                    if ($flag) {
                        $transaction->commit();
                       
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                } 
                
                 }
                
      //----------------------------------------requistion attachement------------------------------
       if(isset($_POST['ErpRequisitionAttachement'])){
               
              $post= $_POST['ErpRequisitionAttachement'];
              $model2->attach_files = UploadedFile::getInstances($model2, 'attach_files');
                   
                    if(!empty( $model2->attach_files)){
                 
                 $files=$model2->attach_files;
                 
                
                 
                 foreach($files as $file){
                     
                
                 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_attach='uploads/pr/attachements/'. $unification.".{$ext}";
   
   
   
   
    
   //--------------------------delete existing attachements------------------------------------------------------

   /* $models3=ErpRequisitionAttachement::find()->where(['pr_id'=>$model->id])->all();
    
    if(!empty($model3)){
        
        foreach($model3 as $m){
            
            unlink($m->attach_upload);
            
        }
    }
     
     $connection = Yii::$app->getDb();
                       $query = $connection->createCommand('DELETE FROM erp_requisition_attachement  WHERE pr_id=:id');
                       $query->bindParam(':id', $id);
                       $id =$model->id;
                       $query->execute();*/
                       
                       
   
                 $attModel=new ErpRequisitionAttachement();
                 $attModel->attach_name=$file->name;
                 $attModel->created_by=Yii::$app->user->identity->user_id;
                 $attModel->pr_id=$model->id;
                 $attModel->attach_upload=$path_to_attach ;
                  
                  if(! $flag=$attModel->save(false)){
                     
               Yii::$app->session->setFlash('failure',Html::errorSummary($attModel));  
                   
         
                                return $this->render('_form', ['model'=>$model,'model1'=>$model1, 'model2'=>$model2, 
                                'modelsRequisitionItems' => (empty($modelsRequisitionItems)) ? [new ErpRequisitionItems] : $modelsRequisitionItems,'isAjax'=>false]);
                   
                  }  
                 
               $file->saveAs( $path_to_attach);   
                     
                 }
                
                
                 
             }
            
               
        
             
            }    
             
              if($model->approve_status!='drafting'){
                  
                   Yii::$app->session->setFlash('success',"Requisition Updated Successfully!"); 
                  return $this->redirect(['pending']);  
                  
              }else{
                  
               Yii::$app->session->setFlash('success',"Requisition Updated Successfully!"); 
                  return $this->redirect(['drafts']);
                  
              }  
                
                
                 
             }
       //-------------------------------END UPDATE---------------------------------------------------------------      
             else{
                 
                 Yii::$app->session->setFlash('failure',"Requisition Could Not be Updated!");
                 
                 
             }
        
                        }    

        $isAjax=false;
        
        

        if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('_form', ['model'=>$model,'model1'=>$model1,'model2'=>$model2, 'modelsRequisitionItems' => (empty($modelsRequisitionItems)) ? [new ErpRequisitionItems] : $modelsRequisitionItems,'isAjax'=>true]);
     
     
         }else{
            return $this->render('_form', ['model'=>$model,'model1'=>$model1,'model2'=>$model2,  'modelsRequisitionItems' => (empty($modelsRequisitionItems)) ? [new ErpRequisitionItems] : $modelsRequisitionItems,'isAjax'=>false]);
     
         }


    }

    /**
     * Deletes an existing ErpRequisition model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
       $flag= $this->findModel($id)->delete();
       if($flag){
           
           return true;
       }
       else{return false;}

       
    }

    /**
     * Finds the ErpRequisition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpRequisition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpRequisition::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
