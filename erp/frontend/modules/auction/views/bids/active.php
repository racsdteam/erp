<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\auction\models\BidsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bids';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
 
 tr.new > td , tr.new > th{
     
     background-color:#ffd9b3;
  } 

  .m-title{
   height:100px; 
   width: 300px; 
   overflow: auto;
   
}
</style>




<div class="row clearfix">

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

  <div class="card card-default">
              <div class="card-header border-transparent">
                <h3 class="card-title"><i class="fas fa-gavel"></i><?=$title?></h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body ">
                  <?php  $i=0 ?>
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Lot No.</th>
                      <th>Lot</th>
                      <th>Qty</th>
                      <th>Bid Reserve</th>
                      <th>Location</th>
                      <th>Total Bids</th>
                       <th>Total Bidders</th>
                      <th>Heighest Bid (Frws)</th>
                      <th>Phy.Auction Date</th>
                      
                    </tr>
                    </thead>
                    <tbody>
                          <?php  foreach($data as $row):; ?>
                    <tr>
                    <td><img src="<?php echo Yii::$app->request->baseUrl?>/img/blue_gavel.png" alt="Product 1" class="img-circle img-size-32 mr-2"></td>
                    <td><a href="#"><?php echo $row["lot"] ; ?></a></td>
                    <td class="text-red" ><a  href="<?=Url::to(['lots/biddings','lot'=>$row["lot"]])?>"> <?php echo $row["description"]  ; ?></a></td>
                     <td><?php echo $row["quantity"] ; ?></td>
                      <td>
                         
                          <span style="font-family:sans-serif;font-weight:bold;font-size:16px;" class="badge badge-success"><?php echo $row["reserve_price"] ; ?></span></td>
                       <td><?php echo $row["location"] ; ?></td>
                        <td>
                             <?php if($row["tot_bid"]==0){$class="badge-danger";}else{$class="badge-primary";} ?>
                    <span style="font-family:sans-serif;font-weight:bold;font-size:16px;" class="badge <?php echo $class ?>"><?php echo $row["tot_bid"] ; ?></span></td>
                         <td><span style="font-family:sans-serif;font-weight:bold;font-size:16px;" class="badge <?php echo $class ?>"><?php echo $row["tot_bidders"] ; ?></span></td>
                         <td><span style="font-family:sans-serif;font-weight:bold;font-size:16px;" class="badge badge-danger"><?php echo $row["highest_bid"] ; ?></span></td>
                         <td><?php echo $row["auction_date"] ; ?></td>
                         
                    </tr>
                    
                    <?php endforeach;?>
                   
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
         
              <!-- /.card-footer -->
            </div>
              </div>
                </div>
