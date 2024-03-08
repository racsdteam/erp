<?php
namespace frontend\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\LoginForm;
use common\models\SignupForm;
use common\models\User;
use yii\db\Query;
use common\models\CaseUserRoles;
use yii\web\UploadedFile;
use common\models\ErpPersonsInPosition;
use yii\web\NotFoundHttpException;
use common\models\UserHelper;
use common\models\UnitHelper;
/**
 * Site controller
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login','signup','forgot-password','reset-password','ver-token','error','profile-update','change-password'],
                        'allow' => true,
                    ],
                    [
                      'actions' => ['user-list','user-approve','users-pending','view','index','get-pos','work',
                      'update','users-list','get-users','change-user-status'],
                        'allow' => true,
                         'matchCallback' => function ($rule, $action) {
            return \Yii::$app->user->identity->isAdmin();
                   },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            
        ];
    }
    
      /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    
   public function actionGetPos()
    {
         $user=Yii::$app->user->identity->user_id;
         UserHelper::getPositionInfo($user);
         //UserHelper::getOrgUnitInfo($user);
         
         //UnitHelper::getOrgUnitDeptChild(3);
        // $pos=array();
        
        $pos=UserHelper::getPositionInfo($user);
      
       var_dump( $pos['id']);
         
        
    }




      public function actionIndex()
    {
       
        return $this->render('all-users');
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionUsersList()
    {
       
        return $this->render('users-list');
    }
    
    
    
     public function actionView($id)
    {
        if (Yii::$app->request->isAjax) {
       
       
            return   $this->renderAjax('profile',[ 'model' => $this->findModel($id),'isAjax'=>true]);
     
     
         }else{
             
           return $this->render('profile', [
            'model' => $this->findModel($id),
        ]);   
         }
         
        
    }
    
     public function actionGetUsers()
    {
       //$this->layout='add-case';
      
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $query = new Query;
        $query	->select([
                'user.*','role.role_name' ]
                )  
                ->from('user ')
                ->join('INNER JOIN', 'user_roles as role',
                'user.user_level=role.role_id');
               
               
               // ->where(['approved' =>0])	;
                
                $command = $query->createCommand();
                $dataProvider = $command->queryAll();  
              //echo json_encode($dataProvider);

              $data = array();

              foreach ($dataProvider as $key => $row)
              {
                
                  $nestedData = array();
                 
              
                  $nestedData[] = $row["first_name"];
                  $nestedData[] = $row["last_name"];
                  $nestedData[] = $row["phone"];
                  $nestedData[] = $row["email"];
                  $nestedData[] = $row["role_name"];
                  $nestedData[] = $row["username"];
                 
                   $data[] = $nestedData;
                 
              }
              $response = [
              
              'users'=> $dataProvider
            ];
            return $response;

}

 
    /**
     * Login action.
     *
     * @return string
     */
    public function actionUsersPending()
    {
        
    
        $query = new Query;
        $query	->select([
                'user_id as id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'username',
               
               
             ]
                )  
                ->from('user ')
               
               
                ->where(['approved'=>0])	;
                
                $command = $query->createCommand();
                $dataProvider = $command->queryAll();   
        
       // var_dump( $dataProvider);die();
        
        
        return $this->render('users-pending', [
                'dataProvider' => $dataProvider,
            ]);
        
    }


    public function actionChangeUserStatus($id){
        
        $user=User::find()->where(['user_id'=>$id])->One();

        if($user->status!=10){
            $user->status=10;
        }else{$user->status=0;}

         $flag= $user->save(false);
         $msg="";
         if($flag){
            
           $msg.="User Status Changed!"; 

         }else{
            $msg.="User Status could not be Changed!"; 
            
         }
         Yii::$app->session->setFlash('success',$msg);
         return  $this->redirect(['users-list']);

    }





    public function actionUserApprove($id)
    {
        
          
        $model=User::findIdentity($id);
        $person_in_pos=ErpPersonsInPosition::find()->where(['person_id'=>$id])->One(); 
              if($person_in_pos!=null){
                  
                $model->position=$person_in_pos->position_id;
                $model->org_unit=$person_in_pos->unit_id;  
                  
              }    

             if( $model->load(Yii::$app->request->post())){
               

                $model->approved=true;
               
                $flag=$model->save(false);
                $msg="";
                
              if($flag){
  
                $msg.="User Approved!";
                $name=$model->first_name."".$model->last_name;
                $this->sendNotifEmail($model->email,$name,'***********',$model->username);


              }else{

                $msg.="User Could not be Approved!";
                     }
                    
                    
                     Yii::$app->session->setFlash('success',$msg);
                     
                     return  $this->redirect(['users-pending']);

             }

            

    if (Yii::$app->request->isAjax) {
        // JSON response is expected in case of successful save
     //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
       
       return   $this->renderAjax('approve', ['model'=>$model,'isAjax'=>true]);

      //return ['fname' => $profile->involvement];


    }else{
        return   $this->render('approve', ['model'=>$model]);

    }
     
   
    }


    public function actionProfileUpdate($id)
    {
        
          
$model=User::findIdentity($id);
$work=$model->workDetails != null ? $model->workDetails : new ErpPersonsInPosition();
$errors=[];
            
              
            
             if(isset($_POST['User'])){
         
       
 $model->attributes=$_POST['User'];
 
 $model->photo_uploaded_file= UploadedFile::getInstance($model, 'photo_uploaded_file');

  // generate a unique file name to prevent duplicate filenames
  $exponent = 3; // Amount of digits
  $min = pow(10,$exponent);
  $max = pow(10,$exponent+1)-1;
  //1
  $value = rand($min, $max);
  $unification= date("Ymdhms")."".$value;
  
  $renderForm=function()use($model,$work){
    return   $this->render('_form', ['model'=>$model,'work'=>$work=!null?$work:new ErpPersonsInPosition(),'isAjax'=>false]);   
      };

 if($model->photo_uploaded_file!==null){
     $file_photo= $model->photo_uploaded_file;
     $temp = explode(".", $file_photo->name);
     $ext = end($temp);

       //renaming files to avoid duplicate names
       $path_to_Photo='uploads/profile/'. $unification.".{$ext}";
      
       if (file_exists($model->user_image)) {
        unlink($model->user_image);
    }
       $model->user_image=$path_to_Photo;
 }

    if($model->save()){
       
     $old=$work->attributes;
     $new=$_POST['ErpPersonsInPosition'];
  
     if(!ArrayHelper::isSubset( $new, $old)){
                $person_in_pos=new ErpPersonsInPosition(); 
                $person_in_pos->attributes=$_POST['ErpPersonsInPosition'];
                $person_in_pos->person_id=Yii::$app->user->identity->user_id;
                if(!$person_in_pos->save()){
                   $errors[]=Html::errorSummary($person_in_pos);
                  }
                 
                 if($work!=null){
                  $work->status=0;
                  if(!$work->save(false)){
                    $errors[]=Html::errorSummary($work);   
                      
                    };
                  }
             
         
       }
       
    
                if($file_photo!==null&&$path_to_Photo !='') {
                    
                                $file_photo->saveAs($path_to_Photo );
                              }
    
    
             
  
               

              }else{
              
              $errors[]=Html::errorSummary($model);
          
                     }
                     if(!empty($errors)){
                          
                          $errorMsg = "<ul style='padding:0'>\n";
                foreach ($errors as $key=>$err) {
                    $errorMsg .= "<li>" .$err. "</li>\n";
                }
                $errorMsg .= "</ul>";
                      
                      Yii::$app->session->setFlash('error',$errorMsg);     
                     return $renderForm();     
                     }
                    
                     Yii::$app->session->setFlash('success',"User Profile has been Updated!"); 
                     return $this->redirect(['/site/index']);

             }

    if (Yii::$app->request->isAjax) {
   
       
       return   $this->renderAjax('_form', ['model'=>$model,'work'=>$work=!null?$work:new ErpPersonsInPosition(),'isAjax'=>true]);

 


    }else{
        return   $this->render('_form', ['model'=>$model,'work'=>$work=!null?$work:new ErpPersonsInPosition(),'isAjax'=>false]);

    }
     
   
    }

    public function actionUpdate($id)
    {
        
$model=User::findIdentity($id);
$work=empty($model->workDetails)?  new ErpPersonsInPosition(): $model->workDetails ;
$errors=[];
            
  
             if($model->load(Yii::$app->request->post())){
     
 $model->photo_uploaded_file= UploadedFile::getInstance($model, 'photo_uploaded_file');

  // generate a unique file name to prevent duplicate filenames
  $exponent = 3; // Amount of digits
  $min = pow(10,$exponent);
  $max = pow(10,$exponent+1)-1;
  //1
  $value = rand($min, $max);
  $unification= date("Ymdhms")."".$value;
  
  $renderForm=function()use($model,$work){
    return   $this->render('_form', ['model'=>$model,'work'=>empty($work) ?new ErpPersonsInPosition() : $work,'isAjax'=>false]);   
      };

 if($model->photo_uploaded_file!==null){
     $file_photo= $model->photo_uploaded_file;
     $temp = explode(".", $file_photo->name);
     $ext = end($temp);

       //renaming files to avoid duplicate names
       $path_to_Photo='uploads/profile/'. $unification.".{$ext}";
      
       if (file_exists($model->user_image)) {
        unlink($model->user_image);
    }
       $model->user_image=$path_to_Photo;
 }

    if($model->save()){
    
    
    if(!ArrayHelper::isSubset(array_values($_POST['ErpPersonsInPosition']), array_values($work->attributes))){
                $person_in_pos=new ErpPersonsInPosition(); 
                $person_in_pos->attributes=$_POST['ErpPersonsInPosition'];
                $person_in_pos->person_id=$model->user_id;
                if(!$person_in_pos->save()){
                   $errors[]=Html::errorSummary($person_in_pos);
                  }
                 
                 if(!empty($work)){
                     $work->status=0;
                  
                  if(!$work->save(false)){
                    $errors[]=Html::errorSummary($work);   
                      
                    };
                  }
             
         
       }
       
    
                if($file_photo!==null&&$path_to_Photo !='') {
                    
                                $file_photo->saveAs($path_to_Photo );
                              }
    
    
             
  
               

              }else{
              
              $errors[]=Html::errorSummary($model);
          
                     }
                     if(!empty($errors)){
                          
                          $errorMsg = "<ul style='padding:0'>\n";
                foreach ($errors as $key=>$err) {
                    $errorMsg .= "<li>" .$err. "</li>\n";
                }
                $errorMsg .= "</ul>";
                      
                      Yii::$app->session->setFlash('error',$errorMsg);     
                     return $renderForm();     
                     }
                    
                     Yii::$app->session->setFlash('success',"User has been Updated!"); 
                     return $this->redirect(['user/index']);

             }

    if (Yii::$app->request->isAjax) {
   
       
       return   $this->renderAjax('_form', ['model'=>$model,'work'=>$work=!null?$work:new ErpPersonsInPosition(),'isAjax'=>true]);

 


    }else{
        return   $this->render('_form', ['model'=>$model,'work'=>$work=!null?$work:new ErpPersonsInPosition(),'isAjax'=>false]);

    }
    
    }

