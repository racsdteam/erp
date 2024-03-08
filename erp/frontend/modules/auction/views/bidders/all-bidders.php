<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use fedemotta\datatables\DataTables;
use yii\bootstrap\Modal;
use kartik\detail\DetailView;
use yii\helpers\Url;
use lo\widgets\modal\ModalAjax;
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
                        <div class="card-header">
                           
                            <h1><?= Html::encode($this->title) ?></h1>
                           
                        </div>
                        
                        <div class="card-body">


 
 <?php 
$i=0; 
 
                                     $query = new Query;
                                     $query	->select([
                                         'u.*','role.role_name'
                                         
                                     ])->from('user as u ')->join('INNER JOIN', 'user_roles as role',
                                         'u.user_level=role.role_id');
                         
                                     $command = $query->createCommand();
                                     $rows=$command->queryAll();
 
?>
   
    <div class="table-responsive">
                                
                                <table  class="table  table-bordered table-striped table-hover dataTable js-exportable ">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>UserName</th>
                                        <th>Position</th>
                                       
                                        <th>Active</th>
                                         <th>View</th>
                                        <th>Update</th>
                                       
                                           
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                    <?php foreach($rows as $row):?>
                                 
                                    <?php $i++;?>
                                  
                                    
                                    <tr>
                                        <td>
                                            <?=
                                           $i;
                                            
                                           ?>
                                          
                                          
                                         </td> 
                                  
                                    <td>
                                            <?=
                                           $row["first_name"]
                                            
                                           ?>
                                          
                                          
                                         </td>  
                                    <td>
                                            <?=
                                             $row["last_name"]
                                            
                                           ?>
                                          
                                          
                                         </td>
                                           
                                        
                                         
                                          <td>
                                            <?php echo $row["phone"]  ;?>
                                          
                                          
                                         </td>
                                         
                                           <td>
                                            <?php echo $row["email"]  ;?>
                                          
                                          
                                         </td>
                                           
                                          <td>
                                            <?php echo $row["username"]  ;?>
                                          
                                          
                                         </td>
                                             
                                            <td > <?php 
                                           
                                       $pos= UserHelper::getPositionInfo($row['user_id']);
                                          
                                           
                                          // echo $row7['position'];
                                           echo  $pos['position'];
                                          
                                            ?> </td>
                                             
                                               <td><?php 
                                               
                                               if($row["status"]==10){
                                                   
                                               echo '<kbd class="bg-green">Active</kbd>' ;    
                                               }else{
                                                   
                                                   echo '<kbd class="bg-pink">Not Active</kbd>' ;  
                                                   
                                               }
                                               
                                              ?></td>
                                               
                                             
                                             
                                             <td> 
                                                 <?=Html::a('<i class="fa fa-eye"></i>',
                                              Url::to(["user/view",'id'=>$row['user_id']
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-view','title'=>'User Info'] ); ?> </td>
                                            
                                           <td> 
                                                 <?=Html::a('<i class="fa fa-edit"></i>',
                                              Url::to(["user/update",'id'=>$row['user_id']
                                           ])
                                          ,['class'=>'btn-info btn-sm active action-view','title'=>'Update User' ] ); ?> </td> 
                                        
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




