<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpDocumentAnnotations;
use common\models\ErpDocumentAnnotationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ErpDocumentAnnotationsController implements the CRUD actions for ErpDocumentAnnotations model.
 */
class ErpDocumentAnnotationsController extends Controller
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
     * Lists all ErpDocumentAnnotations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpDocumentAnnotationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpDocumentAnnotations model.
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
     $model=new  ErpDocumentAnnotations();
     $model->annotation=$xfdf;
     //$model->author=$id;
      $model->doc=$id;
      $model->save(false); */ 
       
      return  json_encode(1);
        
    }
    
    
    //--------------------------------------ann handler----------------------------------------------
    
  public function actionAnnotationsHandler(){
       
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
         $data=json_decode(file_get_contents('php://input'),1);
         
         if($data['command']=='add'){
              
         $model=new  ErpDocumentAnnotations();
         $model->annotation= $data['xfdfString'];
         $model->annotation_id=$data['annotationId'];
         $model->author=Yii::$app->user->identity->user_id;
         $model->attachement=$_REQUEST['documentId'];
         $model->save(false);
             
         }else if($data['command']=='update'){
             
           Yii::$app->db->createCommand()
                      ->update('erp_document_annotations', ['annotation' => $data['xfdfString']], ['annotation_id' =>$data['annotationId']])
                      ->execute();  
             
         }else if($data['command']=='delete'){
         
         Yii::$app->db
->createCommand()
->delete('erp_document_annotations', ['AND', ['attachement' => $_REQUEST['documentId']],  ['annotation_id' =>$data['annotationId']]])
->execute();
         
             
         }
        
           
           
       }else
       
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
           
          $q=" SELECT annotation_id,annotation FROM  erp_document_annotations  where attachement='{$_REQUEST['documentId']}'";
          $com = Yii::$app->db->createCommand($q);
          $rows = $com->queryAll(); 
          return  json_encode($rows);
        
           
           
       }
  

        
    }
    /**
     * Creates a new ErpDocumentAnnotations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpDocumentAnnotations();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ErpDocumentAnnotations model.
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
     * Deletes an existing ErpDocumentAnnotations model.
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
     * Finds the ErpDocumentAnnotations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpDocumentAnnotations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpDocumentAnnotations::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

//----------------------------------------------unable to verify data submission------------------------------------------------------------
public function beforeAction($action) {
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
}
}
