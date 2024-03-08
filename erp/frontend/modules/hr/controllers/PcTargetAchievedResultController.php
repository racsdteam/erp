<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PcTargetAchievedResult;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\UserHelper;
/**
 * PcTargetAchievedResultController implements the CRUD actions for PcTargetAchievedResult model.
 */
class PcTargetAchievedResultController extends Controller
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
     * Lists all PcTargetAchievedResult models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PcTargetAchievedResult::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PcTargetAchievedResult model.
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
     * Creates a new PcTargetAchievedResult model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($evaluation_id)
    {
        $model = new PcTargetAchievedResult();
              if(Yii::$app->request->post()){
               
             $model->attributes=$_POST['PcTargetAchievedResult'];
             $user=Yii::$app->user->identity->user_id;
            $position=UserHelper::getPositionInfo($user);
            $model->pc_evaluation_id=$evaluation_id;
            $model->user_id=$user;
            $model->emp_pos=$position['position_code'];
            $model->save();
            return $this->redirect(['pc-evaluation/view', 'id' =>$evaluation_id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,'evaluation_id'=>$evaluation_id
        ]);
    }

    /**
     * Updates an existing PcTargetAchievedResult model.
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
     * Deletes an existing PcTargetAchievedResult model.
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
     * Finds the PcTargetAchievedResult model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PcTargetAchievedResult the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PcTargetAchievedResult::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
