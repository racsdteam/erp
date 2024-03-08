<?php

namespace frontend\modules\assets0\controllers;

use Yii;
use frontend\modules\assets0\models\AssetDispositions;
use frontend\modules\assets0\models\AssetDispositionsSearch;
use frontend\modules\assets0\models\Assets;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AssetDispositionsController implements the CRUD actions for AssetDispositions model.
 */
class AssetDispositionsController extends Controller
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
     * Lists all AssetDispositions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AssetDispositionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AssetDispositions model.
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
     * Creates a new AssetDispositions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AssetDispositions();
        $request=Yii::$app->request;

         if ($model->load($request->post()) ) {
           
            $renderForm=function()use($model){
               
             return $this->render('_form', [
            'model' => $model,'asset'=>$request->get('asset')
        ]); 
                
            };
             
             $transaction = \Yii::$app->db4->beginTransaction();
             
               try{
                       $model->user=Yii::$app->user->identity->user_id;
           
           if(!$model->save()){
            
          
             throw new UserException(Html::errorSummary($model));
          
             }
             
          $modelAsset=Assets::findOne($model->asset);
          if(!empty($modelAsset))
          $modelAsset->changeStatus('DSPL');
          
         
         
          
  
          $transaction->commit();
          Yii::$app->session->setFlash('success', "Asset Disposal Saved!"); 
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
     * Updates an existing AssetDispositions model.
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
            'model' => $model,'asset'=>$request->get('asset')
        ]); 
                
            };
             
               try{
                       $model->user=Yii::$app->user->identity->user_id;
           
           if(!$model->save()){
            
          
             throw new UserException(Html::errorSummary($model));
          
             }
             
          
 
             
             
             Yii::$app->session->setFlash('success', "Asset Disposal Updated!"); 
             return $this->redirect(['index']);
                       
                   
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
     * Deletes an existing AssetDispositions model.
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
     * Finds the AssetDispositions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AssetDispositions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AssetDispositions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
