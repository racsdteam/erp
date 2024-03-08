

 <?php
 use frontend\modules\hr\models\Employees;
 use frontend\modules\hr\models\EmpPhoto;
  use yii\helpers\Url;
 

$contact=$model->contact;
 ?>
<style>
    
ul.basic-info li a,ul.cont-info li a,ul.addr-info li a {color:black;}   
    
</style> 

<div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-phone-alt"></i> Contact Info</h3>
                <div class="card-tools">
                  <a href="<?=Url::to(['emp-contact/update','employee'=>$model->id])?>" class="btn btn-tool btn-sm action-create" title="Edit Contact Info">
                   <i class="fas fa-pencil-alt"></i>
                  </a>
                 
                </div>
              </div>
              <div class="card-body table-responsive p-0">
               <ul class="nav flex-column cont-info">
                   <li class="nav-item">
                    <a href="#" class="nav-link">
                     Work Phone <span class="float-right "><?php echo $contact->work_phone?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                    Work Email <span class="float-right "><?php echo $contact->work_email?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                     Mobile Phone <span class="float-right "><?php echo $contact->mobile_phone?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                     Personal Email<span class="float-right "><?php echo $contact->personal_email?></span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>