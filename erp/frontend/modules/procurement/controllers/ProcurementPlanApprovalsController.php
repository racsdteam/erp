<?php

namespace frontend\modules\procurement\controllers;

use Yii;
use frontend\modules\procurement\models\ProcurementPlanApprovals;
use frontend\modules\procurement\models\ProcurementPlanApprovalsSearch;
use frontend\modules\procurement\models\ProcurementPlans;
use frontend\modules\hr\models\ApprovalWorkflowActions ;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
date_default_timezone_set('Africa/Cairo');

/**
 * ProcurementPlanApprovalsController implements the CRUD actions for ProcurementPlanApprovals model.
 */
class ProcurementPlanApprovalsController extends Controller
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
     * Lists all ProcurementPlanApprovals models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProcurementPlanApprovalsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single ProcurementPlanApprovals model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
         $model=$this->findModel($id);
         $model->trigger(ProcurementPlanApprovals::EVENT_APPROVAL_STARTED); 
         return $this->render('view', [
            'model' => $model
        ]);
    }
    
    
   public function actionPending(){
    
 
        
       $searchModel = new ProcurementPlanApprovalsSearch();
       $dataProvider = $searchModel->search([$searchModel->formName()=>['assigned_to'=>Yii::$app->user->identity->user_id,'status'=>'pending']]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
     * Creates a new ProcurementPlanApprovals model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProcurementPlanApprovals();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProcurementPlanApprovals model.
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
     * Deletes an existing ProcurementPlanApprovals model.
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
     * Finds the ProcurementPlanApprovals model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProcurementPlanApprovals the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProcurementPlanApprovals::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
