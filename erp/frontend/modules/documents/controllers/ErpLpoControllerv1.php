<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpLpo;
use common\models\ErpLpoSerach;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ErpLpoController implements the CRUD actions for ErpLpo model.
 */
class ErpLpoController extends Controller
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
     * Lists all ErpLpo models.
     * @return mixed
     */
    public function actionIndex()
    {
       // $searchModel = new ErpLpoSerach();
       // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index');
    }
    
    public function actionChangeStatus(){
    
     //$today=date('Y-m-d H:i:s', time());
         
       
       
       
        $query="SELECT po.* FROM erp_lpo as po
        WHERE po.status = 'delivered' and po.id not in ( SELECT app.lpo FROM erp_lpo_approval as app where app.approval_action='approved' and app.approval_status='final' )";
         $c = Yii::$app->db->createCommand($query);
            $rows = $c->queryall(); 
            
           
           
          foreach($rows as $r){
              
              $model=ErpLPO::find()->where(['id'=>$r['id']])->one();
              
              if($model->status=='delivered'){
                 $model->status='processing';
                $model->save(false);  
                  
              }
          }
        
    }

    /**
     * Displays a single ErpLpo model.
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
    
  
    public function actionViewPdf($id)
    {
          if (Yii::$app->request->isAjax) {
              
             return $this->renderAjax('viewer', [
            'model' => $this->findModel($id),
        ]);  
              
          }
        
        return $this->render('viewer', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionLpoViewPdf($id){
       
       $model=$this->findModel($id);      
        
        if($model!=null){
            
          return $this->renderAjax('view1', [
         'model' => $model,
         
    ]);
        
         
        }else{
            
            
            return   ' <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Purchase Order not found.</h3>

          <p>
            We could not find Purchase Order.
            
          </p>

        </div>
     
      </div>';
        }
          
        
    }
    
     public function actionDrafts(){
        
        return $this->render('drafts');
        
    }
    
    
    
         public function actionDone($id)
    {
         $user=Yii::$app->user->identity->user_id;
 
 if(!empty($id)) {
     

  $model=$this->findModel($id);
  
  $model->status='delivered';
  
  $model->save(false);
   
  
  Yii::$app->db->createCommand()
                      ->update('erp_lpo_approval_flow', ['status' =>'completed'], ['lpo' =>$id,'approver'=>$user,'status' =>'pending'])
                      ->execute();  
                  Yii::$app->session->setFlash('success',"LPO  has been succesfully archived");    
 }
       return $this->redirect(['pending']);
    }
    

 public function actionDocTracking($id){

 if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('doc-tracking',['id'=>$id]);
     
     
         }
         else{
             
              return $this->render('doc-tracking',['id'=>$id]);
         }

   
    
    }

    public function actionMyPurchaseOrders(){
        
        return $this->render('my-purchase-orders');
        
    }
    
     public function actionPending(){
        
        return $this->render('pending');
        
    }
    
     public function actionApproved(){
        
        return $this->render('approved');
        
    }
     //------------------------------------------fetch tab-----------------------------------------------------------------
     public function actionFetchTab()
    {
    $step_number = $_REQUEST["step_number"];
    
    $model=new ErpLpo();
   
    if(isset($_GET['active-step'])){
        
        $step_number=$_GET['active-step']; 
    }
    
    if(isset($_GET['lpo_id'])){
        
        if($step_number==5){
          
          $model =ErpLpo::find()->where(['id' =>$_GET['lpo_id']])->one();
        
     
         
           
        
        if($model!=null){
            
          return $this->renderAjax('view1', [
         'model' => $model,
         
    ]);
        
         
        }else{
            
            
            return   ' <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Purchase Order not found.</h3>

          <p>
            We could not find Purchase Order.
            
          </p>

        </div>
     
      </div>';
        }
         
            
            
        }
        
        
       
            
      
       
            
            
        }
       
          
    else{
        
      return   ' <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Expected Lpo Id .</h3>

          <p>
            We could not find LPO Id.
            
          </p>

        </div>
     
      </div>';
    }
   
    }

    /**
     * Creates a new ErpLpo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpLpo();
        
        if(isset($_GET['type'])){
            
            $model->type=$_GET['type'];
        }

        if (Yii::$app->request->post()) {
          
          
          if(isset($_POST['ErpLpo'])){
            
           $model->attributes=$_POST['ErpLpo'];
           
$exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification="PO-".date("Ymdhms")."-".$value; 
 $model->lpo_number=$unification;
 
 $model->created_by=Yii::$app->user->identity->user_id;
 
   $file= UploadedFile::getInstance($model, 'uploaded_file');
   //var_dump($file->name);die();
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_lpo='uploads/lpo/'. $unification.".{$ext}";       
  
  
   $model->lpo_upload=$path_to_lpo;
   $model->file_name=$file->name;
   
   if($model->save(false)){
      
      //-----------------------------update request to done----------------------------------
      
       Yii::$app->db->createCommand()
                      ->update('erp_lpo_request_approval_flow', ['status' =>'done'], 
                      ['approver' =>Yii::$app->user->identity->user_id,'lpo_request'=>$model->lpo_request_id,'status'=>'pending'])
                      ->execute(); 
       
       $file->saveAs( $path_to_lpo); 
      
      Yii::$app->session->setFlash('success',"Purchase Order Created");   
      
      return  $this->redirect(['erp-lpo/drafts']); 
       
   }
              
          }
        }
if (Yii::$app->request->isAjax) {
    
   
   return $this->renderAjax('_form', [
            'model' => $model,'lpo_request_id'=>$_GET['request_id']
        ]);  
}
        return $this->render('_form', [
            'model' => $model,'lpo_request_id'=>$_GET['request_id']
        ]);
    }

    /**
     * Updates an existing ErpLpo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       

        if (Yii::$app->request->post()) {
          
          
          if(isset($_POST['ErpLpo'])){
            
         $model->attributes=$_POST['ErpLpo']; 
           
         $model->uploaded_file= UploadedFile::getInstance($model, 'uploaded_file');
         
         if($model->uploaded_file!=null){
             
            $file= $model->uploaded_file;
             
              if($model->lpo_upload!='' && file_exists($model->lpo_upload)){
       
        unlink($model->lpo_upload) or die("Couldn't delete file"); 
        
    }
   
   
   
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   
   $exponent = 3; // Amount of digits
   $min = pow(10,$exponent);
   $max = pow(10,$exponent+1)-1;
 
    $value = rand($min, $max);
    $unification="PO-".date("Ymdhms")."-".$value;
    $path_to_lpo='uploads/lpo/'. $unification.".{$ext}"; 
   
   $model->lpo_upload=$path_to_lpo;
   $model->file_name=$file->name;
         
             
             
         }
   
 
   if($model->save(false)){
      
      if(isset($path_to_lpo) && $path_to_lpo!=''){
          
         $file->saveAs( $path_to_lpo); 
      }
        
      
      Yii::$app->session->setFlash('success',"Purchase Order Updated"); 
      
      if($model->status=='drafting'){
          
          return  $this->redirect(['erp-lpo/drafts']);  
      }else{
          
           return  $this->redirect(['erp-lpo/pending']); 
      }
      
     
       
   }
              
          }
        }
if (Yii::$app->request->isAjax) {
    
   return $this->renderAjax('_form', [
            'model' => $model,
        ]);  
}
        return $this->render('_form', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing ErpLpo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
     
     $model=$this->findModel($id);
    
   
  
  if($model->delete()){
    
    
    if($model->lpo_upload!='' && file_exists($model->lpo_upload)){
       
        unlink($model->lpo_upload) or die("Couldn't delete file"); 
        
    }
    
    return true;
    
    }else{
        
        return false;
    } 
       
    }

    /**
     * Finds the ErpLpo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpLpo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpLpo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
