<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpDocumentAttachment;
use common\models\ErpDocumentAttachmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Model;
use yii\web\UploadedFile;
use yii\helpers\Url;
use common\models\ErpDocumentVersion;
use common\models\ErpAttachmentVersion;
use common\models\ErpAttachmentVersionUpload;
use common\models\ErpDocumentVersionAttach;
use yii\db\Query;
use common\models\ErpDocumentAttachMerge;
use common\models\ErpDocument;
use yii\web\Response;

/**
 * ErpDocumentAttachmentController implements the CRUD actions for ErpDocumentAttachment model.
 */
class ErpDocumentAttachmentController extends Controller
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
     * Lists all ErpDocumentAttachment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpDocumentAttachmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpDocumentAttachment model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        /*return $this->render('view', [
            'model' => $this->findModel($id),
        ]);*/
       
         if(Yii::$app->request->isAjax){

            return $this->renderAjax('view', ['id'=>$id,
               'attach' =>$_GET['attach'],
            ]);   
        }
        return $this->render('view', ['id'=>$id,
               'attach' =>$_GET['attach'],
            ]);
    
    }
   

    /**
     * Creates a new ErpDocumentAttachment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelsAttachement = [new ErpDocumentAttachment];
           
        if (Yii::$app->request->post()) {

        
            $modelsAttachement = Model::createMultiple(ErpDocumentAttachment::classname());
            Model::loadMultiple( $modelsAttachement , Yii::$app->request->post());
   
           if (isset($_POST['ErpDocument']['id'])) {
     
              $transaction = \Yii::$app->db->beginTransaction();
                  try {
                      
                      
          foreach ($modelsAttachement as $i=>$modelAttachement) {
            
              if($modelAttachement!=new ErpDocumentAttachment()){
       
               

            
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
   
                   $modelAttachement->document=$_POST['ErpDocument']['id']; 
   
                  if($modelAttachement->attach_title==null){
       
                   $modelAttachement->attach_title=$file[$i]->name;
                   
                   
                  }
              
                         
                      }

                      if (! ($flag =$modelAttachement->save(false))) {
                        $transaction->rollBack();
                        break;
                    }

                        if($modelAttachement->attach_upload!=null){
         
                            $file[$i]->saveAs($modelAttachement->attach_upload);
  
                          }
                    
      
                  
                    }
                    
                }

            
                  } 
                  
                  catch (Exception $e) {
                      $transaction->rollBack();
                  }
                  
           }
            
            
             if($flag){
                $transaction->commit();
                Yii::$app->session->setFlash('success',"Attachement Added Successfully!");
                
                 if (Yii::$app->request->isAjax) {
                                Yii::$app->response->format = Response::FORMAT_JSON;
                                $response = ['success' =>true, 
            
                                'message'=>"Attachement Added Successfully"
                              ];
                              
                              return $response;

                             }


             } else{
                Yii::$app->session->setFlash('failure',"Attachement Could not be Added!");
                 if (Yii::$app->request->isAjax) {
                                Yii::$app->response->format = Response::FORMAT_JSON;
                                $response = ['success' =>false, 
            
                                'message'=>"Attachement Could not be Added"
                              ];
                              
                              return $response;

                             }

             } 
             
       
          }
        
        if(Yii::$app->request->isAjax){

            return $this->renderAjax('_form', [
                'modelsAttachement' => (empty($modelsAttachement)) ? [new ErpDocumentAttachment] : $modelsAttachement,
                'isAjax'=>true,
                'id'=>$_GET['id'],
                'context'=>$_GET['context']
            ]);  
        }
        return $this->render('_form', [
            'modelsAttachement' => (empty($modelsAttachement)) ? [new ErpDocumentAttachment] : $modelsAttachement,
            'isAjax'=>false,
            'id'=>$_GET['id'],
            'context'=>$_GET['context']
        ]);
        
    }

    /**
     * Updates an existing ErpDocumentAttachment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$old_attach=$model->attach_upload;
                                           

        if (isset($_POST['ErpDocumentAttachment'])) {
           
            $model->attributes=$_POST['ErpDocumentAttachment'];
            //$model->attach_upload=$old_attach;
           
            $file= UploadedFile::getInstance($model,'attach_uploaded_file');
             
            if($flag=$model->save(false)){

                $path_to_attach="";
                if( $file!==null){
                 
                  // generate a unique file name to prevent duplicate filenames
                $exponent = 3; // Amount of digits
                $min = pow(10,$exponent);
                $max = pow(10,$exponent+1)-1;
                //1
                $value = rand($min, $max);
                $unification= date("Ymdhms")."".$value;
                 
                  $temp= explode(".",   $file->name);
                  
                  $ext = end($temp);
                  $path_to_attach .='uploads/attachements/'. $unification.".{$ext}";

                  $query3 = new Query;
                  $query3	->select([
                      'attch_ver.*'
                      
                  ])->from('erp_attachment_version as attch_ver ')->where(['attch_ver.attachment' =>$model->id])->orderBy([
                          'version_number' => SORT_DESC,
                          
                        ]);	
         
                  $command3 = $query3->createCommand();
                  $rows3= $command3->queryAll();

 $att_version=new ErpAttachmentVersion();
 $att_version->version_number=$rows3[0]['version_number']+1;
 $att_version->attachment=$model->id;
 $att_version->user=Yii::$app->user->identity->user_id;
 $flag=$att_version->save(false);
 
 //-------------------------------------------------------------------attach version upload-------------------------------------------
   $att_version_upload=new ErpAttachmentVersionUpload();
  $att_version_upload->attach_version=$att_version->id;
  $att_version_upload->attach_upload=$path_to_attach;
  $att_version_upload->file_name=$file->name;
   $flag= $att_version_upload->save(false);
  
  if($att_version_upload->attach_upload!=''){
         
   //--------------------------------------------------------delete existing upload----------------------------------------- 
    
   
    
    
    /* $connection = Yii::$app->getDb();
                       $query = $connection->createCommand('DELETE FROM erp_attachment_version_upload WHERE attach_version=:id');
                       $query->bindParam(':id', $id);
                       $id =$rows3[0]['id'];
                       $query->execute();*/
    
    $file->saveAs($att_version_upload->attach_upload);
  

  }    
  
  
  
                }

                if($flag){

                    Yii::$app->session->setFlash('success',"Attachement Updated!");  
                    
                    if (Yii::$app->request->isAjax) {
                                Yii::$app->response->format = Response::FORMAT_JSON;
                                $response = ['success' =>true, 
            
                                'message'=>"Attachement Updated!"
                              ];
                              
                              return $response;

                             }

                    
                   // return  $this->redirect(Url::to(['erp-document/view', 'id' =>$_GET['doc'],'flow'=>$_GET['flow']]));
                    
                      }else{
                          
                        if (Yii::$app->request->isAjax) {
                                Yii::$app->response->format = Response::FORMAT_JSON;
                                $response = ['success' =>false, 
            
                                'message'=>"Attachement Update Failed!"
                              ];
                              
                              return $response;

                             }  
                          
                      }
            }
  
           

        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_form2', [
                'model' => $model,'isAjax'=>true,'context'=>$_GET['context']
            ]);

        }

        return $this->render('_form2', [
            'model' => $model,'isAjax'=>false,'context'=>$_GET['context']
        ]);
    }

    /**
     * Deletes an existing ErpDocumentAttachment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
       
    //select all uploads for the attach
        $query3 = new Query;
         $query3	->select([
             'attch_ver_upload.attach_version as version_id', 'attch_ver_upload.attach_upload',
             
         ])->from('erp_attachment_version as attch_ver ')->join('INNER JOIN', 'erp_attachment_version_upload as attch_ver_upload',
             'attch_ver.id=attch_ver_upload.attach_version')->where(['attch_ver.attachment' =>$id])->orderBy([
                 'version_number' => SORT_DESC,
                 
               ]);

         $command3 = $query3->createCommand();
         $rows3= $command3->queryAll();
        // var_dump($rows3);die();


        foreach( $rows3 as $row){

          //------------------------------------------delete all att versions----------------------------
        \Yii::$app
        ->db
        ->createCommand()
        ->delete('erp_attachment_version_upload', ['attach_version' =>$row['version_id']])
        ->execute();  
        
        if (file_exists($row['attach_upload'])) {
            unlink($row['attach_upload']);
        }
        }

        //------------------------------------------delete all att versions----------------------------
        \Yii::$app
    ->db
    ->createCommand()
    ->delete('erp_attachment_version', ['attachment' =>$id])
    ->execute();

    //-----------------------------------delete from merge-----------------------------------------------

     
      \Yii::$app
      ->db
      ->createCommand()
      ->delete('erp_document_attach_merge', ['attachement' =>$id,'document'=>$_GET['doc']])
      ->execute();
//---------------------------------------------------finally delete the attachement---------------------------------------
   $flag= $this->findModel($id)->delete();
   if($flag){
       
      Yii::$app->session->setFlash('success',"Attachement Deleted!");
     
     if (Yii::$app->request->isAjax) {
                                Yii::$app->response->format = Response::FORMAT_JSON;
                                $response = ['success' =>true, 
            
                                'message'=>"Attachement  Deleted!"
                              ];
                              
                              return $response;

                             }  
       
       
   }else{

    Yii::$app->session->setFlash('success',"Attachement Could not be Deleted!");
     
     if (Yii::$app->request->isAjax) {
                                Yii::$app->response->format = Response::FORMAT_JSON;
                                $response = ['success' =>false, 
            
                                'message'=>"Attachement Could not be Deleted!"
                              ];
                              
                              return $response;

                             }
                             
    }
    //return  $this->redirect(Url::to(['erp-document/view', 'id' =>$_GET['doc'],'flow'=>$_GET['flow']]));
    }

    /**
     * Finds the ErpDocumentAttachment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpDocumentAttachment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpDocumentAttachment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
       protected function attach($attachment,$id){
        
        
        $doc=ErpDocument::find()->where(['id'=>$id])->One();
       
      
        
         $pdf = new \Jurosh\PDFMerge\PDFMerger;
           
                                                       
                                                       if($doc->doc_upload!=''){
                                                         
                                                         
              if (file_exists($doc->doc_upload)) {
                  $pdf->addPDF($doc->doc_upload, 'all'); 
                }
                                                            
                                                       }
                                                       
                                                         if (file_exists($attachment)) {
                   $pdf->addPDF($attachment, 'all');
                   
                     // generate a unique file name to prevent duplicate filenames
             $exponent = 3; // Amount of digits
             $min = pow(10,$exponent);
             $max = pow(10,$exponent+1)-1;
             //1
             $value = rand($min, $max);
             $unification= date("Ymdhms")."".$value;
             $path_to_doc_upload='uploads/documents/'. $unification.'.pdf';
         
         //--------------------------------------------set new doc url-------------------------------------------    
             /* if (file_exists($doc->doc_upload)) {
                    unlink($doc->doc_upload);
                }*/
                // call merge, output format `file`
              $pdf->merge('file', $path_to_doc_upload);
              
//--------------------------------------update doc-------------------------------------------------------------              
      Yii::$app->db->createCommand()
        ->update('erp_document', ['doc_upload' =>$path_to_doc_upload], ['id' => $id])
        ->execute();         

                }
                
                unlink($doc->doc_upload);
               
         
    }
    
      public function actionRemoveAttachment($id){
    
        $model=$this->findModel($id);
     
     if (file_exists($model->attach_upload)) {
           
            if(unlink($model->attach_upload)){
                
                
                return true;
            }else{
                
                
                return false;
            }
            
            
        }    
        
        
        
    }
}
