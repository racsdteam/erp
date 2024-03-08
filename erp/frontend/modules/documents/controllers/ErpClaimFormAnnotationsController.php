<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpClaimFormAnnotations;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ErpClaimFormAnnotationsController implements the CRUD actions for ErpClaimFormAnnotations model.
 */
class ErpClaimFormAnnotationsController extends Controller
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

 public function actionIndex()
    {
        $searchModel = new ErpClaimFormAnnotationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpClaimFormAnnotations model.
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
    
    //---------------------------save annotations ansyc---------------------------------------------
    
    public function actionSaveAnnotAsync(){
      
      /* $data = json_decode( $data, true );
       $xfdf=$data['xfdf'];
       $id=$data['id'];
     $model=new  ErpClaimFormAnnotations();
     $model->annotation=$xfdf;
     //$model->author=$id;
      $model->doc=$id;
      $model->save(false); */ 
       
      return  json_encode(1);
        
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
        
        $model= ErpClaimFormAnnotations::find()->where(['doc'=>$_REQUEST['did']])->One();
        
        if($model!=null){
            
            Yii::$app->db->createCommand()
                      ->update('erp_claim_form_annotations', ['annotation' => $xfdfData], ['doc' =>$_REQUEST['did']])
                      ->execute();
        }else{
          //save
     $model=new  ErpClaimFormAnnotations();
     $model->annotation=$xfdfData;
     $model->author=Yii::$app->user->identity->user_id;
      $model->doc=$_REQUEST['did'];
      $model->save(false);  
            
        }

    }
        
    }
  
} else{
    if(isset($_REQUEST['did'])){
       
      $annots= ErpClaimFormAnnotations::find()->where(['doc'=>$_REQUEST['did']])->One(); 
       
       $headers = Yii::$app->response->headers;
       $headers->set('Content-type', 'text/xml'); 
      
      return $annots->annotation;
        
    }
   
   
}
        
    }

    /**
     * Creates a new ErpClaimFormAnnotations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpClaimFormAnnotations();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ErpClaimFormAnnotations model.
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
     * Deletes an existing ErpClaimFormAnnotations model.
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
     * Finds the ErpClaimFormAnnotations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpClaimFormAnnotations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpClaimFormAnnotations::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function beforeAction($action) {
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
}
}
