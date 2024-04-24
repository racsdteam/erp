<?php

namespace frontend\modules\procurement\controllers;

use Yii;
use frontend\modules\procurement\models\TenderStageSettings;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\UploadedFile;
/**
 * TenderStageSettingsController implements the CRUD actions for TenderStageSettings model.
 */
class TenderStageSettingsController extends Controller
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
     * Lists all TenderStageSettings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TenderStageSettings::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TenderStageSettings model.
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
     * Creates a new TenderStageSettings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TenderStageSettings();

       if(Yii::$app->request->post()){
           $params= array();
            $user_id=Yii::$app->user->identity->user_id;
            $model->attributes=$_POST['TenderStageSettings'];
             $model->user_id=$user_id;


             $params["type"]=$model->type;
             $params["bid_section"]=$model->bid_section;
             $model->uploaded_file = UploadedFile::getInstance($model, 'uploaded_file');
             if(!empty($model->uploaded_file)){
                 
                $file=$model->uploaded_file;
                
$exponent = 3; // Amount of digits
$min = pow(10,$exponent);
$max = pow(10,$exponent+1)-1;
//1
$value = rand($min, $max);
$unification= date("Ymdhms")."".$value;
 
  $temp= explode(".",   $file->name);
  $ext = end($temp);
  $path_to_attach='uploads/procurement/templates/'. $unification.".{$ext}";
   
 $params["template"]=$path_to_attach;
 $file->saveAs($path_to_attach); 
             }
$model->params= Json::encode( $params,JSON_UNESCAPED_SLASHES);
$flag=$model->save();
             if($flag)
             {
            Yii::$app->session->setFlash('success','Tender stage  Saved !');
            
            return $this->redirect(['index']);
             }
        }


        if (Yii::$app->request->isAjax)
        {  
            return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TenderStageSettings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if($model->params!=null)
        {
        $params= Json::decode($model->params,JSON_UNESCAPED_SLASHES);
        $model->type=$params["type"];
        $model->bid_section=$params["bid_section"];
        $model->template=$params["template"];
        }
        if(Yii::$app->request->post()){
            $params_request= array();
             $user_id=Yii::$app->user->identity->user_id;
             $model->attributes=$_POST['TenderStageSettings'];
              $model->user_id=$user_id;
 
 
              $params_request["type"]=$model->type;
              $params_request["bid_section"]=$model->bid_section;
              $model->uploaded_file = UploadedFile::getInstance($model, 'uploaded_file');
              if(!empty($model->uploaded_file)){
                  
                 $file=$model->uploaded_file;
                 
 $exponent = 3; // Amount of digits
 $min = pow(10,$exponent);
 $max = pow(10,$exponent+1)-1;
 //1
 $value = rand($min, $max);
 $unification= date("Ymdhms")."".$value;
  
   $temp= explode(".",   $file->name);
   $ext = end($temp);
   $path_to_attach='uploads/procurement/templates/'. $unification.".{$ext}";
    
  $params_request["template"]=$path_to_attach;
  $file->saveAs($path_to_attach); 
              }
 $model->params= Json::encode( $params_request,JSON_UNESCAPED_SLASHES);
 $flag=$model->save();
              if($flag)
              {
             Yii::$app->session->setFlash('success','Tender stage  Saved !');
             return $this->redirect(['index']);
              }
         }

         if (Yii::$app->request->isAjax)
        {  
            return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TenderStageSettings model.
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
     * Finds the TenderStageSettings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TenderStageSettings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TenderStageSettings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
