<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpLpoRequestSupportingDoc;
use common\models\ErpLpoRequestSupportingDocSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\web\UploadedFile;

/**
 * ErpLpoRequestSupportingDocController implements the CRUD actions for ErpLpoRequestSupportingDoc model.
 */
class ErpLpoRequestSupportingDocController extends Controller
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
     * Lists all ErpLpoRequestSupportingDoc models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpLpoRequestSupportingDocSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpLpoRequestSupportingDoc model.
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
    
     
 public function actionViewPdf1(){
     
           
     if(!isset($_GET['r_id']) || !is_numeric($_GET['r_id']) || intval($_GET['r_id'])<1){
          
           return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Invalid Request ID!
              
               </div>'; 
          
      } 
    
    
    $r_id=$_GET['r_id'];
    
    $query = ErpLpoRequestSupportingDoc::find()->where(['lpo_request' =>$r_id]);
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
         'container'=>$_GET['stepcontent']
    ]);
        
         
        }else{
            
            
            return   '<div class="alert alert-danger  alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Supporting Doc(s) Found!
              
               </div>';
        }    
     
     
     
 }

    /**
     * Creates a new ErpLpoRequestSupportingDoc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpLpoRequestSupportingDoc();
      
        $params['currentUrl']= $_GET['currentUrl'];
        $params['request_id']=$_GET['request_id'];
        $params['stepNumber']= $_GET['stepNumber'];
       
        if (Yii::$app->request->post()) {
         
         $post=Yii::$app->request->post();
       
         
       
        if(isset($post['ErpLpoRequestSupportingDoc'])){
               
             $data=$post['ErpLpoRequestSupportingDoc'];
             
             if(isset($data['request_id'])){
                 
                 
              $model->doc_uploaded_files = UploadedFile::getInstances($model, 'doc_uploaded_files');
               
               
                   
                if(!empty($model->doc_uploaded_files)){
                 
                 $files=$model->doc_uploaded_files;
                 
                 
                 
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
    
   
   
                 $attModel=new ErpLpoRequestSupportingDoc();
                 $attModel->doc_name=$file->name;
                 $attModel->uploaded_by=Yii::$app->user->identity->user_id;
                 $attModel->lpo_request=$data['request_id'];
                 $attModel->doc_upload=$path_to_attach ;
                 
                  if(! $flag=$attModel->save(false)){
                     
                    $errorMsg=Html::errorSummary($attModel);  
                      }  
                 
               $file->saveAs( $path_to_attach);   
                     
                 }
                 
                  if (Yii::$app->has('session')) {
                $session = Yii::$app->session;
                $session->set('initialPage', $data['stepcontent']-1);
           
            if ($flag) {
                $session->setFlash('success', "Attachement Added Successfully !");
            } else {
                $session->setFlash('error', $errorMsg);
            }
        }   
                    
                    
                
                 
             }
            
               
           }else{
               
                    if (Yii::$app->has('session')) {
                $session = Yii::$app->session;
                $session->set('initialPage', $data['stepcontent']-1);
                
                $session->setFlash('error', "Invalid Request Id");
        } 
           }
           
           
           
        }//-------------------end post
        $step= isset($post['stepNumber'])? $post['stepNumber']:-1;
       
        if($step>0){
            
          $initialPage=$step;  
        }
        
        return $this->redirect(['erp-lpo-request/view-pdf','id'=>$data['request_id'],'initialPage'=>$initialPage]); 
           
        }

         if(Yii::$app->request->isAjax){
             
         
           return $this->renderAjax('_form', [
            'model' => $model,'params'=>$params
        ]);   
             
         }

        return $this->render('_form', [
            'model' => $model,'params'=>$params
        ]);
    }

    /**
     * Updates an existing ErpLpoRequestSupportingDoc model.
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
     * Deletes an existing ErpLpoRequestSupportingDoc model.
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
     * Finds the ErpLpoRequestSupportingDoc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpLpoRequestSupportingDoc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpLpoRequestSupportingDoc::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
