<?php

namespace frontend\modules\hr\controllers;

use Yii;
use common\models\ErpUnitsPositions;
use common\models\ErpUnitsPositionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ErpUnitsPositionsController implements the CRUD actions for ErpUnitsPositions model.
 */
class ErpUnitsPositionsController extends Controller
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
     * Lists all ErpUnitsPositions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpUnitsPositionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpUnitsPositions model.
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
     * Creates a new ErpUnitsPositions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpUnitsPositions();
if(isset($_GET['unit']) && $_GET['unit']!=null)
        $model->unit_id=$_GET['unit'];
        if ($model->load(Yii::$app->request->post()) ) {
            
            if(!$model->save()){
            
            $msg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$msg); 
             
            }
            else{
                
               $msg="Position Added !" ;
               Yii::$app->session->setFlash('success',$msg); 
            }
             
             return $this->redirect(['erp-org-units/view','id'=>$_GET['unit']]);
        }
        
        
        
        if(Yii::$app->request->isAjax){
            
            return $this->renderAjax('_form', [
            'model' => $model,
        ]); 
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ErpUnitsPositions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
         if ($model->load(Yii::$app->request->post()) ) {
            
            if(!$model->save()){
            
            $msg=Html::errorSummary($model); 
            Yii::$app->session->setFlash('error',$msg); 
             
            }
            else{
                
               $msg="Position Updated !" ;
               Yii::$app->session->setFlash('success',$msg); 
            }
             
            return $this->redirect(['erp-org-units/view','id'=>$model->unit_id]);
        }
        
        if(Yii::$app->request->isAjax){
            
            return $this->renderAjax('_form', [
            'model' => $model,
        ]); 
        }

        return $this->render('create', [
            'model' => $model,
        ]);

       
    }

    /**
     * Deletes an existing ErpUnitsPositions model.
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
     * Finds the ErpUnitsPositions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpUnitsPositions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpUnitsPositions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
