<?php

namespace frontend\modules\logistic\controllers;

use Yii;
use common\models\RequestToStock;
use common\models\FuelVoucherInfo;
use common\models\ItemsRequest;
use common\models\ActualStock;
use common\models\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
/**
 * RequestToStockController implements the CRUD actions for RequestToStock model.
 */
class RequestToStockController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
                           'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                 
                   [
        'actions' => ['index'],
        'allow' => true,
        'matchCallback' => function ($rule, $action) {
            return \Yii::$app->user->identity->isAdmin() || \Yii::$app->user->identity->role->role_name=='Logistics'|| \Yii::$app->user->identity->user_id==15;
        },
    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                     'delete-fuel-out' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all RequestToStock models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RequestToStock::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
      public function actionFuelIndex()
    {
     
        return $this->render('fuel_index');
    }
    
    
             public function actionDone($id)
    {
         if(!isset($id) || $id==null){
          Yii::$app->session->setFlash('failure',"Invalid Memo ID");    
             
         }else{
             $user=Yii::$app->user->identity->user_id; 
              Yii::$app->db1->createCommand()
                      ->update('request_approval_flow', ['status' =>'archived'], ['request' =>$id,'approver'=>$user,'status' =>'pending'])
                      ->execute();  
                  Yii::$app->session->setFlash('success',"Stock Voucher has been succesfully archived"); 
             
           }
         
  
       return $this->redirect(['pending']);
    }
                 public function actionChangeStatus($id,$status)
    {
         if(!isset($id) || $id==null || !isset($status) || $status==null ){
          Yii::$app->session->setFlash('failure',"Invalid Request");    
             
         }else{
             
          $model= $this->findModel($id);
           $model->status=$status;
           $model->save(false);
           if($status=="approved"):
                 $q88="update  items_request  set status='approved' where request_id=".$id."";
       $command88= Yii::$app->db1->createCommand($q88);
       $row88 = $command88->execute();
            Yii::$app->db1->createCommand()
                      ->update('request_to_stock', ['out_status' =>'1'], ['reqtostock_id' =>$id])
                      ->execute();  
                      
    $q88="update  items_request  set out_status='1', out_date='".date("Y-m-d")."' where request_id=".$id."";
       $command88= Yii::$app->db1->createCommand($q88);
       $row88 = $command88->execute();
       endif;
           }
         
  
       return $this->redirect(['index']);
    }
                public function actionUpdateItemStatus()
    {
         
          $models= RequestToStock::find()->where(["status"=>"approved"])->all();
           
          foreach($models as $model):
                 $q88="update  items_request  set status='approved' where request_id=".$model->reqtostock_id."";
     $command88= Yii::$app->db1->createCommand($q88);
      $row88 = $command88->execute();
       endforeach;
        
       return $this->redirect(['index']);
    }
    
                 public function actionOutStock($id)
    {
         if(!isset($id) || $id==null){
          Yii::$app->session->setFlash('failure',"Invalid Memo ID");    
             
         }else{
             $user=Yii::$app->user->identity->user_id; 
              Yii::$app->db1->createCommand()
                      ->update('request_to_stock', ['out_status' =>'1'], ['reqtostock_id' =>$id])
                      ->execute();  
                      
    $q88="update  items_request  set out_status='1', out_date='".date("Y-m-d")."' where request_id=".$id."";
       $command88= Yii::$app->db1->createCommand($q88);
       $row88 = $command88->execute();
       
       
                  Yii::$app->session->setFlash('success',"Stock Voucher has been succesfully out of stock"); 
             
           }
         
  
       return $this->redirect(['approved']);
    }
    
    
     public function actionDraft()
    {
        return $this->render('draft');
    }
    public function actionPending()
    {
        return $this->render('pending');
    }
      public function actionDocTracking($id){

 if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('doc-tracking',['id'=>$id]);
     
     
         }
         else{
             
              return $this->render('doc-tracking',['id'=>$id]);
         }

   
    
    }
      public function actionMyVouchers()
    {
        return $this->render('myvoucher');
    }
    public function actionApproved()
    {
        return $this->render('approved');
    }
    /**
     * Displays a single RequestToStock model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     
     
        public function actionPdfData($id)
    {
   $model= $this->findModel($id);

       \yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
 
  
          $url = "css/kv-mpdf-bootstrap.min.css";
          $stylesheet = file_get_contents($url);
          
          $url1 = "css/mpdf.css";
          $stylesheet1 = file_get_contents($url1);
       
        $mpdf = new \Mpdf\Mpdf(['format' =>'A4','mode'=>'c']);
        //----------------------------add bootsrap classes---------------------------
       $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
       //------------------------bootsr grid system---------------------------------
        $mpdf->WriteHTML($stylesheet1, \Mpdf\HTMLParserMode::HEADER_CSS);
     //-----------------prevent body overlapping footer-----------------------------------------     
         $mpdf->curlAllowUnsafeSslRequests = true;
         $mpdf->setAutoBottomMargin = 'stretch';
        //--------------------------setting footer-------------------------------------
        $mpdf->SetHTMLFooter('<img src="img/footer.png"/>');
       
        
         
         $mpdf->WriteHTML($this->renderPartial('view', [
            'model' => $model,]));
       $content= $mpdf->Output();
       return $content;
        exit;
    }
    
         public function actionFetchTab()
    {
    $step_number = $_REQUEST["step_number"];
  
    if(isset($_GET['active-step'])){
        
        $step_number=$_GET['active-step']; 
    }
    
    if(isset($_GET['id'])){
        
        $model =RequestToStock::find()->where(['reqtostock_id' =>$_GET['id']])->one();
      
   if($step_number==0){
           
        
        if($model!=null){
            
          return $this->renderAjax('page-viewer1', [
         'model' => $model,
         
    ]);
        
         
        }else{
            
            
             return   ' <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops!  Items request not found.</h3>

          <p>
            We could not find Items request .
            
          </p>

        </div>
     
      </div>';
        }
       
       
           }
    }
    }
    
    
    public function actionView($id)
    {
        return $this->render('viewer', [
            'model' => $this->findModel($id),
        ]);
    }
 public function actionCheckOut($id)
    {
        
         if(Yii::$app->request->post()){
             $items=$_POST['ItemsRequest'];
             foreach($items as $item)
             {
     
                 $model1 = new ItemsRequest;
                 $model1= $this->findModel1($item["id"]);
                  if(Yii::$app->logistic->getActualStock($model1->it_id)==0)
                                {
                                   $model1->out_qty=0; 
                                }else{
                 $model1->out_qty=$item['out_qty'];
                                }
                 $model1->comment=$item['comment'];
                 $model1->save(false);
        
             }
          
                return $this->redirect(['pending']);
         }
         $modelsItem = new ItemsRequest;
        return $this->render('check-out', [
            'model' => $this->findModel($id),'modelsItem' => $modelsItem,
        ]);
    }

    public function actionFuelOut()
    {
        $model = new FuelVoucherInfo();
        $modelItem = new ItemsRequest;
         if(Yii::$app->request->post()){
             
           $modelItem->attributes=$_POST['ItemsRequest']; 
           $modelItem->out_qty=$modelItem->req_qty;
           $modelItem->status="approved";
           $modelItem->request_id =0 ;
           $modelItem->user=Yii::$app->user->identity->user_id;
           $modelItem->out_date=date("Y-m-d");
            $modelItem->out_status=1;
            $modelItem->save(false);
            $model->attributes=$_POST['FuelVoucherInfo']; 
            $model->item_request_id=$modelItem->id;
            $model->user_id=Yii::$app->user->identity->user_id;
           
       If($model->save() ){
               Yii::$app->session->setFlash('success',"fuel Voucher is saved  !"); 
             return $this->redirect(['fuel-out']);
       }  else{
               Yii::$app->session->setFlash('error',"fuel Voucher could not be saved  !"); 
       }
    
     
      
       }
      
        return $this->render('_fuel_form', [
            'model' => $model,'modelItem' => $modelItem,
        ]);
    }

    /**
     * Creates a new RequestToStock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RequestToStock();
        $modelsItem = [new ItemsRequest];
         if(Yii::$app->request->post()){
       
            $model->staff_id=Yii::$app->user->identity->user_id;

if($flag=$model->save(false)){

                 $modelsItem= Model::createMultiple(ItemsRequest::classname());
                 Model::loadMultiple($modelsItem , Yii::$app->request->post()); 
  
  //---------------------------------check items------------------------------------------------------               
                 if(!empty($modelsItem)){
                     
                     
                 
                    $transaction = \Yii::$app->db->beginTransaction();
                try {
                    
                     
                        foreach ($modelsItem as $modelItem) {
                           
                               
                                 if($modelItem !=new ItemsRequest()){
                                
                                if(Yii::$app->logistic->getActualStock($modelItem->it_id)==0)
                                {
                                   $modelItem->req_qty=0; 
                                }
                                
                                $modelItem->request_id =$model->reqtostock_id ;
                                $modelItem->user=Yii::$app->user->identity->user_id;
                            
                            if (! ($flag = $modelItem->save(false))) {
                                $transaction->rollBack();
                               
                                Yii::$app->session->setFlash('failure',Html::errorSummary($modelItem));  
                                  
                            }
                        }
                    
                }
                    if ($flag) {
                        $transaction->commit();
                      
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
                  } 

    
       return $this->redirect(['draft']);
      
       }
       else{
           
          Yii::$app->session->setFlash('failure',"Voucher could not be saved  !"); 
           
           
         }
       
           
           
           
       }

        return $this->render('create', [
            'model' => $model,'modelsItem' => $modelsItem,
        ]);
    }

    /**
     * Updates an existing RequestToStock model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     
      public function actionUpdateFuelOut($id)
    {
        $model = FuelVoucherInfo::find()->where(['id'=>$id])->one();
        $modelItem = ItemsRequest::find()->where(['id'=>$model->item_request_id])->one();
         if(Yii::$app->request->post()){
             
           $modelItem->attributes=$_POST['ItemsRequest']; 
           $modelItem->out_qty=$modelItem->req_qty;
           $modelItem->status="approved";
           $modelItem->request_id =0 ;
           $modelItem->user=Yii::$app->user->identity->user_id;
            $modelItem->save(false);
            $model->attributes=$_POST['FuelVoucherInfo']; 
            $model->item_request_id=$modelItem->id;
            $model->user_id=Yii::$app->user->identity->user_id;
           
       If($model->save()){
               Yii::$app->session->setFlash('success',"fuel Voucher is saved  !"); 
             return $this->redirect(['fuel-out']);
       }  else{
               Yii::$app->session->setFlash('error',"fuel Voucher could not be saved  !"); 
       }
    
     
      
       }
      
        return $this->render('_fuel_form', [
            'model' => $model,'modelItem' => $modelItem,
        ]);
    }
    
     
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsItem = ItemsRequest::find()->where(['request_id'=>$model->reqtostock_id])->all();
        if(Yii::$app->request->post()){
            
             $oldIDs = ArrayHelper::map($modelsItem, 'id', 'id');
             $modelsItem= Model::createMultiple(ItemsRequest::classname(),$modelsItem);
            Model::loadMultiple($modelsItem , Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsItem, 'id', 'id')));
            
            
               if(!empty($modelsItem)){
                     
                      if (!empty($deletedIDs)) {
                        ItemsRequest::deleteAll(['id' => $deletedIDs]);
                    }
                 
                    $transaction = \Yii::$app->db->beginTransaction();
                try {
                    
                     
                        foreach ($modelsItem as $modelItem) {
                           
                               
                                 if($modelItem !=new ItemsRequest()){
                                
                                $modelItem->request_id =$model->reqtostock_id ;
                                $modelItem->user=Yii::$app->user->identity->user_id;
                            
                            if (! ($flag = $modelItem->save(false))) {
                                $transaction->rollBack();
                               
                                Yii::$app->session->setFlash('failure',Html::errorSummary($modelItem));  
                                  
                            }
                        }
                    
                }
                    if ($flag) {
                        $transaction->commit();
                      
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
                  }
                  
            return $this->redirect(['draft']);
        }

        return $this->render('update', [
            'model' => $model, 'modelsItem' => $modelsItem,
        ]);
    }
      public function actionDeleteFuelOut($id)
    {
       $model = FuelVoucherInfo::find()->where(['id'=>$id])->one();
       $modelItem = ItemsRequest::find()->where(['id'=>$model->item_request_id])->one();
        $model->delete();
        $modelItem->delete();
        return $this->redirect(['fuel-out']);
    }
    /**
     * Deletes an existing RequestToStock model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['draft']);
    }

    /**
     * Finds the RequestToStock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RequestToStock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RequestToStock::findOne($id)) !== null) {
            return $model;
        }
    }
     protected function findModel1($id)
    {
        if (($model = ItemsRequest::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
