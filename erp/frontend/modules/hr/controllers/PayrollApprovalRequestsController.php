<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PayrollApprovalRequests;
use frontend\modules\hr\models\Payrolls;
use frontend\modules\hr\models\PayrollRunReports;
use frontend\modules\hr\models\PayrollChanges;
use common\models\StartApprovalForm ;
use common\models\ApprovalRequest ;
use common\models\ApprovalFlowRequest ;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Html;
/**
 * PayrollApprovalRequestsController implements the CRUD actions for PayrollApprovalRequests model.
 */
class PayrollApprovalRequestsController extends Controller
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
     * Lists all PayrollApprovalRequests models.
     * @return mixed
     */
    public function actionIndex()
    {
        
       
        $dataProvider = new ActiveDataProvider([
            'query' => PayrollApprovalRequests::find(),
            'pagination'=>false
        ]);
        
        $dataProvider->sort->attributes['pay_period_month'] = [
    'asc' => [
        new \yii\db\Expression("TRIM(LEADING '0' FROM pay_period_month) DESC"),
        'pay_period_month' => SORT_ASC,
     ],
     'desc' => [
         new \yii\db\Expression("TRIM(LEADING '0' FROM pay_period_month) DESC"),
         'pay_period_month' => SORT_DESC,
     ],
     'desc'    => ['timestamp' => SORT_DESC],
    
];

$dataProvider->sort->defaultOrder = ['pay_period_year' => SORT_DESC,'pay_period_month' => SORT_DESC,'timestamp' => SORT_DESC];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
      public function actionApproved()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PayrollApprovalRequests::find()->where(["status"=>"approved"]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayrollApprovalRequests model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $wf=Yii::$app->wfManager->findWorkFlow($model);
       if($model->isSALApproval()){
           $appEntity=\yii\helpers\ArrayHelper::filter($model->getPayrolls(), [0]);
           if(($changes=PayrollChanges::findByPayPeriod($model->pay_period_year,$model->pay_period_month))!=null){
            $content1=$this->renderPartial('@frontend/modules/hr/views/payroll-changes/pdf',["model"=>$changes,'wf'=>$wf]);
           }else{
             
             $content1=$this->renderPartial($appEntity[0]->views['pdf'], [
            'model' =>$appEntity[0],'approval_id'=>$model->id,'wf'=>$wf
        ]);  
               
           }
          }
          
      else if($model->isDCApproval()){
        $appEntity=\yii\helpers\ArrayHelper::filter($model->getReports(), [0]);   
        $content1=$this->renderPartial($appEntity[0]->views['pdf'], [
            'model' =>$appEntity[0],'approval_id'=>$model->id,'wf'=>$wf
        ]);   
      }   
       
        return $this->render('view', [
            'model' => $model,'content1'=>$content1,'wf'=>$wf
        ]);
    }
     public function actionTest()
    {
        //$model=$this->findModel($id);
       /* $model->trigger(PayrollApprovalRequests::EVENT_REQUEST_APPROVAL); 
        var_dump("one");*/
       var_dump( PayrollApprovalRequests::findByPayRunId(6));
    }

    /**
     * Creates a new PayrollApprovalRequests model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
      public function actionStartApproval($id){
    
       //-----------Payload---------------
       $model= PayrollApprovalRequests::findOne($id); 
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
                $model->trigger(PayrollApprovalRequests::EVENT_REQUEST_SUBMISSION); 
                
                Yii::$app->session->setFlash('success',"Payroll Approval has been submited for approval !");  
             }
              
             
         }   
            else{
               
                Yii::$app->session->setFlash('error',"Payroll Approval already submited for approval !"); 
              
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
    
      public function actionConfirmApproval(){
          
          if (Yii::$app->request->isAjax) {
              $request=Yii::$app->request;
              $requestId=$request->get('requestId');
              $actorId=$request->get('actorId');
             
              
              if(empty($requestId)){
         $res['status']='error';
         $res['error']="Unable to confirm your approval, Invalid Request Id !";
         return $this->asJson($res);    
        }
        
         $model= PayrollApprovalRequests::findOne($requestId);
         
         if(!empty($model->getPayrolls())){
             
         $ids = ArrayHelper::getColumn($model->getPayrolls(), 'id');
         $toApprove =Payrolls::find()->where(['in','id',$ids])->andwhere('id NOT IN (SELECT doc from payroll_approval_annotations where author='.$actorId.')')->asArray()->all();
         if(!empty($toApprove)){
             
         $msg='<p> Following payrolls are not signed ! : </p>';
         $ol='<ol>';
         foreach($toApprove as $prl){
             $ol.='<li>'.$prl['name'].'</li>';
             
         }
         $res['status']='error';
         $res['data']['msg']=$msg;
         $res['data']['content']=$ol;
         return $this->asJson($res);  
         }
         
            }
      if(!empty($model->getReports())){
             
         $ids = ArrayHelper::getColumn($model->getReports(), 'id');
         $toApprove =PayrollRunReports::find()->where(['in','id',$ids])->andwhere('id NOT IN (SELECT doc from payroll_reps_approval_annotations where author='.$actorId.')')->asArray()->all();
         if(!empty($toApprove)){
             
         $msg='<p> Following payroll report(s) are not signed ! : </p>';
         $ol='<ol>';
         foreach($toApprove as $rpt){
             $ol.='<li>'.$rpt['rpt_desc'].'</li>';
             
         }
         $res['status']='error';
         $res['data']['msg']=$msg;
         $res['data']['content']=$ol;
         return $this->asJson($res);  
         }
         
            }
         $res['status']='success';
         $res['data']['msg']='all documents signed';
         return $this->asJson($res);
       
       } 
          
      }
    
    public function actionApprovalHistory($id){
        
        
 if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('approval-history',['model' => $this->findModel($id)]);
     
     
         }
         else{
             
              return $this->render('approval-history',['model' => $this->findModel($id)]);
         }

    } 
     
     
     
    public function actionCreate()
    {
        $model = new PayrollApprovalRequests();

      if (Yii::$app->request->post()) {
           
           $model->attributes=$_POST['PayrollApprovalRequests'];
          
            
            $myDateTime1 = \DateTime::createFromFormat('d/m/Y', $model->pay_period_start);
            $myDateTime2 = \DateTime::createFromFormat('d/m/Y', $model->pay_period_end);
            
            $payrolls=ArrayHelper::getValue($_POST['PayrollApprovalRequests'], 'payrolls');
            $reports=ArrayHelper::getValue($_POST['PayrollApprovalRequests'], 'reports');
            
            $model->pay_period_start=$myDateTime1->format('Y-m-d');
            $model->pay_period_end=$myDateTime2->format('Y-m-d');
            $model->user=Yii::$app->user->identity->user_id;
            $model->payrolls=empty($payrolls)?null : Json::encode($payrolls,JSON_UNESCAPED_SLASHES);//remove backslashes
            $model->reports=empty($reports)?null : Json::encode($reports,JSON_UNESCAPED_SLASHES);
          
            $success=true;
            $render=function()use($model){
             return $this->render('_form', [
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
            $successMsg='Payroll Approval Resquest Saved!';
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
     * Updates an existing PayrollApprovalRequests model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post()) {
            
            
            $payrolls=ArrayHelper::getValue($_POST['PayrollApprovalRequests'], 'payrolls');
            $reports=ArrayHelper::getValue($_POST['PayrollApprovalRequests'], 'reports');
         
            $newpayrolls=empty($payrolls)?[] : $payrolls;
            $newreports=empty($reports)? []: $reports;
            $oldpayrolls=empty($model->payrolls)?[]:json_decode($model->payrolls);
            $oldreports=empty($model->reports)?[]:json_decode($model->reports);
             
            $model->attributes=$_POST['PayrollApprovalRequests'];
           
            $model->payrolls=Json::encode(array_merge($oldpayrolls,$newpayrolls),JSON_UNESCAPED_SLASHES);
            $model->reports=Json::encode(array_merge($oldreports,$newreports),JSON_UNESCAPED_SLASHES);
            
           
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
        
        $model->payrolls=Json::decode($model->payrolls);
        $model->reports=Json::decode($model->reports);
        
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
     * Deletes an existing PayrollApprovalRequests model.
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
     * Finds the PayrollApprovalRequests model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayrollApprovalRequests the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayrollApprovalRequests::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
