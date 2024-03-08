<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\LeaveApprovalTaskInstances;
use frontend\modules\hr\models\ApprovalWorkflowActions ;
use frontend\modules\hr\models\LeaveApprovalFlowComments;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
date_default_timezone_set('Africa/Cairo');

/**
 * LeaveApprovalTaskInstancesController implements the CRUD actions for LeaveApprovalTaskInstances model.
 */
class LeaveApprovalTaskInstancesController extends Controller
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
    
    public function actionTest($id){
        
       // var_dump(\common\models\UserHelper::getPosition(Yii::$app->user->identity->user_id)->reportingTo->position);
       $model=$this->findModel($id);
       var_dump($model->wfInst->workflowDef);
    }

    /**
     * Lists all LeaveApprovalTaskInstances models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => LeaveApprovalTaskInstances::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionPending(){
    
    $tasks=LeaveApprovalTaskInstances::find()->where(['assigned_to'=>Yii::$app->user->identity->user_id,'status'=>'pending'])->all();
    
    return $this->render('pending', [
            'tasks' => $tasks,
        ]);    
      }
           public function actionMyApprovals()
    {
         $tasks=LeaveApprovalTaskInstances::find()->where(['assigned_to'=>Yii::$app->user->identity->user_id])->andWhere(['<>','status','pending'])->all();
        return $this->render('my-approval', [
            'tasks' => $tasks,
        ]);
    }

   public function actionComplete(){
       
       if (Yii::$app->request->isAjax) {
        
        $post = Yii::$app->request->post();
        $res=[];
        
        $id=ArrayHelper::getValue($post, 'requestId');
        if($id==null){
         $res['status']='error';
         $res['error']="Invalid Request Id !";
         return $this->asJson($res);    
        }
        $actionCode=ArrayHelper::getValue($post, 'action');
        
        if($actionCode==null){
           $res['status']='error';
           $res['error']="Invalid Response Action !";
           return $this->asJson($res);   
        }
      $action=ApprovalWorkflowActions::findByCode($actionCode);
      $model=$this->findModel($id);
        
      $varMap=array();
      $varMap=array_merge($post,$varMap);
      $varMap['wfStep']=$model->wfStep;
      $varMap['outcome']=$action!=null ? strtolower($action->outcome) : null;
      $varMap['completed_by']=Yii::$app->user->identity->user_id;
    
      
      
              
      $res=$model->complete($varMap);
      if($res['status']!='success'){
         return $this->asJson($res);  
        }
      
   
        
        switch($actionCode){
        
            case ApprovalWorkflowActions::APRV_CODE:    //-----------------Approve Action
            case ApprovalWorkflowActions::RJT_CODE :     //-----------------Reject Action
            case ApprovalWorkflowActions::REV_CODE:    //--------------------Review & Forwrd 
            $res= $model->wfInst->completeStep($varMap);
             
             break;
             
              //-------------------request for edit action----------------------  
             case ApprovalWorkflowActions::RET_CODE:
            
            $res= $model->wfInst->returnForEdit($varMap);  
            
                break; 
          
           //-----------------reassign action----------------------     
             case ApprovalWorkflowActions::RASS_CODE:
                
                break;    
         
           //-------------------resubmit action-----------------------  
             case ApprovalWorkflowActions::RSBM_CODE:
                
                break;        
        }
      
       
        return $this->asJson( $res);
       
       } 
       
   }
   
   
    
    /**
     * Displays a single LeaveApprovalTaskInstances model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        $model=$this->findModel($id);
        $model->started_at=date('Y-m-d H:i:s');
        $model->save(false);
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new LeaveApprovalTaskInstances model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LeaveApprovalTaskInstances();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing LeaveApprovalTaskInstances model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LeaveApprovalTaskInstances model.
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
     * Finds the LeaveApprovalTaskInstances model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LeaveApprovalTaskInstances the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LeaveApprovalTaskInstances::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
   
}
