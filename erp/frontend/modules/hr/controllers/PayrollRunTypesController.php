<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PayrollRunTypes;
use frontend\modules\hr\models\PayrollRunTypesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayrollRunTypesController implements the CRUD actions for PayrollRunTypes model.
 */
class PayrollRunTypesController extends Controller
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
     * Lists all PayrollRunTypes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayrollRunTypesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayrollRunTypes model.
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
     * Creates a new PayrollRunTypes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PayrollRunTypes();


        if ($model->load(Yii::$app->request->post()) ) {
            
            $render=function()use($model){
                return $this->render('create', [
            'model' => $model,
        ]);  
            };
            
            if(!$model->save()){
            
            $msg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$msg); 
            $success=false; 
            }
            else{
               $success=true; 
               $msg="Payroll Category Saved !" ;
               Yii::$app->session->setFlash('success',$msg); 
            }
            
            if(!$success){
              
              return  $render();  
            } 
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
     * Updates an existing PayrollRunTypes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       if ($model->load(Yii::$app->request->post()) ) {
            
            $render=function()use($model){
                return $this->render('create', [
            'model' => $model,
        ]);  
            };
            
            if(!$model->save()){
            
            $msg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$msg); 
            $success=false; 
            }
            else{
               $success=true; 
               $msg="Payroll Category Updated!" ;
               Yii::$app->session->setFlash('success',$msg); 
            }
            
            if(!$success){
              
              return  $render();  
            } 
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
     * Deletes an existing PayrollRunTypes model.
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
     * Finds the PayrollRunTypes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayrollRunTypes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayrollRunTypes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
