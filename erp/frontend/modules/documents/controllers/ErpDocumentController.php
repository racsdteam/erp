<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpDocument;
use common\models\ErpDocumentType;
use common\models\ErpDocumentSearch;
use common\models\ErpDocumentVersion;
use common\models\ErpDocumentFlow;
use common\models\ErpDocumentFlowRecipients;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\db\Query;
use common\models\ErpDocumentAttachment;
use common\models\Model;
use common\models\ErpAttachmentVersion;
use common\models\ErpAttachmentVersionUpload;
use common\models\ErpDocumentVersionAttach;
use common\models\ErpDocumentAttachMerge;
use common\models\User;
use common\models\ErpDocumentRequestForAction;
use common\models\ErpDocumentRemark;
use common\models\ErpDocumentApproval;
use iio\libmergepdf\Merger;
use iio\libmergepdf\Driver\TcpdiDriver;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * ErpDocumentController implements the CRUD actions for ErpDocument model.
 */
class ErpDocumentController extends Controller
{
    /**for
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
     * Lists all ErpDocument models.
     * @return mixed
     */
    public function actionIndex()
    {
       /* $searchModel = new ErpDocumentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);*/

        return $this->render('index');
    }

    /**
     * Displays a single ErpDocument model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

   
  
    
     public function actionDrafts()
    {
       

        return $this->render('drafts');
    }
    
    
        
         public function actionDone($id)
    {
         $user=Yii::$app->user->identity->user_id;
 
 if(!empty($id)) {
   
   Yii::$app->db->createCommand()
                      ->update('erp_document_flow_recipients', ['status' =>'archived'], ['document' =>$id,'recipient'=>$user,'status' =>'pending'])
                      ->execute();  
                  Yii::$app->session->setFlash('success',"Document has been succesfully archived");    
 }
       return $this->redirect(['in-documents']);
    }
    
    
    
    
      public function actionApproved()
    {
       

        return $this->render('approved');
    }
    
 
  //------------------------------------------------------------Fetch wizard pages------------------------------------------------------------
  
  public function actionFetchTab(){
      
    $step_number = $_REQUEST["step_number"];   
     
     if(isset($_GET['active-step'])){
        
        $step_number=$_GET['active-step']; 
    }
    
    if(isset($_GET['id'])){
        
        $model =ErpDocument::find()->where(['id' =>$_GET['id']])->one();
       
     
           if($step_number==0){
        
    $query = ErpDocumentAttachment::find()->where(['document'=>$model->id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        
        if(!empty($models)){
        
              return $this->renderAjax('content', [
         'models' => $models,
         'pages'=>$pages
         
    ]);
            
         
        }else{
            
               
         return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Attachements Found !
              
               </div>';
        }
       
           } 
      
             
       if($step_number==1)
          {
      
        return $this->renderAjax('work-flow', [
         'model' => $model,
         
         
    ]);
         
     } 
            
            
    
       
          
    }else{
        
      return   ' <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Expected Memo ID .</h3>

          <p>
            We could not find Document Id.
            
          </p>

        </div>
     
      </div>';
    } 
      
  }
  
  public function actionPdfViewer($id){
      
        
    //------------------------update status-----------------------------------------------
    
       $model=$this->findModel($id);
    
    
    //--------------------drafting new----------------------------------------
    
    if($model->is_new && $model->status=='drafting'){
        
        Yii::$app->db->createCommand()
                      ->update('erp_document', ['is_new' =>0], ['id' =>$id,'creator'=>Yii::$app->user->identity->user_id])
                      ->execute();
      
       }
    
  else if($model->status=='processing' || $model->status=='approved'){
          
           Yii::$app->db->createCommand()
                      ->update('erp_document_flow_recipients', ['is_new' =>0], ['recipient' =>Yii::$app->user->identity->user_id])
                      ->execute(); 
          
         }
   
   
        if(Yii::$app->request->isAjax){

          
            
             return $this->renderAjax('view-wizard', [
        'model' =>$this->findModel($id)
         
    ]);
        }
      
        
         return $this->render('view-wizard', [
          'model' =>$this->findModel($id)
        
    ]);
  }
    
    
    
    
   //-------------------------------------------------------merging doc files---------------------------------------------------------------- 
    public function actionDocumentViewer($id){
        
       $doc=ErpDocument::find()->where(['id'=>$id])->One();
      
        if($doc!=null){
           
            if (file_exists($doc->doc_upload)) {
                    unlink($doc->doc_upload);
                }
               
        $pdf = new \LynX39\LaraPdfMerger\PdfManage;  
          // $merger = new Merger(new TcpdiDriver);
            
            //$pdf = new \Jurosh\PDFMerge\PDFMerger;
            $q = new Query;
                                               $q->select([
                                                   'doc_merge_attch.attachement',
                                                   
                                               ])->from('erp_document_attach_merge as doc_merge_attch ')->where(['document' =>$doc->id,'visible'=>'1']);
                                   
                                               $command0 = $q->createCommand();
                                               $rows1= $command0->queryAll(); 
                                                if(empty($rows1)){
                                                    return '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
               
                 No Attachements Found!
              
               </div>'; 
                                                }
            
              foreach($rows1 as $row1)  {
                $query3 = new Query;
                                                        $query3	->select([
                                                            'attch_ver_upload.*'
                                                            
                                                        ])->from('erp_attachment_version as attch_ver ')->join('INNER JOIN', 'erp_attachment_version_upload as attch_ver_upload',
                                                            'attch_ver.id=attch_ver_upload.attach_version')->where(['attch_ver.attachment' =>$row1['attachement']])->orderBy([
                                                                'version_number' => SORT_DESC,
                                                                
                                                              ]);
                                            
                                                        $command3 = $query3->createCommand();
                                                        $rows3= $command3->queryAll();
                                                        $pdf->addPDF($rows3[0]['attach_upload'], 'all');
                                                        //$merger->addFile($rows3[0]['attach_upload']);
                                                       //$pdf->addPDF($rows3[0]['attach_upload'], 'all');
           
              }
              
             $exponent = 3; // Amount of digits
             $min = pow(10,$exponent);
             $max = pow(10,$exponent+1)-1;
             //1
             $value = rand($min, $max);
             $unification= date("Ymdhms")."".$value;
             $path_to_doc_upload='uploads/documents/attachements/'. $unification.'.pdf';
         
         //--------------------------------------------set new doc url-------------------------------------------    
              if (file_exists($doc->doc_upload)) {
                    unlink($doc->doc_upload);
                }
                // call merge, output format `file`
              //$pdf->merge('file', $path_to_doc_upload);
              $pdf->merge('file', $path_to_doc_upload, 'P');
              //$createdPdf = $merger->merge();
             // file_put_contents( $path_to_doc_upload,$createdPdf);
              //return "saved";
              
              $doc->doc_upload= $path_to_doc_upload;
              $doc->save(false);
       

          //--------------------------------------------------------------------------------------------------------------------------------------  
            if($doc->doc_upload!=''){
                
                return $this->renderAjax('viewer',['doc'=>$doc]);
                
            }else{
                
                return '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
               
                 No Attachements Found!
              
               </div>';   
            }

          

        } else{
            
          return '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                 Unable to load Document
              
               </div>';  
            
        }
        
        
    }
    
     public function actionWorkFlow(){
   
    $model = new ErpDocument();
   
    if(isset($_POST['ErpDocument'])){
     
     $data=$_POST['ErpDocument'];
     $employees=array();
     $cc=array();
 
    
     $action=$data['action'];
     $remark=$data['remark'];
     $employees[]=$data['employee'];
     $employees=array_filter($employees);
     
     $cc[]=$data['employee_cc'];
     $cc=array_filter($cc);
     $id=$data['id'];
     $user=Yii::$app->user->identity->user_id;
     $model1=ErpDocument::find()->where(['id'=>$id])->one();
   
   
   
 
 
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
$command8= Yii::$app->db->createCommand($q8); */

$row8 =Yii::$app->muser->getInterim($user,$row7['user_id'],$approvalDate);
      
   
   if($row7['user_id']==$user  || $row8!=null ){
    
   $model1->status='approved';
   
   if($approved=$model1->save(false)){
      $step_action='approved';
      $step_status='final'; 
      $msg="Document Approved";
     
     
      
   }else{
       
      throw new \yii\web\HttpException(451,
          'Document could not be approved
              (please try again).');   
       
         }
  
   }
   else{
      $step_action='approved';
      $step_status='middlemen';
      $msg='Your Approval Saved';   
     }
  
  if(isset($step_action)){
     $this->ApprovalActionLog($model1->id,$user,$step_action,$step_status,$remark);
     
  }
 
if(!empty($employees)){
        
        $forwarded=$this->isForwarded($employees,$cc,$model1->id,$user,$remark);
        if($forwarded){
        
            if($approved){
               $msg.=' And  forwarded!';   
            }else{
                 $msg.=' And Document forwarded!';  
            }
         
       }else{
           
          if($approved){
               $msg.=' but could not be forwarded!';   
            }else{
                 $msg.=' but Document could not be forwarded!';  
            }
       }
       
       }

  
     }
               
