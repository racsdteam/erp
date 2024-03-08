<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\SignupForm;
use common\models\MirrorCase;
use common\models\User;
use frontend\models\UserRoles;
use common\models\ErpPersonsInPosition;

use common\models\ErpOrgSubdivisions;
use common\models\ErpUserActivityLog;
/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['login','signup', 'error'],
                        'allow' => true,
                    ],
                    [
                      'actions' => ['logout', 'index','user-select-hotel'],
                        'allow' => true,
                        'roles' => ['@'],
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
       
      
       //return $this->render('app-menu');
       return $this->render('index');
    }
    
   
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            $this->layout = 'login';
            return $this->render('error', ['exception' => $exception]);
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        
  
     $this->layout='login';
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())&&$model->login() ) {
            
          
                $model1=new ErpUserActivityLog();
                $model1->user=Yii::$app->user->identity->user_id;
                $model1->action='Login';
                $model1->save(false);

                return $this->goHome();
            
           
            
            
           
           
         //return   $this->redirect(Yii::$app->urlManager->createUrl("user/agent"));
           

        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionSignup()
    {
        $model = new SignupForm();
 
        if ($model->load(Yii::$app->request->post()))
        {


            if ($user = $model->signup()) {
              /* if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }*/
                
                $model1=new ErpUserActivityLog();
                $model1->user=$user->user_id;
                $model1->action='Sign-Up';
                $model1->save(false);

               $person_in_pos=new ErpPersonsInPosition(); 
               $person_in_pos->person_id=$user->user_id;
               $person_in_pos->position_id=$model->position;
               $person_in_pos->unit_id=$model->subdivision;
               $person_in_pos->save();
                
           //send notificaton email
$username=$model->username;
$password="**************";
$name=$model->first_name." ".$model->last_name; 
$email=$model->email;
           
        $flag=$this->sendNotifEmail($email,$name,$password,$username);
        
          if($flag){
           $msg="Your Registration has been received !,wait for approval process"; 
           Yii::$app->session->setFlash('success',$msg);

          }else{

            $msg="unable to send confirmation email!";
            Yii::$app->session->setFlash('failure',$msg);
          }

                $model = new SignupForm();
                
                return $this->render('signup', [
                    'model' => $model,
                ]);

            
        }

    }
 
        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    
  
   

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        $model1=new ErpUserActivityLog();
                $model1->user=Yii::$app->user->identity->user_id;
                $model1->action='Sign-Out';
                $model1->save(false);
        Yii::$app->user->logout();
        Yii::$app->session->destroy();
        
        return $this->goHome();
    }




     //to prevent unable to verify yr submission data errror
     public function beforeAction($action) { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);
    
    }
    
      
   public function sendNotifEmail($email,$name,$password,$username){
  
   
    
   //--------------------user feedback------------------
   
    $flag= Yii::$app->mailer->compose( ['html' =>'userFeedback-html'],
    [
        'name' =>$name,'username'=>$username,'password'=>$password
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$email=>$name])
->setSubject('ERP User Credentials')
//->setTextBody('You Can Change Login Password After Sign in')
->send();   

//----------------------admin feedback-----------------------------------
  $usersAdmin=User::find()->where(['user_level'=>User::ROLE_ADMIN])->All();
        
       $emails=array();
       
    foreach($usersAdmin as $admin){
      
      $name=$admin->first_name." ".$admin->last_name.""; 
      
      $flag= Yii::$app->mailer->compose( ['html' =>'adminFeedback-html'],
    [
        'name' =>$name,'username'=>$username,'password'=>$password
       
    ])
->setFrom(['no_reply@rac.co.rw' => 'RAC SYSTEM'])
->setTo([$admin->email=>$name])
->setSubject('ERP User Credentials')
//->setTextBody('You Can Change Login Password After Sign in')
->send();   
    }
    
    
   
   
return $flag;
   } 
   


   
}
