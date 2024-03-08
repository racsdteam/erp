<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\Employees;
use frontend\modules\hr\models\EmployeesSearch;
use frontend\modules\hr\models\EmpContact;
use frontend\modules\hr\models\EmpAddressCurrent;
use frontend\modules\hr\models\EmpEmployment;
use frontend\modules\hr\models\EmpPayDetails;
use frontend\modules\hr\models\EmpPaySupplements;
use frontend\modules\hr\models\EmpStatutoryDetails;
use frontend\modules\hr\models\EmpPhoto;
use frontend\modules\hr\models\EmpBankDetails;
use frontend\modules\hr\models\EmpPaySplits;
use frontend\modules\hr\models\EmpUserDetails;
use frontend\modules\hr\models\EmployeeStatuses;
use frontend\modules\hr\models\PayTemplates;
use frontend\modules\hr\models\EmpTerminations;
use frontend\modules\hr\models\PayGroups;
use frontend\modules\hr\models\TermReasons;
use common\models\ErpOrgPositions;
use common\models\ErpOrgUnits;
use common\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\FileHelper ;
use yii\filters\AccessControl;

/**
 * EmployeesController implements the CRUD actions for Employees model.
 */
class EmployeesController extends Controller
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
            return \Yii::$app->user->identity->isAdmin() || \Yii::$app->user->identity->isPayrollOfficer();
        },
    ],
                ],
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
     * Lists all Employees models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        return $this->render('index',['status'=>Yii::$app->request->get('status')]);
    }
    
    /**
     * Displays a single Employees model.
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



    public function actionTest(){
        /*$res=[];
     foreach(\common\models\User::find()->all() as $u){
        $e=Employees::find()->where(['like','CONCAT(first_name," ",last_name)',$u->first_name.'%',false])->orWhere(['like',
         'CONCAT(first_name," ",last_name)',$u->last_name.'%',false ])->one();
        if(!empty($e)){
            $user['employee']=$e->id;
            $user['user_id']=$u->user_id;
            $res[]=$user;
        }
        
       
     }
     
     
     
    foreach($res as $key=>$val){
      
      $user=new EmpUserDetails();
      $user->setAttributes($val);
      $user->save();
        
    }
    
    var_dump(1);*/
    
    var_dump(Yii::$app->empUtil->generateEmpNo4('OJT'));
    }
    
    public function actionBasicDetails($id){
        
        return $this->render('_details-view', [
            'model' => $this->findModel($id),
        ]); 
        
    }
    
    public function actionContactDetails($id){
        
        return $this->render('_contact', [
            'model' => $this->findModel($id),
        ]); 
        
    }
    
      public function actionAddressDetails($id){
        
        return $this->render('_address', [
            'model' => $this->findModel($id),
        ]); 
        
    }
    
     public function actionEmployementDetails($id){
        
        return $this->render('_job', [
            'model' => $this->findModel($id),
        ]); 
        
    }
    
     public function actionBankDetails($id){
        
        return $this->render('_bank', [
            'model' => $this->findModel($id),
        ]); 
        
    }
      public function actionDocuments($id){
        
        return $this->render('_documents', [
            'model' => $this->findModel($id),
        ]); 
        
    }
     public function actionEditDetails($id){
          $model=$this->findModel($id);
          $modelPhoto=new EmpPhoto();
          $errors=array();
            if (Yii::$app->request->post() && isset($_POST['Employees'])) {
            
                  $model->attributes=$_POST['Employees'];
    
          
          if($success=$model->save()){
              
                if(isset($_POST['EmpPhoto'])){
                    $modelPhoto->upload_file= UploadedFile::getInstance($modelPhoto, 'upload_file');
                  if($modelPhoto->upload_file!=null){
                     
                     $photoFile=$modelPhoto->upload_file;
                
                
                 $transaction = \Yii::$app->db4->beginTransaction();
    try {
                $modelPhoto->file_name=$photoFile->name;
                $modelPhoto->file_type=$photoFile->extension;
                $modelPhoto->mime_type=$photoFile->type;
                $modelPhoto->employee=$model->id;
                $modelPhoto->dir='uploads/employees/'.$model->id.'/photo/';
                //var_dump( $modelPhoto->attributes);die();
                if($success=$modelPhoto->save()){
                $dirPath='uploads/employees/'.$model->id.'/photo/';
                    $this->createDir($dirPath);
                    $photoFile->saveAs($dirPath.$modelPhoto->id.$photoFile->extension);
                }else{
                  
             
              $errorMsg=Html::errorSummary($modelPhoto);
              $class = end(explode("\\", get_class($modelPhoto)));
              $errors[$class]=$errorMsg;
                }
                 
         if($success){
            
            $transaction->commit(); 
         }else{
             
            $transaction->rollback(); 
         }           
        
    } catch(Exception $e) {
        $transaction->rollback();
    }
                
               
                   
                     
                  }
                  
             
                
              }
              
          }else{
              
             $errorMsg=Html::errorSummary($model);
              $class = end(explode("\\", get_class($model)));
              $errors[$class]=$errorMsg;         
              
          }
            if(!empty($errors)){
            Yii::$app->session->setFlash('error',$errors);    
            
            }else{
                   Yii::$app->session->setFlash('success',"Employee Basic Info Updated!"); 
            }
            
              return $this->redirect(['basic-details', 'id' => $model->id]);   
          
            }
          if(Yii::$app->request->isAjax){
             return $this->renderAjax('_details-form', [
            'model' => $model,'modelPhoto'=> $modelPhoto
        ]);   
          }
        return $this->render('_details-form', [
            'model' => $model,'modelPhoto'=> $modelPhoto
        ]); 
        
    }
    
    /**
     * edit contact
     * 
     */
     
      public function actionEditContact($id){
          
          $model=$this->findModel($id);
          $modelContact=($contact=$model->contact)!=null?$contact:new EmpContact();
          $errors=array();
            if (Yii::$app->request->post() && isset($_POST['Employees'])) {
            
            $modelContact->attributes=$_POST['Employees'];
    
          
          if(!$flag=$model->save()){
              
             $errorMsg=Html::errorSummary($model);
              $class = end(explode("\\", get_class($model)));
              $errors[$class]=$errorMsg; 
              
          }
            if(!empty($errors)){
            Yii::$app->session->setFlash('error',$errors);    
            
            }else{
                   Yii::$app->session->setFlash('success',"Employee Basic Info Updated!"); 
            }
            
              return $this->redirect(['basic-details', 'id' => $model->id]);   
          
            }
          if(Yii::$app->request->isAjax){
             return $this->renderAjax('_details-form', [
            'model' => $model,'modelPhoto'=> $modelPhoto
        ]);   
          }
        return $this->render('_details-form', [
            'model' => $model,'modelPhoto'=> $modelPhoto
        ]); 
        
    } 
    
    
    public function actionGetImportTemp() 
{ 
     $path="downloads/employee_import_v1.xlsx";
     
     $res=array();
    
     if (file_exists($path)) {
   
     $res['status']=1;
     $res['data']=['path'=>Url::base(true).'/'.$path,'msg'=>'Template File Found !'];
   
     
      }else{
          
       $res['status']=0;
       $res['data']=['error'=>'Template File Not Found !'];   
        }
        
       return json_encode($res);
}
    
    
     public function actionBulkCreate(){
         
      
      $model = new \yii\base\DynamicModel([
        'empType', 'bulk_upload_file'
    ]);
    
    $model->addRule(['empType'], 'required')
    ->addRule(['bulk_upload_file'],'required')   
    ->addRule(['bulk_upload_file'],'file');
        
        
      $errors=array();
     
      
      $request = Yii::$app->request;
     
      
        if ($request->post() && isset($_POST['DynamicModel'])) {
            $model->attributes=$_POST['DynamicModel'];
            $file= UploadedFile::getInstance($model, 'bulk_upload_file');
          
            if($file!=null){
          
            $filename = uniqid().$file->extension; 
            $file->saveAs( "uploads/temp/".$filename );    
            $inputfile=  "uploads/temp/".$filename;
            
             if(file_exists($inputfile)){
    try{
               \PHPExcel_Settings::setZipClass(\PHPExcel_Settings::PCLZIP);
                $inputfiletype= \PHPExcel_IOFactory::identify($inputfile);
                $objreader= \PHPExcel_IOFactory::createReader($inputfiletype);
                $objPHPExcel= $objreader -> load($inputfile);
                
            }
            
            
            catch(Exception $e){
                die("Error!!!");
            }
            $sheet=$objPHPExcel->getSheet(0);
             $highestRow=$sheet->getHighestRow();
              $highestColumn=$sheet->getHighestColumn();
              $sheetData = $sheet->toArray(null, true, true, true);
             
              $rows=array();
              for ($row = 2; $row <= $highestRow; $row++){ 
                $row_data=array();                 
                $row_data['basic']=array_pop($sheet->rangeToArray('B' . $row . ':' . 'E' . $row,
                                    NULL,
                                    TRUE,
                                    FALSE));  
               $row_data["statutory"]  = array_pop($sheet->rangeToArray('F' . $row . ':' . 'H' . $row,
                                    NULL,
                                    TRUE,
                                    FALSE));
               
               $row_data["pay"] = array_pop($sheet->rangeToArray('I' . $row . ':' . 'M' . $row,
                                    NULL,
                                    TRUE,
                                    FALSE)); 
                                    
                 $row_data["bank"]  = array_pop($sheet->rangeToArray('N' . $row . ':' . 'P' . $row,
                                    NULL,
                                    TRUE,
                                    FALSE));
                                    
                                    
                                    
               $row_data["work"]  = array_pop($sheet->rangeToArray('Q' . $row . ':' . 'U' . $row,
                                    NULL,
                                    TRUE,
                                    FALSE));
                                    
                                   
                 
                
                $row_data["address"]  =array_pop($sheet->rangeToArray('V' . $row . ':' . 'AA' . $row,
                                    NULL,
                                    TRUE,
                                    FALSE));
                $row_data["contact"]  = array_pop($sheet->rangeToArray('AB' . $row . ':' . 'AE' . $row,
                                    NULL,
                                    TRUE,
                                    FALSE)); 
                $rows[]=$row_data;
               
             
              }
              
             $transaction = \Yii::$app->db4->beginTransaction();
         try {
             
               
       
     foreach ($rows as $key=>$data){
         
     
      
      list($first_name, $last_name,$gender, $nic_num) =$data['basic'];
      list($med_scheme, $emp_med_no,$emp_pension_no) =$data['statutory'];
      list($pay_rank,$base_pay,$pay_type,$pay_group,$pay_tmpl) =$data['pay'];
      list($bank_name,$bank_account,$bank_branch) =$data['bank'];
      list($org_unit,$aff_org,$position,$employment_type,$start_date) =$data['work'];
      list($country, $province,$district,$sector, $cell,$village) =$data['address'];
      list($mobile_phone, $work_phone,$work_email,$personal_email) =$data['contact'];
      
      
      $emp_model=Employees::findByNID($nid);
      if(!empty($emp_model)){
      
       $emp_model->status= EmployeeStatuses::STATUS_TYPE_ACTIVE;
       $emp_model->save(false); 
      }
    else
    {
      $emp_model = new Employees;
      $modelContact=new EmpContact();
      $modelAddressCurrent=new EmpAddressCurrent();
      $modelEmployment=new EmpEmployment();
      $modelPayDetails=new EmpPayDetails();
      $modelStatutoryDetails=new EmpStatutoryDetails;
      $modelBankDetails=new EmpBankDetails();
      
    $emp_model->setAttributes(compact("first_name", "last_name","gender","nic_num"));
    $emp_model->employee_no=Yii::$app->empUtil->generateEmpNo($model->empType);
    $emp_model->employee_type=$model->empType;
    $emp_model->created_by=Yii::$app->user->identity->user_id;
    
    if($emp_model->save()){

     //-------------------statutory details-----------------------------------------
     $modelStatutoryDetails->setAttributes(compact("med_scheme", "emp_med_no","emp_pension_no"));
     $modelStatutoryDetails->employee=$emp_model->id; 
     $modelStatutoryDetails->scenario='create';
      
      if($modelStatutoryDetails->validate()){
         if(!$modelStatutoryDetails->save()){
        
         $errors['modelStatutoryDetails']=$modelStatutoryDetails->errors;
         $transaction->rollBack();
         break;
        }  
          
      }
    
 
 //----------------------------------------employment details-----------------------------------
    $modelEmployment->org_unit= ($orgUnit=ErpOrgUnits::findByCode($org_unit)) !=null ? $orgUnit->id  : null;   
    $modelEmployment->position=($pos=ErpOrgPositions::findByCode($position)) !=null ? $pos->id  : null; 
    $modelEmployment->employment_type=$employment_type;  
    $modelEmployment->start_date=!empty($start_date) ? $this->formatDateFromExcel($start_date):null;
    $modelEmployment->employee=$emp_model->id; 
 
 //------------------------manual validation------------------------------------   
    if($modelEmployment->validate()){
        
        if(! $modelEmployment->save()){
        
         $errors[$modelEmployment->formName()]=$modelEmployment;
         $transaction->rollBack();
         break;
         }
        
       }
    
    //--------------------pay details--------------------------------------------------
      $modelPayDetails->employee=$emp_model->id;
      $modelPayDetails->pay_basis=!empty($pay_type) ? $pay_type :null;
      $modelPayDetails->pay_rank=!empty($pay_rank) ? $pay_rank :null;
      $modelPayDetails->base_pay=!empty($base_pay) ?strval ($base_pay):null;
      $modelPayDetails->pay_group=($payGroup=PayGroups::findByCode($pay_group)) !=null ? $payGroup->code  : null; 
      $modelPayDetails->created_by=Yii::$app->user->identity->user_id;
      
      if(!$modelPayDetails->save()){
         
      
         
         $errors[$modelPayDetails->formName()]=$modelPayDetails;
          $transaction->rollBack();
          break;
              
      }   
         
         //---------------------bank details----------------------------------------------//
     $modelBankDetails->employee=$emp_model->id;
     $modelBankDetails->setAttributes(compact("bank_name", "bank_account","bank_branch"));
     $modelBankDetails->acct_holder_type='SGL';
     $modelBankDetails->acct_reference='ALW';
     $modelBankDetails->bank_code=(string)75;
     
      if(!$modelBankDetails->save()){
         
         
         $errors[$modelBankDetails->formName()]=$modelBankDetails;
         $transaction->rollBack();
        
          break;
              
      }  
          
  
   
      
   //------------------contact--------------------------------------------------//

        $modelContact->setAttributes(compact("mobile_phone", "work_phone","work_email","personal_email"));
        $modelContact->employee=$emp_model->id;
       if($modelContact->validate()){
            
             if(! $modelContact->save()){
         
          
           $errors[$modelContact->formName()]=$modelContact;
           $transaction->rollBack();
           break;
      }
        }
        
      
   
 //-----------------------address data-----------------------------------------------
  
    
       
       $modelAddressCurrent->setAttributes(compact("country", "province","district","sector","cell","village"));
       $modelAddressCurrent->employee=$emp_model->id;
       $modelAddressCurrent->scenario="create";
        if($modelAddressCurrent->validate()){
            
         if(! $modelAddressCurrent->save()){
         
          
          $errors[$modelAddressCurrent->formName()]=$modelAddressCurrent;
          $transaction->rollBack();
           break;
              
      }    
        }
        
         
       
        
    }
    else{
        
         $class =$this->getModelClass($emp_model) ;
         $errors[$emp_model->formName()]=$emp_model;
          $transaction->rollBack();
          break;
       }
    }                         
   
  
     
     
}//-----------------------------END FOREACH--------------------------
unlink($inputfile);
$res=array(); 
 if (!empty($errors)) {
                $success=false;
               
                
                
               
                foreach ($errors as $key=>$model) {
                    
                   
                   
                     $errorMsg="<div>";
                     $errorMsg .="<h6>".$key."</h6>";
                    
                     $errorMsg .= "<ul style='padding:0; list-style-position: inside;'>\n";
                         
                         foreach($model->errors  as $attribute=>$error){
                           
                            $errorMsg .= "<li>" .$error[0]." : <span class='bg-warning'>".$model->getAttribute($attribute). "</span></li>\n";  
                             
                         }
                    
                   
                }
                $errorMsg .= "</ul>";
                $errorMsg .="</div>";
              
            }
            else{
                $success=true;
               
            }
            
        if(!$success){
            
           
            $res[]=['code'=>0,'data'=>['error'=>$errorMsg]];
            return json_encode($res);
        }
   
           $transaction->commit();
           Yii::$app->session->setFlash('success',"Employee data Imported!");
           $res[]=['code'=>1,'data'=>['msg'=>'Employees data Imported !']];
           return json_encode($res);
           
           
    } 
    catch(Exception $e) {
        $transaction->rollback();
    }
}
}
}

      
       if(!empty($request->get('empType')))
       $model->empType=$request->get('empType');
        return $this->render('_bulk-upload',[ 'model' => $model]);  
}
    
       public function actionGetImportTerminateTemp() 
{ 
     $path="downloads/employee_terminate.xlsx";
     
     $res=array();
    
     if (file_exists($path)) {
   
     $res['status']=1;
     $res['data']=['path'=>Url::base(true).'/'.$path,'msg'=>'Template File Found !'];
   
     
      }else{
          
       $res['status']=0;
       $res['data']=['error'=>'Template File Not Found !'];   
        }
        
       return json_encode($res);
}
    public function actionBulkTerminate(){
      
      $model=new Employees();
      $employees=array();
      $errors=array();
      $request = Yii::$app->request;
      
        if ($request->post() && isset($_POST['Employees']['bulk_upload_file'])) {
            
            $file= UploadedFile::getInstance($model, 'bulk_upload_file');
            $empType=$request->post('empType');
            
            if($file!=null){
          
            $filename = uniqid().$file->extension; 
            $file->saveAs( "uploads/temp/".$filename );    
            $inputfile=  "uploads/temp/".$filename;
            
             if(file_exists($inputfile)){
    try{
                \PHPExcel_Settings::setZipClass(\PHPExcel_Settings::PCLZIP);
                $inputfiletype= \PHPExcel_IOFactory::identify($inputfile);
                $objreader= \PHPExcel_IOFactory::createReader($inputfiletype);
                $objPHPExcel= $objreader -> load($inputfile);
                
            }
            
            
            catch(Exception $e){
                die("Error!!!");
            }
            $sheet=$objPHPExcel->getSheet(0);
             $highestRow=$sheet->getHighestRow();
              $highestColumn=$sheet->getHighestColumn();
             
              for ($row = 2; $row <= $highestRow; $row++){ 
          
             $employees=array_merge($employees, $sheet->rangeToArray('B' . $row . ':' . 'F' . $row,
                                    NULL,
                                    TRUE,
                                    FALSE));                     
                                           
              }
                //  Use foreach loop and insert data into Query
   
   
    foreach($employees  as $key=>$data){
    $model=Employees::findByNID($data[2]);  
   
    if($model!=null)
    {
    if($empType=="EMP"){
        $modelTermination = new EmpTerminations();
        $modelTermination->employee=$model->id;
        $modelTermination->term_reason=($reason=TermReasons::findByCode($data[3]))!=null ? $reason->id : null ;
        $modelTermination->term_note=$data[4];
        $modelTermination->term_date=date("Y-m-d");
        $modelTermination->user=Yii::$app->user->identity->user_id;
        $modelTermination->save(false);
     
       $model->status=EmployeeStatuses::STATUS_TYPE_TERM;
       $flag=$model->save(false); 
    }
    else{
    $model->status=Employees::STATUS_TYPE_NACT;
    $flag=$model->save(false); 
    }
    }else{
        
         $class =$this->getModelClass($model) ;
         $errors[$class ]=$errorMsg=Html::errorSummary( $model);
       }
    
      }//-------------------------END FOREACH EMPLOYEE LOOP
      
unlink($inputfile);
$res=array(); 
 if (!empty($errors)) {
                $flag=false;
                $errorMsg = "<ul style='padding:0'>\n";
                foreach ($errors as $key=>$err) {
                    $errorMsg .= "<li>" .$key.$err. "</li>\n";
                }
                $errorMsg .= "</ul>";
            }
            else{
                $flag=true;
               }
            
      
             
                 
         if($flag){
            Yii::$app->session->setFlash('success',"Employee data Imported!");
            $res[]=['code'=>1,'data'=>['msg'=>'Employees data Imported !']];
           // return $this->redirect(['index']); 
            return json_encode($res);
           
         }else{
             
            //$transaction->rollback(); 
            Yii::$app->session->setFlash('error',  $errorMsg);
            $this->view->params['typeMode'] = 'bulk';
            $this->view->params['typeEmp'] = $_POST['empType'];
            $res[]=['code'=>0,'data'=>['error'=>$errorMsg]];
            return json_encode($res);
          //return $this->render('_bulk-upload',[ 'model' => $model,'empType'=>$_POST['empType']]); 
         }           
        
                  
             }
            
         }//----------------------END POST----------------------------------------  
        }
           $this->view->params['typeMode'] = 'bulk';
           $this->view->params['typeEmp'] = $_GET['empType'];
           return $this->render('_bulk-terminate',[ 'model' => $model,'empType'=>$_GET['empType']]);    
     }
    /**
     * Creates a new Employees model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {   
        
        
        $model = new Employees();
        $modelPhoto=new EmpPhoto();
        $modelContact=new EmpContact();
        $modelAddressCurrent=new EmpAddressCurrent();
        $modelEmployment=new EmpEmployment();
        $modelPayDetails=new EmpPayDetails();
        $modelPaySupplements=[new EmpPaySupplements];
        $modelStatutoryDetails=new EmpStatutoryDetails;
        $modelBankAccounts=[new EmpBankDetails];
        $modelPaySplits=[new EmpPaySplits];
        $modelUserDetails=new EmpUserDetails();
        
        $request = Yii::$app->request;
        $user=Yii::$app->user->identity->user_id;
      
        $errors=array();
        
        $renderCallBack=function()use(&$model,&$modelPhoto,&$modelStatutoryDetails,
                                      &$modelContact,&$modelAddressCurrent,&$modelEmployment,
                                      &$modelPayDetails,&$modelPaySupplements,&$modelBankAccounts,&$modelPaySplits,&$modelUserDetails){
            
            return $this->render('_form-wizard', [
            'model' => $model,
            'modelPhoto'=> $modelPhoto,
            'modelStatutoryDetails' =>$modelStatutoryDetails,
            'modelContact'=>$modelContact,
            'modelAddressCurrent'=>$modelAddressCurrent,
            'modelEmployment'=>$modelEmployment,
            'modelPayDetails'=>$modelPayDetails,
            'modelPaySupplements' => (empty($modelPaySupplements)) ? [new EmpPaySupplements] : $modelPaySupplements,
            'modelBankAccounts'=>(empty($modelBankAccounts)) ? [new EmpBankDetails] : $modelBankAccounts,
            'modelPaySplits'=>(empty($modelPaySplits)) ? [new EmpPaySplits] : $modelPaySplits,
            'modelUserDetails'=>$modelUserDetails
        ]);
        };

        if ($request->post()) {
           
         $model->attributes=$_POST['Employees'];
         $modelPhoto->upload_file= UploadedFile::getInstance($modelPhoto, 'upload_file');
         $modelStatutoryDetails->attributes= $_POST['EmpStatutoryDetails']; 
         $modelContact->attributes=$_POST['EmpContact'];
         $modelAddressCurrent->attributes=$_POST['EmpAddressCurrent'];
         $modelEmployment->attributes=$_POST['EmpEmployment'];
          $modelPayDetails->attributes=$_POST['EmpPayDetails'];
           $modelPaySupplements = Model::createMultiple(EmpPaySupplements::classname());
          Model::loadMultiple(  $modelPaySupplements  , Yii::$app->request->post()); 
          
            $modelBankAccounts = Model::createMultiple(EmpBankDetails::classname(), $modelBankAccounts);
            Model::loadMultiple($modelBankAccounts, Yii::$app->request->post());
            
              $modelPaySplits= Model::createMultiple(EmpPaySplits::classname());
          Model::loadMultiple(  $modelPaySplits , Yii::$app->request->post());  
        
        $transaction = \Yii::$app->db4->beginTransaction();
         try {
             
             
             
             if($model->save()){
                 
                 if(isset($_POST['EmpPhoto'])){
                   
                    if($modelPhoto->upload_file!=null){
                      $photoFile=$modelPhoto->upload_file;
                      
                      $modelPhoto->employee=$model->id;
                      $modelPhoto->dir=$savePath='uploads/employees/'.$model->id.'/photo/';
                      $modelPhoto->file_name=$photoFile->name;
                      $modelPhoto->file_type=$photoFile->extension;
                      $modelPhoto->mime_type=$photoFile->type;
                      
                      
                     if($modelPhoto->save()){
                      
                      $this->createDir($savePath);
                      $photoFile->saveAs($savePath.'/'.$modelPhoto->id.$photoFile->extension);
                   
                }else{
                  
             
              $errorMsg=Html::errorSummary($modelPhoto);
              $class = end(explode("\\", get_class($modelPhoto)));
              $errors[$class]=$errorMsg;
                }
                
                 
                  }
                  
             
                
              }
              
                 if(isset($_POST['EmpStatutoryDetails'])){
                       
                          
                        $modelStatutoryDetails->employee=$model->id;
                        $modelStatutoryDetails->scenario="create";
                      
                       if($modelStatutoryDetails->validate()){
                   
                          if (!$modelStatutoryDetails->save()) {
                                              
                                 $errorMsg=Html::errorSummary($modelStatutoryDetails); 
                      $class = end(explode("\\", get_class($modelStatutoryDetails)));
                      $errors[$class]=$errorMsg;
                      
                     
                                     
                                 } 
                  }
          
                    }
              
              
                   if(isset($_POST['EmpContact'])){
                 
                 
                   $modelContact->employee=$model->id;
                   //$modelContact->scenario="create";
                
                     if(!$modelContact->save()){
                     $errorMsg=Html::errorSummary($modelContact); 
                      $class = end(explode("\\", get_class($modelContact)));
                      $errors[$class]=$errorMsg;
                 }   
                  
                  
             
                 
              }
              
                if(isset($_POST['EmpAddressCurrent'])){
               
                 
                  $modelAddressCurrent->employee=$model->id;
                  //-------------validate country---------------------------------
                  $modelAddressCurrent->scenario='create';
                  if($modelAddressCurrent->validate()){
                     
                    
                      if(!$modelAddressCurrent->save())
                      {
                
                    $errorMsg=Html::errorSummary($modelAddressCurrent);
                    $class = end(explode("\\", get_class($modelAddressCurrent)));
                    $errors[$class]=$errorMsg;
                     
                 }
                      
                  }
                 
                 
         
              }
              
                if(isset($_POST['EmpEmployment'])){
                 
                  
                 
                  $modelEmployment->employee=$model->id;
                  $modelEmployment->employee_type=$model->employee_type;
                  $modelEmployment->employee_no=$model->employee_no;
                  
                  if(!$flag= $modelEmployment->save()){
                      $errorMsg=Html::errorSummary($modelEmployement); 
                       $class = end(explode("\\", get_class($modelEmployement)));
                       $errors[$class]=$errorMsg;
                  }
                  
                }
                
                 if(isset($_POST['EmpPayDetails'])){
                  
                 
                 
                  $modelPayDetails->employee=$model->id;
                  $modelPayDetails->org_unit=$modelEmployement->org_unit;
                  $modelPayDetails->position=$modelEmployement->position;
                  $modelPayDetails->created_by=$user;
                  
                  if(!$flag=$modelPayDetails->save()){
                      $errorMsg=Html::errorSummary($modelPayDetails); 
                       $class = end(explode("\\", get_class($modelPayDetails)));
                       $errors[$class]=$errorMsg;
                      
                  }
                  
                }
                
            if(isset($_POST['EmpPaySupplements']) && !empty($_POST['EmpPaySupplements'])){
                 
          
             
           foreach ($modelPaySupplements as $suppl) {
      
                      $suppl->employee=$model->id;
                      $suppl->user=Yii::$app->user->identity->user_id;
                      
                       if(!$suppl->save()){
                 
                       $errorMsg=Html::errorSummary($suppl); 
                       $class = end(explode("\\", get_class($suppl)));
                       $errors[$class]=$errorMsg;
                       break;
                   
                }
               
                     
        
      
          }       
                  
                }
                
                  if(isset($_POST['EmpBankDetails'])){
                 
             
          
            
              foreach ($modelBankAccounts as $modelBankAcc) {
                         
                           $modelBankAcc->employee=$model->id;
                          
                            if (! ($flag = $modelBankAcc->save())) {
                                $errorMsg=Html::errorSummary($modelBankAcc); 
                       $class = end(explode("\\", get_class($modelBankAcc)));
                       $errors[$class]=$errorMsg;
                                break;
                            }
                        }           
                  
                }
               
             if(isset($_POST['EmpPaySplits'])){
                
          
             
           foreach ($modelPaySplits as $paysplit) {
      
                      $paysplit->employee=$model->id;
                       $paysplit->user=Yii::$app->user->identity->user_id;
                      
                       if(! $paysplit->save()){
                 
                       $errorMsg=Html::errorSummary( $paysplit); 
                       $class = end(explode("\\", get_class(  $paysplit)));
                       $errors[$class]=$errorMsg;
                       break;
                   
                }
               
                     
        
      
          }       
                  
                }    
                
                if(isset($_POST['EmpUserDetails'])){
                    
                   $emptyUser=new EmpUserDetails();
                   $modelUserDetails->attributes=$_POST['EmpUserDetails'];
                   $modelUserDetails->employee=$model->id;
                   $modelUserDetails->scenario="create";
                  if($modelUserDetails->validate()){
                        if(!$modelUserDetails->save()){
                        $errorMsg=Html::errorSummary($modelUserDetails); 
                       $class = end(explode("\\", get_class($modelUserDetails)));
                       $errors[$class]=$errorMsg;
                      
                  }
                  }
                   
                   
               
                }
                 
               }else{
                 
                 $errorMsg=Html::errorSummary($model); 
                 $class = end(explode("\\", get_class($model)));
                 $errors[$class]=$errorMsg; 
                   
                }   
            
           if (!empty($errors)) {
                 $success=false;
                $errorMsg = "<ul style='padding:0'>\n";
                foreach ($errors as $key=>$err) {
                    $errorMsg .= "<li>" .$key.$err. "</li>\n";
                }
                $errorMsg .= "</ul>";
            }else{
                
                $success=true;
            }
           
           if(!$success)
           {
               
            Yii::$app->session->setFlash('error',  $errorMsg);
            
             return $renderCallBack();
           }
             $transaction->commit(); 
             Yii::$app->session->setFlash('success',"Employee data Saved!");
             return $this->redirect(['index']);           
        
    } catch(Exception $e) {
        $transaction->rollback();
    }
         
          
         
        }
        
       $model->employee_type=$request->get('empType');
       return $renderCallBack();
    }
 
    /**
     * Updates an existing Employees model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelPhoto=new EmpPhoto();
        $modelStatutoryDetails=empty($statutory=$model->statutoryDetails)? new EmpStatutoryDetails : $statutory ;
        $modelContact=empty($contact=$model->getContact())? new EmpContact : $contact ;
        $modelAddressCurrent=empty($address=$model->getAddress()) ?new EmpAddressCurrent():$address;
        $modelEmployment=empty($empl=$model->employmentDetails) ? new EmpEmployment() :$empl;
        $modelPayDetails=empty($pay=$model->payDetails) ?new EmpPayDetails() :$pay; 
        $modelPaySupplements=$model->paySupplements;
        $modelBankAccounts=$model->bankAccounts;
        $modelPaySplits=$model->paySplits;
        $modelUserDetails=empty($user=$model->userDetails) ?new EmpUserDetails():$user;
        
        $request = Yii::$app->request;
        $user=Yii::$app->user->identity->user_id;
        
        $renderCallBack=function()use(&$model,&$modelPhoto,&$modelStatutoryDetails,
                                      &$modelContact,&$modelAddressCurrent,&$modelEmployment,
                                      &$modelPayDetails,&$modelPaySupplements,&$modelBankAccounts,&$modelPaySplits,&$modelUserDetails){
            
            return $this->render('_form-wizard', [
            'model' => $model,
            'modelPhoto'=> $modelPhoto,
            'modelStatutoryDetails' =>$modelStatutoryDetails,
            'modelContact'=>$modelContact,
            'modelAddressCurrent'=>$modelAddressCurrent,
            'modelEmployment'=>$modelEmployment,
            'modelPayDetails'=>$modelPayDetails,
            'modelPaySupplements' => (empty($modelPaySupplements)) ? [new EmpPaySupplements] : $modelPaySupplements,
            'modelBankAccounts'=>(empty($modelBankAccounts)) ? [new EmpBankDetails] : $modelBankAccounts,
            'modelPaySplits'=>(empty($modelPaySplits)) ? [new EmpPaySplits] : $modelPaySplits,
            'modelUserDetails'=>$modelUserDetails
        ]);
        };

        if ($request->post()) {
           
          
         $model->attributes=$_POST['Employees'];    
       
        
        $transaction = \Yii::$app->db4->beginTransaction();
         try {
             
          
             
             if($model->save()){
                 
                 if(isset($_POST['EmpPhoto'])){
                    $modelPhoto->upload_file= UploadedFile::getInstance($modelPhoto, 'upload_file');
                    if($modelPhoto->upload_file!=null){
                      $photoFile=$modelPhoto->upload_file;
                      
                      $modelPhoto->employee=$model->id;
                      $modelPhoto->dir=$savePath='uploads/employees/'.$model->id.'/photo/';
                      $modelPhoto->file_name=$photoFile->name;
                      $modelPhoto->file_type=$photoFile->extension;
                      $modelPhoto->mime_type=$photoFile->type;
                      
                     if($modelPhoto->save()){
                      
                      $this->createDir($savePath);
                      $photoFile->saveAs($savePath.'/'.$modelPhoto->id.$photoFile->extension);
                   
                }else{
                  
             
              $errorMsg=Html::errorSummary($modelPhoto);
              $class = end(explode("\\", get_class($modelPhoto)));
              $errors[$class]=$errorMsg;
                }
                
                 
                  }
                  
             
                
              }
              
                 if(isset($_POST['EmpStatutoryDetails'])){
                       
                        $modelStatutoryDetails->attributes= $_POST['EmpStatutoryDetails'];      
                        $modelStatutoryDetails->employee=$model->id;
                                    
                        if (!$modelStatutoryDetails->save(false)) {
                            
                                              
                                 $errorMsg=Html::errorSummary($modelStatutoryDetails); 
                      $class = end(explode("\\", get_class($modelStatutoryDetails)));
                      $errors[$class]=$errorMsg;
                      
                     
                                     
                                 }
                        
                
                    }
              
              
                   if(isset($_POST['EmpContact'])){
                 
                   $modelContact->attributes=$_POST['EmpContact'];
                   $modelContact->employee=$model->id;
                   //$modelContact->scenario="update";
                 
                     if(!$modelContact->save()){
                     $errorMsg=Html::errorSummary($modelContact); 
                      $class = end(explode("\\", get_class($modelContact)));
                      $errors[$class]=$errorMsg;
                 }   
                  
                  
             
                 
              }
              
                if(isset($_POST['EmpAddressCurrent'])){
               
                  $modelAddressCurrent->attributes=$_POST['EmpAddressCurrent'];
                  $modelAddressCurrent->employee=$model->id;
                  //-------------validate country---------------------------------
                  $modelAddressCurrent->scenario='update';
                  if($modelAddressCurrent->validate()){
                     
                    
                      if(!$modelAddressCurrent->save())
                      {
                
                    $errorMsg=Html::errorSummary($modelAddressCurrent);
                    $class = end(explode("\\", get_class($modelAddressCurrent)));
                    $errors[$class]=$errorMsg;
                     
                 }
                      
                  }
                 
                 
         
              }
              
                if(isset($_POST['EmpEmployment'])){
                 
                  
                  $modelEmployment->attributes=$_POST['EmpEmployment'];
                  if(empty($modelEmployment->employee))
                  $modelEmployment->employee=$model->id;
                  
                  if(empty($modelEmployment->employee_type))
                  $modelEmployment->employee_type=$model->employee_type;
                  
                  if(!$flag= $modelEmployment->save()){
                      $errorMsg=Html::errorSummary($modelEmployement); 
                       $class = end(explode("\\", get_class($modelEmployement)));
                       $errors[$class]=$errorMsg;
                  }
                  
                }
                
                 if(isset($_POST['EmpPayDetails'])){
                  
                 
                  $modelPayDetails->attributes=$_POST['EmpPayDetails'];
                  $modelPayDetails->employee=$model->id;
                  $modelPayDetails->org_unit=$modelEmployment->org_unit;
                  $modelPayDetails->position=$modelEmployment->position;
                  $modelPayDetails->created_by=$user;
                 
                  
                  if(!$flag=$modelPayDetails->save()){
                      $errorMsg=Html::errorSummary($modelPayDetails); 
                       $class = end(explode("\\", get_class($modelPayDetails)));
                       $errors[$class]=$errorMsg;
                     }
                  
                }
                
                 if(isset($_POST['EmpPaySupplements']) && !empty($_POST['EmpPaySupplements'])){
                     $oldIDs = ArrayHelper::map($modelPaySupplements , 'id', 'id');           
                     $modelPaySupplements = Model::createMultiple(EmpPaySupplements::classname());
                     Model::loadMultiple(  $modelPaySupplements  , Yii::$app->request->post()); 
                     
                     $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelPaySupplements, 'id', 'id')));
            if (! empty($deletedIDs)) {
                           EmpPaySupplements::deleteAll(['id' => $deletedIDs]);
                        }
          
             
           foreach ($modelPaySupplements as $suppl) {
      
                      $suppl->employee=$model->id;
                      $suppl->user=Yii::$app->user->identity->user_id;
                      
                       if(!$suppl->save()){
                 
                       $errorMsg=Html::errorSummary($suppl); 
                       $class = end(explode("\\", get_class($suppl)));
                       $errors[$class]=$errorMsg;
                       break;
                   
                }
               
                     
        
      
          }       
                  
                }
                
                 if(isset($_POST['EmpBankDetails'])){
                 
                 $oldIDs = ArrayHelper::map($modelBankAccounts, 'id', 'id');
            $modelBankAccounts = Model::createMultiple(EmpBankDetails::classname(), $modelBankAccounts);
            Model::loadMultiple($modelBankAccounts, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelBankAccounts, 'id', 'id')));
            if (! empty($deletedIDs)) {
                           EmpBankDetails::deleteAll(['id' => $deletedIDs]);
                        }
                        
              foreach ($modelBankAccounts as $modelBankAcc) {
                           $modelBankAcc->employee=$model->id;
                            if (! ($flag = $modelBankAcc->save())) {
                                $errorMsg=Html::errorSummary($modelBankAcc); 
                       $class = end(explode("\\", get_class($modelBankAcc)));
                       $errors[$class]=$errorMsg;
                                break;
                            }
                        }           
                  
                }
               
                  if(isset($_POST['EmpPaySplits'])){
                      
                      
          $oldIDs = ArrayHelper::map($modelPaySplits, 'id', 'id');
           
          $modelPaySplits= Model::createMultiple(EmpPaySplits::classname());
          Model::loadMultiple(  $modelPaySplits , Yii::$app->request->post());          
          $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelPaySplits, 'id', 'id')));
         
          if (! empty($deletedIDs)) {
              
                           EmpPaySplits::deleteAll(['id' => $deletedIDs]);
                        } 
                        
                       
           foreach ($modelPaySplits as $paysplit) {
      
                      $paysplit->employee=$model->id;
                       $paysplit->user=Yii::$app->user->identity->user_id;
                      
                       if(! $paysplit->save()){
                 
                       $errorMsg=Html::errorSummary( $paysplit); 
                       $class = end(explode("\\", get_class(  $paysplit)));
                       $errors[$class]=$errorMsg;
                       break;
                   
                }
               
                     
        
      
          }       
                  
                } 
                
                if(isset($_POST['EmpUserDetails'])){
                    
                   $emptyUser=new EmpUserDetails();
                   $modelUserDetails->attributes=$_POST['EmpUserDetails'];
                   $modelUserDetails->employee=$model->id;
                   $modelUserDetails->scenario="update";
                  if($modelUserDetails->validate()){
                        if(!$modelUserDetails->save()){
                        $errorMsg=Html::errorSummary($modelUserDetails); 
                       $class = end(explode("\\", get_class($modelUserDetails)));
                       $errors[$class]=$errorMsg;
                      
                  }
                  }
                   
                   
               
                }
                 
               }else{
                 
                 $errorMsg=Html::errorSummary($model); 
                 $class = end(explode("\\", get_class($model)));
                 $errors[$class]=$errorMsg; 
                   
                }   
            
           if (!empty($errors)) {
                 
                 $transaction->rollback(); 
                 $success=false;
                 $errorMsg = "<ul style='padding:0'>\n";
                foreach ($errors as $key=>$err) {
                    $errorMsg .= "<li>" .$key.$err. "</li>\n";
                }
                $errorMsg .= "</ul>";
            }else{
                
                $success=true;
            }
           
           if(!$success)
           {
             
             Yii::$app->session->setFlash('error',  $errorMsg);
             return $renderCallBack();
           }
             $transaction->commit(); 
             Yii::$app->session->setFlash('success',"Employee data Updated!");
             return $this->redirect(['index']);           
        
    } catch(Exception $e) {
        $transaction->rollback();
    }
         
          
         
        }
        
       

        return $renderCallBack();
    }

    /**
     * Deletes an existing Employees model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $flag=$this->findModel($id)->delete();
        if($flag){ Yii::$app->session->setFlash('success',"Employee deleted!");}

        return $this->redirect(['index']);
    }

    /**
     * Finds the Employees model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employees the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employees::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function createDir($path){
        
        return FileHelper::createDirectory($path);
    }
    
    function containsOnlyNull($input)
{
    return empty(array_filter($input, function ($a) { return $a !== NULL;}));
}

   function getModelClass($model)
{
    return end(explode("\\", get_class($model)));
}


function formatDateFromExcel($dateVal){
    
   return date('Y-m-d', \PHPExcel_Shared_Date::ExcelToPHP($dateVal)); 
}
}
