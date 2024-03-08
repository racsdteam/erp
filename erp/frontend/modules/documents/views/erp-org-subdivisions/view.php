<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

?>

 <style type="text/css">
        html, body {
            margin: 0px;
            padding: 0px;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        #subdivisions-view {
            width: 100%;
            height: 100%;
        }
    </style>

<div id="subdivisions-view">
</div>

<?php

$url=Url::to(["erp-org-subdivisions/get-json",'id'=>$id,'level'=>$level,
                                              
]);

$script = <<< JS

 $.ajax({
            url:'{$url}',
            type: 'GET',
            dataType: 'json',
           // data: { id:'{$id}',level:'{$level}',
             success: function(data) {
               console.log(data);

               if(data['flag']==false){
 var html='<div class="alert alert-danger alert-dismissable">'+
                                      '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+
                                       '<h4><i class="icon fa fa-check"></i>Error!</h4>'+data['message']+
                                       
                                 '</div>';
                 
                 $('#modal-action .modal-body').html(html);
               }else{
               
                var peopleElement = document.getElementById("subdivisions-view");
                var image="/erp/images/m-loader.gif";
                var orgChart = new getOrgChart(peopleElement, {
            primaryFields: ["name", "title", "phone", "mail"],
             photoFields: ["image"],
            dataSource:data, customize: {
                "1": { color: "green" },
               // "2": { theme: "deborah" },
               // "3": { theme: "deborah", color: "darkred" }
            }
            /* [
                { id: 1, parentId: null, name: "Amber McKenzie", title: "CEO", phone: "678-772-470", mail: "lemmons@jourrapide.com", adress: "Atlanta, GA 30303", image: "/erp/img/avatar-user.png" },
                { id: 2, parentId: 1, name: "Ava Field", title: "Paper goods machine setter", phone: "937-912-4971", mail: "anderson@jourrapide.com", image: "/erp/img/avatar-user.png" },
                { id: 3, parentId: 1, name: "Evie Johnson", title: "Employer relations representative", phone: "314-722-6164", mail: "thornton@armyspy.com", image: "/erp/img/avatar-user.png" },
                { id: 4, parentId: 1, name: "Paul Shetler", title: "Teaching assistant", phone: "330-263-6439", mail: "shetler@rhyta.com", image: "/erp/img/avatar-user.png" },
                { id: 5, parentId: 2, name: "Rebecca Francis", title: "Welding machine setter", phone: "408-460-0589", image: "/erp/img/avatar-user.png" },
                { id: 6, parentId: 2, name: "Rebecca Randall", title: "Optometrist", phone: "801-920-9842", mail: "JasonWGoodman@armyspy.com", image: "/erp/img/avatar-user.png" },
                { id: 7, parentId: 2, name: "Spencer May", title: "System operator", phone: "Conservation scientist", mail: "hodges@teleworm.us", image: "/erp/img/avatar-user.png" },
                { id: 8, parentId: 6, name: "Max Ford", title: "Budget manager", phone: "989-474-8325", mail: "hunter@teleworm.us", image: "/erp/img/avatar-user.png" },
                { id: 9, parentId: 7, name: "Riley Bray", title: "Structural metal fabricator", phone: "479-359-2159", image: "/erp/img/avatar-user.png" },
                { id: 10, parentId: 7, name: "Callum Whitehouse", title: "Radar controller", phone: "847-474-8775", image: "/erp/img/avatar-user.png" }
            ]*/
        });
    }   
               
             },
             
              error:function(request, status, error) {
            console.log("ajax call went wrong:" + request.responseText);
        }


         });

  

JS;
$this->registerJs($script);

?>