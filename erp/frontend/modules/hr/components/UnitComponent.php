<?php
namespace frontend\modules\hr\components;


use Yii;
use yii\base\Component;
use yii\data\ActiveDataProvider;
use common\models\ErpOrgUnits;
use common\models\ ErpOrgLevels;
use frontend\modules\hr\models\EmpEmployement;
use frontend\modules\hr\models\Employees;

class UnitComponent extends Component {
 
 
 public function getPositionsProvider($unit){
 
 $model=ErpOrgUnits::findOne($unit);    
 $dataProvider = new ActiveDataProvider([
    'query' =>  $model->getPositions(),
]);    

return  $dataProvider ;   
 }
 
 
 public function getAllUnitTypes(){
     
    
      $rows= ErpOrgLevels::find()->select('levels.*')
                            ->alias('levels')
                            ->all();
                          return  $rows;
 }
 
  public function getAllUnitByCode($code){
     
    
      $row= ErpOrgUnits::find()->where(['unit_code'=>$code])
                            ->one();
                          return  $row;
 }
 public function getRootedOutUnits(){
     $rows=ErpOrgUnits::find()->select('u.*,type.level_code')
                            ->alias('u')
                            ->innerJoin('erp_org_levels type', '`type`.`id` = `u`.`unit_level`')
                            ->where(['active'=>1,'parent_unit'=>1])
                            ->all();
                          return  $rows;
    
 }
 
  
 
  public function getEmployees($orgUnit){
     
     $query=Employees::find()->alias('e')
                           ->innerJoin('emp_employment impl', '`impl`.`employee` = `e`.`id`');
     is_array($orgUnit)?  $query->where(['in','impl.org_unit', $orgUnit]) :  $query ->where(['impl.org_unit'=>$orgUnit ]);                      
   
     $query->andwhere([ 'e.status' =>'ACT' ]);      
      
     return  $query ->count();         
    
 }
 
 public function getEmpCount($id){
     
      $data=$this->getChildUnits($id);
        $ids=array();
       
        if(!empty($data)){
         $ids[]=$id;    
            foreach($data as $cu){
               
               if(is_array($cu) ){
                   
                   foreach($cu as $u){
                       
                        $ids[]=$u->id;
                   }
               }else{
                   
                   $ids[]=$cu->id;
               }
              
            }
        }else{$ids[]=$id;}
       
       $count=$this->getEmployees($ids);
       return $count;
 }
 
 public function getAllUnits(){
 
  $rows=ErpOrgUnits::find()->select('u.*,type.level_code')
                            ->alias('u')
                            ->innerJoin('erp_org_levels type', '`type`.`id` = `u`.`unit_level`')
                             ->where(['active'=>1])
                            ->all();
                          return  $rows;
 
}

 public function getChildUnits($parent){
 
 $children=ErpOrgUnits::find()->select('u.*')
                            ->alias('u')
                            ->where(['parent_unit'=>$parent,'active'=>1])
                            ->all();
     $tree=array();                         
     if(!empty($children)) {
             
             foreach($children as $c){
               
              $data=$this->getChildUnits($c->id);
              
              if(!empty($data)){
                  
                  $tree[]=$c;
                  $tree[$c->id]=$this->getChildUnits($c->id);
              }else{
                  
                  $tree[]=$c;
              }
            
                 
             }
         }                  
 return $tree;
}

 public function getAllUnitsLevel1(){
$subQuery=ErpOrgUnits::find()->select('u.id')
                            ->alias('u')
                            ->innerJoin('erp_org_levels type', '`type`.`id` = `u`.`unit_level`')
                             ->where(['in','level_code', ['D','U']])
                             ->andwhere(['active'=>1]);

 $rows=ErpOrgUnits::find()->select('u.*,type.level_code')
                            ->alias('u')
                            ->innerJoin('erp_org_levels type', '`type`.`id` = `u`.`unit_level`')
                            ->where(['not in','parent_unit', $subQuery])//units not under departments
                             ->andwhere(['active'=>1])
                            ->all();
                            return  $rows;
 
}

public function getAllUnitsByType($type){
 
  $query=ErpOrgUnits::find()->select('u.*')
                            ->alias('u')
                            ->innerJoin('erp_org_levels type', '`type`.`id` = `u`.`unit_level`')
                            ->where(['type.level_code'=>$type,'active'=>1]);
                          
    $provider = new ActiveDataProvider([
    'query' => $query,
    'pagination' =>false,
   
]);                        
                            
                            
                            return   $provider ;
 
}


 } 
?>