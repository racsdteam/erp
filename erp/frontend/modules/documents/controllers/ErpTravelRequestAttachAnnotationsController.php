<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpTravelRequestAttachAnnotations;
use common\models\ErpTravelRequestAttachAnnotationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ErpTravelRequestAttachAnnotationsController implements the CRUD actions for ErpTravelRequestAttachAnnotations model.
 */
class ErpTravelRequestAttachAnnotationsController extends Controller
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
     * Lists all ErpTravelRequestAttachAnnotations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpTravelRequestAttachAnnotationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpTravelRequestAttachAnnotations model.
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
    
      //--------------------------------------ann handler----------------------------------------------
    
    public function actionAnnotationsHandler(){
       
    
        //POST request 
       if (Yii::$app->request->post()) {
   
   
    if(isset($_REQUEST['did'])){
    
                       
                        
    if(isset($_POST['data'])){

        if (get_magic_quotes_gpc()) {
            $xfdfData = stripslashes($_POST['data']);
        } else{
            $xfdfData = $_POST['data'];
        }
        
        $model= ErpTravelRequestAttachAnnotations::find()->where(['doc'=>$_REQUEST['did']])->One();
        
        if($model!=null){
            
            
            Yii::$app->db->createCommand()
                      ->update('erp_travel_request_attach_annotations', ['annotation' => $xfdfData], ['doc' =>$_REQUEST['did']])
                      ->execute();
        }else{
          //save
     $model=new  ErpTravelRequestAttachAnnotations();
     $model->annotation=$xfdfData;
     $model->author=Yii::$app->user->identity->user_id;
      $model->doc=$_REQUEST['did'];
      $model->save(false);  
            
        }

    }
        
    }
  
} else{
    if(isset($_REQUEST['did'])){
       
      $annots=ErpTravelRequestAttachAnnotations::find()->where(['doc'=>$_REQUEST['did']])->One(); 
       
       $headers = Yii::$app->response->headers;
       $headers->set('Content-type', 'text/xml'); 
      
      return $annots->annotation;
        
    }
   
   
}
        
    }

    /**
     * Creates a new ErpTravelRequestAttachAnnotations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpTravelRequestAttachAnnotations();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ErpTravelRequestAttachAnnotations model.
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
     * Deletes an existing ErpTravelRequestAttachAnnotations model.
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
     * Finds the ErpTravelRequestAttachAnnotations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpTravelRequestAttachAnnotations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpTravelRequestAttachAnnotations::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function beforeAction($action) {
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
}
}
