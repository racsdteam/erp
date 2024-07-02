<?php

namespace frontend\modules\procurement\controllers;

use Yii;
use frontend\modules\procurement\models\Tenders;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\procurement\models\TenderStageIntstances;
use yii\web\UploadedFile;
/**
 * TendersController implements the CRUD actions for Tenders model.
 */
class TendersController extends Controller
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
     * Lists all Tenders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tenders::find(),
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
        $tenderStageIntstances= new TenderStageIntstances;
        $model= $this->findModel($id);
        if( $model->status== Tenders::STATUS_TYPE_DRAFT)
        {
            return $this->render('view', [
                'model' => $model,'tenderStageIntstances'=> $tenderStageIntstances
            ]);
        }
        return $this->render('stagesManagement', [
            'model' => $model,'tenderStageIntstances'=> $tenderStageIntstances
        ]);
    }
    public function actionSubmitionView($id)
    {
        $tenderStageIntstances= new TenderStageIntstances;
        return $this->render('submition', [
            'model' => $this->findModel($id)
        ]);
    }
    public function actionSubmition($id,$number)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            $model->number=$number;
            $model->status=Tenders::STATUS_TYPE_SUBM;
            if ($model->save()) {
                Yii::$app->session->setFlash('success','Tender is successfull saved !');
                return $this->redirect(['index']);
            }
        }
        Yii::$app->session->setFlash('Error','Tender is not saved !');
        return $this->render('submition-view', [
            'model' => $this->findModel($id)
        ]);
    }
    /**
     * Creates a new Tenders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tenders();
        if (Yii::$app->request->isPost) {
            $user_id=Yii::$app->user->identity->user_id;
            $post_data=Yii::$app->request->post();
            $model->attributes=array_filter($post_data['Tenders']);
            $model->user_id=$user_id;
            $model->status=Tenders::STATUS_TYPE_DRAFT;
            $model->uploaded_file1 = UploadedFile::getInstance($model, 'uploaded_file1');
            $model->uploaded_file2 = UploadedFile::getInstance($model, 'uploaded_file2');
            $model->uploaded_file3 = UploadedFile::getInstance($model, 'uploaded_file3');

            if($model->uploaded_file1!=null){
                 
                $file1=$model->uploaded_file1;
          
          $exponent = 3; // Amount of digits
$min = pow(10,$exponent);
$max = pow(10,$exponent+1)-1;
$value = rand($min, $max);
$unification= date("Ymdhms")."".$value;

$temp= explode(".",   $file1->name);
$ext = end($temp);
$path_to_doc1='uploads/procurement/DAO/'. $unification.".{$ext}";
$model->dao=$path_to_doc1;

          }
          if($model->uploaded_file2!=null){
                 
            $file2=$model->uploaded_file2;
      
      $exponent = 3; // Amount of digits
$min = pow(10,$exponent);
$max = pow(10,$exponent+1)-1;
$value = rand($min, $max);
$unification= date("Ymdhms")."".$value;

$temp= explode(".",   $file2->name);
$ext = end($temp);
$path_to_doc2='uploads/procurement/RFQ/'. $unification.".{$ext}";
$model->rfq=$path_to_doc2;

      }

      if($model->uploaded_file3!=null){
                 
        $file3=$model->uploaded_file3;
  
  $exponent = 3; // Amount of digits
$min = pow(10,$exponent);
$max = pow(10,$exponent+1)-1;
$value = rand($min, $max);
$unification= date("Ymdhms")."".$value;

$temp= explode(".",   $file3->name);
$ext = end($temp);
$path_to_doc3='uploads/procurement/RFP/'. $unification.".{$ext}";
$model->rfp=$path_to_doc3;

  }


            if ($model->save()) {
                if($model->dao!=null){
                $file1->saveAs($path_to_doc1); 
                }
                if($model->rfq!=null){
                $file2->saveAs($path_to_doc2); 
                }
                if($model->rfp!=null){
                $file3->saveAs($path_to_doc3); 
                }
                // Record saved successfully
                Yii::$app->session->setFlash('success','Tender is successfull Created !');
                return $this->redirect(['view','id'=>$model->_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tenders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $user_id=Yii::$app->user->identity->user_id;
            $post_data=Yii::$app->request->post();
            $model->attributes=array_filter($post_data['Tenders']);
            $model->user_id=$user_id;
            $model->status=Tenders::STATUS_TYPE_DRAFT;
            $model->uploaded_file1 = UploadedFile::getInstance($model, 'uploaded_file1');
            $model->uploaded_file2 = UploadedFile::getInstance($model, 'uploaded_file2');
            $model->uploaded_file3 = UploadedFile::getInstance($model, 'uploaded_file3');
            if($model->uploaded_file1!=null){
                 
                $file1=$model->uploaded_file1;
          
          $exponent = 3; // Amount of digits
$min = pow(10,$exponent);
$max = pow(10,$exponent+1)-1;
$value = rand($min, $max);
$unification= date("Ymdhms")."".$value;

$temp= explode(".",   $file1->name);
$ext = end($temp);
$path_to_doc1='uploads/procurement/DAO/'. $unification.".{$ext}";
$model->dao=$path_to_doc1;

          }
          if($model->uploaded_file2!=null){
                 
            $file2=$model->uploaded_file2;
      
      $exponent = 3; // Amount of digits
$min = pow(10,$exponent);
$max = pow(10,$exponent+1)-1;
$value = rand($min, $max);
$unification= date("Ymdhms")."".$value;

$temp= explode(".",   $file2->name);
$ext = end($temp);
$path_to_doc2='uploads/procurement/RFQ/'. $unification.".{$ext}";
$model->rfq=$path_to_doc2;

      }

      if($model->uploaded_file3!=null){
                 
        $file3=$model->uploaded_file3;
  
  $exponent = 3; // Amount of digits
$min = pow(10,$exponent);
$max = pow(10,$exponent+1)-1;
$value = rand($min, $max);
$unification= date("Ymdhms")."".$value;

$temp= explode(".",   $file3->name);
$ext = end($temp);
$path_to_doc3='uploads/procurement/RFP/'. $unification.".{$ext}";
$model->rfp=$path_to_doc3;

  }
            if ($model->save()) {
                if($model->uploaded_file1!=null){
                    $file1->saveAs($path_to_doc1); 
                    }
                    if($model->uploaded_file2!=null){
                    $file2->saveAs($path_to_doc2); 
                    }
                    if($model->uploaded_file3!=null){
                    $file3->saveAs($path_to_doc3); 
                    }

                    Yii::$app->session->setFlash('success','Tender is successfull Updated !');
                return $this->redirect(['view','id'=>(string) $model->_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tenders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tenders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $_id
     * @return Tenders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tenders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
