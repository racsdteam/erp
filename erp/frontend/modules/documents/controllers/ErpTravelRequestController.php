<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpTravelRequest;
use common\models\ErpTravelRequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ErpTravelClearance;
use common\models\ErpClaimForm;
use common\models\ErpTravelRequestAttachement;
use yii\web\UploadedFile;
use common\models\ErpMemo;
use yii\helpers\Html;
use common\models\ErpEmployeeClaims;
use yii\data\Pagination;
use common\models\ErpPersonsInPosition;

/**
 * ErpTravelRequestController implements the CRUD actions for ErpTravelRequest model.
 */
class ErpTravelRequestController extends Controller
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
     * Lists all ErpTravelRequest models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$searchModel = new ErpTravelRequestSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index');
    }

    /**
     * Displays a single ErpTravelRequest model.
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
    
      public function actionDrafts()
    {
        return $this->render('drafts');
    }
    
     public function actionPending()
    {
        return $this->render('pending');
    }
    
         public function actionReturned()
    {
        return $this->render('returned');
    }
    
       public function actionDone($id)
    {
         $user=Yii::$app->user->identity->user_id;
 
 if(!empty($id)) {
   
   Yii::$app->db->createCommand()
                      ->update('erp_travel_request_approval_flow', ['status' =>'archived'], ['tr_id' =>$id,'approver'=>$user,'status' =>'pending'])
                      ->execute();  
                  Yii::$app->session->setFlash('success',"Travel Request has been succesfully archived");    
 }
       return $this->redirect(['pending']);
    }
    
    
      public function actionApproved()
    {
        return $this->render('approved');
    }
       public function actionMyTravelRequest()
    {
        return $this->render('my-travel-request');
    }
    public function actionViewerPdf($id)
    {
      
       if (Yii::$app->request->isAjax){
           return $this->renderAjax('viewer',[ 'model' => $this->findModel($id)]); 
           
       }else{
            return $this->render('viewer',[ 'model' => $this->findModel($id)]);
       }
      
    }
    
     public function actionApprovalWorkFlow()
    {
       $model=new ErpTravelRequest();
       return $this->render('approval-work-flow',[ 'model' =>$model]);
    }
    
    public function actionWorkFlow($id){

  if(Yii::$app->request->isAjax){

            return $this->renderAjax('doc-tracking',['id'=>$id]);   
        }
    return $this->render('doc-tracking',['id'=>$id]);
    
    }
    
     public function actionFetchTab()
    {
    $step_number = $_REQUEST["step_number"];
    
    $model=new ErpTravelRequest();
   
    if(isset($_GET['active-step'])){
        
        $step_number=$_GET['active-step']; 
    }
    
    if(isset($_GET['tr_id'])){
     
     $model=ErpTravelRequest::find()->where(['id'=>$_GET['tr_id']])->one() ;
     
     if($model!=null){
         
       
           if($step_number==0){
           
             
      $memo =ErpMemo::find()->where(['id' =>$model->memo])->one();
    
        
          if($memo!=null){
            
          return $this->renderAjax('page-viewer1', [
         'model' => $memo,
         
    ]);
        
         
        }else{
            
            
            return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Memo Found!
              
               </div>';
        }
       
       
           }
    //----------------end step 0     
           
       
     if($step_number==1){
           
             
    $query = ErpTravelClearance::find()->where(['tr_id'=>$model->id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
            
          return $this->renderAjax('page-viewer2', [
         'models' => $models,
         'pages' => $pages,
         'step'=>$step_number,
         'container'=>$step_number+1
    ]);
        
         
        }else{
            
            
            return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Travel Clearance(s) Found!
              
               </div>';
        }
       
     }
       
           if($step_number==2){
           
             
    $query = ErpClaimForm::find()->where(['tr_id' =>$model->id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
            
          return $this->renderAjax('page-viewer3', [
         'models' => $models,
         'pages' => $pages,
         'step'=>$step_number,
        'container'=>$step_number+1
    ]);
        
         
        }else{
            
            
            return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Claim Form(s) Found!
              
               </div>';
        }
        
           }
       
       if($step_number==3)
          {
           
             
    $query = ErpTravelRequestAttachement::find()->where(['tr_id' =>$model->id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
            
          return $this->renderAjax('page-viewer4', [
         'models' => $models,
         'pages' => $pages,
        'step'=>$step_number,
        'container'=>$step_number+1
    ]);
        
         
        }else{
            
            
            return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Attachment(s) Found!
              
               </div>';
        }
       
       
      
         
     }
     
   
        
    }else{
        
        echo 'no Travel Request  Found';
    }
   
    }else{
       
      echo 'no Travel Request ID  sent';  
        
    }
   
   
   
   
    }

    /**
     * Creates a new ErpTravelRequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpTravelRequest();
        
        if(isset($_GET['memo'])){
         
           $model->memo=$_GET['memo'];   
        }
       
        $model1=new ErpTravelClearance();
       
       
        $model2=new ErpClaimForm();
        
        $models3=new ErpTravelRequestAttachement();
         

        if (Yii::$app->request->post()) {
            
            
           
             //var_dump(Yii::$app->request->post());die();
             $exponent = 3; // Amount of digits
             $min = pow(10,$exponent);
             $max = pow(10,$exponent+1)-1;
             
              //-----------------prevent new row being saved----------------------------   
             
             
             if(isset($_POST['ErpTravelRequest'])){
              
              if(isset($_SESSION['id'])){
                  
              $tr = ErpTravelRequest::find()->where(['id'=>$_SESSION['id']])->One();
                  
               
                 if ($tr!=null) {
            $model=$tr;
        }
                  
              }
             
             
             
             
              $model->attributes=$_POST['ErpTravelRequest'];
              $data=$_POST['ErpTravelRequest'];
              $model->created_by=Yii::$app->user->identity->user_id;
              $value = rand($min, $max); 
              $unification="TR-".date("Ymdhms")."-".$value;
              $model->tr_code=strtoupper($unification);
              $employees=$data['employee'];
             
                if($flag=$model->save()){
                    
                     
           if(isset($_SESSION['id'])){
               
             ErpTravelClearance::deleteAll('tr_id = :id ', [':id' =>$_SESSION['id']]);
                  
              }
         
         
         
          if(!empty($employees)){
              
       
           
            foreach($employees as $employee)
            {
                  $model1 = new ErpTravelClearance();
                  $model1->attributes=$_POST['ErpTravelClearance'];
                  $model1->created_by=Yii::$app->user->identity->user_id;
                  $model1->employee=$employee;
                  $model1->tr_id=$model->id;
             
             $value = rand($min, $max);
             $unification=strtoupper("TC".date("Ymdhms")."".$value);
             $model1->tc_code=$unification;
            
                 
                  if(! $flag=$model1->save()){
                     
                     Yii::$app->session->setFlash('failure',Html::errorSummary($model1));  
                    return $this->render('_form', [
            'model' => $model,'models3'=>$models3
        ]);
                   
                  }else{ $_SESSIOn['id1']=$model1->id;}
            } 
            
          }
                
             
          
           
           if(isset($_POST['ErpClaimForm'])){
               
               
                if(isset($_SESSION['id'])){
               
        ErpClaimForm::deleteAll('tr_id = :id ', [':id' =>$_SESSION['id']]);
                  
              }
     //-----------------------claim form details----------------------------------
      if(!empty($employees)){
               foreach($employees as $employee)
            {
                  
                  $model2 = new ErpClaimForm();
                  $model2->attributes=$_POST['ErpClaimForm'];
                  $model2->created_by=Yii::$app->user->identity->user_id;
                  $model2->tr_id=$model->id;
                  $model2->employee=$employee;
            
                 if(! $flag=$model2->save(false)){
                     
                     Yii::$app->session->setFlash('failure',Html::errorSummary($model1));  
                    return $this->render('_form', [
                    'model' => $model,'models3'=>$models3
        ]);
                   
                  }else{
                      
                      $_SESSIOn['id2']=$model2->id;
                  }
                
            }
            
      }
         
              
               
           }
           
       
               
             
             
             if(isset($_POST['ErpTravelRequestAttachement'])){
               
             
             
           $models3->attach_files = UploadedFile::getInstances($models3, 'attach_files');
             
             if(!empty($models3->attach_files)){
                 
                 $files=$models3->attach_files;
                 
                 foreach($files as $file){
                     
                
                 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_attach='uploads/tr/attachements/'. $unification.".{$ext}";
    
   
   
                 $attModel=new ErpTravelRequestAttachement();
                 $attModel->attach_name=$file->name;
                 $attModel->created_by=Yii::$app->user->identity->user_id;
                 $attModel->tr_id=$model->id;
                 $attModel->attach_upload=$path_to_attach ;
                  if(! $flag=$attModel->save(false)){
                     
                     Yii::$app->session->setFlash('failure',Html::errorSummary($model1));  
                    return $this->render('_form', [
            'model' => $model,'models3'=>$models3
        ]);
                   
                  }  
                 
               $file->saveAs( $path_to_attach);   
                     
                 }
                 
             }
               
            
           }
             
             
               
               
           
              
             $_SESSIOn['id']=$model->id; 
            
             }  // travel requets saved
           
                    
                else{
                    
                 Yii::$app->session->setFlash('failure',Html::errorSummary($model));  
                     return $this->render('_form', [
            'model' => $model,'models3'=>$models3
        ]);
                }
             
           if($flag){
               
              Yii::$app->session->setFlash('success',"Travel Request Created Successfully!"); 
               
                return $this->redirect(['drafts']);
           }
                
                
            }//travel request
             
             
        }//post request
        return $this->render('_form', [
            'model' => $model,'models3'=>$models3
        ]);
    }
    
  //=======================================no LPO===============================================================
      
public  function actionNoLPo(){
  
  $q44=" SELECT tr.id FROM erp_travel_request as tr where tr.status='approved' and  not EXISTS (select r.request_id from erp_lpo_request as r where tr.id=r.request_id and r.type='TT')";
  $com44 = Yii::$app->db->createCommand($q44);
  $rows = $com44->queryall();
 // var_dump($rows);die();
 
  foreach( $rows as $row){
    $q22 =" SELECT tr.* FROM  erp_travel_request  as tr
     where tr.id='".$row['id']."' ";
  $command22 =Yii::$app->db->createCommand($q22);
   $row1 =$command22->queryOne();
   
  
   
   if(!empty($row1)){
       
     $data[]=['id' => $row1['id'], 'text' =>$row1['tr_code']." / ".$row1['purpose']." / Departure Date : ".$row1['departure_date']];    
       
   }
  } 
 
  return json_encode($data); 
           
}

    /**
     * Updates an existing ErpTravelRequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $models1= ErpTravelClearance::find()->where(['tr_id'=>$model->id])->all();
        $models2= ErpClaimForm::find()->where(['tr_id'=>$model->id])->all();
        
       if(!empty($models1)){
         
         
          foreach($models1 as $tc){
            
            $pos=ErpPersonsInPosition::find()->where(['person_id'=>$tc->employee])->One(); 
            
            $model->position[]=$pos->position_id;
            $model->employee[]=$tc->employee;
            
         }  
           
       }
       
        
        $models3=new ErpTravelRequestAttachement();
         

        if (Yii::$app->request->post()) {
            
            
           
             //var_dump(Yii::$app->request->post());die();
             $exponent = 3; // Amount of digits
             $min = pow(10,$exponent);
             $max = pow(10,$exponent+1)-1;
             
              //-----------------prevent new row being saved----------------------------   
             
             
             if(isset($_POST['ErpTravelRequest'])){
              
              if(isset($_SESSION['id'])){
                  
              $tr = ErpTravelRequest::find()->where(['id'=>$_SESSION['id']])->One();
                  
               
                 if ($tr!=null) {
            $model=$tr;
        }
                  
              }
             
             
             
             
              $model->attributes=$_POST['ErpTravelRequest'];
              $data=$_POST['ErpTravelRequest'];
              $employees=$data['employee'];
             
          if($flag=$model->save(false)){
                    
                   
                   if(!empty($employees)){
                     
                     
                      foreach($model->employee as $emp){
                           
                     
                 if(!in_array($emp ,$employees ) )
{
    \Yii::$app
    ->db
    ->createCommand()
    ->delete('erp_travel_clearance', ['tr_id' =>$model->id,'employee'=>$emp])
    ->execute();
    
    \Yii::$app
    ->db
    ->createCommand()
    ->delete('erp_claim_form', ['tr_id' =>$model->id,'employee'=>$emp])
    ->execute();
}
                           
                       }
                       
                      
                   }
       
          if(!empty($employees)){
              
       
           
            foreach($employees as $employee)
            {
                  
                  
                  $model1 =ErpTravelClearance::find()->where(['tr_id'=>$model->id,"employee"=>$employee])->One();
                  if($model1==null){
                   $model1 = new ErpTravelClearance();
                   $model1->created_by=Yii::$app->user->identity->user_id;
                   $model1->employee=$employee;
                   $model1->tr_id=$model->id;   
                  $value = rand($min, $max);
                  $unification=strtoupper("TC".date("Ymdhms")."".$value);
                  $model1->tc_code=$unification;
            
                 
                  if(! $flag=$model1->save()){
                     
                     Yii::$app->session->setFlash('failure',Html::errorSummary($model1));  
                    return $this->render('_form', [
                          'model' => $model,'models3'=>$models3
        ]);
                   
                  }
                  
                  } 
            } 
            
          }
                
             
      
             if(isset($_POST['ErpTravelRequestAttachement'])){
               
             
             
           $models3->attach_files = UploadedFile::getInstances($models3, 'attach_files');
             
             if(!empty($models3->attach_files)){
                 
                 $files=$models3->attach_files;
                 
                 foreach($files as $file){
                     
                
                 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_attach='uploads/tr/attachements/'. $unification.".{$ext}";
    
   
   
                 $attModel=new ErpTravelRequestAttachement();
                 $attModel->attach_name=$file->name;
                 $attModel->created_by=Yii::$app->user->identity->user_id;
                 $attModel->tr_id=$model->id;
                 $attModel->attach_upload=$path_to_attach ;
                  if(! $flag=$attModel->save(false)){
                     
                     Yii::$app->session->setFlash('failure',Html::errorSummary($model1));  
                    return $this->render('_form', [
            'model' => $model,'models3'=>$models3
        ]);
                   
                  }  
                 
               $file->saveAs( $path_to_attach);   
                     
                 }
                 
             }
               
            
           }
             
             
               
               
           
              
             $_SESSIOn['id']=$model->id; 
            
             }  // travel requets saved
           
                    
                else{
                    
                 Yii::$app->session->setFlash('failure',Html::errorSummary($model));  
                     return $this->render('_form', [
            'model' => $model,'models3'=>$models3
        ]);
                }
             
           if($flag){
               
              Yii::$app->session->setFlash('success',"Travel Request updated Successfully!"); 
               
                return $this->redirect(['drafts']);
           }
                
                
            }//travel request
             
             
        }//post request
        return $this->render('_form', [
            'model' => $model,'models3'=>$models3
        ]);
    }

    /**
     * Deletes an existing ErpTravelRequest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()){
           
           
           Yii::$app->session->setFlash('success',"Travel Request Deleted Successfully!"); 
               
                
            
        }else{
            
           Yii::$app->session->setFlash('failure',"Travel Request could not be deleted !"); 
        }
         
        return $this->redirect(['drafts']);  

        //return $this->redirect(['index']);
    }

    /**
     * Finds the ErpTravelRequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpTravelRequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpTravelRequest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
     public function beforeAction($action){
       

    if ($formTokenValue = \Yii::$app->request->post('_csrf-frontend')) {
        $sessionTokenValue = \Yii::$app->session->get('form_token_param');

        if ($formTokenValue != $sessionTokenValue ) {
            throw new \yii\web\HttpException(400, 'The form has already been submitted!.');
        }

        \Yii::$app->session->remove('form_token_param');
    }

    return parent::beforeAction($action);
        
       
        
    }
}
