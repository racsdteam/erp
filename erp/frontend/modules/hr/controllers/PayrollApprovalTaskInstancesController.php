<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PayrollApprovalTaskInstances;
use frontend\modules\hr\models\ApprovalWorkflowActions ;
use frontend\modules\hr\models\PayrollApprovalComments;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
/**
 * PayrollApprovalTaskInstancesController implements the CRUD actions for PayrollApprovalTaskInstances model.
 */
class PayrollApprovalTaskInstancesController extends Controller
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
     * Lists all PayrollApprovalTaskInstances models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PayrollApprovalTaskInstances::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayrollApprovalTaskInstances model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
 public function actionPending(){
    
    $tasks=PayrollApprovalTaskInstances::find()->where(['assigned_to'=>Yii::$app->user->identity->user_id,'status'=>'pending'])->all();
    return $this->render('pending', [
            'tasks' => $tasks,
        ]);    
      }
           public function actionMyApprovals()
    {
         $tasks=PayrollApprovalTaskInstances::find()->where(['assigned_to'=>Yii::$app->user->identity->user_id])->andWhere(['<>','status','pending'])->all();
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
            case ApprovalWorkflowActions::VF_CODE:    //--------------------Verfier 
            case ApprovalWorkflowActions::CTF_CODE:    //--------------------Certifier
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
            //-------------------resubmit action-----------------------  

        }
      
       
        return $this->asJson( $res);
       
       } 
       
   }
   
   
    
    /**
     * Displays a single PayrollApprovalTaskInstances model.
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
     * Creates a new PayrollApprovalTaskInstances model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PayrollApprovalTaskInstances();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PayrollApprovalTaskInstances model.
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
     * Deletes an existing PayrollApprovalTaskInstances model.
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
     * Finds the PayrollApprovalTaskInstances model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayrollApprovalTaskInstances the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayrollApprovalTaskInstances::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
