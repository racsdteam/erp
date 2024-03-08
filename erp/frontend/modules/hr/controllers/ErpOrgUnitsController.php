<?php

namespace frontend\modules\hr\controllers;

use Yii;
use common\models\ErpOrgUnits;
use common\models\ErpOrgUnitsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ErpOrgUnitsController implements the CRUD actions for ErpOrgUnits model.
 */
class ErpOrgUnitsController extends Controller
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
     * Lists all ErpOrgUnits models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpOrgUnitsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpOrgUnits model.
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
    
  public function actionPositions(){
      
       Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
          
              if(isset($parents[0]) && is_numeric($parents[0])){
               $model=ErpOrgUnits::findOne($parents[0]);
                $positions=$model->positions;
                if(!empty(  $positions)){
                 
                 foreach ( $positions as $p) {
                    
                 $out[]=['id'=>$p->id,'name'=>$p->position];
                      } 
                }
           }
       
            return ['output'=>$out, 'selected'=>''];
        }
    }
    
   
    return ['output'=>'', 'selected'=>''];  
      
      
      
  }

    /**
     * Creates a new ErpOrgUnits model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpOrgUnits();
        
        $formAjax=$this->renderAjax('_form', [
            'model' => $model,
        ]);
        $form=$this->render('create', [
            'model' => $model,
        ]);
        
        

       if ($model->load(Yii::$app->request->post()) ) {
            
            
          
            if(!$model->save()){
            
            $msg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$msg); 
            return $form;
             
            }
               $msg="Org Unit Created !" ;
               Yii::$app->session->setFlash('success',$msg); 
               return $this->redirect(['index']);
        }
        
        if(Yii::$app->request->isAjax){
            
            return $formAjax;
        }

          return $form;
    }

    /**
     * Updates an existing ErpOrgUnits model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $formAjax=$this->renderAjax('_form', [
            'model' => $model,
        ]);
        $form=$this->render('create', [
            'model' => $model,
        ]);
        
         if ($model->load(Yii::$app->request->post()) ) {
            
            if(!$model->save()){
            
            $msg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$msg); 
            return $form;
             
            }
           
            $msg="Org Unit Updated !" ;
            Yii::$app->session->setFlash('success',$msg); 
            return $this->redirect(['index']);
        }
        
        if(Yii::$app->request->isAjax){
            
           return $formAjax; 
        }

         return $form;
    }

    /**
     * Deletes an existing ErpOrgUnits model.
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
     * Finds the ErpOrgUnits model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpOrgUnits the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpOrgUnits::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
