<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\StatutoryDeductions;
use frontend\modules\hr\models\StatutoryDeductionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
/**
 * StatutoryDeductionsController implements the CRUD actions for StatutoryDeductions model.
 */
class StatutoryDeductionsController extends Controller
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
     * Lists all StatutoryDeductions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StatutoryDeductionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StatutoryDeductions model.
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
     * Creates a new StatutoryDeductions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StatutoryDeductions();

        if (Yii::$app->request->post()) {
            $model->attributes=$_POST['StatutoryDeductions'];
           
            $renderForm=function()use($model){
               return $this->renderAjax('create', [
            'model' => $model,
        ]);    
            };
           
            if(!$flag=$model->save()){
            
            $errorMsg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$errorMsg); 
             
            }
          if(!$flag){
           
           return $renderForm();  
          }
          $succesMsg="Statutory Deduction Saved !" ;
        Yii::$app->session->setFlash('success',$succesMsg); 
            return $this->redirect(['index']);
        }
      
       if(Yii::$app->request->isAjax){
         
         return $this->renderAjax('create', [
            'model' => $model,
        ]);   
           
       }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StatutoryDeductions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       
            if (Yii::$app->request->post()) {
            $model->attributes=$_POST['StatutoryDeductions'];
            $renderForm=function()use($model){
               return $this->renderAjax('update', [
            'model' => $model,
        ]);    
            };
           
            if(!$flag=$model->save(false)){
            
            $errorMsg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$errorMsg); 
             
            }
          if(!$flag){
           
           return $renderForm();  
          }
          $succesMsg="Statutory Deduction Updated !" ;
        Yii::$app->session->setFlash('success',$succesMsg); 
            return $this->redirect(['index']);
        }
      
       if(Yii::$app->request->isAjax){
         
         return $this->renderAjax('update', [
            'model' => $model,
        ]);   
           
       }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
  

    /**
     * Deletes an existing StatutoryDeductions model.
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
     * Finds the StatutoryDeductions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StatutoryDeductions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StatutoryDeductions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
