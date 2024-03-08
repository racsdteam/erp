<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\Payslips;
use frontend\modules\hr\models\PayItems;
use frontend\modules\hr\models\PayslipsSearch;
use frontend\modules\hr\models\PayslipItems;
use frontend\modules\hr\components\PaySlipCalculator;
use frontend\modules\hr\components\PayrollManager;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * PayslipsController implements the CRUD actions for Payslips model.
 */
class PayslipsController extends Controller
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
                    'delete' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all Payslips models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PayslipsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
        public function actionMyPayslips()
    {
       $employee=Yii::$app->empUtil->getEmpByUser(Yii::$app->user->identity->user_id);
       $searchModel = new PayslipsSearch();
       
       $params=array();
       $params['employee']=!empty($employee)? $employee->id:null;
       $params['status']="approved";
        
         $dataProvider = $searchModel->search([$searchModel->formName()=>$params]);
        return $this->render('my-payslip', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }
    
    /**
     * Displays a single Payslips model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
          if(Yii::$app->request->isAjax){
              return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
          }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionRefresh(){
      
      if(Yii::$app->request->isAjax){
         
         $data = Yii::$app->request->post();
         $ids=array_map('intval',json_decode($data['ids']));
         $payslips=Payslips::findAll($ids);
         if(!empty($payslips)){
           
           try {
   

   $slipManager = \Yii::createObject(PaySlipCalculator::className());
 
  foreach($payslips as $slip){
  
  $slipManager->calculate($slip,true);
    }

  $res['success']=true;
  $res['data']['msg']='payslip(s) refreshed !';
  
  return $this->asJson($res);

 
}catch(yii\base\UserException $e) {
    $res['success']=false;
    $res['data']['msg']=$e->getMessage();
    return $this->asJson($res);
}  
             
          }else{
              
         $res['success']=false;
       $res['data']['msg']= json_encode( $ids);
    return $this->asJson($res);     
              
             }
     
       }
        
        
    }
    public function actionAdjust(){
      if(Yii::$app->request->isAjax){
        
         $data = Yii::$app->request->post();
         $id=$data['slipId'];
         $item=array_keys($data)[1];
         $amount=empty($data[$item])? 0 : $data[$item];
         $action=$data['action'];
         $res=[];
         if($action=='edit'){
            
                  try {
       
        $model=Payslips::findOne($id);
        if($model==null)
        throw new UserException(sprintf("PaySlip with Id %u not found.",$id));
        
        $payItem=PayItems::findOne($item);
        if($payItem==null)
        throw new UserException(sprintf("PayItem with Id %u not found.",$item));
        
        $slipItem=PayslipItems::find()->where(['pay_slip'=>$model->id,'item'=>$payItem->id])->one();
         
         if($slipItem==null){
             $slipItem=new PayslipItems();
            
             }
         $slipItem->amount=$this->parseFloat($amount);
       
        if($slipItem->isNewRecord){
                  $slipItem->item=$item;
                  $slipItem->pay_slip=$model->id;
                  $slipItem->user=Yii::$app->user->identity->user_id;
               
                  }
                  
                  
  if(!$slipItem->save()){
                $res['success']=false;
                $res['data']['msg']=Html::errorSummary($slipItem);
                return $this->asJson($res); 
             }
   $slipManager = \Yii::createObject(PaySlipCalculator::className());
   
   $slipManager->calculate($model,true);
    

  $res['success']=true;
  $res['data']['msg']='payslip updated !';
  return $this->asJson($res);

 
}


catch(yii\base\UserException $e) {
    $res['success']=false;
    $res['data']['msg']=$e->getMessage();
    return $this->asJson($res);
}     
              
             }
    
            
    
      }
        
    }
    /**
     * Creates a new Payslips model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Payslips();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Payslips model.
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
    
    public function actionDeleteApi(){
        
        
         if(Yii::$app->request->isAjax){
         
         $data = Yii::$app->request->post();
         $ids=array_map('intval',json_decode($data['ids']));
       
         if(!empty( $ids)){
           
           try {
   
    Payslips::deleteAll(['id'=>$ids]);
   

  $res['success']=true;
  $res['data']['msg']='payslip(s) deleted !';
  
  return $this->asJson($res);

 
}catch(yii\base\UserException $e) {
    $res['success']=false;
    $res['data']['msg']=$e->getMessage();
    return $this->asJson($res);
}  
             
          }else{
              
         $res['success']=false;
         $res['data']['msg']= "invalid Payslip ids";
         return $this->asJson($res);     
              
             }
     
       }
    }

    /**
     * Deletes an existing Payslips model.
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
     * Finds the Payslips model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payslips the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payslips::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
   protected function  parseFloat($numString){
    
    return  filter_var($numString, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ); 
}

}
