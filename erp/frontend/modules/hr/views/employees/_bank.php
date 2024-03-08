

 <?php
 use frontend\modules\hr\models\Employees;
 use frontend\modules\hr\models\EmpPhoto;

$bank=$model->bankDetails;

 ?>
<style>
    
ul.basic-info li a,ul.cont-info li a,ul.addr-info li a {color:black;}   
    
</style> 
 <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-university"></i> Bank  Info</h3>
                <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-sm">
                   <i class="fas fa-pencil-alt"></i>
                  </a>
                 
                </div>
              </div>
              <div class="card-body table-responsive p-0 ">
                  
               
               <ul class="nav flex-column basic-info">
                  <li class="nav-item ">
                    <a href="#" class="nav-link ">
                    Bank Name <span class="float-right "><?php echo $bank->bank_name?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                   Bank Account <span class="float-right "><?php echo $bank->bank_account?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                   Bank Branch <span class="float-right "><?php echo $bank->bank_branch?></span>
                    </a>
                  </li>
                  
                </ul>
              </div>
            </div>