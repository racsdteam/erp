<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="itemlist-index row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                 <div class="card card-default color-palette-card">
        
                       <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-file-o"></i> <?= Html::encode($this->title) ?> </h3>
                       </div>
               
           <div class="card-body"> 

    <p>
        <?= Html::a('Create Item', ['create'], ['class' => 'btn btn-success active']) ?>
    </p>

       <?php 
        
 $q1=" SELECT i.*  FROM    items as i   order by i.timestamp desc";
     $com1 = Yii::$app->db1->createCommand($q1);
     $rows = $com1->queryAll();
       
       ?>
<div class="table-responsive">

<table class="table table-cases table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                       <th>#</th>
                                        <th align="center">Actions</th>
                                        <th>Item Code </th>
                                        <th>Item Name</th>
                                        <th>Item Category</th>
                                        <th>Item Sub Category</th>
                                        <th>Item Tech Specs</th>
                                        <th>Item Minimun QTY</th>
                                         <th>Item UOM</th>
                                         <th>Registered By</th>
                                           <th>Created Time</th>
                                     
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                 
                                   
                                     
 <?php $i=0;
 foreach($rows as $row ):
 
  $q1=" SELECT c.name as category,s.name as sub_category FROM  categories as c  
  inner join sub_categories as s  on c.id=s.category
 inner join items as i  on s.id=i.it_sub_categ
 where i.it_sub_categ='".$row['it_sub_categ']."'";
 $com1 = Yii::$app->db1->createCommand($q1);
 $row1 = $com1->queryOne();
     
     
 $q99=" SELECT p.position,u.first_name,u.last_name  FROM  user as u  
  inner join erp_persons_in_position as pp  on pp.person_id=u.user_id
 inner join erp_org_positions as p  on p.id=pp.position_id
 where u.user_id='".$row['user']."'";
 $com99 = Yii::$app->db->createCommand($q99);
 $rows99 = $com99->queryOne();

 $i++;                                
                                  
                                  ?>
                                   
                                   
                                     <tr>
                                         <td>
                                     <?php echo  $i; ?>
                 
                                     </td>
                                    
                                       <td nowrap>
                            <div style="text-align:center" class="centerBtn">
                                
                               
  
                                                 <?=Html::a('<i class="fa fa-eye"></i> View',
                                             
                                             Url::to(["items/view",'id'=>$row['it_id']])
                                          
                                          ,['class'=>'btn btn-info btn-sm  ','title'=>'View Item Info'] ); ?> |
                                            
                                         
                                          <?=Html::a('<i class="fa fa-edit"></i> Edit',
                                             Url::to(["items/update",'id'=>$row['it_id']
                                           ])
                                          ,['class'=>'btn btn-primary btn-sm ','title'=>'Edit Item' ] ); ?>
                                      
                                         
                         </div>
                                   
                                          </td > 
                                           <td><?php echo $row["it_code"]; ?></td>
                                        <td><?php echo $row["it_name"]; ?></td>
                                        <td><?php  echo  $row1["category"];  ?> </td>
                                        <td><?php  echo  $row1["sub_category"];  ?> </td>
                                         <td><?php echo $row["it_tech_specs"] ; ?></td>
                                          <td><?php echo $row["it_min"] ; ?></td>
                                           <td><?php echo $row["it_unit"] ; ?></td> 
                                <td>
                                     <?php echo $rows99["first_name"].' '.$rows99["last_name"]." [ ". $rows99["position"]."]" ; ?></td> 
                                          <td><?php echo $row["timestamp"] ; ?></td>  

                                           
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