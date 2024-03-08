<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\EmpPayRevisions;
use frontend\modules\hr\models\EmpPayRevisionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\hr\models\EmpPayDetails;
use frontend\modules\hr\models\Employees;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\base\UserException;
/**
 * EmpPayRevisionsController implements the CRUD actions for EmpPayRevisions model.
 */
class EmpPayRevisionsController extends Controller
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
                    'activate'=>['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all EmpPayRevisions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpPayRevisionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EmpPayRevisions model.
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
     * Creates a new EmpPayRevisions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmpPayRevisions();
        $newPay=new EmpPayDetails();
        $request=Yii::$app->request;

        if ($request->post()) {
            $employee=$request->post('employee');
            $newPay->attributes=$request->post('EmpPayDetails');
            $model->attributes=$request->post('EmpPayRevisions');
            $payoutYM=explode("-",$model->payout_ym);
            $model->payout_month=$payoutYM[0];
            $model->payout_year=$payoutYM[1];
            
            $renderForm=function()use($model,$newPay,$employee){
              return  $this->render('create', [
            'model' => $model,'newPay'=>$newPay,'employee'=>Employees::findOne($employee)
        ]);
            };
         
           if($model->payout_month==date('m') && ($model->effective_date >=date("Y-m-d"))){
            $newPay->active=1;
             }else{
            $newPay->active=0;     
                 
             }
            $newPay->created_by=Yii::$app->user->identity->user_id; 
                     $transaction = \Yii::$app->db4->beginTransaction();
                try {
                    
                   try{
                       
                         if(!$newPay->save()){
            
            $errorMsg=Html::errorSummary($newPay); 
            Yii::$app->session->setFlash('error', $errorMsg); 
            throw new UserException($errorMsg);
           
             }
             
           
            if($newPay->active){
                $model->status='activated';
                $model->activation_date=date("Y-m-d H:i:s");
                
                $oldPay=EmpPayDetails::findOne($model->previous_pay);
                $oldPay->active=0;
                $oldPay->save(false);
            }
           $model->revised_pay=$newPay->id;
           $model->user=Yii::$app->user->identity->user_id;   
          if(!$model->save()){
            
            $errorMsg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error', $errorMsg); 
             throw new UserException($errorMsg);
          
             }
             
             $transaction->commit();
             Yii::$app->session->setFlash('success', "Employee Pay Revision Saved!"); 
             return $this->redirect(['emp-pay-details/index']);
                       
                   }
                    catch (UserException $e) {
                    $transaction->rollBack();
                    return $renderForm(); 
                }
                 
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
       
         
          
        }
        
        $empId=$request->get('emp');
        $employee=Employees::findOne($empId);
        if(empty($employee)){
         Yii::$app->session->setFlash('error',"Employee Not Found !");     
         return $this->redirect(['emp-pay-details/index']);    
        }
      
            /* $newPay->setAttributes($employee->payDetails->attributes);
              unset($newPay->id,$newPay->base_pay);*/
              
          return $this->render('create', [
            'model' => $model,'newPay'=>$newPay,'employee'=>$employee
        ]);
          
            
        
       
    }


public function actionActivate(){
 
 $res=[];
 $request=Yii::$app->request;
 $id=$request->queryParams['id'];
 if(empty($id)){
 $res['success']=false;
 $res['data']['msg']='Invalid Revision Id';
 return $this->asJson($res);    
 }
  if ($request->isAjax) {
  
   $model = $this->findModel($id);
   $model->status='activated';
   $model->activation_date=date("Y-m-d H:i:s");
   $model->save(false);
   $model->trigger(EmpPayRevisions::EVENT_REVISION_ACTIVATED);
   
 $res['success']=true;
 $res['data']['msg']='Pay Revision Activated !';
 return   $this->asJson($res);   
      
  }
 
 

    
    
}
    /**
     * Updates an existing EmpPayRevisions model.
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
     * Deletes an existing EmpPayRevisions model.
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
     * Finds the EmpPayRevisions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EmpPayRevisions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EmpPayRevisions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
