<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Signature;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * SignatureController implements the CRUD actions for Signature model.
 */
class SignatureController extends Controller
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
     * Lists all Signature models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Signature::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Signature model.
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
     * Creates a new Signature model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Signature();
     
        if (Yii::$app->request->post()) {
            $post=$_POST['Signature'];
            $user=$post['user'];
            $model->signature_uploaded_file= UploadedFile::getInstance($model, 'signature_uploaded_file');       
              $exponent = 3; // Amount of digits
            $min = pow(10,$exponent);
            $max = pow(10,$exponent+1)-1;
              $value = rand($min, $max);
  $unification= date("Ymdhms")."".$value;


 if($model->signature_uploaded_file!==null){
     $file_photo= $model->signature_uploaded_file;
     $temp = explode(".", $file_photo->name);
     $ext = end($temp);

       //renaming files to avoid duplicate names
       $path_to_signature='uploads/signature/'. $unification.".{$ext}";
       $model->signature=$path_to_signature;
        
 }
                              if(!empty($user))
                                     
                                     {
                       
                              foreach($user as $key=>$value){
                                            $model->user=$value;
                                          

                                        }
                       $model->save();                    
                if($file_photo!==null&&$path_to_signature !='') {
                    
                                $file_photo->saveAs($path_to_signature );
                                return $this->redirect(['view', 'id' => $model->id]);
                              }
                                     }
           
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Signature model.
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
     * Deletes an existing Signature model.
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
     * Finds the Signature model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Signature the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Signature::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
