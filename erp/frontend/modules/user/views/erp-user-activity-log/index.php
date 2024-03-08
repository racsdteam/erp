<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\Query;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ErpUserActivityLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Erp User Activity Logs';
$this->params['breadcrumbs'][] = $this->title;
?>

            
<div class="erp-user-activity-log-index">

<div class="row clearfix">



                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="box box-default color-palette-box">
                        <div class="box-header with-border">
                           
                            <h1><?= Html::encode($this->title) ?></h1>
                           
                        </div>
                        
                        <div class="box-body">

  <p>
        <?= Html::a('Register User Signature', ['create'], ['class' => 'btn btn-success action-add-hotel','title'=>'Create Memo']) ?>
    </p>
   
    <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                         <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Position</th>
                                        <th>Action</th>
                                        <th>time</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php foreach($dataProvider as $row):?>
                                    <?php $i++; ?>
                                     <tr  class="<?php if($row['approved']==0){echo 'new';}else{echo 'read';}  ?>">
                                          <td><?php echo $i  ;?></td>
                                            <td><?php echo $row["first_name"]  ;?></td>
                                            <td><?php echo $row["last_name"]  ;?></td>
                                            <td><?php 
                                           $q7=" SELECT p.position FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
                                          
                                           where pp.person_id='".$row['id']."' ";
                                           $command7= Yii::$app->db->createCommand($q7);
                                           $row7 = $command7->queryOne();
                                           $pos=$row7['position']; 
                                          
                                           
                                          // echo $row7['position'];
                                           echo  $pos;
                                          
                                             ?></td>
                                            <td><?php echo $row["action"]  ;?></td>
                                            <td><?php echo $row["time"]  ;?></td>
                                 
                                           

                                            
                                        </tr>
                                    
                                    <?php endforeach;?>
                                       
                                    </tbody>
                                </table>
</div>
</div>
                    </div>

                   

                </div>
            </div>


</div>
