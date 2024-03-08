<?php

namespace frontend\modules\hr\controllers;

use Yii;
use frontend\modules\hr\models\PcReport;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\UserHelper;
use common\models\ErpPersonInterim;
use common\models\ErpUnitsPositions;
use yii\filters\AccessControl;
/**
 * PcReportController implements the CRUD actions for PcReport model.
 */
class PcReportController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
              'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                 
                   [
        'actions' => ['index'],
        'allow' => true,
        'matchCallback' => function ($rule, $action) {
            return \Yii::$app->user->identity->isAdmin();
        },
    ],
                ],
                 ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PcReport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PcReport::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PcReport model.
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
     * Creates a new PcReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PcReport();

             if(Yii::$app->request->post()){
               
             $model->attributes=$_POST['PcReport'];
              $user=Yii::$app->user->identity->user_id;
            $position=UserHelper::getPositionInfo($user);
            $model->emp_id=$user;
            $model->emp_pos=$position['position_code'];
            $model->created_date=date("Y-m-d");
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }
 public function actionSubmit($id)
    {
        $model = $this->findModel($id);
         $model->status="submitted";
         $model->save();
        return $this->redirect(['view', 'id' => $model->id]);
    }
    /**
     * Updates an existing PcReport model.
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
     * Deletes an existing PcReport model.
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
     * Finds the PcReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PcReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PcReport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
