<?php
use yii\helpers\Url;
use  common\models\User;


/* @var $this yii\web\View */

$this->title = 'Welcome';



?>
<div id="app">
<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{title}}</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-envelope"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Bids</span>
                <span class="info-box-number">
                 {{totalbids }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-hourglass-half"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Lots</span>
                <span class="info-box-number">{{ totallots }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-map-marker-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Sites</span>
                <span class="info-box-number">{{ totalsites}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Bidders</span>
                <span class="info-box-number">{{ totalbidders}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div
           <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cart-arrow-down"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Expected Revenue</span>
                <span class="info-box-number">
                 {{exprevenue }} Frws
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-cart-arrow-down"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Bids Revenue</span>
                <span class="info-box-number">
                    {{ bidsrevenue }} Frws
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>
      
          <!-- /.col -->
        </div>
        <!-- /.row -->
      
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
<?php
 $url1=Url::to(['action-api/bids']);
 $url2=Url::to(['action-api/lots']);
 $url3=Url::to(['action-api/sites']);
 $url4=Url::to(['action-api/lots-info']);
 $url5=Url::to(['action-api/bidders']);
$script2 = <<< JS
var app = new Vue({
  el: '#app',
 data: {
 title:"RAC Auction Dashboard",
  totalbids: 0,
  totalbidders: 0,
  totallots: 0,
  totalsites: 0,
  lotsmaxbid: null,
  lotsbids: null,
  lotsinitprice: null,
  lots: null,
  exprevenue: 0,
  bidsrevenue: 0,

},
methods: {
	pollData: async function() {
	    
		this.totalbids = await  axios.get("{$url1}").then().then((res)=>{return res.data });
		this.totalbidders = await  axios.get("{$url5}").then().then((res)=>{return res.data });
		this.totallots = await  axios.get("{$url2}").then().then((res)=>{return res.data });
		this.totalsites = await  axios.get("{$url3}").then().then((res)=>{return res.data });
		const data= await  axios.get("{$url4}").then().then((res)=>{return res.data });
		this.lots = data.lots;
		this.lotsinitprice = data.init_price;
		this.lotsbids = data.bids;
		this.lotsmaxbid = data.max_prices;
		const exprevenue  =	this.lotsinitprice.reduce((pv,cv)=>{
		         cv= cv.replace(/,/g, '');
                  return pv + (parseInt(cv)||0);
       },0);
		this.exprevenue= exprevenue.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
		const bidsrevenue= this.lotsmaxbid.reduce((pv1,cv1)=>{
		         cv1= cv1.replace(/,/g, '');
                  return pv1 + (parseInt(cv1)||0);
       },0);
       this.bidsrevenue= bidsrevenue.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	}
},
updated(){

},
beforeDestroy () {
	clearInterval(this.totalbids);
	clearInterval(this.totalitems);
	clearInterval(this.totalsites);
	clearInterval(this.itemsmaxbid);
	clearInterval(this.lotsbids);
	clearInterval(this.lotsinitprice);
	clearInterval(this.lots);
},
async created () {
   await this.pollData();
	setInterval(() => {
		    this.pollData();
		}, 10000);
	 $('.table').DataTable( {
	  paging: true,
      lengthChange: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
       responsive: true,
      dom: 'Bfrtip',
      buttons: [ 'copy', 'excel', 'pdf','print' ],
		
	
	} );	
}

});

JS;
$this->registerJs($script2);



$script1 = <<< JS



 function getEmployee(value,id)
{
    
     $.get('{$url}',{ position : value },function(data){
        
         console.log(data);
          $('#emp-'+id).html(data);
    });
   
}



JS;
$this->registerJs($script1,$this::POS_HEAD);
?>
