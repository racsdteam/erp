<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpLpoRequest;
use common\models\ErpLpo;
use common\models\ErpLpoRequestSearch;
use common\models\ErpLpoRequestSupportingDoc;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Model;
use yii\web\UploadedFile;
use common\models\ErpLpoRequestFlowRecipients;
use common\models\ErpLpoRequestFlow;
use yii\helpers\Url;
use iio\libmergepdf\Merger;
use iio\libmergepdf\Driver\TcpdiDriver;
use yii\db\Query;
use yii\helpers\Json;
use common\models\ErpLpoRequestApproval;
use common\models\ErpLpoRequestApprovalFlow;
use common\models\ErpLpoRequestComments;
use common\models\ErpTransmissionSlipComments;
use common\models\ErpTransmissionSlip;
use common\models\User;
use common\models\ErpRequisition;
use yii\data\Pagination;
use yii\filters\AccessControl;


/**
 * ErpLpoRequestController implements the CRUD actions for ErpLpoRequest model.
 */
class ErpLpoRequestController extends Controller
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
     * Lists all ErpLpoRequest models.
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->render('index');
    }
    
      public function actionTest()
    {
        var_dump(ErpLpoRequestFlow::currentApprover(1030));
        
    }
    
       public function actionMyRequisition()
    {
        
        return $this->render('my-requisition');
    }
    
      public function actionMyPurchaseOrders()
    {
        
        return $this->render('my-purchase-orders');
    }

