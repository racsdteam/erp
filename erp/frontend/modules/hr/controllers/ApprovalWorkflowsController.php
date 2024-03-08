<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\ApprovalWorkflows;
use frontend\modules\hr\models\ApprovalProcessSteps;
use frontend\modules\hr\models\ApprovalWorkflowsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
//-------------------------------testing -------------------------------
use frontend\modules\hr\models\LeaveRequest;
/**
 * ApprovalWorkflowsController implements the CRUD actions for ApprovalWorkflows model.
 */
class ApprovalWorkflowsController extends Controller
{
   // public $enableCsrfValidation = false;
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
     * Lists all ApprovalWorkflows models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApprovalWorkflowsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

public function actionTestProcess(){
  
  $request=LeaveRequest::findOne(2);
  $approvalEngine=Yii::$app->approval;
  $process=$approvalEngine->getApprovalProcess($request,7);
  var_dump($process);

//var_dump(\common\models\UserHelper::getPositionInfo(62));
    
}
    /**
     * Displays a single ApprovalWorkflows model.
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
 public function actionSort($id){
      $model = $this->findModel($id);
       
        if (Yii::$app->request->post()) {
           $id_ary = explode(",",$_POST["row_order"]);
           $sequence=1;

	for($i=0;$i<count($id_ary);$i++) {
   
       $step=ApprovalProcessSteps::findOne($id_ary[$i]);
        
        if( $step!=null){
           
             $step->number= $sequence;
            if(!$flag= $step->save(false)){
              $errorMsg=Html::errorSummary($model); 
              Yii::$app->session->setFlash('error',$errorMsg);
              break;
              
            }
        }else{
            $flag=false;
            $errorMsg="line Step with Id ".$id_ary[$i]." not found"; 
            Yii::$app->session->setFlash('error',$errorMsg); 
            break;
        }
	    $sequence++; 
	}
       
      if($flag){
          $succesMsg="Approval Steps Order Changed !" ;
          Yii::$app->session->setFlash('success',$succesMsg);   
      }     
    
      return $this->redirect(['view','id'=>$model->id]);
        }
      
      return $this->render('_sort',['model'=>$model]);   
        
    }
 
 public function actionRemoveStep($stepId){
   
   $step=ApprovalProcessSteps::findOne($stepId);
   $app_wf=$step->app_wf;
   $step->delete();
   
   Yii::$app->session->setFlash('success',"Approval Step Deleted !"); 
   
   return $this->redirect(['view', 'id' =>$app_wf]);
   
     
 }   
    /**
     * Creates a new ApprovalWorkflows model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ApprovalWorkflows();

        if ($model->load(Yii::$app->request->post()) ) {
            
            $model->user=Yii::$app->user->identity->user_id;
           
            $renderForm=function()use($model){
              return $this->render('create', [
            'model' => $model,
            ]);  
            };
           
          
             if(!$this->isEmpty($_POST['ApprovalCondModel'])){
               $model->conditionModel->setAttributes($_POST['ApprovalCondModel']);
               $model->conditions=json_encode($model->conditionModel, JSON_PRETTY_PRINT);  
             }
           
            
            if(!$model->save()){
            
            $msg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$msg);
            return  $renderForm();
             
            }
            else{
                
               $msg="Approval Process Saved !" ;
               Yii::$app->session->setFlash('success',$msg); 
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
     * Updates an existing ApprovalWorkflows model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->initCondition();
        
         if ($model->load(Yii::$app->request->post()) ) {
            
             if(!$this->isEmpty($_POST['ApprovalCondModel'])){
               $model->conditionModel->setAttributes($_POST['ApprovalCondModel']);
               $model->conditions=json_encode($model->conditionModel, JSON_PRETTY_PRINT);   
             }
            
            if(!$model->save()){
            
            $msg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$msg); 
             
            }
            else{
                
               $msg="Approval process  Updated !" ;
               Yii::$app->session->setFlash('success',$msg); 
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
     * Deletes an existing ApprovalWorkflows model.
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
     * Finds the ApprovalWorkflows model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ApprovalWorkflows the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ApprovalWorkflows::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function isEmpty($post){
     
     $arr=array_filter($post, function( $field ){ return is_array($field) ? empty($field) : strlen( $field); });  
    if(empty($arr)){
        
      return true;  
    }
     
     
     return false;
        
    }
}
