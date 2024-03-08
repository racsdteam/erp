<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\PassengerManifest;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

/**
 * ProvinceController implements the CRUD actions for Province model.
 */
class PassengerManifestController extends Controller
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
     * Lists all PassengerManifest models.
     * @return mixed
     */
    public function actionIndex()
    {
       $model= new PassengerManifest;
             if(!empty($_POST))
       {
           $airline=$_POST['airline'];
           $number=$_POST['number'];
           $date=$_POST['date'];
       }
        return $this->render('index',[ 'model' => $model,'airline' => $airline,'number' => $number,'date' => $date,]);
    }

    
    
    
    public function actionIndex2()
    {
         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $q2 = new Query;
$q2->select([
    'p.*'
    
])->from('passenger_manifest as p')->orderBy(['p.recorded' => SORT_DESC])->limit(100);
$command2 = $q2->createCommand();
$rows2= $command2->queryAll();
return $rows2;
    }

    /**
     * Displays a single PassengerManifest model.
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
     * Creates a new PassengerManifest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!empty($_POST))
        {
        $flag="false";
        $data=array();
        $check_in_sequence_number = $_POST['check_in_sequence_number'];
        $compartment_code = $_POST['compartment_code'];
        $date_of_flight = $_POST['date_of_flight'];
        $date1 = new \DateTime($date_of_flight);
        $date2=$date1->format('Y-m-d H:i:s');
        $date_of_flight= $date2;
        $flight_number = $_POST['flight_number'];
        $from_city_airport_code = $_POST['from_city_airport_code'];
        $operating_carrier_pnr_code = $_POST['operating_carrier_pnr_code'];
        $Operating_carrier_designator = $_POST['Operating_carrier_designator'];
        $passenger_description = $_POST['passenger_description'];
        $passenger_fn = $_POST['passenger_fn'];
        $passenger_ln = $_POST['passenger_ln'];
        $passenger_status = $_POST['passenger_status'];
        $seat_number = $_POST['seat_number'];
        $to_city_airport_code = $_POST['to_city_airport_code'];
           
  $q52=" SELECT *  from  passenger_manifest where flight_number='".$flight_number."' and 
  date_of_flight='".$date_of_flight."'  and seat_number='".$seat_number."' and compartment_code='".$compartment_code."' and check_in_sequence_number='".$check_in_sequence_number."' ";
 $com52 = Yii::$app->db->createCommand($q52);
 $r52= $com52->queryOne();   
 if(empty($r52['id']))
 {
     $model= new PassengerManifest;
     $model->check_in_sequence_number = $check_in_sequence_number;
     $model->compartment_code = $compartment_code;
     $model->date_of_flight = $date_of_flight;
     $model->flight_number = $flight_number;
     $model->from_city_airport_code = $from_city_airport_code;
     $model->operating_carrier_pnr_code = $operating_carrier_pnr_code;
     $model->Operating_carrier_designator = $Operating_carrier_designator;
     $model->passenger_description= $passenger_description;
     $model->passenger_fn = $passenger_fn;
     $model->passenger_ln = $passenger_ln;
     $model->passenger_status = $passenger_status;
     $model->seat_number  = $seat_number ;
     $model->to_city_airport_code = $to_city_airport_code;
     if($model->save())
     {
               $q2 = new Query;
$q2->select([
    'p.*'
    
])->from('passenger_manifest as p')->orderBy(['p.recorded' => SORT_DESC])->limit(100);
$command2 = $q2->createCommand();
$rows2= $command2->queryAll();
          $flag="true";
          $data['flag']=$flag;
          $data['data']=$rows2;
     }
 }
 else{
     $data['flag']=$flag;
     $data['boardingpass']=$r52;
     
 }
        }
        
        $data2[]=$data;
        return $data2;
    }

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
     * Deletes an existing PassengerManifest model.
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
     * Finds the PassengerManifest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PassengerManifest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PassengerManifest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
      public function beforeAction($action) { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action);
    
    }
    
}