    if($action=='forward'){
 
    
    if($this->isForwarded($employees,$cc,$model1->id,$user,$remark)){
        
         $step_action='forwarded';
         $step_status='middlemen';
         $msg="Document Forwarded !";
         
       
        if($model1->creator!=$user){
            
          $this->ApprovalActionLog($model1->id,$user,$step_action,$step_status,$remark);
        }
        Yii::$app->session->setFlash('success',$msg);
    
     if($model1->status=='drafting'){
           
           $model1->status='processing';
           $model1->save(false);
           return $this->redirect(['erp-document/drafts']); 
       }
       
         
    }else{
        
      throw new \yii\web\HttpException(451,
          'The Document  could not be forwarded
              (please try again).'); 
        
    }
 
      }
    
 if($action=='rfa'){
        $approval_status='Change requested';
        $msg="Document Sent for Correction";  
     }
     
     
if($action=='close'){
    
   
        $model1->status='closed';
      
       if($model1->save(false)){
          
          
         $step_action='closed';
         $step_status='final';
         $msg="Document Closed !";
         $this->ApprovalActionLog($model1->id,$user,$step_action,$step_status,$remark);
         
       
        
           
       }else{
          throw new \yii\web\HttpException(451,
          'The document could not be Closed
              (please try again).');  
           
       }
     }     
  
 
  
  Yii::$app->session->setFlash('success',$msg);
  
  
  $done=  Yii::$app->db->createCommand()
                      ->update('erp_document_flow_recipients', ['status' =>'done'], ['recipient'=>$user,'document'=>$model1->id])
                      ->execute(); 
   
   return $this->redirect(['in-documents']); 
   
}

 return $this->renderAjax('work-flow', [
         'model' => $model,
         
         
    ]);

   }
   
