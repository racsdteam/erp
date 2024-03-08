<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use fedemotta\datatables\DataTables;
use yii\bootstrap\Modal;
use kartik\detail\DetailView;
use yii\helpers\Url;
use yii\db\Query;
use common\models\UserHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MirrorCaseSearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Bidders';

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row clearfix">



                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card card-default ">
                        <div class="card-header ">
                           
                            <h1><?= Html::encode($this->title) ?></h1>
                           
                        </div>
                        
                        <div class="card-body">


 
 <?php 
 $i=0; 
 
?>
   
    <div class="table-responsive">
                
                  <h4>Bidders List</h4>
                 <table   class="table display"  cellspacing="0" width="100%">
   <thead>
      <tr>
         <th>#</th>
         <th>First Name</th>
         <th>Last Name</th>
         <th>ID Type</th>
         <th>ID No.</th>
         <th>Phone</th>
         <th>Email</th>
          <th>Time Registered</th>
         
      </tr>
   </thead>
   
       <tbody>
     
         <?php  foreach($bidders as $row):; ?>
                    <tr>
                    <td><?=++$i?></td>
                    <td><a href="#"><?php echo $row["first_name"] ; ?></a></td>
                    <td><a href="#"><?php echo $row["last_name"] ; ?></a></td>
                     <td><?php echo $row["doc_type"] ; ?></td>
                     
                       <td><span style="font-family:sans-serif;font-weight:bold;font-size:16px;"><?php echo $row["doc_id"] ; ?></span></td>
                       
                        <td><span style="font-family:sans-serif;font-weight:bold;font-size:16px;"><?php echo $row["phone"] ; ?></span></td>
                         <td><?php echo $row["email"] ; ?></td>
                          <td><?php echo date('Y-m-d H:i:s', $row['created_at']); ?></td>
                        
                    </tr>
                    
                    <?php endforeach;?>
      
   </tbody>
</table>

               
              </div>

</div>
                    </div>

                   

                </div>
            </div>
 


<?php
           
$url =  Url::to(['user/get-users']);
$url2 = Url::to(['user/change-user-status']) ;
$url3 = Url::to(['user/update']) ;
$url4 = Url::to(['user/view']) ;
$script = <<< JS


JS;
$this->registerJs($script);



?>




