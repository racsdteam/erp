<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\ApprovalWorkflowSteps;
use frontend\modules\hr\models\ApprovalWorkflowStepsSearch;
use frontend\modules\hr\models\ApprovalWorkflows;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * ApprovalWorkflowStepsController implements the CRUD actions for ApprovalWorkflowSteps model.
 */
class ApprovalWorkflowStepsController extends Controller
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
     * Lists all ApprovalWorkflowSteps models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApprovalWorkflowStepsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ApprovalWorkflowSteps model.
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
     * Creates a new ApprovalWorkflowSteps model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ApprovalWorkflowSteps();
        $model->initDefaultValues();
          
       
        
        if (Yii::$app->request->post()) {
            
          $model->attributes=$_POST['ApprovalWorkflowSteps'];
          $model->assignmentModel->setAttributes($_POST['StepAssignmentModel']);
          $model->assignment_type=json_encode($model->assignmentModel, JSON_PRETTY_PRINT);
          $model->task_actions=json_encode($model->outcomes, JSON_PRETTY_PRINT);
           $model->is_last_approval=(int)$_POST['ApprovalWorkflowSteps']['is_last_approval'];
          $model->user=Yii::$app->user->identity->user_id;
          
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
          $succesMsg="Approval Step Saved !" ;
          Yii::$app->session->setFlash('success',$succesMsg);   
          return $this->redirect(['approval-workflows/view', 'id' => $model->wf_def]);
        }
if(Yii::$app->request->isAjax)
        
    return $this->renderAjax('create', [
            'model' => $model
        ]);
        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing ApprovalWorkflowSteps model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $model->initAssignmentType();
        $model->initActions();

        if (Yii::$app->request->post()) {
          
          $model->setAttributes($_POST['ApprovalWorkflowSteps']);
          $model->assignmentModel->setAttributes($_POST['StepAssignmentModel']);
          $model->is_last_approval=(int)$_POST['ApprovalWorkflowSteps']['is_last_approval'];
          $model->assignment_type=json_encode($model->assignmentModel, JSON_PRETTY_PRINT);
          $model->task_actions=json_encode($model->outcomes, JSON_PRETTY_PRINT);
         
            $renderForm=function()use($model){
               return $this->renderAjax('update', [
            'model' => $model,
        ]);    
            };
           // var_dump($model->is_last_approval); die();
            if(!$flag=$model->save()){
            
            $errorMsg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$errorMsg); 
             
            }
          if(!$flag){
           
           return $renderForm();  
          }
          $succesMsg="Approval Step Updated !" ;
          Yii::$app->session->setFlash('success',$succesMsg);   
          return $this->redirect(['approval-workflows/view', 'id' => $model->wf_def]);
        }
if(Yii::$app->request->isAjax)
        
    return $this->renderAjax('update', [
            'model' => $model
        ]);
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    

    /**
     * Deletes an existing ApprovalWorkflowSteps model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $wfDef=$model->wf_def;
        $model->delete();
        Yii::$app->session->setFlash('success',"Approval Step Deleted !"); 
        return $this->redirect(['approval-workflows/view', 'id' =>$wf_def]);

        
    }

    /**
     * Finds the ApprovalWorkflowSteps model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ApprovalWorkflowSteps the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ApprovalWorkflowSteps::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
