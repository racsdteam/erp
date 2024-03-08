<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\EmpEmployment;
use frontend\modules\hr\models\EmpEmploymentSearch;
use frontend\modules\hr\models\Employees;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * EmpEmploymentController implements the CRUD actions for EmpEmployment model.
 */
class EmpEmploymentController extends Controller
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
     * Lists all EmpEmployment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpEmploymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmpEmployment model.
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
     * Creates a new EmpEmployment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmpEmployment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EmpEmployment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $copy = clone $model;
        $copy->employee_type=$model->employee0->employee_type;
        $modelOptions= new \yii\base\DynamicModel([
        'create', 
    ]);
    
    $modelOptions
      ->addRule(['create'],'boolean');
  
        
        $request=Yii::$app->request;
        
      

        if($copy->load($request->post())){
           
       
         
          $modelOptions->attributes=$request->post('DynamicModel');
          $renderForm=function()use(&$copy,&$modelOptions){
              return  $this->render('create', [
            'model' => $copy,'modelOptions'=>$modelOptions
        ]);
            };
          
           
          if(filter_var($modelOptions->create, FILTER_VALIDATE_BOOLEAN)){
              
          $newModel=new EmpEmployment();
          $newModel->setAttributes($copy->attributes);
          $newModel->isNewRecord=true;
          $newModel->id=null;
          $newModel->user=Yii::$app->user->identity->user_id;
          $newModel->timestamp=null;
          
          if(!$newModel->save()){
            
            $errorMsg=Html::errorSummary($newModel); 
            Yii::$app->session->setFlash('error', $errorMsg); 
            return  $renderForm();
           
             }
             
             $model->active=0;
             $employee=$model->employee0;
             $employee->employee_type=$copy->employee_type;
             $employee->save(false);
          }else{
              
               $model->attributes=$copy->attributes;
          }
          
          $model->save(false);
          
          Yii::$app->session->setFlash('success', "Employee Employment Details Updated!"); 
          return $this->redirect(['employees/view','id'=>$model->employee0->id]);
         
        }
        
        
        
       if($request->isAjax)
        return $this->renderAjax('_form', [
            'model' =>  $copy ,'modelOptions'=>$modelOptions
        ]);
        
        return $this->render('update', [
            'model' =>  $copy ,'modelOptions'=>$modelOptions
        ]);
    }

    /**
     * Deletes an existing EmpEmployment model.
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
     * Finds the EmpEmployment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmpEmployment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpEmployment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
