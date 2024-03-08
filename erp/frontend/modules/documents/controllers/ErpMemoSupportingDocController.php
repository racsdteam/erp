<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpMemoSupportingDoc;
use common\models\ErpMemoSupportingDocSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Model;
use yii\web\UploadedFile;
use yii\data\Pagination;
/**
 * ErpMemoSupportingDocController implements the CRUD actions for ErpMemoSupportingDoc model.
 */
class ErpMemoSupportingDocController extends Controller
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
     * Lists all ErpMemoSupportingDoc models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpMemoSupportingDocSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
  

    /**
     * Displays a single ErpMemoSupportingDoc model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * 
     * 
     * 
     */
    public function actionView($id)
    {
      
        if(Yii::$app->request->isAjax){

         
             return $this->renderAjax('view2', [
         'model' => $this->findModel($id),
         
    ]);
        }
       /* return $this->render('view2', [
            'doc' =>$doc,
        ]);*/
        
         return $this->render('view2', [
        'model' => $this->findModel($id),
         
    ]);
    }
    
public function actionGetSupportDocsByMemo($id){
        
        
    $query = ErpMemoSupportingDoc::find()->where(['memo' =>$id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
              
             if (Yii::$app->request->isAjax) {
            
          return $this->renderAjax('page-viewer3', [
         'models' => $models,
         'pages' => $pages,
         'stepcontent'=>$_GET['stepcontent']
    ]);
    
          }else{
        return $this->render('page-viewer3', [
         'models' => $models,
         'pages' => $pages,
         'stepcontent'=>$_GET['stepcontent']
    ]); 
              
          }
        
         
        }else{
            
         return   ' <div class="error-page">
        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Supporting Doc(s) not found.</h3>

          <p>
            We could not find Memo Supporting Docs.
            
          </p>

        </div>
     
      </div>';
            
            
            
            
            
           
        }     
        
    }

    /**
     * Creates a new ErpMemoSupportingDoc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       
        $model=new ErpMemoSupportingDoc();
        $memo=$_GET['memo'];
        $stepcontent=$_GET['stepcontent'];
        

        if(Yii::$app->request->post()){
            
             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;     
             if(isset($_POST['ErpMemoSupportingDoc'])){
             
             $model->doc_uploaded_files = UploadedFile::getInstances($model, 'doc_uploaded_files');
             
             if(empty($model->doc_uploaded_files)){
                     
                     return ['flag'=>false,
                       'message'=>"Attachement(s) Added !",
                       'stepcontent'=>$_GET['stepcontent']
                       ]; 
             }
                   
                    
                 
                       $files=$model->doc_uploaded_files;
                 
                
                 
                 foreach($files as $key => $file){
                 
                    
                
                 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_doc='uploads/memo/attachements/'. $unification.".{$ext}";
   
   $model=new ErpMemoSupportingDoc(); 
   $model->doc_upload=$path_to_doc;
   $model->memo=$memo;
   $model->doc_name=$file->name;
   $model->uploaded_by=Yii::$app->user->identity->user_id;
                  
                  if(! $flag=$model->save(false)){
                      
                     if(Yii::$app->request->isAjax){
                        
                        
                     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;   
                      
                       return ['flag'=>false,
                       'message'=>Html::errorSummary($model),
                       'stepcontent'=>$_GET['stepcontent']
                       ] ; 
                       
                     }else{
                      
                         Yii::$app->session->setFlash('failure',Html::errorSummary($model));  
                   
            return $this->render('_form', [
            'model' => $model,
            'memo'=>$memo,
            'stepcontent'=>$_GET['stepcontent']
        ]);  
                       }
                     
            
                   
                  }  
                 
               $file->saveAs( $path_to_doc);  
                     
                 }
                 
             
             
              
                 
             
            
    
       
                      
                       return ['flag'=>true,
                       'message'=>"Attachement(s) Added !",
                       'stepcontent'=>$_GET['stepcontent']
                       ];
        
             
            }     
            
        }

       
        
        if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('_form', ['model'=>$model,'memo'=>$memo,
            'stepcontent'=>$stepcontent,'isAjax'=>true]);
     
     
         }else{
            return $this->render('_form', ['model'=>$model,
                'memo'=>$memo,'stepcontent'=>$stepcontent, 'isAjax'=>false
            ]);
     
         }
    }

    /**
     * Updates an existing ErpMemoSupportingDoc model.
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
     * Deletes an existing ErpMemoSupportingDoc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
          
        $model=$this->findModel($id);
        
         if (file_exists($model->doc_upload)) {
            unlink($model->doc_upload);
        }
          
          $flag= $model->delete();
   if($flag){
       return true;
   }else{
       
       return false;
   }
    }

    /**
     * Finds the ErpMemoSupportingDoc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpMemoSupportingDoc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpMemoSupportingDoc::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