 //--------------------log fucntion---------------------------------------
 
 public function ApprovalActionLog($doc,$user,$step_action,$step_status,$remark){
 
    $approval=new ErpDocumentApproval();
    $approval->document=$doc;
    $approval->approved_by=$user;
     $approval->approval_action=$step_action;
      $approval->approval_status=$step_status;
     $approval->remark=$remark;
    $approval_saved=$approval->save(false);     
     
 }
 
 public function isForwarded($employees,$cc,$doc,$user,$remark){
  
   
    
    
     if(!empty($employees)){
 foreach($employees as $key=>$employee){
   
    $recipientModel=new ErpDocumentFlowRecipients();
    $recipientModel->document=$doc;
    $recipientModel->recipient=$employee;
    $recipientModel->sender=$user;
    $recipientModel->remark =$remark;
    
   if(!empty($cc)){
        
        if (in_array($employee, $cc)){
            
          $recipientModel->is_copy =1;   
        }
    }
   
    if(!$forwarded=$recipientModel->save(false)){
      
    
      break; 
      
      return false;
        
    }
   
   $flag=$this->sendEmail($user,$employee,$doc) ;
   
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
    
    $recipientModel=new ErpDocumentFlowRecipients();
    $recipientModel->document=$doc;
    $recipientModel->recipient=$row7['user_id'];
    $recipientModel->sender=$user;
    $recipientModel->remark =$remark;
    $recipientModel->is_copy =1;   
    
      if($recipientModel->save(false)){
       $flag=$this->sendEmail($user,$row7['user_id'],$doc) ;
        
    }
   
  
    
}
    
    
 }
 
     } 
     
