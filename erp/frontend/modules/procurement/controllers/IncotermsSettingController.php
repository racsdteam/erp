<?php

namespace frontend\modules\procurement\controllers;

use Yii;
use frontend\modules\procurement\models\IncotermsSetting;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IncotermsSettingController implements the CRUD actions for IncotermsSetting model.
 */
class IncotermsSettingController extends Controller
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
     * Lists all IncotermsSetting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => IncotermsSetting::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single IncotermsSetting model.
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
     * Creates a new IncotermsSetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new IncotermsSetting();

        if(Yii::$app->request->post()){
            
            $user_id=Yii::$app->user->identity->user_id;
           $model->attributes=$_POST['IncotermsSetting'];
            $model->user_id=$user_id;
            $flag=$model->save();
            if($flag)
            {
           Yii::$app->session->setFlash('success','INCOTERM  Saved !');
           return $this->redirect(['index']);
            }
       }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing IncotermsSetting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->post()){
            
            $user_id=Yii::$app->user->identity->user_id;
           $model->attributes=$_POST['IncotermsSetting'];
            $model->user_id=$user_id;
            $flag=$model->save();
            if($flag)
            {
           Yii::$app->session->setFlash('success','INCOTERM  Updated !');
           return $this->redirect(['index']);
            }
       }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing IncotermsSetting model.
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
     * Finds the IncotermsSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return IncotermsSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IncotermsSetting::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
