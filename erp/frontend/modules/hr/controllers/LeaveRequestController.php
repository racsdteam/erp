<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\LeaveRequest;
use frontend\modules\hr\models\LeaveSupporting;
use frontend\modules\hr\models\LeaveCategory;
use frontend\modules\hr\models\LeaveApprovalList;
use frontend\modules\hr\models\LeavePublicHoliday;
use frontend\modules\hr\models\LeaveApprovalComments;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\UserHelper;
use common\models\User;
use common\models\ErpPersonInterim;
use common\models\StartApprovalForm ;
use common\models\ApprovalFlowRequest ;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
 

class LeaveRequestController extends Controller
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
            return \Yii::$app->user->identity->isAdmin();
        },
    ],
                ]
                ],
            
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all LeaveRequest models.
     * @return mixed
     */
    public function actionIndex()
    {
       
            $userinfo=UserHelper::getPositionInfo(Yii::$app->user->identity->user_id); 
  $userposition=$userinfo['position_code'];
  
        if($userposition == "DHR" ||$userposition == "MGRHRA" || $userposition == "HROFC" || $userposition == "AAO"|| $userposition == "ITENG")
        {

        return $this->render('index');
        }else{
              return $this->redirect(['leave-request/my-leave']);
        }
    }
    
  public function actionTest(){
      
    //$inter=  \common\models\User::findIdentity(60)->findInterim();
    var_dump(User::className());
  }  

    /**
     * Displays a single LeaveRequest model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
   
    public function actionPdf($id)
    {
        
       $html=$this->renderAjax('pdf', [
            'model' => $this->findModel($id),
        ]);
        
       return $this->asJson($html);
    }
   
    public function actionView($id)
    {
         
         $model=$this->findModel($id);
        
        $content1=$this->renderPartial('pdf', [
            'model' => $model,
        ]);
        return $this->render('viewer', ['content1'=> $content1,
            'model' =>$model,
        ]);
    
    }
      public function actionView2($id)
    {
       return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
      public function actionDraft()
    {
        return $this->render('draft');
    }
     public function actionMyLeave()
    {
        return $this->render('myleaves');
    }
    
              public function actionApproved()
    {
        return $this->render('approved');
    }
    
    
    
    public function actionStartApproval($id){
    
       //-----------Payload---------------
       $model=LeaveRequest::findOne($id); 
       
       //----------find workflow definition----------
      $approvalStartForm=new StartApprovalForm();
      
     $goBack=function()use($model){
        return  $this->redirect(['view', 'id'=>$model->id]);
      }; 
       
        if(Yii::$app->request->post()){
         
         //-----inputs----------------------------------------   
        $approvalStartForm->attributes=$_POST['StartApprovalForm'];
     
         
         //----------wf instance--------------------------------------
         $wfInstance =Yii::$app->wfManager->createWorkflowInstance($approvalStartForm);
         if($wfInstance==null){
          Yii::$app->session->setFlash('error',"Unable to create workflow Instance !"); 
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
                Yii::$app->session->setFlash('success',"Leave Request has been submited for approval !");  
             }
              
             
         }   
            else{
               
                Yii::$app->session->setFlash('error',"Leave Request already submited for approval !"); 
              
           }    
           
           
            return $goBack();
          
          
         
          
           }
      
       
    if(Yii::$app->request->isAjax){
         
         return $this->renderAjax('start-approval', [
            'wfStartForm' =>$approvalStartForm,'model'=>$model
        ]);   
           
       }
        return $this->render('start-approval', [
            'wfStartForm' =>$approvalStartForm,'model'=>$model
        ]);  
        
    }
    

     

    
        public function actionPdfData($id)
    {
  $url = "css/kv-mpdf-bootstrap.min.css";
          $stylesheet = file_get_contents($url);
          
          $url1 = "css/mpdf.css";
          $stylesheet1 = file_get_contents($url1);
           
          //$url2 = "css/prince-bootstrap-grid-fix.css";
         // $stylesheet2 = file_get_contents($url2);
          
        $mpdf = new \Mpdf\Mpdf(['format' =>'A4']);
        //----------------------------add bootsrap classes---------------------------
       $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
       //------------------------bootsr grid system---------------------------------
        $mpdf->WriteHTML($stylesheet1, \Mpdf\HTMLParserMode::HEADER_CSS);
       //---------------------make us eof font awesome----------------------------
       $mpdf->WriteHTML('.fa { font-family: fontawesome;}',1);
        //-----------------prevent body overlapping footer-----------------------------------------     
         
         $mpdf->setAutoBottomMargin = 'stretch';
       //-----------------sett footer------------------------------
        $mpdf->SetHTMLFooter('<img src="img/footer.png"/>');
        $mpdf->SetCompression(false);
        $mpdf->autoPageBreak = true;
          $mpdf->curlAllowUnsafeSslRequests = true;
         $mpdf->WriteHTML($this->renderPartial('view', [
            'model' => $this->findModel($id),]));
       $content= $mpdf->Output();
       return $content;
        exit;
    }
  
  
  public function actionSupportDocs($id){
    
        
    $query = LeaveSupporting::find()->where(['leave_request_id' =>$id]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all(); 
        
          if(!empty($models)){
              
             if (Yii::$app->request->isAjax) {
           
           $html=  $this->renderAjax('documents', [
         'models' => $models,
         'pages' => $pages,
         
    ]); 
       
    
    return $this->asJson($html);
    
          }else{
        return $this->render('documents', [
         'models' => $models,
         'pages' => $pages,
    
    ]); 
              
          }
        
         
        }else{
            
         $html=  ' <div class="error-page">
        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> No Supporting Doc(s).</h3>

          <p>
            We could not find  Supporting Docs.
            
          </p>

        </div>
     
      </div>';
            
         return $this->asJson($html);    
            
            
            
           
        }     
        
    } 
   
   
    
    

    /**
     * Creates a new LeaveRequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $model = new LeaveRequest();
     $LeaveSupporting = new LeaveSupporting();
     
     
              if(Yii::$app->request->post()){
                $exclude_weekens=true;
              $user_id=Yii::$app->user->identity->user_id;
             $model->attributes=$_POST['LeaveRequest'];
             $count = LeaveRequest::find()->where(["leave_financial_year"=>$model->leave_financial_year,'user_id'=>$user_id])->count();
          
             $leave_category=LeaveCategory::find()->where(["id"=>$model->leave_category])->one();
             $position=UserHelper::getPositionInfo($user_id);
             $model->employee_position_appointment=$position['position_code'];
             $model->request_end_date=$this->enddate($model->request_start_date,$model->number_days_requested);
             $model->user_id=$user_id;
          
                if($count!=0 && $leave_category->leave_category=="Annual Leave")
             {
              $pre_number_days=LeaveRequest::find()->where(['and',["leave_financial_year"=>$model->leave_financial_year],["user_id"=>$model->user_id]])->sum('number_days_requested');
          
                 
             }else{
                 $pre_number_days=0;
             }
             
              $model->number_days_remaining=$leave_category->leave_number_days-($model->number_days_requested+$pre_number_days);
            
            
            
                if($leave_category->leave_annual_request_frequency >= $count+1)
            {
            
            if($leave_category->leave_number_days >= $model->number_days_requested)
            {
               
            if($model->number_days_remaining >= 0)
            {
                
            $flag=$model->save();
                
              if($flag)  
                {
                if($model->employee_interim!=null)
                {
                  $modeliterim = new ErpPersonInterim();
                  $modeliterim->person_in_interim=$model->employee_interim;
                  $modeliterim->date_from=$model->request_start_date;
                  $modeliterim->date_to=$model->request_end_date;
                  $modeliterim->leave_request_id=$model->id;
                  $modeliterim->interim_creator=Yii::$app->user->identity->user_id;
                  $modeliterim->person_interim_for=Yii::$app->user->identity->user_id;
                  $modeliterim->save(false);
                }
             if(isset($_POST['LeaveSupporting'])){
             
             $LeaveSupporting->attach_files = UploadedFile::getInstances($LeaveSupporting, 'attach_files');
                   
                    if(!empty( $LeaveSupporting->attach_files)){
                 
                       $files=$LeaveSupporting->attach_files;

                 foreach($files as $key => $file){
                 
                    
                
                 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_doc='uploads/leave/supporting_doc/'. $unification.".{$ext}";
   
   $LeaveSupporting=new LeaveSupporting(); 
   $LeaveSupporting->doc=$path_to_doc;
   $LeaveSupporting->leave_request_id=$model->id;
   $LeaveSupporting->uploaded_by=Yii::$app->user->identity->user_id;
                  
                  if(! $flag=$LeaveSupporting->save(false)){
                     
            Yii::$app->session->setFlash('failure',Html::errorSummary($LeaveSupporting));  

                  }  
                 
               $file->saveAs( $path_to_doc);  
                     
                 }
                 
              
                 
             }
            
               
        
             
            }  
                }
            return $this->redirect(['draft']);
            }
            else{
                  $msg="the days request exced your remaining leave days  for this category.";
            }
            }
            else{
                  $msg="the days request exced the allowed days for this category.";
            }
            }
            else{
                  $msg="You have exced the allowed limit of leaves for this category.";
            }
            
            Yii::$app->session->setFlash('error',$msg);
        }

        return $this->render('create', [
            'model' => $model, 'LeaveSupporting'=>$LeaveSupporting,
        ]);
    }

    /**
     * Updates an existing LeaveRequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
       $LeaveSupporting = new LeaveSupporting();
       if(Yii::$app->request->post()){
                $exclude_weekens=true;
              $user_id=Yii::$app->user->identity->user_id;
             $model->attributes=$_POST['LeaveRequest'];
             $count = LeaveRequest::find()->where(["leave_financial_year"=>$model->leave_financial_year])->count();
          
             $leave_category=LeaveCategory::find()->where(["id"=>$model->leave_category])->one();
             $position=UserHelper::getPositionInfo($user_id);
             $model->employee_position_appointment=$position['position_code'];
              $model->request_end_date=$this->enddate($model->request_start_date,$model->number_days_requested);
             $model->user_id=$user_id;
            
                if($count!=0 && $leave_category->leave_category="Annual Leave")
             {
              $pre_number_days=LeaveRequest::find()->where(['and',["leave_financial_year"=>$model->leave_financial_year],["user_id"=>$model->user_id]])->sum('number_days_requested');
             }else{
                 $pre_number_days=0;
             }
              $model->number_days_remaining=$leave_category->leave_number_days-($model->number_days_requested+$pre_number_days);
             
              
            if($leave_category->leave_number_days >= $model->number_days_requested)
            {
            if($model->number_days_remaining > 0)
            {
            $flag=$model->save();
            
            if($flag){
                 if($model->employee_interim!=null)
                {
                 $modeliterim=ErpPersonInterim::find()->where(["leave_request_id"=>$model->id])->one();
                 if($modeliterim==null)
                 {
                  $modeliterim = new ErpPersonInterim();
                 }
                
                  $modeliterim->person_in_interim=$model->employee_interim;
                  $modeliterim->date_from=$model->request_start_date;
                  $modeliterim->date_to=$model->request_end_date;
                  $modeliterim->leave_request_id=$model->id;
                  $modeliterim->interim_creator=Yii::$app->user->identity->user_id;
                  $modeliterim->person_interim_for=Yii::$app->user->identity->user_id;
                  $modeliterim->save(false);
                }
            if(isset($_POST['LeaveSupporting'])){
             
             $LeaveSupporting->attach_files = UploadedFile::getInstances($LeaveSupporting, 'attach_files');
                  
                    if(!empty( $LeaveSupporting->attach_files)){
                 
                       $files=$LeaveSupporting->attach_files;

                 foreach($files as $key => $file){
                 
                    
                
                 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_doc='uploads/leave/supporting_doc/'. $unification.".{$ext}";
   
   $LeaveSupporting=new LeaveSupporting(); 
   $LeaveSupporting->doc=$path_to_doc;
   $LeaveSupporting->leave_request_id=$model->id;
   $LeaveSupporting->uploaded_by=Yii::$app->user->identity->user_id;
                  
                  if(! $flag=$LeaveSupporting->save(false)){
                     
            Yii::$app->session->setFlash('failure',Html::errorSummary($LeaveSupporting));  

                  }  
                 
               $file->saveAs( $path_to_doc);  
                     
                 }
                 
              
                 
             }
            
               
        
             
            }  
            }
            return $this->redirect(['draft']);
            }
            else{
                  $msg="the days request exced your remaining leave days  for this category.";
            }
            }
            else{
                  $msg="the days request exced the allowed days for this category.";
            }
            
            
            Yii::$app->session->setFlash('error',$msg);
        }

        return $this->render('update', [
          'model' => $model, 'LeaveSupporting'=>$LeaveSupporting,
        ]);
    }

    /**
     * Deletes an existing LeaveRequest model.
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
   
   public function actionDocDelete($id)
    {
        
      $model=  $this->findModel2($id);
         if (file_exists($model->doc)) {
            unlink($model->doc);
        }
          
          $flag= $model->delete();
   if($flag){
       return true;
   }else{
       
       return false;
   }
    }
    /**
     * Finds the LeaveRequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LeaveRequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LeaveRequest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
     protected function findModel2($id)
    {
        $model = LeaveSupporting::find()->where(['id'=>$id])->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
  
       protected function enddate($from,$nunber)
    {
        
    $startDate = new \DateTime($from);
    $temp = new \DateTime($from);
    $endDate = new \DateTime();
   
    $index = intval($nunber/5);
    if($index>0)
    {

    $nunber=$nunber+($index*2);
    }
    
    $endDate =  $temp->modify("+$nunber day");
   
   $weekends_holidays=0;
   
     while ($startDate <= $endDate) 
     {
        /*    if($this->checkHoliday($startDate))
        {
            $weekends_holidays++;
            
        }*/
         $startDate->modify('+1 day');
     }
      
     $endDate->modify("+$weekends_holidays day");
     
     return $endDate->format('Y-m-d'); 
    }
      
}
