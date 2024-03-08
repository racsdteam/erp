<?php

namespace frontend\modules\assets0\controllers;

use Yii;
use frontend\modules\assets0\models\AssetTypes;
use frontend\modules\assets0\models\AssetTypesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * AssetTypesController implements the CRUD actions for AssetTypes model.
 */
class AssetTypesController extends Controller
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
     * Lists all AssetTypes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AssetTypesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AssetTypes model.
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

    /**
     * Creates a new AssetTypes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AssetTypes();

       if ($model->load(Yii::$app->request->post()) ) {
            
            $renderForm=function()use($model){
            return $this->render('create', [
            'model' => $model,
        ]);   
            };
            $image= UploadedFile::getInstance($model, 'image0');
            $path='uploads/assets/';
            
            if(!empty($image)){
             $model->image=$path.uniqid().$image->extension; 
                
            }
           if(!$model->save()){
               Yii::$app->session->setFlash('error',Html::errorSummary($model)); 
               return  $renderForm();
           
             
            }
          if(!empty($image)){
              
               FileHelper::createDirectory($path);
               $image->saveAs($model->image);
          }
          
           
             
              Yii::$app->session->setFlash('success',"Asset Type Saved"); 
              return $this->redirect(['index']);
        }
        
        if(Yii::$app->request->isAjax){
            
            return $this->renderAjax('_form', [
            'model' => $model,
        ]); 
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AssetTypes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
      

          if ($model->load(Yii::$app->request->post()) ) {
            
            $renderForm=function()use($model){
            return $this->render('create', [
            'model' => $model,
        ]);   
            };
            $image= UploadedFile::getInstance($model, 'image0');
            $path='uploads/assets/';
            
            if(!empty($image)){
             $model->image=$path.uniqid().$image->extension; 
                
            }
           if(!$model->save()){
               Yii::$app->session->setFlash('error',Html::errorSummary($model)); 
               return  $renderForm();
           
             
            }
          if(!empty($image)){
              
               FileHelper::createDirectory($path);
               $image->saveAs($model->image);
                 
               if(!empty($oldImage) && file_exists($oldImage))  
                unlink($oldImage);
          }
          
           
             
              Yii::$app->session->setFlash('success',"Asset Type Updated"); 
              return $this->redirect(['index']);
        }
        
        if(Yii::$app->request->isAjax){
            
            return $this->renderAjax('_form', [
            'model' => $model,
        ]); 
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AssetTypes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AssetTypes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AssetTypes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AssetTypes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
