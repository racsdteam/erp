<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\ReportDatasets;
use frontend\modules\hr\models\ReportDatasetsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReportDatasetsController implements the CRUD actions for ReportDatasets model.
 */
class ReportDatasetsController extends Controller
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
     * Lists all ReportDatasets models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportDatasetsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReportDatasets model.
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
     * Creates a new ReportDatasets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReportDatasets();
        $render=function()use(&$model){
               return $this->render('create', [
            'model' => $model,
        ]); 
            };

      if ($model->load(Yii::$app->request->post())) {
          
         if(!$model->save()){
               $errorMsg=Html::errorSummary($model);
               Yii::$app->session->setFlash('error', $errorMsg);
               return $render();
           }
           $successMsg="DataSet Saved !";
           Yii::$app->session->setFlash('success',$successMsg);
            return $this->redirect(['index']);
        }
        
        $rptId=Yii::$app->request->get('id');
        if(!empty($rptId) && is_numeric($rptId)){
         
         $model->report=$rptId; 
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
     * Updates an existing ReportDatasets model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
if ($model->load(Yii::$app->request->post())) {
            $render=function()use($model){
               return $this->render('create', [
            'model' => $model,
        ]); 
            };
            
           if(!$model->save()){
               $errorMsg=Html::errorSummary($model);
               Yii::$app->session->setFlash('error', $errorMsg);
               return $render();
           }
           $successMsg="DataSet Updated !";
           Yii::$app->session->setFlash('success',$successMsg);
            return $this->redirect(['index']);
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
     * Deletes an existing ReportDatasets model.
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
     * Finds the ReportDatasets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReportDatasets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReportDatasets::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
