<?php

namespace frontend\modules\procurement\controllers;

use Yii;
use frontend\modules\procurement\models\DocumentsSettings;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * DocumentsSettingsController implements the CRUD actions for DocumentsSettings model.
 */
class DocumentsSettingsController extends Controller
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
     * Lists all DocumentsSettings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => DocumentsSettings::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DocumentsSettings model.
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
     * Creates a new DocumentsSettings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DocumentsSettings();

         if(Yii::$app->request->post()){
            $params=array();
             $user_id=Yii::$app->user->identity->user_id;
            $model->attributes=$_POST['DocumentsSettings'];
            $params["is_required"]=$_POST['DocumentsSettings']['required_status'];
            $params["more_docs_status"]=$_POST['DocumentsSettings']['more_docs_status'];
            $params["min_docs"]=$_POST['DocumentsSettings']['min_docs'];
            $params["max_docs"]=$_POST['DocumentsSettings']['max_docs'];
             $model->params=Json::encode($params,JSON_UNESCAPED_SLASHES);
             $model->user_id=$user_id;
             $flag=$model->save();
             if($flag)
             {
            Yii::$app->session->setFlash('success','Section setting saved !');
            return $this->redirect(["index"]);
             }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DocumentsSettings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

          if(Yii::$app->request->post()){
            $params=array();
             $user_id=Yii::$app->user->identity->user_id;
            $model->attributes=$_POST['DocumentsSettings'];
            $params["is_required"]=$_POST['DocumentsSettings']['required_status'];
            $params["more_docs_status"]=$_POST['DocumentsSettings']['more_docs_status'];
            $params["min_docs"]=$_POST['DocumentsSettings']['min_docs'];
            $params["max_docs"]=$_POST['DocumentsSettings']['max_docs'];
             $model->params=Json::encode($params,JSON_UNESCAPED_SLASHES);
             $model->user_id=$user_id;
             $flag=$model->save();
             if($flag)
             {
            Yii::$app->session->setFlash('success','Section setting updated !');
            return $this->redirect(["index"]);
             }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DocumentsSettings model.
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
     * Finds the DocumentsSettings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DocumentsSettings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DocumentsSettings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
