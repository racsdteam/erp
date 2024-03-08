<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\EmpPaySupplements;
use frontend\modules\hr\models\EmpPaySupplementsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
/**
 * EmpPaySupplementsController implements the CRUD actions for EmpPaySupplements model.
 */
class EmpPaySupplementsController extends Controller
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
     * Lists all EmpPaySupplements models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpPaySupplementsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmpPaySupplements model.
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
     * Creates a new EmpPaySupplements model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmpPaySupplements();
        $request=Yii::$app->request;
        
        if ($request->post() ) {
           
            $model->attributes=$_POST['EmpPaySupplements'];
            $renderForm=function()use($model){
              
            return $this->render('_form', [
            'model' => $model ]); 
           };
           
           if(!$success=$model->save()){
              
           $errorMsg= Html::errorSummary($model) ;
           }
          
           if(!$success){
           
           Yii::$app->session->setFlash('error', $errorMsg);
           return $renderForm;
          
           }
            
             Yii::$app->session->setFlash('success', "Additional Pay  Added!");
             return $this->redirect(['emp-pay-details/view', 'id' =>$model->employee0->payDetails->id]); 
             
           
           
          
        }
         
         
         $model->employee=$request->get('emp');
        
         if($request->isAjax){
            
            return $this->renderAjax('_form', [
            'model' => $model
        ]); 
        }

        return $this->render('_form', [
            'model' => $model
        ]);   
         
    }

    /**
     * Updates an existing EmpPaySupplements model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $request=Yii::$app->request;
       
       if ($request->post() ) {
           
            $model->attributes=$_POST['EmpPaySupplements'];
            $renderForm=function()use($model){
              
            return $this->render('_form', [
            'model' => $model ]); 
           };
           
           if(!$success=$model->save()){
              
           $errorMsg= Html::errorSummary($model) ;
           }
         
           if(!$success){
           
           Yii::$app->session->setFlash('error', $errorMsg);
           return $renderForm;
          
           }
            
        Yii::$app->session->setFlash('success', "Supplemental Pay  Updated!");
        return $this->redirect(['emp-pay-details/view', 'id' =>$model->employee0->payDetails->id]); 
             
           
           
          
        }
        
         if(Yii::$app->request->isAjax){
            
            return $this->renderAjax('_form', [
            'model' => $model,
        ]); 
        }

        return $this->render('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EmpPaySupplements model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        
        $this->findModel($id)->delete();
        $successMsg="Additional Pay item  Deleted!";  
     
         if(Yii::$app->request->isAjax) {
          \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; 
           
           return ['status'=>1,'data'=>['msg'=>$successMsg]]; 
              
              } 
    Yii::$app->session->setFlash('success', $successMsg);
        
    return $this->redirect(['emp-pay-details/view', 'id' => $_GET['pay_id']]);

        
    }

    /**
     * Finds the EmpPaySupplements model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmpPaySupplements the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpPaySupplements::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
