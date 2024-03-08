	 
	<?php

use adminlte\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;


?> 
	 	  <!-- Control Sidebar -->
      <aside class="control-sidebar sidebar-dark-success elevation-4">
          
          <!-- Sidebar -->
    <div class="sidebar">
     

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fas fa-user-alt"></i>
              <p>
               Manage Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../../index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../../index3.html" class="nav-link nav-admin">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li>
         
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-lock"></i>
              <p>
               Security Groups
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=Url::to(['tblgroups/index'])?>" title="All Security Groups" class="nav-link nav-admin">
                  <i class="fa fa-cubes nav-icon"></i>
                  <p>All Security Groups</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=Url::to(['tblgroups/create'])?>" title="New Security Group " class="nav-link nav-admin">
                  <i class="fa fa-plus-square nav-icon"></i>
                  <p> New Security Goup</p>
                </a>
              </li>
              
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
      
  
                   <?php


$script = <<< JS

 $('.nav-admin').click(function () {
        var url = $(this).attr('href');
 
        
  
$('.modal-action').modal('show')
    .find('.modal-body')
    .load(url);
    
   $('.modal-action #defaultModalLabel').text($(this).attr('title'));
return false;
                        
 
        });
        
    

JS;
$this->registerJs($script);

?>
     
      
      