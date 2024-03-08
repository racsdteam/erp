<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpOrgSubdivisions;
use common\models\ErpOrgSubdivisionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use common\models\ErpOrgLevels;

/**
 * ErpOrgSubdivisionsController implements the CRUD actions for ErpOrgSubdivisions model.
 */
class ErpOrgSubdivisionsController extends Controller
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
     * Lists all ErpOrgSubdivisions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ErpOrgSubdivisionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
//----------------------------------------offices-------------------------------------------
   
   public function actionOffices($level)
   {
   
    return $this->render('index', [
        'level' => $this->getLevel($level),
        'rows' => $this-> getSubdivisionInfo($level),
    ]);  
   }
   

   public function actionUnits($level)
   {
   
    return $this->render('index', [
        'level' => $this->getLevel($level),
        'rows' => $this-> getSubdivisionInfo($level),
    ]);
   
   }
   public function actionDepartments($level)
   {
    return $this->render('index', [
        'level' => $this->getLevel($level),
        'rows' => $this-> getSubdivisionInfo($level),
    ]);
    
   }

   public function getLevel($level){
    
    return ErpOrgLevels::find()->where(['id'=>$level])->One();

   }

   public function getSubdivisionInfo($level){
    /*$query1="  SELECT subdiv.id,subdiv.subdiv_name,subdiv2.subdiv_name as parent,level.level_name FROM `erp_org_subdivisions` as subdiv 
    inner join erp_org_levels as level on level.id=subdiv.subdiv_level 
    LEFT JOIN erp_org_subdivisions as subdiv2 on subdiv2.parent_subdiv=subdiv.id WHERE subdiv.subdiv_level={$level}";*/

    $query1="  SELECT subdiv.*,level.level_name FROM `erp_org_subdivisions` as subdiv 
    inner join erp_org_levels as level on level.id=subdiv.subdiv_level 
    WHERE subdiv.subdiv_level={$level}";
    $command1 = Yii::$app->db->createCommand($query1);
     $rows = $command1->queryall(); 
     return $rows;
   }

    /**
     * Displays a single ErpOrgSubdivisions model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
       return $this->renderAjax('view', [
            'id' =>$id,'level'=>$_GET['level'],
        ]);

        
    }

    public function actionGetJson()
    {
        //{ id: 1, parentId: null, name: "Amber McKenzie", title: "CEO", phone: "678-772-470", mail: "lemmons@jourrapide.com", adress: "Atlanta, GA 30303", image: "/erp/img/avatar-user.png" }, 
        $id = Yii::$app->request->queryParams['id'];//subdivision 
        $level = Yii::$app->request->queryParams['level'];//sub level


        $sub=ErpOrgSubdivisions::find()->where(['id'=>$id])->One();
        $levl=ErpOrgLevels::find()->where(['id'=>$level])->One();
       
       //get head position in the subdivision
        $q1="SELECT p.id, p.position from erp_subdivision_positions as sbp inner join erp_org_positions as 
        p on p.id=sbp.position_id where subdiv_id={$id} and position_status='boss' ";
        $com1 = Yii::$app->db->createCommand($q1);
         $row1 = $com1->queryOne();

        
        
         //people with head position if many
         $rows2=array();
        //positions reporting to head pos
         $rows=array();

         $json_data=array();
         $parent=1;
         $i=$parent;

        if($row1){
        
         //get  people with head postion if many in subdivision
         $q2="SELECT u.* from erp_persons_in_position as p inner join user as 
         u on p.person_id=u.user_id where position_id={$row1['id']} and subdivision_id='{$id}' ";
         $com2 = Yii::$app->db->createCommand($q2);
          $rows2 = $com2->queryAll();
         
         

          //if peope at head position not empty
        if(!empty($rows2)){
           $image=$rows2[0]['user_image']!=''?$rows2[0]['user_image']:'uploads/profile/avatar-user.png';
            $json_data[]=['id'=>$i,'parentId'=>null,'name'=>$rows2[0]['first_name']." ".$rows2[0]['last_name'],
            'title'=>$row1['position'], 'phone'=>$rows2[0]['phone'], 'mail'=>$rows2[0]['email'],  'image'=>Yii::$app->request->baseUrl . '/'. $image];

        }else{
            //echo json_encode(['flag'=>false,'message'=>'Unable  to show '.$sub->subdiv_name." ".$levl->level_name.' ,No person assigned to head Position!']);die();
            $image='uploads/profile/avatar-user.png';
            $json_data[]=['id'=>$i,'parentId'=>null,'name'=>"",
            'title'=>$row1['position'], 'phone'=>"", 'mail'=>"",  'image'=>Yii::$app->request->baseUrl . '/'. $image];
            //echo json_encode( $json_data);
        }

        
         
           // all positions in the subdvision that report to head position
        $q3="SELECT p.id, p.position from erp_subdivision_positions as sbp inner join erp_org_positions as 
        p on p.id=sbp.position_id where subdiv_id={$id} and p.report_to={$row1['id']} ";
        $com3= Yii::$app->db->createCommand($q3);
         $rows = $com3->queryAll(); 

         

 //people under single position in subdivision
 if(!empty($rows)){
    foreach($rows as $row){
      
      
       $q4="SELECT u.* from erp_persons_in_position as p inner join user as 
       u on p.person_id=u.user_id where position_id={$row['id']} and subdivision_id='{$id}' ";
       $com4 = Yii::$app->db->createCommand($q4);
       
        $rows3 = $com4->queryAll();

       

        if(!empty( $rows3 )){
       
        foreach($rows3 as $row2){
            $image2=$row2['user_image']!=''?$row2['user_image']:'uploads/profile/avatar-user.png';
            $i++;
           $json_data[]=['id'=>$i,'parentId'=>$parent,'name'=>$row2['first_name']." ".$row2['last_name'],'title'=>$row['position'], 
           'phone'=>$row2['phone'], 'mail'=>$row2['email'],  'image'=>Yii::$app->request->baseUrl . '/'.$image2];
          
        }
      
    }
    //-----------------------------------default to position
    else{
        $i++;
        $image='uploads/profile/avatar-user.png';
        $json_data[]=['id'=>$i,'parentId'=>$parent,'name'=>"",
        'title'=>$row['position'], 'phone'=>"", 'mail'=>"",  'image'=>Yii::$app->request->baseUrl . '/'. $image];

    }

       }

   }

          
        }else{

            echo json_encode(['flag'=>false,'message'=>'Unable  to show '.$sub->subdiv_name." ".$levl->level_name.' ,No Position(s) Found!']);die();
        }
            
         //echo json_encode($rows);die();
        

       
        
       

        
        


/*
         $json_data=array();
         $parent=1;
         $i=$parent;
         $json_data[]=['id'=>$i,'parentId'=>null,'name'=>'test',
         'title'=>$row1['position'], 'phone'=>"678-772-470", 'mail'=>"lemmons@jourrapide.com",  'image'=>"/erp/img/avatar-user.png"];
         foreach($rows as $row){
            $i++;
            $json_data[]=['id'=>$i,'parentId'=>$parent,'name'=>'test','title'=>$row['position'], 'phone'=>"678-772-470", 'mail'=>"lemmons@jourrapide.com",  'image'=>"/erp/img/avatar-user.png"];
           
         }*/

         //echo json_encode($json_data);
         echo json_encode($json_data);
        
        //return $row1;

       
    }

    /**
     * Creates a new ErpOrgSubdivisions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpOrgSubdivisions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            $levelModel=ErpOrgLevels::find()->where(['id'=>$model->subdiv_level])->One();

            Yii::$app->session->setFlash('success',$levelModel->level_name." added successfully!");
            return $this->redirect([$levelModel->level_name."s",'level'=>$levelModel->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ErpOrgSubdivisions model.
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
     * Deletes an existing ErpOrgSubdivisions model.
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
     * Finds the ErpOrgSubdivisions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpOrgSubdivisions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpOrgSubdivisions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
