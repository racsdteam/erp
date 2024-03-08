

 <?php
 use frontend\modules\hr\models\Employees;
 use frontend\modules\hr\models\EmpPhoto;
 use common\models\Countries;
use common\models\District;
use common\models\Sector;
use yii\helpers\Url;

$address=$model->address;
 ?>
<style>
    
ul.basic-info li a,ul.cont-info li a,ul.addr-info li a {color:black;}   
    
</style> 

 <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-map-marker-alt"></i>  Address Info</h3>
                <div class="card-tools">
                  <a href="<?=Url::to(['emp-address/update','employee'=>$model->id])?>" class="btn btn-tool btn-sm action-create" title="Edit address Info">
                   <i class="fas fa-pencil-alt"></i>
                  </a>
                 
                </div>
              </div>
              <div class="card-body table-responsive p-0">
               <ul class="nav flex-column addr-info">
                   <li class="nav-item">
                    <a href="#" class="nav-link">
                    Country <span class="float-right "><?php 
                    $c=Countries::find()->where(['country_code'=>$address->country])->One();
                    $myCountry=$c!=null?$c->country_name:'';
                    echo $myCountry?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                   District/Sector/Cell/Village<span class="float-right "><?php
                    $addrStr='';
                    $d=District::findOne( $address->district);
                    $s=Sector::findOne( $address->sector);
                    
                     $addrStr.=$d!=null?$d->district:'--';
                     $addrStr.=$d!=null?'/'.$s->sector:'--';
                     $addrStr.=$address->cell!=null?'/'.$address->cell:'';
                    $addrStr.=$address->village!=null?'/'.$address->village:'';
                    
                   echo $addrStr?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                     City <span class="float-right "><?php echo $address->city?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                    Street Number<span class="float-right "><?php echo $address->address_line1?></span>
                    </a>
                  </li>
                   <li class="nav-item">
                    <a href="#" class="nav-link">
                    House Number<span class="float-right "><?php echo $address->address_line2?></span>
                    </a>
                  </li>
                   <li class="nav-item">
                    <a href="#" class="nav-link">
                   House Name<span class="float-right "><?php echo $address->address_line_3?></span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>