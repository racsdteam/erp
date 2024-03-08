<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpDocumentAttachMerge;
use common\models\ErpDocument;
use common\models\ErpDocumentAttachMergeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\data\Pagination;
use iio\libmergepdf\Merger;
use iio\libmergepdf\Driver\TcpdiDriver;

/**
 * ErpDocumentAttachMergeController implements the CRUD actions for ErpDocumentAttachMerge model.
 */
class ErpDocumentAttachMergeController extends Controller
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
     * Lists all ErpDocumentAttachMerge models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpDocumentAttachMergeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ErpDocumentAttachMerge model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
      
    $query = ErpDocumentAttachMerge::find()->where(['document' =>$id,'visible'=>'1']);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>1]);
    $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

   
    
    /*
        $doc=ErpDocument::find()->where(['id'=>$id])->One();
        $doc_merge_upload='';
        if($doc!=null){

            if($doc->doc_upload!=''){

               
                if (file_exists($doc->doc_upload)) {
                    unlink($doc->doc_upload);
                }
           
            }
           
            
            $pdf = new \Jurosh\PDFMerge\PDFMerger;
            $q = new Query;
                                               $q->select([
                                                   'doc_merge_attch.attachement',
                                                   
                                               ])->from('erp_document_attach_merge as doc_merge_attch ')->where(['document' =>$doc->id,'visible'=>'1']);
                                   
                                               $command0 = $q->createCommand();
                                               $rows1= $command0->queryAll(); 
                                                if(empty($rows1)){
                                                    echo '<span class="bg-red">'."No Document Attachement(s) Found!".'</span>';die();
                                                }
            
              foreach($rows1 as $row1)  {
                $query3 = new Query;
                                                        $query3	->select([
                                                            'attch_ver_upload.*'
                                                            
                                                        ])->from('erp_attachment_version as attch_ver ')->join('INNER JOIN', 'erp_attachment_version_upload as attch_ver_upload',
                                                            'attch_ver.id=attch_ver_upload.attach_version')->where(['attch_ver.attachment' =>$row1['attachement']])->orderBy([
                                                                'version_number' => SORT_DESC,
                                                                
                                                              ]);	;
                                            
                                                        $command3 = $query3->createCommand();
                                                        $rows3= $command3->queryAll();
                                                       $pdf->addPDF($rows3[0]['attach_upload'], 'all');
            
                                                      
            
              } 
              // generate a unique file name to prevent duplicate filenames
             $exponent = 3; // Amount of digits
             $min = pow(10,$exponent);
             $max = pow(10,$exponent+1)-1;
             //1
             $value = rand($min, $max);
             $unification= date("Ymdhms")."".$value;
             $path_to_merge='uploads/documents/'. $unification.'.pdf';
                // call merge, output format `file`
              $pdf->merge('file', $path_to_merge);
              
//--------------------------------------update doc model-------------------------------------------------------------              
              $doc->doc_upload =$path_to_merge;
              $doc->save(false);

             

        

        }
        */
        
        if(empty($models)){
            
            
         return   '<div class="alert alert-danger alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                 <h4><i class="icon fa fa-ban"></i></h4>
                No Attachements Found !
              
               </div>';
        }
        
        
        
        if(Yii::$app->request->isAjax){

            /*return $this->renderAjax('view2', [
                'doc' =>$doc,
            ]); */ 
            
             return $this->renderAjax('view2', [
         'models' => $models,
         'pages' => $pages,
    ]);
        }
       /* return $this->render('view2', [
            'doc' =>$doc,
        ]);*/
        
         return $this->render('view2', [
         'models' => $models,
         'pages' => $pages,
    ]);
      
    }

    public function actionChangeStatus()
    {

        if(Yii::$app->request->isAjax){

            $data= Yii::$app->request->get();
            $attach_id=$data['attach_id'];
            $doc_id=$data['doc_id'];
            $visible=$data['status'];
            $flag=Yii::$app->db->createCommand()
            ->update('erp_document_attach_merge', ['visible' =>$visible], ['document' => $doc_id,'attachement'=>$attach_id])
            ->execute();
           echo $flag;

		} 
    }

    /**
     * Creates a new ErpDocumentAttachMerge model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpDocumentAttachMerge();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ErpDocumentAttachMerge model.
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
     * Deletes an existing ErpDocumentAttachMerge model.
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
     * Finds the ErpDocumentAttachMerge model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpDocumentAttachMerge the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpDocumentAttachMerge::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
