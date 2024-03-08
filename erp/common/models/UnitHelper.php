<?php
namespace common\models;

use Yii;


class UnitHelper
{
    
const LEVEL_OFFICE=1;
const LEVEL_UNIT=3;
const LEVEL_DEPT=2;

const UNIT_FIN=5;
const UNIT_HR=9;

//---------unit,dep,office
public static function getOrgUnitInfo($id)
{
 
$q=" select u.unit_name,l1.level_name as unit_level,u2.unit_name as parent_unit,l2.level_name as parent_level from erp_org_units as u 
inner join erp_org_units as u2 on u2.id=u.parent_unit inner join erp_org_levels as l1 on l1.id=u.unit_level 
inner join erp_org_levels as l2 on l2.id=u2.unit_level and u.id={$id} ";
$command= Yii::$app->db->createCommand($q);
$row = $command->queryOne();
return $row;


}

//---------unit,dep,office
public static function getOrgUnitInfoByCode($code)
{
 
$q=" select u.unit_name,l1.level_name as unit_level,u2.unit_name as parent_unit,l2.level_name as parent_level from erp_org_units as u 
inner join erp_org_units as u2 on u2.id=u.parent_unit inner join erp_org_levels as l1 on l1.id=u.unit_level 
inner join erp_org_levels as l2 on l2.id=u2.unit_level and u.unit_code='".$code."' ";
$command= Yii::$app->db->createCommand($q);
$row = $command->queryOne();
return $row;


}

public static function getOrgUnitChild($id,$level)
{
$query="SELECT u.* FROM erp_org_units as u inner join erp_org_units as u1 on u.parent_unit=u1.id where u.parent_unit={$id} and u.unit_level={$level}";
$c = Yii::$app->db->createCommand($query);
$rows= $c->queryall(); 
return $rows;


}


 public static function getPositionsByUnit($unit,$positions){

//---------------select all child units  under the unit----------
$query1="SELECT p.* FROM erp_org_positions as p inner join erp_units_positions as up on up.position_id=p.id  where up.unit_id={$unit}";
            $c1 = Yii::$app->db->createCommand($query1);
                  $pos = $c1->queryall(); 
                  
                  if(!empty($pos)){
                      
                    foreach($pos as $p){
                       $positions[]=$p['position_code']; 
                    }
                  
                    }
      
                    $query="SELECT u.* FROM erp_org_units as u inner join erp_org_units as u1 on u.parent_unit=u1.id where u.parent_unit={$unit} and u1.unit_level=3";
                    $c = Yii::$app->db->createCommand($query);
                    $units = $c->queryall(); 
            
           
                    if(!empty($units)){

            
            
               foreach ($units as $unit1) {
              
                $positions2=array();
                 //new instance of fuction
                $data= $this::getPositionsByUnit($unit1['id'],$positions2); 
                if(!empty($data)){
                    
                    
                    foreach($data as $p){
                        
                       $positions[]=$p;  
                    }
                }
                
            
              }

            }
            
             
             return $positions;
            
            

}



}

?>