     return $forwarded;
     
 }
 
 public function sendEmail($from,$to,$doc){
     
     
    
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
           
     $q1=" SELECT doc.*,t.type FROM erp_document as doc  inner join erp_document_type as t on t.id=doc.type
     where doc.id='".$doc."' ";
     $com1= Yii::$app->db->createCommand($q1);
     $row1 = $com1->queryOne();  
                                      
                                           
                                            
                                           
                                               
                                                 $flag1= Yii::$app->mailer->compose( ['html' =>'userNotification-html'],
    [
        'recipient' =>$recipient,'sender'=>$sender ,'doc'=>$row1['type'],'date'=>date("Y-m-d H:i:s"),'remark'=>$remark
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$user2->email=>$to])
->setSubject('ERP Notification')
//->setTextBody('You Can Change Login Password After Sign in')
->send();


                                            
    
   return $flag1;
     
     
 }
   
   


public function actionViewForCorrection($id)
{
 
         //update read status for current user
         $user=Yii::$app->user->identity->user_id;
        Yii::$app->db->createCommand()
        ->update('erp_document_request_for_action', ['is_new' => '0'], ['document' =>$id,'action_handler'=>$user])
        ->execute();

     
   
    return $this->render('doc-for-correction', [
        'model' =>$this->findModel($id),'flow'=>$_GET['flow'],
    ]);
}

