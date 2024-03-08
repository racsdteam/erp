<?php

namespace frontend\modules\assets0\controllers;

use Yii;
use frontend\modules\assets0\models\AssetAllocations;
use frontend\modules\assets0\models\AssetAllocationsSearch;
use frontend\modules\assets0\models\Assets;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AssetAllocationsController implements the CRUD actions for AssetAllocations model.
 */
class AssetAllocationsController extends Controller
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
     * Lists all AssetAllocations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AssetAllocationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AssetAllocations model.
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
     * Creates a new AssetAllocations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AssetAllocations();
        $request=Yii::$app->request;

         if ($model->load($request->post()) ) {
           
            $renderForm=function()use($model){
               
             return $this->render('_form', [
            'model' => $model,
             'asset'=>$request->get('asset')
        ]); 
                
            };
             
             $transaction = \Yii::$app->db4->beginTransaction();
             
               try{
                       $model->user=Yii::$app->user->identity->user_id;
           
           if(!$model->save()){
            
          
             throw new UserException(Html::errorSummary($model));
          
             }
             
          $modelAsset=Assets::findOne($model->asset);
          $modelAsset->status='IS';
          $modelAsset->save(false);
  
          $transaction->commit();
          Yii::$app->session->setFlash('success', "Asset Allocation Saved!"); 
          return $this->redirect(['assets/view','id'=>$model->asset]);
                       
                   
               }
               
                 catch (UserException $e) {
                    $transaction->rollBack();
                     Yii::$app->session->setFlash('error',$e->getMessage()); 
                    return $renderForm(); 
                }
                 
                 catch (Exception $e) {
                    $transaction->rollBack();
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
     * Updates an existing AssetAllocations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

      $request=Yii::$app->request;

         if ($model->load($request->post()) ) {
           
            $renderForm=function()use($model){
               
             return $this->render('_form', [
            'model' => $model,
             'asset'=>$request->get('asset')
        ]); 
                
            };
             
             $transaction = \Yii::$app->db4->beginTransaction();
             
               try{    if(empty($model->user))
                       $model->user=Yii::$app->user->identity->user_id;
           
           if(!$model->save()){
            
          
             throw new UserException(Html::errorSummary($model));
          
             }
             
          $modelAsset=Assets::findOne($model->asset);
          $modelAsset->status='IS';
          $modelAsset->save(false);
  
          $transaction->commit();
          Yii::$app->session->setFlash('success', "Asset Allocation Updated!"); 
          return $this->redirect(['assets/view','id'=>$model->asset]);
                       
                   
               }
               
                 catch (UserException $e) {
                    $transaction->rollBack();
                     Yii::$app->session->setFlash('error',$e->getMessage()); 
                    return $renderForm(); 
                }
                 
                 catch (Exception $e) {
                    $transaction->rollBack();
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
     * Deletes an existing AssetAllocations model.
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
     * Finds the AssetAllocations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AssetAllocations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AssetAllocations::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
