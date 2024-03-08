<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpTravelRequestAttachement;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\data\Pagination;
/**
 * ErpTravelRequestAttachementController implements the CRUD actions for ErpTravelRequestAttachement model.
 */
class ErpTravelRequestAttachementController extends Controller
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
     * Lists all ErpTravelRequestAttachement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ErpTravelRequestAttachement::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpTravelRequestAttachement model.
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
 
    public function actionViewPdf1($tr_id){
        
  $query = ErpTravelRequestAttachement::find()->where(['tr_id' =>$tr_id]);
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
     * Creates a new ErpTravelRequestAttachement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpTravelRequestAttachement();
       
        if (Yii::$app->request->post()) {
           
          
          
           Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
           
           
          
           if(isset($_POST['ErpTravelRequestAttachement'])){
               
             $post= $_POST['ErpTravelRequestAttachement'];
             
            
               
               if(isset($post['tr_id'])){
               
               
                
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
   $path_to_attach='uploads/tr/attachements/'. $unification.".{$ext}";
    
   
   
                 $attModel=new ErpTravelRequestAttachement();
                 $attModel->attach_name=$file->name;
                 $attModel->created_by=Yii::$app->user->identity->user_id;
                 $attModel->tr_id=$post['tr_id'];
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
                   
                    'message' => 'Travel Request ID not found !',
                ],
                'code' => 1,
            ];
           }
           
        }//-------------------end post
        
           
        }

         if(Yii::$app->request->isAjax){
             
         
           return $this->renderAjax('_form', [
            'model' => $model,'tr_id'=>$_GET['tr_id'],'context'=>$_GET['context']
        ]);   
             
         }

        return $this->render('create', [
            'model' => $model,'tr_id'=>$_GET['tr_id']
        ]);
    }

    /**
     * Updates an existing ErpTravelRequestAttachement model.
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
     * Deletes an existing ErpTravelRequestAttachement model.
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
     * Finds the ErpTravelRequestAttachement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpTravelRequestAttachement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpTravelRequestAttachement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