public function actionForwardAfterCorrection(){
   
       $user=Yii::$app->user->identity->user_id;
   
    //$recipientModel->recipient=$value;
    if(Yii::$app->request->post()){

       
         $data=$_POST['ErpDocument'];
        $id=$_POST['ErpDocument']['id'];
        $recipients=$data['recipients_names'];
        $flowModel=ErpDocumentFlow::find()->where(['document'=>$id])->one();
        $flow=$flowModel->id;
      
        
           if(!empty($recipients))
                                  
                                     {
      //----------------------------------------set version---------------------------------------------------------------------                          
    //var_dump($recipients);die();  
                                            foreach($recipients as $key=>$value){
                                            
                                            $recipientModel=new ErpDocumentFlowRecipients();
        $recipientModel->flow_id=$flow;
        $recipientModel->sender= $user;
        $recipientModel->recipient=$value;
         $flag=$recipientModel->save();
                                           
                                            }

                            }else{
                                
                                $recipientModel=new ErpDocumentFlowRecipients();
        $recipientModel->flow_id=$flow;
        $recipientModel->sender= $user;
        $recipientModel->recipient=$_POST['recipient'];
         $flag=$recipientModel->save();
                            }
        
        
       
        
        //-----------------------------------------------------------------saving remark if any--------------------------------------------------------                        
      if(isset($data['remark'])){
         
         $remark=new ErpDocumentRemark();  
         $remark->remark=$data['remark'];  
         $remark->document=$id;
         $remark->author=$user;
         $remark->save();
        
         
       } 
        if($flag)
        {
        Yii::$app->session->setFlash('success',"Document Forwarded Successfully!");
        Yii::$app->db->createCommand()
        ->update('erp_document_request_for_action', ['status' => 'done'], ['document' =>$id,'action_handler'=>$user,'status'=>'pending'])
        ->execute();
        }
        else{
            Yii::$app->session->setFlash('failure',"Document Could not be Forwarded!");

        }
        return $this->redirect(['docs-requested-for-action']);
        
    }

}


    public function actionViewDoc($url)
    {

        if(Yii::$app->request->isAjax){

            return $this->renderAjax('view', [
                'url' =>$url,
            ]);   
        }
        return $this->render('view', [
            'url' =>$url,
        ]);
    }
    /**
     * Creates a new ErpDocument model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
         $model = new ErpDocument();
         
         $modelsAttachement = [new ErpDocumentAttachment];
       
        if(Yii::$app->request->post()){
            
           //var_dump(Yii::$app->request->post());die();
            $post=$_POST['ErpDocument'];
            $model->attributes=$post; 
            $model->creator=Yii::$app->user->identity->user_id;
           
            $exponent =2; // Amount of digits
            $min = pow(10,$exponent);
            $max = pow(10,$exponent+1)-1;
            //1
            $value = rand($min, $max);
            $unification= "doc"."-".date("Ymdhms")."-".$value;
            $model->doc_code= $unification;
          
                            if($model->save(false)){
                
                                $_SESSION['doc_id']=$model->id;
      
     //------------------------------------attchemts-------------------------------------------------------------------------
        $modelsAttachement = Model::createMultiple(ErpDocumentAttachment::classname());
        Model::loadMultiple( $modelsAttachement , Yii::$app->request->post());

            $transaction = \Yii::$app->db->beginTransaction();
            try {
        
               
                 
    foreach ($modelsAttachement as $i=>$modelAttachement) {
      
       
       if($modelAttachement!=new ErpDocumentAttachment()){
        
        //------------------------------------------------saving attachement metadata--------------------------------
            
          
             //saving files for dyanamic forms
           $file[$i]=  UploadedFile::getInstanceByName("ErpDocumentAttachment[".$i."][attach_uploaded_file]");
      

 $path_to_attach="";
 if( $file[$i]!==null){
  
// generate a unique file name to prevent duplicate filenames
 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file[$i]->name);
   
   $ext = end($temp);
   $path_to_attach .='uploads/documents/attachements/'. $unification.".{$ext}";
  
   $modelAttachement->attach_upload=$path_to_attach;
   
   $modelAttachement->file_name=$file[$i]->name;
   
   $modelAttachement->user=Yii::$app->user->identity->user_id;
   
   $modelAttachement->document=$model->id; 
   
   if($modelAttachement->attach_title==null){
       
       $modelAttachement->attach_title=$file[$i]->name;
   }
 
        }
            
            
         if(!($flag =$modelAttachement->save(false))){
        
        $transaction->rollBack();
       
       }
       
        
        $file[$i]->saveAs($path_to_attach);
       
      
          }
              
          }

      
            } 
            
            catch (Exception $e) {
                $transaction->rollBack();
            }
            if($flag){
                
                 $transaction->commit();
                
                Yii::$app->session->setFlash('success',"Document Saved Successfully!");
                return $this->redirect(['drafts']); 
            
             } else{
                 
               Yii::$app->session->setFlash('failure',"Unable to save documents !");   
                 
             }      
                      
                            }
                        }    

        $isAjax=false;
        
        

        if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('_form', ['model'=>$model, 'modelsAttachement' => (empty($modelsAttachement)) ? [new ErpDocumentAttachment] : $modelsAttachement,'isAjax'=>true]);
     
     
         }else{
            return $this->render('_form', [
                'model' => $model, 'modelsAttachement' => (empty($modelsAttachement)) ? [new ErpDocumentAttachment] : $modelsAttachement,'isAjax'=>false
            ]);
     
         }

     
    }
    
   
    
//-------------------------------------------------------person documents-----------------------------------------
public function actionInDocuments(){

    return $this->render('in-documents'); 

}

public function actionSentDocuments(){

    return $this->render('sent-documents'); 

}

public function actionMyDocuments(){

    return $this->render('my-documents'); 

}
//========================================================process action========================================
public function actionDocumentRequestAction(){
   
   
    if(isset($_POST['ErpDocument'])){
     $action=$_POST['ErpDocument']['action'];
     $remark=$_POST['ErpDocument']['remark'];
     //$recipients=$_POST['ErpDocument']['recipients_names'];
      $id=$_POST['ErpDocument']['id'];
      $user=Yii::$app->user->identity->user_id;
      
//---------------------------------------------------------------get 
    

    //-----------------------------------------------get action handler--------------------------------------------------
    $q1=" SELECT *  FROM erp_document_flow_recipients as r inner join erp_document_flow as f on r.flow_id=f.id
    where r.recipient={$user} and f.document={$id} ";
    $command = Yii::$app->db->createCommand($q1);
    $r1 = $command->queryOne();
        
     $modelRequest=new ErpDocumentRequestForAction();
     $modelRequest->document=$id;
     $modelRequest->action_description =$remark;
     $modelRequest->requested_by=$user;
     $modelRequest->action_handler=$r1['sender'];
     $modelRequest->save();


     
     //-----------------------------remove the user from the flow-------------------------
   /*  $q3=" SELECT *  FROM erp_document_flow_recipients as r inner join erp_document_flow as f on r.flow_id=f.id
      where r.flow_id='".$flow->id."' ";
$command = Yii::$app->db->createCommand($q3);
$rows = $command->queryAll();*/

