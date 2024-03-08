<?php

namespace frontend\modules\assets0\controllers;

use Yii;
use frontend\modules\assets0\models\AssetStatusDetails;
use frontend\modules\assets0\models\AssetStatusDetailsearch;
use frontend\modules\assets0\models\Assets;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AssetStatusDetailsController implements the CRUD actions for AssetStatusDetails model.
 */
class AssetStatusDetailsController extends Controller
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
     * Lists all AssetStatusDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AssetStatusDetailsearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AssetStatusDetails model.
     * @param integer $id
     * @return mixed
     * @tassets0ows NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AssetStatusDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AssetStatusDetails();
        
      
           $request=Yii::$app->request;
        
         if ($model->load($request->post()) ) {
           
           
            $renderForm=function()use($model){
               
             return $this->render('_form', [
            'model' => $model
        ]); 
                
            };
           
               try{
        
           $model->user=Yii::$app->user->identity->user_id;
           
           if(!$model->save()){
            
          
             throw new UserException(Html::errorSummary($model));
          
             }
             
         
             
             $assetModel=Assets::findOne($model->asset);
             if(!empty($assetModel))
             $assetModel->changeStatus($model->status);
             
            
       
           
             Yii::$app->session->setFlash('success', "Asset Status Changed !"); 
             return $this->redirect(['assets/view','id'=>$model->asset]);
                       
                   
               }
               
                catch (UserException $e) {
                    $transaction->rollBack();
                     Yii::$app->session->setFlash('error',$e->getMessage()); 
                    return $renderForm(); 
                }
                 
              
       
        }
        
       
       
        
        if(Yii::$app->request->isAjax)
         return $this->renderAjax('_form', [
            'model' => $model,'asset'=>$request->get('asset')
        ]);
        
        return $this->render('_form', [
            'model' => $model,'asset'=>$request->get('asset')
        ]);
    }

    /**
     * Updates an existing AssetStatusDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @tassets0ows NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

          if ($model->load($request->post()) ) {
           
           
            $renderForm=function()use($model){
               
             return $this->render('_form', [
            'model' => $model
        ]); 
                
            };
           
               try{
          
           if(empty($model->user))
           $model->user=Yii::$app->user->identity->user_id;
           
           if(!$model->save()){
            
          
             throw new UserException(Html::errorSummary($model));
          
             }
             
         
             
             $assetModel=Assets::findOne($model->asset);
             $assetModel->status=$model->status;
              
             if(! $assetModel->save(false)){
           
            throw new UserException(Html::errorSummary( $assetModel));
          
             }
       
             Yii::$app->session->setFlash('success', "Asset Status Updated !"); 
             return $this->redirect(['assets/view','id'=>$model->asset]);
                       
                   
               }
               
                catch (UserException $e) {
                    $transaction->rollBack();
                     Yii::$app->session->setFlash('error',$e->getMessage()); 
                    return $renderForm(); 
                }
                 
              
       
        }
        
      
        
        if(Yii::$app->request->isAjax)
         return $this->renderAjax('_form', [
            'model' => $model,'asset'=>$request->get('asset')
        ]);
        
        return $this->render('_form', [
            'model' => $model,'asset'=>$request->get('asset')
        ]);
    }

    /**
     * Deletes an existing AssetStatusDetails model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @tassets0ows NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AssetStatusDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be tassets0own.
     * @param integer $id
     * @return AssetStatusDetails the loaded model
     * @tassets0ows NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AssetStatusDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
