<?php

namespace frontend\modules\hr\controllers;

use Yii;
use common\models\Countries;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * CountriesController implements the CRUD actions for Countries model.
 */
class CountryController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Countries models.
     * @return mixed
     */
    public function actionIndex()
    {
       /* $searchModel = new CountriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
    }

    /**
     * Displays a single Countries model.
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
    
       public function actionProvinces() {
    
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $country_id = $parents[0];
          
             $country=Countries::find()->where(['country_code'=>$country_id ])->one();
             
              $provices=$country->provinces;
             
            if(!empty( $provices)){
                 
                 foreach ($provices as $p) {
                    
                $out[]=['id'=>$p->idProvince,'name'=>$p->province];
        } 
                }
             
               
           
            return ['output'=>$out, 'selected'=>''];
        }
    }
    
   
    return ['output'=>'', 'selected'=>''];
}


    public function actionPopulateCountries($id)
    {
        //Yii::$app->response->format = Response::FORMAT_JSON;
       
        $Countriess = Countries::find()->andWhere(['province_id' =>$id])->all();
      /*  $data = [['id' => '', 'name' => '']];
        foreach ($provinces as $province) {
         $data[] = ['id' => $province->idProvince, 'name' => $province->province];

           
        }
    return ['data' => $data];*/

      if (count($Countriess) > 0) {
        echo "'<option></option>'";
       
        foreach ($Countriess as $Countries) {
            echo "<option value='" . $Countries->idCountries . "'>" . $Countries->Countries . "</option>";
        }
    } else {
        echo "'<option></option>'";
    }
    }
    /**
     * Creates a new Countries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Countries();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idCountries]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Countries model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idCountries]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Countries model.
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
     * Finds the Countries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Countries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Countries::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
