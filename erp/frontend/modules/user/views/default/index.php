<?php
use yii\helpers\Url;
use  common\models\User;


/* @var $this yii\web\View */

$this->title = 'User Accounts';


if (Yii::$app->session->hasFlash('success')){

$msg=  Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  

   }
  

if (Yii::$app->session->hasFlash('failure')){

$msg=  Yii::$app->session->getFlash('failure');

  echo '<script type="text/javascript">';
  echo 'showErrorMessage("'.$msg.'");';
  echo '</script>';
  

   }
$role=Yii::$app->user->identity->user_level;


function getPositionsByUnit($unit,$positions){

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
                $data=getPositionsByUnit($unit1['id'],$positions2); 
                if(!empty($data)){
                    
                    
                    foreach($data as $p){
                        
                       $positions[]=$p;  
                    }
                }
                
            
              }

             // var_dump($positions);

          
        
            
            }
            
             
             return $positions;
            
            
}
    $positions=array();
   $hr_positions[]=getPositionsByUnit(9,$positions);
  
      
 //-------------------pending users-------------------------------------------------------------------------
 $q2=" SELECT count(*) as tot FROM user where  approved=0  ";
 $com2 = Yii::$app->db->createCommand($q2);
       $r2 = $com2->queryall(); 
       
 //all users
  $q3=" SELECT count(*) as tot FROM user where approved=1  ";
 $com3 = Yii::$app->db->createCommand($q3);
       $r3 = $com3->queryall();

?>

<style>
    
    a.div-clickable{ display: block;
       height: 100%;
       width: 100%;
       text-decoration: none;}   
       
       
       
   </style>
   
   

<!-- Info boxes -->
<div class="row">
       
         <div class="col-md-3 col-sm-6 col-xs-12">
    
        <div class="small-box bg-teal">
            <div class="inner">
              <h3><?php echo   $r2[0]['tot'] ?></h3>

              <p>Pending Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
           <a href="<?=Url::to(['user/users-pending'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
          
          </div>
          
          <div class="col-md-3 col-sm-6 col-xs-12">
    
        <div class="small-box bg-teal">
            <div class="inner">
              <h3><?php echo   $r3[0]['tot'] ?></h3>

              <p>Approved Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-checkmark"></i>
            </div>
           <a href="<?=Url::to(['user/index'])?>" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i> </a>
          </div>
          
          </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        
        <!-- /.col -->
      </div>