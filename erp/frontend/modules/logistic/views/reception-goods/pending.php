<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reception Goods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reception-goods-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Reception Goods', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

<div class="card card-default color-palette-card">
 <div class="card-header with-border">
   <h3 class="card-title"><i class="fa fa-tag"></i>Pending of Goods Received</h3>
 </div>
 <div class="card-body">

 
 <?php if (Yii::$app->session->hasFlash('success')): ?>
  
  <?php 
  $msg=Yii::$app->session->getFlash('success');

  echo '<script type="text/javascript">';
  echo 'showSuccessMessage("'.$msg.'");';
  echo '</script>';
  
  
  ?>
    <?php endif; ?>
    
    <?php 
    
    $q1=" SELECT f.* FROM reception_approval_flow  as f inner join reception_goods as re on re.id=f.reception
     where f.approver='".Yii::$app->user->identity->user_id."' and f.status='pending' order by f.timestamp desc";
     $com1 = Yii::$app->db1->createCommand($q1);
     $rows = $com1->queryAll(); 
        

     $i=0;
    ?>


 <div class="table-responsive">
 <table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                             <th>#</th>
                                        <th align="center">Actions</th>
                                        <th>Good Received Code</th>
                                          <th>supplier</th>
                                          <th>Purchase Order Number</th>
                                          <th>Reception Date</th>
                                           <th>Created By</th>
                                          <th>Status</th>
                                          
                                          
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                  
                                    <?php 
                                    if(!empty($rows)){
                                    foreach($rows as $row1):
                                   $q=" SELECT r.*,s.name,s.country,s.city FROM  reception_goods as r inner join supplier as s on s.id=r.supplier where r.id='".$model->id."' ";
                                   $com = Yii::$app->db1->createCommand($q);
                                    $row = $com->queryOne();
                                   
                                   
                                      $i++;
                                    ?>
                                  
                                    
                                  
                                    
                                    <tr class="<?php if($row1['is_new']==1){echo 'new';}else{echo 'read';}  ?>">
                                        
                                         <td>
                                            <?=
                                           $i++;
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                         <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                
                               
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                             
                                             Url::to(["reception-goods/view",'id'=>$row1['id'],'flow'=>$row['id']])
                                          
                                          ,['class'=>'btn-info btn-sm active action-viexw','title'=>'View Memo Info'] ); ?> 
                                            
                                          
                                          <?=Html::a('<i class="fa fa-recycle"></i> Histroy',
                                             Url::to(["reception-goods/memo-tracking",'id'=>$row1['id']
                                           ])
                                          ,['class'=>'btn-primary btn-sm active action-view','title'=>'Memo tracking History' ] ); ?>
                                           
                                                 
                                                 
                                         
                         </div>
                                   
                                          </td > 
                                         
                                         
                                    <td nowrap><?= Html::a(' <i class="fa fa-file-text"></i>'." ".$row1["number"],
                                    Url::to(['request-to-stock/view','id'=>$row1["id"]]), ['class'=>'action-viewx']) ?></td>
                                    <td>
                                            <?=
                                           $row['name'] 
                                            
                                           ?>
                                          
                                          
                                         </td>  
                                    <td>
                                                  <?php
                                         
                                     echo  $row1['purchase_order_number'] ;
   
                                           ?>
                                           </td> 
                                            <td>
                                                  <?php
                                         
                                     echo  $row1['reception_date'] ;
   
                                           ?>  
                                          
                                         </td>
                                         
                                            <td><?php 
                                           $q7=" SELECT p.position,u.first_name,u.last_name FROM erp_org_positions as p inner join  erp_persons_in_position as pp on pp.position_id=p.id
inner join  user as u on u.user_id=pp.person_id
where pp.person_id='".$row1['user']."' "; 

$command7= Yii::$app->db->createCommand($q7);
$row7 = $command7->queryOne(); 
                                            echo $row7["first_name"]." ".$row7["last_name"]."/".$row7["position"] ; ?>
                                            
                                            
                                            
                                            </td>
                                            
                                             <td><?php 
                                             $status= $row1["status"];
                                             if( $status=='processing' || $status=='drafting'){
                                                 
                                                 $class="label pull-left bg-pink";
                                             }else if($status=='expired'){
                                                  $class="label pull-left bg-red";
                                                 
                                             }else if($status=='approved')
                                             {$class="label pull-left bg-green";}
                                             else{
                                                  $class="label pull-left bg-orange";
                                                 
                                             }
                                             
                                             echo '<small style="padding:5px;border-radius:13px" class="'.$class.'">'.$status.'</small>'; ?></td>
                                        </tr>

                                     
                                    
                                    <?php 
                                    endforeach;
                                    }
                                    ?>
                                       
                                    </tbody>
                                </table>
                                 </div>
 </div>

 </div>
 
 
 </div>

</div>

</div>
