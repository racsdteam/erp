<?php
namespace frontend\modules\procurement\controllers;

use Yii;
use frontend\modules\procurement\models\EnvelopeSettings;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * EnvelopeSettingsController implements the CRUD actions for EnvelopeSettings model.
 */
class EnvelopeSettingController extends Controller
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
     * Lists all EnvelopeSettings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => EnvelopeSettings::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EnvelopeSettings model.
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
     * Creates a new EnvelopeSettings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EnvelopeSettings();

            if(Yii::$app->request->post()){
            
             $user_id=Yii::$app->user->identity->user_id;
            $model->attributes=$_POST['EnvelopeSettings'];
             $model->procurement_methods_code=Json::encode($model->procurement_methods_code,JSON_UNESCAPED_SLASHES);
             $model->procurement_categories_code=Json::encode($model->procurement_categories_code,JSON_UNESCAPED_SLASHES);
             $model->user_id=$user_id;
             $flag=$model->save();
             if($flag)
             {
            Yii::$app->session->setFlash('success','Envelope setting Saved !');
            return $this->redirect(["index"]);
             }
             }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EnvelopeSettings model.
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
            $model->attributes=$_POST['EnvelopeSettings'];
             $model->procurement_methods_code=Json::encode($model->procurement_methods_code,JSON_UNESCAPED_SLASHES);
             $model->procurement_categories_code=Json::encode($model->procurement_categories_code,JSON_UNESCAPED_SLASHES);
             $model->user_id=$user_id;
             $flag=$model->save();
             if($flag)
             {
            Yii::$app->session->setFlash('success','Envelope setting updated !');
            return $this->redirect(["index"]);
             }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EnvelopeSettings model.
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
     * Finds the EnvelopeSettings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EnvelopeSettings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EnvelopeSettings::findOne($id)) !== null) {
            $model->procurement_methods_code=Json::decode($model->procurement_methods_code, $asArray = true);
             $model->procurement_categories_code=Json::decode($model->procurement_categories_code, $asArray = true);
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