public function sendNotifEmail($email,$name,$password,$username){
  
   
    
   //--------------------user feedback------------------
   
    $flag= Yii::$app->mailer->compose( ['html' =>'userApprovedFeedBack-html'],
    [
        'name' =>$name,'username'=>$username,'password'=>$password
       
    ])
->setFrom(['no_reply@rac.co.rw' =>'RAC SYSTEM'])
->setTo([$email=>$name])
->setSubject('ERP User Approval')
//->setTextBody('You Can Change Login Password After Sign in')
->send();   


    
   
   
return $flag;
   } 

 //===========================================reset password===============================
    
    public function actionForgotPassword()
{
      
   $model=new SignupForm();
    if (isset($_POST['SignupForm'])) {
        
         $getEmail=$_POST['SignupForm']['email'];
         
        
            $getModel= User::findByEmail($getEmail);
            
            if( $getModel!=null){
                
                
                 $getToken=rand(0, 99999);
                $getTime=date("H:i:s");
                $getModel->password_reset_token=md5($getToken.$getTime);
                
               
			
				$getModel->save(false);
                                
	 $name= $getModel->first_name." ". $getModel->last_name;			
				//send mail
				$sent= Yii::$app->mailer->compose( ['html' =>'passwordResetToken-html'],
                [
                    'token' =>$getModel->password_reset_token,'name'=>$name
                   
                ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$getModel->email=>$name])
->setSubject('Reset Password')
//->setTextBody('You Can Change Login Password After Sign in')
->send();   

				 \Yii::$app->session->setFlash('success',"A link to reset your password has been sent to your Email");
			
				
			
            }else{
                
             \Yii::$app->session->setFlash('failure',"Email provided could not be found!");   
             return $this->render('forgotPassword',['model'=>$model]);
            }
        
        $model=new SignupForm();
		return $this->render('forgotPassword',['model'=>$model]);
  
               
    }
 
    return $this->render('forgotPassword',['model'=>$model]);
}
//===============================verify toekn====================
public function actionVerToken($token)
        {
            $model=new SignupForm();
            
            
            $user=$this->getToken($token);
           
          
          
            if(isset($_POST['SignupForm']))
            {
               
        
                if($user->password_reset_token==$_POST['SignupForm']['tokenhid']){
                  
                    $user->setPassword($_POST['SignupForm']['password']);
                    $user->password_reset_token=NULL;
                   $flag= $user->save(false);
                   if( $flag){
                     \Yii::$app->session->setFlash('success',"Password has been successfully changed! please login");   
                       
                   }else{
                       
                        \Yii::$app->session->setFlash('failure',"Password could not be changed! please try again");
                   }
                   
                    return    $this->render('changePassword',[
			'model'=>$model,'token'=>$user->password_reset_token
		]);
                  
                }
            }
        return    $this->render('changePassword',[
			'model'=>$model,'token'=>$user->password_reset_token
		]);
        }
        
        public function getToken($token)
	{
		$model=User::findByPasswordResetToken($token);
		
	
		if($model!==null)
		{
		    
		    	return $model;
		
	
		}
	 throw new NotFoundHttpException('The requested page does not exist.');
	}
	
	    public function actionChangePassword()
{
    $id = \Yii::$app->user->id;
 
    try {
        $model = new \common\models\ChangePasswordForm($id);
    } catch (InvalidParamException $e) {
        throw new \yii\web\BadRequestHttpException($e->getMessage());
    }
 
    if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->changePassword()) {
        \Yii::$app->session->setFlash('success', 'Password Changed!');
         return $this->redirect( ['/site/index'
        
    ]); 
    }
 if(Yii::$app->request->isAjax){
   return $this->renderAjax('changePassword2', [
        'model' => $model,
    ]);   
 }
    return $this->render('changePassword2', [
        'model' => $model,
    ]);
}

     //to prevent unable to verify yr submission data errror
     public function beforeAction($action) { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);
    
    }

    private function findModel($id){
        $model = User::findIdentity($id);
     return $model;
    }

    public function findUserLevelByName($name){
        
            $model = CaseUserRoles::find()
            ->where(['role_name' => $name])
            ->one();
            return $model!==null?$model:null;
        
           }
   
}
