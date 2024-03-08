<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\db\Query;
use  frontend\modules\auction\models\Bids;
use yii\bootstrap4\ActiveForm;


/* @var $this yii\web\View */
/* @var $model frontend\modules\auction\models\Bids */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bids', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php
$cond[]='and'; 
    
    /*$dateNow=date('Y-m-d H:i:s');
   $cond[]=['>=', 'item.end_date',$dateNow];*/
    
    $query = new Query;
     $query->select([
        'lot.lot',
        'lot.description',
        'lot.quantity',
        'lot.reserve_price',
        'loc.location',
        'lot.start_date',
        'lot.end_date',
        'bid.id',
        'bid.user',
        'bid.amount',
        'bid.status',
        'count(bid.item) as tot_bid',
        'MAX(bid.amount) as highest_bid ',
        'count(bid.user) as tot_bidders'
        
        ]
        )  
        ->from('lots as lot')
         ->join('INNER JOIN', 'lots_locations as loc',
            'lot.location =loc.id')	
        ->join('LEFT JOIN', 'bids as bid',
            'bid.item =lot.id')		
          ->where(['bid.item'=>$model->item])
          ->groupBy(['lot.lot']); 
          
          
         $queryString=$query->createCommand()->getRawSql();
         $data = Yii::$app->db5->createCommand($queryString)->queryOne();
     
     //------------bidders list-------------------------------------------
   
                      
    $query1 = new Query;
     $query1->select([
        'u.*',
        'b.*',
       
        
        ]
        )  
        ->from('user as u')
        
        ->join('INNER JOIN', 'bids as b',
            'b.user =u.user_id')
            ->orderBy([
  'amount' => SORT_DESC,
  
])
          ->where(['b.item'=>$model->item])
          ;
         
          
          
         $queryString1=$query1->createCommand()->getRawSql();
         $bidders = Yii::$app->db5->createCommand($queryString1)->queryAll();
        
          
         
?>

<div class="card">
        <div class="card-header">
          <h3 class="card-title"><span class="text-blue"><?php echo $data['description'] ?></span>  Bidding Details</h3>

        </div>
        <div class="card-body">
          <div class="row">
          
                <div class="col-12 col-sm-3 ">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Total Bidders</span>
                      <span class="info-box-number text-center text-muted mb-0"><?= $data['tot_bidders'] ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Total Biddings</span>
                      <span class="info-box-number text-center text-muted mb-0"><?= $data['tot_bid'] ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-3">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Highest Bid</span>
                      <span class="info-box-number text-center text-muted mb-0"><?= $data['highest_bid'] ?><span>
                    </div>
                  </div>
                </div>
                
                 <div class="col-12 col-sm-3">
                  <div class="info-box bg-light">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Selected Bidders</span>
                      <span class="info-box-number text-center text-muted mb-0">0<span>
                    </div>
                  </div>
                </div>
              </div>
              
                <div class="row mt-5">
          
                <div class="col-12 col-sm-12 ">
                    
                 <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-content-below-home-tab" 
                data-toggle="pill" href="#custom-content-below-home" 
                role="tab" aria-controls="custom-content-below-home" aria-selected="true"><i class="fas fa-users"></i> Bidders List</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile"
                role="tab" aria-controls="custom-content-below-profile" aria-selected="false"><i class="fas fa-clipboard-check"></i> Selected  List</a>
              </li>
             
            </ul>  
            
              <div class="tab-content" id="custom-content-below-tabContent">
              
              <div class="tab-pane fade show active " id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
              
              <div class="table-responsive mt-5">
                <?php $form = ActiveForm::begin([
                                
                                'id'=>'frm-bidders', 
                              
                                'action' => ['bids/selected-bidders','id'=>$model->id],
                               
                               'method' => 'post',
                               ]); ?>
                
                 <table   class="table display"  cellspacing="0" width="100%">
   <thead>
      <tr>
         <th></th>
         <th>First Name</th>
         <th>Last Name</th>
         <th>ID Type</th>
         <th>ID No.</th>
         <th>Phone</th>
         <th>Email</th>
         <th>Bid Amount</th>
         <th>Bid Time</th>
      </tr>
   </thead>
   
       <tbody>
     
         <?php  foreach($bidders as $row): ?>
         <?php ++$i?>
                    <tr>
                    
                  <td></td>
                    <td><?php echo Html::hiddenInput('bids[user]', $row['user_id']); ?>
                        <a href="#"><?php echo $row["first_name"] ; ?></a></td>
                    <td><a href="#"><?php echo $row["last_name"] ; ?></a></td>
                     <td><?php echo $row["doc_type"] ; ?></td>
                     
                       <td><?php echo $row["doc_id"] ; ?></td>
                       
                         <td><?php echo $row["phone"] ; ?></td>
                         <td><?php echo $row["email"] ; ?></td>
                         <td><span style="font-family:sans-serif;font-weight:bold;font-size:16px;" class="badge badge-info"><?php echo $row["amount"] ; ?></span></td>
                         <td><?php echo $row["timestamp"] ; ?></td>
                    </tr>
                    
                    <?php endforeach;?>
      
   </tbody>
      <tfoot>
      <tr>
       
       <td colspan="9">
        
                       
        <?= Html::submitButton('<i class="far fa-bell"></i> Notify Selected', ['class' => 'btn btn-success ']) ?>
   

       </td>
    

      </tr>
   </tfoot>
</table>

         <?php ActiveForm::end(); ?>       
              </div>
              
              </div>
              <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                 Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam. 
              </div>
              
            </div>
                </div>
                </div>
            
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
      
      <?php

$lot=$model->item;
$script = <<< JS

$(document).ready(function (){

var dTable=$('.table').DataTable( {
    destroy: true,
     select: true,
   
     columnDefs: [
         {
            targets: 0,
            checkboxes: {
               selectRow: true
            }
         }
      ],
      select: {
         style: 'multi'
      },
     // order: [[1, 'asc']]
  
} );

$('#frm-bidders').on('beforeSubmit', function(event) {
    
    var \$form = $(this);

     var selectedRowInputs = $('.selected input');
     
     var bidders =[];
$.each(selectedRowInputs .serializeArray(), function(index) {
         bidders[index] = this.value;
});
     

   
   $.ajax({
      
        url: \$form.attr("action"),  //Server script to process data
        type: 'POST',

        // Form data
        data:JSON.stringify({ lot:$lot,selected: bidders }),

       // beforeSend: beforeSendHandler, // its a function which you have to define

        success: function(response) {
          
       
        },

        error: function(){
            alert('ERROR at PHP side!!');
        },


        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false,
       
    });

  
return false;//prevent the modal from exiting
  
    
});


});

JS;
$this->registerJs($script);

?>