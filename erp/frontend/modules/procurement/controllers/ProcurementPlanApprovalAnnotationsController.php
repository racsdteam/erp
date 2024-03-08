<?php

namespace frontend\modules\procurement\controllers;

use frontend\modules\procurement\models\ProcurementPlanApprovalAnnotations;
use frontend\modules\procurement\models\ProcurementPlans;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;


class ProcurementPlanApprovalAnnotationsController extends \yii\web\Controller
{
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
        $searchModel = new LeaveAnnotations();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
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
       
     
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
         $data=json_decode(file_get_contents('php://input'),1);
         
         if($data['command']=='add'){
              
         $model=new  ProcurementPlanApprovalAnnotations();
         $model->annotation= $data['xfdfString'];
         $model->annotation_id=$data['annotationId'];
         $model->type=$data['type'];
         $model->author=Yii::$app->user->identity->user_id;
         $model->doc=$_REQUEST['documentId'];
         $model->save(false);
             
         }else if($data['command']=='update'){
             
           Yii::$app->db8->createCommand()
                      ->update('procurement_plan_approval_annotations', ['annotation' => $data['xfdfString']], ['annotation_id' =>$data['annotationId']])
                      ->execute();  
             
         }else if($data['command']=='delete'){
         
         Yii::$app->db8
->createCommand()
->delete('procurement_plan_approval_annotations', ['AND', ['doc' => $_REQUEST['documentId']],  ['annotation_id' =>$data['annotationId']]])
->execute();
         
             
         }
        
           
           
       }else
       
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
           
          $q=" SELECT annotation_id,annotation FROM  procurement_plan_approval_annotations  where doc='{$_REQUEST['documentId']}'";
          $com = Yii::$app->db8->createCommand($q);
          $rows = $com->queryAll(); 
          return  json_encode($rows);
        
           
           
       }
  

        
    }
    
    public function actionConfirmApproval(){
          
          if (Yii::$app->request->isAjax) {
              $request=Yii::$app->request;
              $requestId=$request->get('requestId');
              $actorId=$request->get('actorId');
             
              
              if(empty($requestId)){
         $res['status']='error';
         $res['data']['msg']="Unable to confirm your approval, Invalid Request Id !";
         return $this->asJson($res);    
        }
        
         $model= ProcurementPlans::findOne($requestId);
         
          $q=" SELECT * FROM  procurement_plan_approval_annotations  where doc='{$requestId}' and author='{$actorId}' and type='Signature'";
          $com = Yii::$app->db8->createCommand($q);
          $row= $com->queryOne();
          
          if(empty($row)){
              
             $res['status']='error';
             $res['data']['msg']="Procurement Plan not signed!\n<small>please sign before mark it as approved</small>";
            return $this->asJson($res);  
          }
            
         $res['status']='success';
         $res['data']['msg']='all documents signed';
         return $this->asJson($res);
       
       } 
          
      }
 /**
     * Creates a new ErprequestAnnotations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProcurementPlanApprovalAnnotations();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ErprequestAnnotations model.
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
     * Deletes an existing ErprequestAnnotations model.
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
     * Finds the ErprequestAnnotations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErprequestAnnotations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProcurementPlanApprovalAnnotations::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function beforeAction($action) {
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
}
}
