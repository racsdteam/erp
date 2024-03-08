<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PayrollRepsApprovalRequests;
use frontend\modules\hr\models\PayrollRunReports;
use common\models\StartApprovalForm ;
use common\models\ApprovalRequest ;
use common\components\WorkFlowManager;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
/**
 * PayrollRepsApprovalRequestsController implements the CRUD actions for PayrollRepsApprovalRequests model.
 */
class PayrollRepsApprovalRequestsController extends Controller
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
                    'delete' => ['POST'], 'update' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PayrollRepsApprovalRequests models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PayrollRepsApprovalRequests::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
      public function actionApproved()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PayrollRepsApprovalRequests::find()->where(["status"=>"approved"]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayrollRepsApprovalRequests model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $wf=Yii::$app->wfManager->findWorkFlow($model);
        
        
        $firstReport = \yii\helpers\ArrayHelper::filter($model->getRunReports(), [0]);
        
        $content1=$this->renderPartial($firstReport[0]->views['pdf'], [
            'model' => $firstReport[0],'wf'=>!empty($wf)?$wf->id : null,
        ]); 
    
        return $this->render('view', [
            'model' => $model,'content1'=>$content1,'wf'=>$wf
        ]);
    }
     public function actionTest()
    {
        /*$model=$this->findModel($id);
       /* $model->trigger(PayrollRepsApprovalRequests::EVENT_REQUEST_APPROVAL); 
        var_dump("one");
        PayrollRepsApprovalRequests::findByPayroll(5);*/
        
        $class=\frontend\modules\hr\models\ApprovalWorkflowInstances::CLASS_MAP['PayrollRepsApprovalRequests'];
        var_dump(end( explode( "\\", $class)));
    }

    /**
     * Creates a new PayrollRepsApprovalRequests model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
      public function actionStartApproval($id){
    
       //-----------Payload---------------
       $model= PayrollRepsApprovalRequests::findOne($id); 
       //----------find workflow definition----------
       $approvalRequest=new ApprovalRequest();
       
      
      $goBack=function()use($model){
        return  $this->redirect(['view', 'id'=>$model->id]);
      }; 
       
        if(Yii::$app->request->post()){
         
         //-----inputs----------------------------------------   
        $approvalRequest->attributes=$_POST['ApprovalRequest'];
        $approvalRequest->entityRecord=$model;
        $approvalRequest->initiator=Yii::$app->user->identity->user_id;
     
         
         //----------wf instance--------------------------------------
         $wfInstance =Yii::$app->wfManager->createWorkflowInstance($approvalRequest);
         if($wfInstance==null){
          Yii::$app->session->setFlash('error',"Unable to  start approval ! , please contact administrator"); 
          return $goBack();    
          }
         
         
         if(!$wfInstance->isRunning()){
             
             
             $res=$wfInstance->run();
            
             if($res['status']!='success'){
              
               Yii::$app->session->setFlash('error',$res['error']); 
              
               
             }
             else{
                $model->status='processing';
                $model->save(false);
                Yii::$app->session->setFlash('success',"Payroll Approval has been submited for approval !");  
             }
              
             
         }   
            else{
               
                Yii::$app->session->setFlash('error',"Leave Request already submited for approval !"); 
              
           }    
           
           
            return $goBack();
          
          
         
          
           }
      
       
    if(Yii::$app->request->isAjax){
         
         return $this->renderAjax('start-approval', [
            'approvalRequest' =>$approvalRequest,'model'=>$model
        ]);   
           
       }
        return $this->render('start-approval', [
            'approvalRequest' =>$approvalRequest,'model'=>$model
        ]);  
        
    }
    
    public function actionApprovalHistory($id){
        
 $request=Yii::$app->request;
 
 if ($request->isAjax) {
       
       
            return   $this->renderAjax('approval-history',['model' => $this->findModel($id),'wf'=>$request->get('wf')]);
     
     
         }
         else{
             
              return $this->render('approval-history',['model' => $this->findModel($id),'wf'=>$request->get('wf')]);
         }

    } 
     
     
     
    public function actionCreate()
    {
        $model = new PayrollRepsApprovalRequests();

      if (Yii::$app->request->post()) {
           
            $post=$_POST['PayrollRepsApprovalRequests'];
          
            
            $myDateTime1 = \DateTime::createFromFormat('d/m/Y', $post['pay_period_start']);
            $myDateTime2 = \DateTime::createFromFormat('d/m/Y', $post['pay_period_end']);
            
            $model->attributes=$_POST['PayrollRepsApprovalRequests'];
            $model->pay_period_start=$myDateTime1->format('Y-m-d');
            $model->pay_period_end=$myDateTime2->format('Y-m-d');
            $model->user=Yii::$app->user->identity->user_id;
            $model->reports=Json::encode($_POST['PayrollRepsApprovalRequests']["reports"]);
            $success=true;
            $render=function()use($model){
             return $this->renderAjax('_form', [
            'model' => $model,
        ]);    
            };
            if(!$model->save()){
                 $success=false;
                 $errorMsg=Html::errorSummary($model); 
            }
            
            if(!$success){
              Yii::$app->session->setFlash('error',$errorMsg);
              return $render();
            }
            $successMsg='Payroll Reports Approval Resquest Saved!';
            Yii::$app->session->setFlash('success',$successMsg); 
            return $this->redirect(['index']);
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
     * Updates an existing PayrollRepsApprovalRequests model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post() && !empty($_POST['PayrollRepsApprovalRequests'])) {
            
            
            $post=$_POST['PayrollRepsApprovalRequests'];
            $myDateTime1 = \DateTime::createFromFormat('d/m/Y', $post['pay_period_start']);
            $myDateTime2 = \DateTime::createFromFormat('d/m/Y', $post['pay_period_end']);
            
            $model->attributes=$_POST['PayrollRepsApprovalRequests'];
            $model->pay_period_start=$myDateTime1->format('Y-m-d');
            $model->pay_period_end=$myDateTime2->format('Y-m-d');
            $model->PayrollRunReports=Json::encode($_POST['PayrollRepsApprovalRequests']["PayrollRunReports"]);
            $hasErrors=false;
            
            if(!$model->save()){
            
            $hasErrors=true;
        
            }
           
           if( $hasErrors){
              
            
              return $this->render('_form', [
            'model' => $model,
           
              ]);
        
           }
             $succesMsg="Payroll details Updated !" ;
             Yii::$app->session->setFlash('success',$succesMsg); 
             return $this->redirect(['index']);
        }
        
        $model->PayrollRunReports=Json::decode($model->PayrollRunReports);
       // var_dump($model->PayrollRunReports);die();
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
     * Deletes an existing PayrollRepsApprovalRequests model.
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
     * Finds the PayrollRepsApprovalRequests model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayrollRepsApprovalRequests the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayrollRepsApprovalRequests::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
