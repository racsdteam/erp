<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\EmpExcludedFromPay;
use frontend\modules\hr\models\EmpExcludedFromPaySearch;
use frontend\modules\hr\models\EmpEmployement;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * EmpExcludedFromPayController implements the CRUD actions for EmpExcludedFromPay model.
 */
class EmpExcludedFromPayController extends Controller
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
     * Lists all EmpExcludedFromPay models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpExcludedFromPaySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmpExcludedFromPay model.
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
     * Creates a new EmpExcludedFromPay model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmpExcludedFromPay();

         if ($model->load(Yii::$app->request->post()) ) {
            
            $model->user=Yii::$app->user->identity->user_id;
            $renderForm=function()use($model){
               
               return $this->render('_form', [
            'model' => $model,
        ]);   
                
            };
            
            $success=$error=false;
            
            if(!$model->save()){
            $success=false;
            $errorMsg=Html::errorSummary($model); 
            
             
            }
            else{
               $success=true; 
               $successMsg="Employee Excluded From Pay !" ;
             
               
            }
            
            if(!$success){
              Yii::$app->session->setFlash('error',$errorMsg);  
              return $renderForm();
            }
            Yii::$app->session->setFlash('success',$successMsg);  
            return $this->redirect(['index']);
        }
        
        if(Yii::$app->request->isAjax)
         return $this->renderAjax('_form', [
            'model' => $model,
        ]);
        return $this->render('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EmpExcludedFromPay model.
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
               
               return $this->render('_form', [
            'model' => $model,
        ]);   
                
            };
            
            $success=$error=false;
            
            if(!$model->save()){
            $success=false;
            $errorMsg=Html::errorSummary($model); 
            
             
            }
            else{
               $success=true; 
               $successMsg="Employee Exclude From Pay Updated !" ;
               
            }
            
            if(!$success){
              Yii::$app->session->setFlash('error',$errorMsg);  
              return $renderForm();
            }
            Yii::$app->session->setFlash('success',$successMsg);  
            return $this->redirect(['index']);
        }
if(Yii::$app->request->isAjax)
         return $this->renderAjax('_form', [
            'model' => $model,
        ]);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EmpExcludedFromPay model.
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
     * Finds the EmpExcludedFromPay model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmpExcludedFromPay the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpExcludedFromPay::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