//-----------------------------------------check if the doc was sent to more than one person--------------remove only that person
$flag= ErpDocumentFlowRecipients::deleteAll('recipient = :recip AND flow_id=:flow ', [':recip' =>$user,':flow'=>$r1['flow_id']]);
/*if(count($rows)==1){

  $flag=$flow->delete();
   
}*/

if($flag){
Yii::$app->session->setFlash('success',"The document was sent for Correction");


}

   


   } 


return $this->redirect(['in-documents']);
}




//=====================================docs for correction==================================
public function actionDocsRequestedForAction(){


return $this->render('docs-requested-for-action');

}


//===============================================docs tracking-======================================

public function actionDocTracking($id){

 if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('doc-tracking',['id'=>$id]);
     
     
         }
         else{
             
              return $this->render('doc-tracking',['id'=>$id]);
         }

   
    
    }
    




    /**
     * Updates an existing ErpDocument model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
      
        $model = $this->findModel($id);
       
        $modelsAttachement = ErpDocumentAttachment::find()->where(['document'=>$model->id])->all();
       
        if(Yii::$app->request->post()){
            
           
            $post=$_POST['ErpDocument'];
            $model->attributes=$post; 
            if($model->save(false)){
          
                  $oldIDs = ArrayHelper::map($modelsAttachement, 'id', 'id');
                  $modelsAttachement = Model::createMultiple(ErpDocumentAttachment::classname(),$modelsAttachement);
                  Model::loadMultiple($modelsAttachement  , Yii::$app->request->post()); 
                  
                  $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsAttachement, 'id', 'id')));
                
                   
            $transaction = \Yii::$app->db->beginTransaction();
            try {
        
          if (!empty($deletedIDs)) {
                       
                      $models = ErpDocumentAttachment::find()
                ->where(['id'=>$deletedIDs])
                ->all();
                
                
                
                if(!empty($models)){
                    
                    
                    
                    foreach($models as $f){
                        
                     if (file_exists($f->attach_upload)) {
                        
                        unlink($f->attach_upload);
                } 
                
                    
                        
                    }
                    
                    
                    
                   
                }
                       
                       
           ErpDocumentAttachment::deleteAll(['id' => $deletedIDs]);
                    }      
                 
    foreach ($modelsAttachement as $i=>$modelAttachement) {
      
       
       if($modelAttachement!=new ErpDocumentAttachment()){
        
        //------------------------------------------------saving new attachements--------------------------------
            
          $modelAttachement->document=$model->id;  
            
             //saving files for dyanamic forms
           $file[$i]=  UploadedFile::getInstanceByName("ErpDocumentAttachment[".$i."][attach_uploaded_file]");
      

 $path_to_attach="";
 
 
 if( $file[$i]!==null){
  
// generate a unique file name to prevent duplicate filenames
 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file[$i]->name);
   
   $ext = end($temp);
   $path_to_attach .='uploads/documents/attachements/'. $unification.".{$ext}";
  
   $modelAttachement->attach_upload=$path_to_attach;
   
   $modelAttachement->file_name=$file[$i]->name;
   
   $modelAttachement->user=Yii::$app->user->identity->user_id;
   
   if($modelAttachement->attach_title==null){
       
       $modelAttachement->attach_title=$file[$i]->name;
   }
 
        
     
     
     
     
 }
            
            
         if(!($flag =$modelAttachement->save(false))){
        
        $transaction->rollBack();
       
       }
       
       
       if($file[$i]!=null){
           
           
        $file[$i]->saveAs($path_to_attach); 
           
       }
       
       
       
      
          }
              
          }
//--------------------end for each--------------------------------------------------
      
            } 
            
            catch (Exception $e) {
                $transaction->rollBack();
            }
            if($flag){
                
                 $transaction->commit();
                
                Yii::$app->session->setFlash('success',"Document Updated  Successfully!");
                return $this->redirect(['drafts']); 
            
             } else{
                 
               Yii::$app->session->setFlash('failure',"Unable to Update The document !");   
                 
             }      
                      
                            }
                        }    

        $isAjax=false;
        
        

        if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('_form', ['model'=>$model, 'modelsAttachement' => (empty($modelsAttachement)) ? [new ErpDocumentAttachment] : $modelsAttachement,'isAjax'=>true]);
     
     
         }else{
            return $this->render('_form', [
                'model' => $model, 'modelsAttachement' => (empty($modelsAttachement)) ? [new ErpDocumentAttachment] : $modelsAttachement,'isAjax'=>false
            ]);
     
         }
    }
    
    //----------------------------recall document---------------------------------------
    
    public function actionRecall($id)
    {
       
       $model = $this->findModel($id);
       
       if($model!=null){
           
           if($model->creator==Yii::$app->user->identity->user_id){
               
               $connection = Yii::$app->getDb();
                       
                       $query = $connection->createCommand('DELETE FROM erp_document_flow_recipients WHERE document=:doc_id');
                       $query->bindParam(':doc_id', $doc_id);
                       $doc_id =$model->id;
                       $query->execute();
                       
                       $model->status='drafting';
                       $model->is_new=1;
                       $flag= $model->save(false);
              
           }else{
              $flag=false;
              $msg="Not Allowed To recall this document!";
              
               
           }
       }else{
           $msg="Document not found!"; 
       }
      
       if($flag){
       Yii::$app->session->setFlash('success',"Document Recalled Successfully !");    
           
       }else{
           
           Yii::$app->session->setFlash('failure',$msg);
           
             return $this->redirect(['my-documents']);
       }
        
      
        return $this->redirect(['drafts']);
    }

    /**
     * Deletes an existing ErpDocument model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        
      $model= $this->findModel($id);
      
      $models= ErpDocumentAttachment::find()->where(['document'=>$model->id])->all();
      
      if(!empty($models)){
          
          foreach($models as $f){
              
            if (file_exists($f->attach_upload)) {
                    
                    unlink($f->attach_upload);
                }
              
              $f->delete();
          }
          
      }
       
      if( $model->delete()){
          
         Yii::$app->session->setFlash('success',"Document Deleted Successfully!");
                return $this->redirect(['drafts']);  
          
          
      }else{
          
          
          Yii::$app->session->setFlash('failure',"Document Could Not be Deleted!");
                return $this->redirect(['drafts']); 
      }
       
       
        
               

        
    }

    /**
     * Finds the ErpDocument model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpDocument the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpDocument::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function attach($attachment,$doc){
        
        
        
         $merger = new Merger(new TcpdiDriver);
         $merger->addFile($attachment);
         $createdPdf = $merger->merge();
             
        /* $pdf = new \Jurosh\PDFMerge\PDFMerger;
           
                                             
                                                       $pdf->addPDF($attachment, 'all');*/
            
                                                      
            
              
              // generate a unique file name to prevent duplicate filenames
             $exponent = 3; // Amount of digits
             $min = pow(10,$exponent);
             $max = pow(10,$exponent+1)-1;
             //1
             $value = rand($min, $max);
             $unification= date("Ymdhms")."".$value;
             $path_to_doc_upload='uploads/documents/attachements/'. $unification.'.pdf';
               if(file_put_contents($path_to_doc_upload,$createdPdf)){
              
               $model = ErpDocument::findOne($doc);
                $model->doc_upload=$path_to_doc_upload;
                $model->save(false);
              
              /*Yii::$app->db->createCommand()
        ->update('erp_document', ['doc_upload' =>$path_to_doc_upload], ['id' => $doc])
        ->execute(); */ 
             
              }else{
            header("HTTP/1.1 500 Internal Server Error ,Unable To Marge Document Attachement(s)");
              }
             
                // call merge, output format `file`
             // $pdf->merge('file', $path_to_doc_upload);
            
//--------------------------------------update doc-------------------------------------------------------------              
           

    }
   /* 
     public function beforeAction($action){
       

    if ($formTokenValue = \Yii::$app->request->post('_csrf-frontend')) {
        $sessionTokenValue = \Yii::$app->session->get('form_token_param');

        if ($formTokenValue != $sessionTokenValue ) {
            throw new \yii\web\HttpException(400, 'The form has already been submitted!.');
        }

        \Yii::$app->session->remove('form_token_param');
    }

    return parent::beforeAction($action);
        
       
        
    }*/
}
