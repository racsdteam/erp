<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpRequisitionAttachement;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\data\Pagination;
/**
 * ErpRequisitionAttachementController implements the CRUD actions for ErpRequisitionAttachement model.
 */
class ErpRequisitionAttachementController extends Controller
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
     * Lists all ErpRequisitionAttachement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ErpRequisitionAttachement::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpRequisitionAttachement model.
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
    
        public function actionViewPdf($id)
    {
       return $this->renderAjax('pdf-viewer',['model' => $this->findModel($id)]);
    }
    
    public function actionViewPdf1(){
    
    if(!isset($_GET['pr_id']) || !is_numeric($_GET['pr_id']) || intval($_GET['pr_id'])<1){
          
           return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                Invalid Requisition ID!
              
               </div>'; 
          
      }  
      
    $pr_id=$_GET['pr_id'];   
    $query = ErpRequisitionAttachement::find()->where(['pr_id' =>$pr_id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(empty($models)){
           
            return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                 
                  Supporting Doc(s) Not Found!
              
               </div>'; 
          } 
          
             
          return $this->renderAjax('pdf-viewer1', [
         'models' => $models,
         'pages' => $pages,
         'stepcontent'=>$_GET['stepcontent']
        
    ]);  
    
        
        
    }
    
    public function actionGetSupportDocsByReq($id){
        
    $query = ErpRequisitionAttachement::find()->where(['pr_id' =>$id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
            
          return $this->renderAjax('pdf-viewer1', [
         'models' => $models,
         'pages' => $pages,
         'stepcontent'=>$_GET['stepcontent']
        
    ]);    
        
          }else{
              
             return   '<div class="alert alert-warning alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Supporting Document(s) Found!
              
               </div>';  
              
              
           }
          
          
          
    
        
        
    }  
   

    /**
     * Creates a new ErpRequisitionAttachement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpRequisitionAttachement();
        $stepcontent=$_GET['stepcontent'];
       
        if (Yii::$app->request->post()) {
           
        
          
          Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
           
           
          
           if(isset($_POST['ErpRequisitionAttachement'])){
               
             $post= $_POST['ErpRequisitionAttachement'];
             
            
               
               if(isset($post['pr_id'])){
               
               
                
               $model->attach_files = UploadedFile::getInstances($model, 'attach_files');
                   
                    if(!empty($model->attach_files)){
                 
                 $files=$model->attach_files;
                 
                
                 
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
    
   
   
                 $attModel=new ErpRequisitionAttachement();
                 $attModel->attach_name=$file->name;
                 $attModel->created_by=Yii::$app->user->identity->user_id;
                 $attModel->pr_id=$post['pr_id'];
                 $attModel->attach_upload=$path_to_attach ;
                  if(! $flag=$attModel->save(false)){
                     
                      return [
                'data' => [
                    'success' => false,
                    
                    'message' =>Html::errorSummary($attModel),
                ],
                'code' => 0,
            ];
                   
                  }  
                 
               $file->saveAs( $path_to_attach);   
                     
                 }
                 
                 
                  return [
                'data' => [
                    'success' => true,
                   
                    'message' => 'Attachement(s) added successfully !',
                ],
                'code' => 1,
            ];
                 
             }
            
               
           }else{
               
                  return [
                'data' => [
                    'success' => false,
                   
                    'message' => 'Purchase Requisition ID not found !',
                ],
                'code' => 0,
            ];
           }
           
        }//-------------------end post
        
           
        }

         if(Yii::$app->request->isAjax){
             
         
           return $this->renderAjax('_form', [
            'model' => $model,'pr_id'=>$_GET['pr_id'],'stepcontent'=>$stepcontent
        ]);   
             
         }

        return $this->render('_form', [
            'model' => $model,'pr_id'=>$_GET['pr_id'],'stepcontent'=>$stepcontent
        ]);
    }

    /**
     * Updates an existing ErpRequisitionAttachement model.
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
     * Deletes an existing ErpRequisitionAttachement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
         $model=$this->findModel($id);
        
         if (file_exists($model->attach_upload)) {
            unlink($model->attach_upload);
        }
          
          $flag= $model->delete();
   if($flag){
       return true;
   }else{
       
       return false;
   }
    
    }

    /**
     * Finds the ErpRequisitionAttachement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpRequisitionAttachement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpRequisitionAttachement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
