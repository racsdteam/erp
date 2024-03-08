<?php

namespace frontend\modules\logistic\controllers;

use Yii;
use common\models\ActualStock;
use common\models\ItemsRequest;
use common\models\Model;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
class CheckStockController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actionCheck()
    {
        $item=$_GET['item'];
        $quantity=$_GET['quantity'];
        $quantity2=0;
        $data=array();
         $actual_stock=Yii::$app->logistic->getActualStock($item);;
        $quantity2=$actual_stock;
        if($quantity2 >= $quantity)
        {
            $data['flag']=true;
            $data['message']="The Qantity Asked is in stoke";
        }else{
             $data['flag']=false;
            $data['message']="The Qantity Asked is not in stoke \n the Current Quantity is $quantity2";
        }
        return json_encode($data);
    }
        
    public function actionGetSubCategories($category){
        
         $id=$_GET['category'];
 $data[]=  "<option>Select Sub Category</option>"; 
			  $q8="SELECT * from  sub_categories  where 	category=".$id."";
$command8= Yii::$app->db1->createCommand($q8);
$rows = $command8->queryAll();

 if(!empty($rows)){
     foreach($rows as $row)
     {
  $data[]=  "<option value='".$row['id']."'>".$row['name']."</option>";   
     } 
 }
		
		return Json::encode($data);
		
        
    }
     public function actionGetItems($subcategory){
        
         $id=$_GET['subcategory'];
 $data[]=  "<option>Select Item</option>"; 
			  $q8="SELECT * from   items  where it_sub_categ=".$id."";
$command8= Yii::$app->db1->createCommand($q8);
$rows = $command8->queryAll();

 if(!empty($rows)){
     foreach($rows as $row)
     {
  $data[]=  "<option value='".$row['it_id']."'>".$row['it_code']."/ ".$row['it_name']." / ".$row['it_unit']."</option>";   
     } 
 }
		
		return Json::encode($data);
		
        
    }
}
?>