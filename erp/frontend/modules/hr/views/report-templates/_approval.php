
   
    <ol style="margin-top:0;padding:0;list-style-position:inside">
<?php 
if(!empty($wf))
        {
       
        foreach($wf->stepInstances as $approval)
        {
            if($approval->task_type=="Approval")
            {
?>
        <li style="margin-top:22px"><?= $approval->name ?>…………………....</li>
<?php } } }?>        
        </ol>
