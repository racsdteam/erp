<?php

namespace frontend\modules\procurement\controllers;

use Yii;
use yii\helpers\Html;
use frontend\modules\procurement\models\TenderStageIntstances;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Model;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * TenderStageIntstancesController implements the CRUD actions for TenderStageIntstances model.
 */
class TenderStageInstancesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TenderStageIntstances models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TenderStageIntstances::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

     /**
     * Displays a single Tenders model.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreateFromTender($tender_id)
    {
        $tenderStageIntstances=[new TenderStageIntstances];
        if (Yii::$app->request->isPost) {

            $tenderStageIntstances= Model::createMultiple(TenderStageIntstances::class);
            Model::loadMultiple( $tenderStageIntstances , Yii::$app->request->post()); 
            if(!empty($tenderStageIntstances)){
                   
                 
                $transaction = \Yii::$app->db->beginTransaction();
        try {
                    foreach ($tenderStageIntstances as $model) {
                               
                            $user_id=Yii::$app->user->identity->user_id;
                           $model->user_id=$user_id;
                           $model->status=TenderStageIntstances::STATUS_TYPE_NOT_START;
            if (! ($flag = $model->save(false))) {
                $transaction->rollBack();
               
                Yii::$app->session->setFlash('failure',Html::errorSummary($model));  
                  
            }
                        
        }
        if ($flag) {
            $transaction->commit();
          
        }
    }
     catch (Exception $e) {
        $transaction->rollBack();
    }

        }
        return $this->redirect(['tenders/view','id'=>(string)$tender_id]);
    }          
        }
   
    
    /**
     * Updates an existing Tenders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$tender_id,$section_code)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $user_id=Yii::$app->user->identity->user_id;
            $post_data=Yii::$app->request->post();
            $model->attributes=array_filter($post_data['TenderStageIntstances']);
            $model->status=TenderStageIntstances::STATUS_TYPE_NOT_START;
            $model->user_id=$user_id;
            if ($model->save()) {
                return $this->redirect(['tenders/view','id'=>(string) $tender_id]);
            }
        }
        if (Yii::$app->request->isAjax)
        {  
            return $this->renderAjax('update', [
            'model' => $model,'section_code'=>$section_code
        ]);
    }
        return $this->render('update', [
            'model' => $model,'section_code'=>$section_code
        ]);
    }

    /**
     * Deletes an existing Tenders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id,$tender_id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['tenders/view','id'=>(string) $tender_id]);
    }

    /**
     * Finds the Tenders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return TenderStageIntstances the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TenderStageIntstances::findOne($id)) !== null) {
            $model->documents=Json::decode($model->documents, $asArray = true);
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
