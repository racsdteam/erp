<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\EmpPayDetails;
use frontend\modules\hr\models\EmpPayDetailsSearch;
use frontend\modules\hr\models\EmpPayAdditional;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EmpPayDetailsController implements the CRUD actions for EmpPayDetails model.
 */
class EmpPayDetailsController extends Controller
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
     * Lists all EmpPayDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpPayDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmpPayDetails model.
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
    
   
   public function actionRevise($id){
       
      return $this->render('_revision', [
            'model' => $this->findModel($id),
        ]);  
       
       
       
   }

   public function actionRemovePay(){
             
             if(Yii::$app->request->post()){
                 
             $model =EmpPayAdditional::find()->where(['employee'=>$_POST['employee'],'pay_id'=>$_POST['payid'],'id'=>$_POST['lineitem']])->one();
              
             if($model!=null){
              
              
              if($model->delete()){
                 $msg='Item has been excluded from employee pay ';
                 $success=true;
             }else{
                 $error=sprintf("unable to remove line item id :  %u !", $data['lineitem']);
                 $success=false;
                 
              }    
               }else{
                   
                  
                   $error=sprintf("the line item id :  %u not found !",$data['lineitem']) ;
                   $success=false;
                 } 
                 
             if(!$success)
             Yii::$app->session->setFlash('error', $error);
             Yii::$app->session->setFlash('success', $msg);
             return $this->redirect(['view','id'=>$_POST['payid']]);
             }
              
             
    }
    /**
     * Creates a new EmpPayDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmpPayDetails();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EmpPayDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $copy = clone $model;
        
        
        $modelOptions= new \yii\base\DynamicModel([
        'create', 
    ]);
    
    $modelOptions
      
    ->addRule(['create'],'boolean');
  
        
        $request=Yii::$app->request;

        if($copy->load($request->post())) {
           
          $modelOptions->attributes=$request->post('DynamicModel');
         
          $renderForm=function()use(&$copy,&$modelOptions){
              return  $this->render('create', [
            'model' => $copy,'modelOptions'=>$modelOptions
        ]);
            };
          if(filter_var($modelOptions->create, FILTER_VALIDATE_BOOLEAN)){
              
          $newModel=new EmpPayDetails();
          $newModel->setAttributes($copy->attributes);
          $newModel->isNewRecord=true;
          $newModel->id=null;
          $newModel->created_by=Yii::$app->user->identity->user_id;
          $newModel->created=null;
          
          if(!$newModel->save()){
            
            $errorMsg=Html::errorSummary($newModel); 
            Yii::$app->session->setFlash('error', $errorMsg); 
            return  $renderForm();
           
             }
             
             $model->active=0;
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
     * Deletes an existing EmpPayDetails model.
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
     * Finds the EmpPayDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmpPayDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpPayDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