public function actionDocTracking($id){

 if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('doc-tracking',['id'=>$id]);
     
     
         }
         else{
             
              return $this->render('doc-tracking',['id'=>$id]);
         }

   
    
    }
    /**
     * Displays a single ErpLpoRequest model.
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
  
  //------------------------------------view pdf single -------------------------------------  
     public function actionView1($id)
    {
         $model=ErpLpoRequest::find()->where(['id'=>$id])->one() ;
     
     if($model!=null){
         
       
          
           
          return $this->renderAjax('page-viewer1', [
         'model' => $model,
         
    ]);  
       
          
   
     }else{
         
         echo 'No Purchase Order Request Found !';
     }  
       
    }
    
    
 //-------------------view supporting docs single-------------------------------------------------
 
 public function actionView3($id){
     
           
    $query = ErpLpoRequestSupportingDoc::find()->where(['lpo_request' =>$id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
            
          return $this->renderAjax('page-viewer2', [
         'models' => $models,
         'pages' => $pages,
        'step'=>$step_number,
        'container'=>$step_number+1
    ]);
        
         
        }else{
            
            
            return   '<div class="alert alert-warning alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Supporting Doc(s) Found!
              
               </div>';
        }    
     
     
     
 }
    
     public function actionSupportDocs($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
 
 
 //-------------------------view pdf combined--------------------------------------------------------   
        public function actionViewPdf($id)
    {
        if(isset($_GET['status']) && $_GET['status']=='completed'){
           
           
 if (Yii::$app->request->isAjax) {
       
       
            return $this->renderAjax('viewer',[ 'model' => $this->findModel($id),'po'=>$_GET['po']]); 
     
     
         }
         else{
             
              return $this->render('viewer',[ 'model' => $this->findModel($id),'po'=>$_GET['po']]); 
         }
          
        }else{
            
       
            
             if (Yii::$app->request->isAjax) {
       
       
                   return $this->renderAjax('viewer',[ 'model' => $this->findModel($id),'initialPage'=>$_GET['initialPage']]);  
     
     
         }
         else{
             
                    return $this->render('viewer',[ 'model' => $this->findModel($id),'initialPage'=>$_GET['initialPage']]);  
         }
   
        }
       
      
    }
    
    
       public function actionView2($id)
    {
        return $this->render('view2', [
            'model' => $this->findModel($id),
        ]);
    }
           public function actionPdfData($id)
    {
        $url = "css/bootstrap.css";
          $stylesheet = file_get_contents($url);
           
          $url2 = "css/prince-bootstrap-grid-fix.css";
          $stylesheet2 = file_get_contents($url2);
        $mpdf = new \Mpdf\Mpdf();
        //----------------------------add bootsrap classes---------------------------
       $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
       //------------------------bootsr grid system---------------------------------
        $mpdf->WriteHTML($stylesheet2, \Mpdf\HTMLParserMode::HEADER_CSS);
        //--------------------------setting header-------------------------------------
          $mpdf->setAutoBottomMargin = 'stretch';
     //------------------fix image not showing---------------------------------------------------    
         //$mpdf->showImageErrors = true;
         $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->SetHTMLFooter('<img src="img/footer.png"/>');
         $mpdf->WriteHTML($this->renderPartial('view2', [
           'model' => $this->findModel($id)]));
       $content= $mpdf->Output();
       return $content;
        exit;
    }
    
       public function actionFetchTab()
    {
    $step_number = $_REQUEST["step_number"];
    
    $model=new ErpLpoRequest();
   
    if(isset($_GET['active-step'])){
        
        $step_number=$_GET['active-step']; 
    }
    
    if(isset($_GET['id'])){
     
     $model=ErpLpoRequest::find()->where(['id'=>$_GET['id']])->one() ;
     
     if($model!=null){
         
       
           if($step_number==3){
           
          return $this->renderAjax('page-viewer1', [
         'model' => $model,
         
    ]);  
       
           }
    //----------------end step 0     
   
        
       
       if($step_number==4)
          {
           
             
    $query = ErpLpoRequestSupportingDoc::find()->where(['lpo_request' =>$model->id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
            
          return $this->renderAjax('page-viewer2', [
         'models' => $models,
         'pages' => $pages,
         'step'=>$step_number,
        'container'=>$step_number+1
    ]);
        
         
        }else{
            
            
            return   '<div class="alert alert-warning alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Supporting Doc(s) Found!
              
               </div>';
        }
       
       
      
         
     }   
        
        
        
       
     }else{
         
         echo 'No Purchase Order Request Found !';
     }
       
          
    }else{
        
      return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Purchase Order Request ID Found!
              
               </div>';
    }
   
    }  
   
   
   public function actionDrafts(){
        
        return $this->render('drafts');
        
    }
     
    
     public function actionViewPdfSupportingDocs($id)
    {
       $pdf = new \LynX39\LaraPdfMerger\PdfManage; 
        $q = new Query;
                                               $q->select([
                                                   'support_doc.doc_upload',
                                                   
                                               ])->from('erp_lpo_request_supporting_doc as support_doc ')->where(['lpo_request' =>$id]);
                                   
                                               $command0 = $q->createCommand();
                                               $rows1= $command0->queryAll();
                                               
                                                
              foreach($rows1 as $row1)  {
                
                                                        $pdf->addPDF($row1['doc_upload'], 'all');
                                                        //$merger->addFile($rows3[0]['attach_upload']);
                                                       //$pdf->addPDF($rows3[0]['attach_upload'], 'all');
           
              }
              
              $createdPdf = $pdf->merge();
              
              return $createdPdf;
               exit;
    } 
    
    
    
  

//--------------------------------------------approved requests-------------------------------------------------------

public function actionApproved(){
    
    
     return  $this->render('approved'); 
    
    
}

 public function actionDone($id)
   
    {
    
    $user=Yii::$app->user->identity->user_id;
   
    //--------------change status when LPO created-----otherwise status remains processing---------------
     $model=$this->findModel($id);
     
     $modelSlip=ErpLpo::find()->where(['lpo_request_id'=>$model->id])->One();
     
     if($modelSlip!=null){
         
         $model->status='processed';
         $model->save(false);
        }
  
  Yii::$app->db->createCommand()
                      ->update('erp_lpo_request_approval_flow', ['status' =>'archived'], ['lpo_request' =>$id,'approver'=>$user,'status' =>'pending'])
                      ->execute();  
                  Yii::$app->session->setFlash('success',"LPO Request has been succesfully archived");    
 
       return $this->redirect(['pending-requests']);
    }

public function actionCompleted(){
    
    
     return  $this->render('completed'); 
    
    
}


    /**
     * Creates a new ErpLpoRequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //-------------------------main--------------------------------------------------
        $model = new ErpLpoRequest();
        $modelSupportDocs = new ErpLpoRequestSupportingDoc;
        
        //--------------------------transmission slip-------------------------------------
        $modelSlip=new ErpTransmissionSlip();
        $model2=new ErpTransmissionSlipComments();
        
        $user=Yii::$app->user->identity->user_id;
        
        $params['request_id']=$_GET['request_id'];
        $params['request_type']=$_GET['type'];
       
        
        
        
        if(Yii::$app->request->post()){
            
            
           
            
            if(isset($_POST['ErpLpoRequest'])){
                
                $model->attributes=$_POST['ErpLpoRequest']; 
                $model->requested_by=$user;
                
              
                 
                 
                 if($flag=$model->save(false)){
                     
 //-----------------------------------------------supporting docs--------------------------------------
 
   if(isset($_POST['ErpLpoRequestSupportingDoc'])){
               
             
             
          $modelSupportDocs->doc_uploaded_files= UploadedFile::getInstances($modelSupportDocs, 'doc_uploaded_files');
          $files=$modelSupportDocs->doc_uploaded_files;   
             
             if(!empty($files)){
                 foreach($files as $file){
$exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_attach='uploads/lpo-r/attachements/'. $unification.".{$ext}";
    
    $modelSupportDocs = new ErpLpoRequestSupportingDoc;
    $modelSupportDocs->doc_upload=$path_to_attach;
    $modelSupportDocs->lpo_request=$model->id;
    $modelSupportDocs->doc_name=$file->name;
    $modelSupportDocs->uploaded_by=$user;
   
                  if(! $flag=$modelSupportDocs->save(false)){
                     
                     break;
                     Yii::$app->session->setFlash('failure',Html::errorSummary($modelSupportDocs));  
                return   $this->render('_form', ['model'=>$model,'model1'=>$modelSlip,
               'model2'=>$model2,'model3'=>$model3, 'modelSupportDocs' =>$modelSupportDocs,'isAjax'=>false,'params'=>$params]);
                   
                  }  
                 
               $file->saveAs( $path_to_attach);   
                     
                 }
                 
             }
             
            
           }
 //------------------------------------transimission slip------------------------------------------------
  if(isset($_POST['ErpTransmissionSlip'])){
   
   
     $modelSlip->attributes=$_POST['ErpTransmissionSlip'];
     $modelSlip->type_id=$model->id;
     $modelSlip->created_by=$user;
         
         if(!$flag=$modelSlip->save(false)){
             
           Yii::$app->session->setFlash('failure',Html::errorSummary($modelSlip));  
          return   $this->render('_form', ['model'=>$model,'model1'=>$modelSlip,
               'model2'=>$model2,'model3'=>$model3, 'modelSupportDocs' =>$modelSupportDocs,'isAjax'=>false,'params'=>$params]); 
         }   
  }
         
         
 
 //-----------------------------------Transmission Slip----------------------------------------------------------- 
      if(isset($_POST['ErpTransmissionSlipComments'])){
          
         $model2->attributes=$_POST['ErpTransmissionSlipComments'];
         $model2->trans_slip=$modelSlip->id;
         $model2->author=$user;
        if(! $flag=$model2->save(false)){
            
           Yii::$app->session->setFlash('failure',Html::errorSummary($model2));  
          
           return   $this->render('_form', ['model'=>$model,'model1'=>$modelSlip,
               'model2'=>$model2,'model3'=>$model3, 'modelSupportDocs' =>$modelSupportDocs,'isAjax'=>false,'params'=>$params]);
        }
          
      }
        
   
                     
                 }else{
                     
                     Yii::$app->session->setFlash('failure',Html::errorSummary($model));  
          
          return   $this->render('_form', ['model'=>$model,'model1'=>$modelSlip,
               'model2'=>$model2,'model3'=>$model3, 'modelSupportDocs' =>$modelSupportDocs,'isAjax'=>false,'params'=>$params]);
                 }
                
            }
            
         
             if($flag){
             Yii::$app->session->setFlash('success',"LPO Request Saved Successfully!");                    
             return  $this->redirect(['drafts']);                 

                            }  
            
            
        }

        $isAjax=false;
        
        if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('_form', ['model'=>$model,'model1'=>$modelSlip,
             'model2'=>$model2,'model3'=>$model3,'modelSupportDocs' =>$modelSupportDocs,'isAjax'=>true,'params'=>$params]);
     
     
         }else{
            
                return   $this->render('_form', ['model'=>$model,'model1'=>$modelSlip,
               'model2'=>$model2,'model3'=>$model3, 'modelSupportDocs' =>$modelSupportDocs,'isAjax'=>false,'params'=>$params]);
           
     
         }
    }

 
 

 public function actionPendingRequests()
    {
        
       return $this->render('pending');  
        
    }
 
 
 public function actionMyRequests()
    {
        
       return $this->render('my-requests');  
        
    }
 
 //---------------------------------approve & forward------------------------------------------------------------------   
  

public function actionLPOApprove(){
   
   
    if(isset($_POST['ErpLpoRequest'])){
     
     $action=$_POST['ErpLpoRequest']['action'];
     $remark=$_POST['ErpLpoRequest']['remark'];
     $recipients=$_POST['ErpLpoRequest']['recipients_names'];
     $id=$_POST['ErpLpoRequest']['id'];
     $user=Yii::$app->user->identity->user_id;
    
   
    
    //------------------------------------------find req-----------------------------------------
     $lpo=ErpLpoRequest::find()->where(['id'=>$id])->One();
    //---------------------------------------get flow----------------------------------------------
     $lpo_flow=ErpLpoRequestFlow::find()->where(['lpo_request'=>$id])->One();
     
      
   //-------------------------------------get user last pending request-------------------- 
     $q1=" SELECT r.*  FROM erp_lpo_request_flow_recipients as r  where
     r.flow_id={$lpo_flow->id} and r.recipient={$user} and r.status='processing' order by r.timestamp desc ";
    $command = Yii::$app->db->createCommand($q1);
    $r1 = $command->queryAll(); 
    
   //--------------------------------check if no other received at the same timestamp------------------------------------
   //---------------------------------------approve------------------------------------------------------------------
    $approval=new ErpLpoRequestApproval();
    $approval->lpo_request=$id;
    $approval->approved_by=$user;
    $approval->approval_status="approved";
    //$approval->remark=$remark;
    $approved=$approval->save(false);
    
    //-------------------------save coment------------------------------------
         $comment=new ErpLpoRequestComments();
         $comment->lpo_request=$lpo->id;
         $comment->author=$user;
         $comment->comment=$remark;  
         $comment->save(false);
    
     //---------------------------------get DAF------------------------------------- 
     $q=" SELECT pp.person_id from erp_org_positions as p left join erp_org_positions as p1 on p1.id=p.report_to 
     inner join erp_persons_in_position as pp on pp.position_id=p.id where p.position='Director Finance Unit'";
    $command = Yii::$app->db->createCommand($q);
    $r_DAF = $command->queryOne();
    

    if($user==$r_DAF['person_id']){
    
    
    //-------------------------------------------------------requisition level approval-----------------------------  
     $approved=  Yii::$app->db->createCommand()
                      ->update('erp_lpo_request', ['status' =>'approved'], ['id'=>$id])
                      ->execute();
                     
     
    }
  
  
  
 
 
 //================================forwared to next level-==================================================
 if(!empty($recipients)){
 foreach($recipients as $key=>$value){
   
   
   //-----------------------make sure it is not sent back to the creator-----------------------------------
   
  
       
    $recipientModel=new ErpLpoRequestFlowRecipients();
    $recipientModel->flow_id=$lpo_flow->id;
    $recipientModel->recipient=$value;
    $recipientModel->sender=$user;
    //$recipientModel->remark =$remark;
    $forwarded= $recipientModel->save(false);
   
   
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
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>'LPO Request','date'=>date("Y-m-d H:i:s")
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$recipient])
->setSubject('ERP Notification')
//->setTextBody('You Can Change Login Password After Sign in')
->send();   
                                            }
   

  
    }
 }


    
    
  
//----------------------------------------if all went  well---------------------------------------------------
if($approved){

  $done=  Yii::$app->db->createCommand()
                      ->update('erp_lpo_request_flow_recipients', ['status' =>'done'], ['id'=> $r1[0]['id']])
                      ->execute();
  
  
  $msg="LPO Approved " ; 
 
 
 
 if($forwarded) {
     
  $msg.=" & forwarded for further processing" ;    
 }
 
 
  Yii::$app->session->setFlash('success', $msg);
      
}else{
    
     Yii::$app->session->setFlash('failure',"LPO could not be Approved or forwarded !");
   
}

Yii::$app->db->createCommand()
                      ->update('erp_lpo_request_flow_recipients', ['status' =>'done',], ['id' =>$r1[0]['id']])
                      ->execute();
return $this->redirect(['pending-requests']);

   
}

   }

    /**
     * Updates an existing ErpLpoRequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idsu
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
          $model = $this->findModel($id);
          //--------------------------transmission slip-------------------------------------
          $modelSlip=$model->transSlip;
          $modelSupportDocs = new ErpLpoRequestSupportingDoc();
          $user=Yii::$app->user->identity->user_id;
         
         $params=array();
         $params['request_id']=$_GET['request_id'];
         $params['request_type']=$_GET['type'];
        
        
         
         
         
         if($modelSlip==null){
             $modelSlip=new ErpTransmissionSlip();
         }
        
         $model2=ErpTransmissionSlipComments::find()->where(['trans_slip'=>$modelSlip->id,'author'=>$modelSlip->created_by])->one() ;
         
         if($model2==null){
             
             $model2=new ErpTransmissionSlipComments();
         }
         
     
        
        if(Yii::$app->request->post()){
            
            
           
            
            if(isset($_POST['ErpLpoRequest'])){
                
                $model->attributes=$_POST['ErpLpoRequest']; 
                
                if($flag=$model->save(false)){
                     
 //-----------------------------------------------supporting docs--------------------------------------
 
   if(isset($_POST['ErpLpoRequestSupportingDoc'])){
               
             
             
          $modelSupportDocs->doc_uploaded_files= UploadedFile::getInstances($modelSupportDocs, 'doc_uploaded_files');
          $files=$modelSupportDocs->doc_uploaded_files;   
             
             if(!empty($files)){
                 foreach($files as $file){
$exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_attach='uploads/lpo-r/attachements/'. $unification.".{$ext}";
    
    $modelSupportDocs = new ErpLpoRequestSupportingDoc;
    $modelSupportDocs->doc_upload=$path_to_attach;
    $modelSupportDocs->lpo_request=$model->id;
    $modelSupportDocs->doc_name=$file->name;
    $modelSupportDocs->uploaded_by=$user;
   
                  if(! $flag=$modelSupportDocs->save(false)){
                     
                     Yii::$app->session->setFlash('failure',Html::errorSummary($modelSupportDocs));  
          
           return   $this->render('_form', ['model'=>$model,'model1'=>$modelSlip,
             'model2'=>$model2,'request_id'=>$_GET['request_id'], 'modelSupportDocs' =>$modelSupportDocs,'isAjax'=>false,'params'=>$params]);
                   
                  }  
                 
               $file->saveAs( $path_to_attach);   
                     
                 }
                 
             }
             
            
           }
 //------------------------------------transimission slip------------------------------------------------
  if(isset($_POST['ErpTransmissionSlip'])){
   
   
     $modelSlip->attributes=$_POST['ErpTransmissionSlip'];
     
         
         if(!$flag=$modelSlip->save(false)){
             
           Yii::$app->session->setFlash('failure',Html::errorSummary($modelSlip));  
          
           return   $this->render('_form', ['model'=>$model,'model1'=>$modelSlip,
             'model2'=>$model2,'request_id'=>$_GET['request_id'], 'modelSupportDocs' =>$modelSupportDocs,'isAjax'=>false,'params'=>$params]);   
         }   
  }
         
         
 
 //-----------------------------------Transmission Slip----------------------------------------------------------- 
      if(isset($_POST['ErpTransmissionSlipComments'])){
          
         $model2->attributes=$_POST['ErpTransmissionSlipComments'];
         
        if(! $flag=$model2->save(false)){
            
           Yii::$app->session->setFlash('failure',Html::errorSummary($model2));  
          
           return   $this->render('_form', ['model'=>$model,'model1'=>$modelSlip,
             'model2'=>$model2,'request_id'=>$_GET['request_id'], 'modelSupportDocs' =>$modelSupportDocs,'isAjax'=>false,'params'=>$params]);  
        }
          
      }
        
   
                     
                 }else{
                     
                     Yii::$app->session->setFlash('failure',Html::errorSummary($model));  
          
           return   $this->render('_form', ['model'=>$model,'model1'=>$modelSlip,
             'model2'=>$model2,'request_id'=>$_GET['request_id'], 'modelSupportDocs' =>$modelSupportDocs,'isAjax'=>false,'params'=>$params]);
                 }
                
            }
            
         
             if($flag){
               Yii::$app->session->setFlash('success',"LPO Request Updated  Successfully!");      
              
              
              if($model->status=='drafting'){
                  
                 
                             
             return  $this->redirect(['drafts']);    
              } else{
                  
                   
                              
             return  $this->redirect(['pending-requests']);  
              }  
             
                           

                            }  
            
            
        }

        $isAjax=false;
        
        if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('_form', ['model'=>$model,'model1'=>$modelSlip,
             'model2'=>$model2,'model3'=>$model3, 'modelSupportDocs' =>$modelSupportDocs,'isAjax'=>false,'params'=>$params]);
     
     
         }else{
            
                return   $this->render('_form', ['model'=>$model,'model1'=>$modelSlip,
             'model2'=>$model2,'model3'=>$model3,'modelSupportDocs' =>$modelSupportDocs,'isAjax'=>false,'params'=>$params]);
           
     
         }
    }

    /**
     * Deletes an existing ErpLpoRequest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
         $flag=$this->findModel($id)->delete();
       
       if($flag){
       Yii::$app->session->setFlash('success',"LPO Request has been deleted!");    
           
       }else{Yii::$app->session->setFlash('failure',"LPO Request could not be deleted!");}
        
       
        return $this->redirect(['drafts']);
    }

    /**
     * Finds the ErpLpoRequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpLpoRequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpLpoRequest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
     //to prevent unable to verify yr submission data errror
     public function beforeAction($action) { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);
    
    }
}
