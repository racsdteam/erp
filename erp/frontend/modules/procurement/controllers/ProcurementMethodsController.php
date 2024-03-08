<?php

namespace frontend\modules\procurement\controllers;

use Yii;
use frontend\modules\procurement\models\ProcurementMethods;
use frontend\modules\procurement\models\ProcurementMethodsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * ProcurementMethodsController implements the CRUD actions for ProcurementMethods model.
 */
class ProcurementMethodsController extends Controller
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
     * Lists all ProcurementMethods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProcurementMethodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProcurementMethods model.
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
     * Creates a new ProcurementMethods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProcurementMethods();

        if ($model->load(Yii::$app->request->post())) {
            
            if($model->save()){
                
               Yii::$app->session->setFlash('success',"Procurement Method Saved!"); 
               return $this->redirect(['index']);  
            }
             
            else{
          
               Yii::$app->session->setFlash('error',Html::errorSummary($model));  
           }
              
        } 
       
        
        if(Yii::$app->request->isAjax)
        
         return $this->renderAjax('create', [
            'model' => $model,
        ]);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProcurementMethods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

         if ($model->load(Yii::$app->request->post())) {
            
            if($model->save()){
                
                Yii::$app->session->setFlash('success',"Procurement Method Updated!"); 
                return $this->redirect(['index']);
            }
            else{
             Yii::$app->session->setFlash('error',Html::errorSummary($model));  
           }  
                
        } 
        
           
        
        if(Yii::$app->request->isAjax)
        
         return $this->renderAjax('update', [
            'model' => $model,
        ]);

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProcurementMethods model.
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
     * Finds the ProcurementMethods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProcurementMethods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProcurementMethods::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
