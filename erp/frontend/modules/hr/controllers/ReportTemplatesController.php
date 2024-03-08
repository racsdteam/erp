<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\ReportTemplates;
use frontend\modules\hr\models\ReportTemplatesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
/**
 * ReportTemplatesController implements the CRUD actions for ReportTemplates model.
 */
class ReportTemplatesController extends Controller
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
     * Lists all ReportTemplates models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportTemplatesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReportTemplates model.
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


  public function actionTest(){
       //---------call procedure-----------------
   // $rows=Yii::$app->db4->createCommand("CALL getRSSB_RAMA_CTB('ALL','2022','02','B')")->queryAll();
    //var_dump($rows);
    //var_dump(array_keys($rows[0]));
    //----------list all procedure---------------------------------------------
   //$rows=Yii::$app->db4->createCommand("SHOW PROCEDURE STATUS")->queryAll();
   //-------------------get table schema--------------------------------------
  // $table = Yii::$app->db4->getTableSchema('payslips');
  }
    /**
     * Creates a new ReportTemplates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReportTemplates();

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
           $successMsg="Report Template Saved !";
           Yii::$app->session->setFlash('success',$successMsg);
            return $this->redirect(['index']);
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
     * Updates an existing ReportTemplates model.
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
           $successMsg="Report Template Updated !";
           Yii::$app->session->setFlash('success',$successMsg);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ReportTemplates model.
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
     * Finds the ReportTemplates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReportTemplates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReportTemplates::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
