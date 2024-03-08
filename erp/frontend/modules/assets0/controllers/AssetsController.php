<?php

namespace frontend\modules\assets0\controllers;

use Yii;
use frontend\modules\assets0\models\Assets;
use frontend\modules\assets0\models\AssetsSearch;
use frontend\modules\assets0\models\AssetAllocations;
use frontend\modules\assets0\models\AssetSecDetails;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * AssetsController implements the CRUD actions for Assets model.
 */
class AssetsController extends Controller
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
     * Lists all Assets models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AssetsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Assets model.
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
     * Creates a new Assets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Assets();
        $allocation=new AssetAllocations();
        $sec=new AssetSecDetails();
        
        
         if ($model->load(Yii::$app->request->post()) ) {
            
                $renderForm=function()use($model,$allocation,$sec){
            return $this->render('create', [
           'model' => $model,'allocation'=>$allocation,'sec'=>$sec
        ]);   
            };
            
            $check_serial_number= Assets::find()->where(["serialNo" =>$model->serialNo])->one();
            if($check_serial_number!=null){
                 Yii::$app->session->setFlash('error',"Serial Number Registered"); 
              return  $renderForm();
            }
            
        
            
            try {
             $model->tagNo=Yii::$app->assetUtil->generateTagNo($model->type);
             $model->created_by=Yii::$app->user->identity->user_id; 
            
           if(!$model->save()){
               Yii::$app->session->setFlash('error',Html::errorSummary($model)); 
               return  $renderForm();
           
             
            }
         if($allocation->load(Yii::$app->request->post())){
             
             $allocation->asset=$model->id;
             $allocation->user=Yii::$app->user->identity->user_id;
             $allocation->scenario="create";
             $valid=$allocation->validate();
             if($valid){
               if(!$allocation->save()){
               Yii::$app->session->setFlash('error',Html::errorSummary($allocation)); 
               return  $renderForm();
           
             
            }  
             }
             
            
            }
            
              if($sec->load(Yii::$app->request->post())){
             
             $sec->asset=$model->id;
             $sec->user=Yii::$app->user->identity->user_id;
             $sec->scenario="create";
             
             $valid=$sec->validate();
             if($valid){
               if(!$sec->save()){
               Yii::$app->session->setFlash('error',Html::errorSummary($sec)); 
               return  $renderForm();
           
             
            }  
             }
             
            
            }
             
              Yii::$app->session->setFlash('success',"Asset Saved!"); 
              return $this->redirect(['index']);
}

//catch exception
catch(\yii\base\UserException $e) {
 
   Yii::$app->session->setFlash('error',$e->getMessage()); 
   return  $renderForm();
}
         
        }
        
        if(Yii::$app->request->isAjax){
            
            return $this->renderAjax('_form', [
            'model' => $model,'allocation'=>$allocation,'sec'=>$sec
        ]); 
        }

        return $this->render('create', [
            'model' => $model,'allocation'=>$allocation,'sec'=>$sec
        ]);
    }

    /**
     * Updates an existing Assets model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $allocation=empty($model->allocation)? new AssetAllocations : $model->allocation;
        $sec=empty($model->security[0])? new AssetSecDetails : $model->security[0] ;

       if ($model->load(Yii::$app->request->post()) ) {
            
            $renderForm=function()use($model){
            return $this->render('create', [
            'model' => $model, 
            'allocation'=>empty($allocation)? new AssetAllocations : $allocation,
             'sec'=>empty($sec)? new AssetSecDetails : $sec
        ]);   
            };
            
            try {
                
             if(empty($model->tagNo))  
              $model->tagNo=Yii::$app->assetUtil->generateTagNo($model->type);
            
           if(!$model->save()){
               Yii::$app->session->setFlash('error',Html::errorSummary($model)); 
               return  $renderForm();
           
             
            }
           if($allocation->load(Yii::$app->request->post())){
             if(empty($allocation->asset))  
             $allocation->asset=$model->id;
             if(empty($allocation->user)) 
             $allocation->user=Yii::$app->user->identity->user_id; 
             
              $allocation->scenario="update";
              $valid=$allocation->validate();
              
              if($valid){
                 
                  if(!$allocation->save()){
               Yii::$app->session->setFlash('error',Html::errorSummary($allocation)); 
               return  $renderForm();
           
             
            } 
              }
             
            
            }
            
              if($sec->load(Yii::$app->request->post())){
             
             $sec->asset=$model->id;
             $sec->user=Yii::$app->user->identity->user_id;
             $sec->scenario="update";
             
             $valid=$sec->validate();
             if($valid){
               if(!$sec->save()){
               Yii::$app->session->setFlash('error',Html::errorSummary($sec)); 
               return  $renderForm();
           
             
            }  
             }
             
            
            }
             
              Yii::$app->session->setFlash('success',"Asset Updated!"); 
              return $this->redirect(['index']);
}

//catch exception
catch(\yii\base\UserException $e) {
 
   Yii::$app->session->setFlash('error',$e->getMessage()); 
   return  $renderForm();
}
         
        }
        
        if(Yii::$app->request->isAjax){
            
            return $this->renderAjax('_form', [
            'model' => $model,
            'allocation'=>empty($allocation)? new AssetAllocations : $allocation,
            'sec'=>empty($sec)? new AssetSecDetails : $sec
        ]); 
        }

        return $this->render('create', [
            'model' => $model,
            'allocation'=>empty($allocation)? new AssetAllocations : $allocation,
            'sec'=>empty($sec)? new AssetSecDetails : $sec
        ]);
    }

    /**
     * Deletes an existing Assets model.
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
     * Finds the Assets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Assets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Assets::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
