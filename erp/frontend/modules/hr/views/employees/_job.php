

 <?php
 use frontend\modules\hr\models\Employees;
 use frontend\modules\hr\models\EmpPhoto;


$work=$model->employmentDetails; 

 ?>
<style>
    
ul.basic-info li a,ul.cont-info li a,ul.addr-info li a {color:black;}   
    
</style> 
 <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-briefcase"></i> Employement Info</h3>
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
                    Department/Unit/Office  <span class="float-right ">
                    <?php echo $work->orgUnitDetails->unit_name?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                    Position<span class="float-right "><?php echo $work->positionDetails->position?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                   Start  Date <span class="float-right "><?php echo date('d/m/Y',strtotime($work->start_date))?></span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Employement Type <span class="float-right "><?php echo $work->employmentType->name?></span>
                    </a>
                  </li>
                   <li class="nav-item">
                    <a href="#" class="nav-link">
                   
                     Supervisor<span class="float-right "><?php echo $supervisor->first_name.' '.$supervisor->last_name?></span>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                     Location<span class="float-right  "><?php echo $work->workLocation->name?></span>
                    </a>
                  </li>
                  
                  
                </ul>
              </div>
            </div>