<?php

namespace frontend\modules\assets0\controllers;

use Yii;
use frontend\modules\assets0\models\AssetDsplReasons;
use frontend\modules\assets0\models\AssetDsplReasonsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AssetDsplReasonsController implements the CRUD actions for AssetDsplReasons model.
 */
class AssetDsplReasonsController extends Controller
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
     * Lists all AssetDsplReasons models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AssetDsplReasonsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AssetDsplReasons model.
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
     * Creates a new AssetDsplReasons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AssetDsplReasons();
 if ($model->load(Yii::$app->request->post()) ) {
            
            $renderForm=function()use($model){
            return $this->render('create', [
            'model' => $model,
        ]);   
            };
           
           if(!$model->save()){
               Yii::$app->session->setFlash('error',Html::errorSummary($model)); 
               return  $renderForm();
           
             
            }
         
             
              Yii::$app->session->setFlash('success',"Asset Disposal Reason Saved!"); 
              return $this->redirect(['index']);
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
     * Updates an existing AssetDsplReasons model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       if ($model->load(Yii::$app->request->post()) ) {
            
            $renderForm=function()use($model){
            return $this->render('create', [
            'model' => $model,
        ]);   
            };
           
           if(!$model->save()){
               Yii::$app->session->setFlash('error',Html::errorSummary($model)); 
               return  $renderForm();
           
             
            }
         
             
              Yii::$app->session->setFlash('success',"Asset Disposal Reason Updated!"); 
              return $this->redirect(['index']);
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
     * Deletes an existing AssetDsplReasons model.
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
     * Finds the AssetDsplReasons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AssetDsplReasons the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AssetDsplReasons::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
