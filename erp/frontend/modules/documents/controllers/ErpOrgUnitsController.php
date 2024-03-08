<?php

namespace frontend\modules\documents\controllers;

use Yii;
use common\models\ErpOrgUnits;
use common\models\ErpOrgUnitsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use common\models\ErpOrgLevels;


/**
 * ErpOrgUnitsController implements the CRUD actions for ErpOrgUnits model.
 */
class ErpOrgUnitsController extends Controller
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
     * Lists all ErpOrgUnits models.
     * @return mixed
     */
    public function actionIndex()
    {
      $idLevel= $_GET['level'];
      $level= $this->getLevel($idLevel);
      return $this->redirect([strtolower($level->level_name)."s",'level'=>$idLevel]);
    }

    //----------------------------------------offices-------------------------------------------
   
   public function actionOffices($level)
   {
   
    return $this->render('index', [
        'level' => $this->getLevel($level),
        'rows' => $this-> getOrgUnitInfo($level),
    ]);  
   }
   

   public function actionUnits($level)
   {
   
    return $this->render('index', [
        'level' => $this->getLevel($level),
        'rows' => $this-> getOrgUnitInfo($level),
    ]);
   
   }
   public function actionDepartments($level)
   {
    return $this->render('index', [
        'level' => $this->getLevel($level),
        'rows' => $this-> getOrgUnitInfo($level),
    ]);
    
   }

   public function getLevel($id){
    
   
    if (($model =ErpOrgLevels::findOne($id)) !== null) {
        return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');


   }

   public function getOrgUnitInfo($level){
   

    $query1="  SELECT unit.*,level.level_name FROM `erp_org_units` as unit 
    inner join erp_org_levels as level on level.id=unit.unit_level 
    WHERE unit.unit_level={$level}";
    $command1 = Yii::$app->db->createCommand($query1);
     $rows = $command1->queryall(); 
     return $rows;
   }

    /**
     * Displays a single ErpOrgUnits model.
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


        $sub=ErpOrgUnits::find()->where(['id'=>$id])->One();
        $levl=ErpOrgLevels::find()->where(['id'=>$level])->One();
       
      
       
       //get head position in the unit
        $q1="SELECT p.id, p.position from erp_units_positions as up inner join erp_org_positions as 
        p on p.id=up.position_id where unit_id={$id} and position_status='chief' ";
        $com1 = Yii::$app->db->createCommand($q1);
         $row1 = $com1->queryOne();

    //people with head position if many
         $rows2=array();
        //positions reporting to head pos
         $rows=array();

         $json_data=array();
        
         
         
         //tree element id
         $id=1;
        

        if($row1){
        
         //get  people with head postion  in unit
         $q2="SELECT u.* from erp_persons_in_position as p inner join user as 
         u on p.person_id=u.user_id where position_id={$row1['id']} and unit_id='{$id}' ";
         $com2 = Yii::$app->db->createCommand($q2);
          $rows2 = $com2->queryOne();
         
         

          //if peope at head position not empty
        if(!empty($rows2)){
           $image=$rows2['user_image']!=''?$rows2['user_image']:'uploads/profile/avatar-user.png';
            $json_data[]=['id'=>$id,'parentId'=>null,'name'=>$rows2['first_name']." ".$rows2['last_name'],
            'title'=>$row1['position'], 'phone'=>$rows2['phone'], 'mail'=>$rows2['email'],  'image'=>Yii::$app->request->baseUrl . '/'. $image];

        }else{
            //echo json_encode(['flag'=>false,'message'=>'Unable  to show '.$sub->subdiv_name." ".$levl->level_name.' ,No person assigned to head Position!']);die();
            $image='uploads/profile/avatar-user.png';
            $json_data[]=['id'=>$id,'parentId'=>null,'name'=>"",
            'title'=>$row1['position'], 'phone'=>"", 'mail'=>"",  'image'=>Yii::$app->request->baseUrl . '/'. $image];
            //echo json_encode( $json_data);
        }

        //echo json_encode($json_data);die();
         
           // all positions in the unit that report to head position
           $descendants=$this->getDescendants($row1['id'],$id,$id);
           $json_data=array_merge( $json_data, $descendants); 

          
        }else{

            echo json_encode(['flag'=>false,'message'=>'Unable  to show '.$sub->unit_name." ".$levl->level_name.' ,No Position(s) Found!']);die();
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

        return json_encode($json_data);
       
        
        //return $row1;

       
    }

  public function getDescendants($position,$id,$parent){

    $json_data=array();
    
    //deces positions
    $q3="SELECT p.id, p.position from erp_units_positions as sbp inner join erp_org_positions as 
    p on p.id=sbp.position_id where p.report_to={$position} ";
    $com3= Yii::$app->db->createCommand($q3);
     $rows = $com3->queryAll(); 
     //echo json_encode($rows);die();
     
 //people under single position 
 if(!empty($rows)){
    foreach($rows as $row){
      
      
       $q4="SELECT u.* from erp_persons_in_position as p inner join user as 
       u on p.person_id=u.user_id where p.position_id={$row['id']}";
       $com4 = Yii::$app->db->createCommand($q4);
       
        $rows3 = $com4->queryAll();

       

        if(!empty( $rows3 )){
       
        foreach($rows3 as $row2){
           
            $id++; 
            $image2=$row2['user_image']!=''?$row2['user_image']:'uploads/profile/avatar-user.png';
          
           $json_data[]=['id'=>$id,'parentId'=>$parent,'name'=>$row2['first_name']." ".$row2['last_name'],'title'=>$row['position'], 
           'phone'=>$row2['phone'], 'mail'=>$row2['email'],  'image'=>Yii::$app->request->baseUrl . '/'.$image2];
          
        }
      
    }
    //-----------------------------------default to position
    else{
        $id++; 
        $image='uploads/profile/avatar-user.png';
        $json_data[]=['id'=>$id,'parentId'=>$parent,'name'=>"",
        'title'=>$row['position'], 'phone'=>"", 'mail'=>"",  'image'=>Yii::$app->request->baseUrl . '/'. $image];

    }


    //get child of current pos

    $q5="SELECT p.id, p.position from erp_units_positions as sbp inner join erp_org_positions as 
    p on p.id=sbp.position_id where p.report_to={$row['id']} ";
    $com5= Yii::$app->db->createCommand($q5);
     $rows5 = $com5->queryAll(); 
      if(!empty($rows5)){
       
       //parent =id
       //id of the node
        $data=$this->getDescendants($row['id'],$id,$id);
        $c=sizeof($data);
        $last=$data[$c-1];
        $index=$last['id'];
        $id=$index;
        $json_data=array_merge($json_data,$data );  
        
     
        
      }

       }

   }
    return $json_data;  
  
  }


    /**
     * Creates a new ErpOrgUnits model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ErpOrgUnits();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            $levelModel=ErpOrgLevels::find()->where(['id'=>$model->unit_level])->One();

            Yii::$app->session->setFlash('success',$levelModel->level_name." added successfully!");
            return $this->redirect([strtolower($levelModel->level_name)."s",'level'=>$levelModel->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ErpOrgUnits model.
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
     * Deletes an existing ErpOrgUnits model.
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
     * Finds the ErpOrgUnits model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ErpOrgUnits the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ErpOrgUnits::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
