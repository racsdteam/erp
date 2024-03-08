<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PcTargetMillstone;
use frontend\modules\hr\models\PcTarget;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PcTargetMillstoneController implements the CRUD actions for PcTargetMillstone model.
 */
class PcTargetMillstoneController extends Controller
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
     * Lists all PcTargetMillstone models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PcTargetMillstone::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PcTargetMillstone model.
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
     * Creates a new PcTargetMillstone model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new PcTargetMillstone();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['performance-contract/view', 'id' =>$id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,'id'=>$id
        ]);
    }

    /**
     * Updates an existing PcTargetMillstone model.
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
     * Deletes an existing PcTargetMillstone model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model= $this->findModel($id);
        $tagert=  PcTarget::find()->where(["id"=>$model->target_id])->one();
        $this->findModel($id)->delete();
 return $this->redirect(['performance-contract/view', 'id' =>$tagert->pa_id]);
 
    }

    /**
     * Finds the PcTargetMillstone model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PcTargetMillstone the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PcTargetMillstone::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
