	function showViewer(fullpath,serverUrl,id,user,vcontainer,...args){

  WebViewer({
 // ui: 'beta',
  licenseKey: 'Rwanda Airports Company(rac.co.rw):ENTERP:RAC ERP::B+:AMS(20220306):C2A5D1AD0467A60A7360B13AC9A2737820616F996CB37A0595857BAA1AE768AE62B431F5C7',
  path: '/erp/lib',
  initialDoc:fullpath,
  filename:args[0],
  documentType: 'pdf',
  backendType: 'ems',
  disabledElements: [
   
   
   // 'textSelectButton',
    'panToolButton',
    'searchButton',
  
   
  ],
 
}, document.getElementById(vcontainer))
  .then( function(instance) {
 
    var docViewer = instance.docViewer;
    var annotManager = instance.annotManager;
    var Annotations = instance.Annotations;
    var Tools = instance.Tools;
  
   
  //-----------------------remove default miscToolGroup----------------------------------------------------- 
    instance.disableElements(['miscToolGroupButton' ]);
  //---------------------------document display settings------------------------------------------------------------
  var FitMode = instance.FitMode;
    instance.setFitMode(FitMode.FitWidth);
 //-------------------------------disable default browser print --------------------------------------------  
    instance.useEmbeddedPrint(false);
    instance.setPrintQuality(6);
  //----------------------------------setting default annotation author  & admin previlege------------------------------------------------- 
  
  if(user !==null){
   annotManager.setCurrentUser(user.fn+" "+user.ln+" /"+user.pos);    
   if(user.role==='Admin'){
    
     instance.annotManager.setIsAdminUser(true) ;
    
  }   
    }
 
  
 //----------------------------adding custom stamp ToolGroup-------------------------------------------- 
  instance.setHeaderItems(function(header) {
      header.get('freeHandToolGroupButton').insertBefore({
  type: 'toolGroupButton',
  toolGroup: 'miscTools',
  img: "https://rac.co.rw/erp/img/dmd_stamp_image.png",
  dataElement: 'miscToolGroupButton1',
  title: "component.miscToolsButton",
  //hidden:["tablet", "mobile"]
});


    });
  
  
  
   //-------------------------------------MD STAMP TOOL-------------------------------------------------

    
 var MD_StampTool = window.createStampTool(instance,120,120,'/erp/img/rac_stamp.png','Stamp');



//-------------------------------------DMD STAMP TOOL-------------------------------------------------

    var DMD_StampTool = window.createStampTool(instance,294,180,'/erp/img/dmd_stamp.png','Stamp');


//-------------------------------------FIN STAMP TOOL-------------------------------------------------

  
    var FIN_StampTool = window.createStampTool(instance,294,180,'/erp/img/f_stamp.png','Stamp');


//-------------------------------------HR STAMP TOOL-------------------------------------------------

  
    var HR_StampTool = window.createStampTool(instance,294,180,'/erp/img/hr_stamp.png','Stamp');


 //-------------------------------------ENG STAMP TOOL-------------------------------------------------

    var ENG_StampTool = window.createStampTool(instance,294,180,'/erp/img/eng_stamp.png','Stamp');



 //-------------------------------------KIA OP STAMP TOOL-------------------------------------------------

    var OP_StampTool = window.createStampTool(instance,294,180,'/erp/img/au_stamp.png','Stamp');
    
    
    


 //-------------------------------------ANS STAMP TOOL-------------------------------------------------

    var ANS_StampTool = window.createStampTool(instance,294,180,'/erp/img/ans_stamp.png','Stamp');
    
    
//-------------------signature tool----------------------------------

    var SIGN_StampTool = window.createStampTool(instance,201,86,'/erp/'+user.signature,'Signature');
 
 let map = new Map();
//-----------------------------MD STAMP----------------------------------------------
const stampImage='https://rac.co.rw/erp/img/stampImage.jpg';


 instance.registerTool({
  toolObject: MD_StampTool, 
  toolName: 'MDstampTool', 
  buttonImage:stampImage,
  buttonName: 'MDstampToolButton',
  tooltip: 'RAC Stamp'});

 map.set('MD', 'MDstampToolButton'); 
    map.set('AAMD', 'MDstampToolButton'); 
     map.set('ADLO', 'MDstampToolButton'); 
     map.set('ADVMD','MDstampToolButton');
    

 instance.updateTool('MDstampTool', {
      buttonGroup: 'miscTools'
    });

//--------------------------------------------DMD STAMP---------------------------------------------

const stampImage1='https://rac.co.rw/erp/img/dmd_stamp_image.png';

  instance.registerTool({
  toolObject:  DMD_StampTool, 
  toolName: 'DMDstampTool', 
  buttonImage:stampImage1,
  buttonName: 'DMDstampToolButton',
  tooltip: 'DMD Office Stamp'});


     map.set('DMD', 'DMDstampToolButton'); 
     map.set('AADMD', 'DMDstampToolButton'); 
    
     
     instance.updateTool('DMDstampTool', {
      buttonGroup: 'miscTools'
    });
    
    
//---------------------------------FINANCE STAMP------------------------------------------------------

const stampImage2='https://rac.co.rw/erp/img/fin_stamp_image.png';

  
  instance.registerTool({
  toolObject: FIN_StampTool, 
  toolName: 'FINstampTool', 
  buttonImage:stampImage2,
  buttonName: 'FINstampToolButton',
  tooltip: 'Director Finance Stamp'});


     map.set('DAF', 'FINstampToolButton'); 
     map.set('AADAF', 'FINstampToolButton');

   instance.updateTool('FINstampTool', {
      buttonGroup: 'miscTools'
    });     

 //-----------------------------------------------HR STAMP----------------------------------------------------

const stampImage3='https://rac.co.rw/erp/img/hr_stamp_image.png';

  
  instance.registerTool({
  toolObject: HR_StampTool, 
  toolName: 'HRstampTool', 
  buttonImage:stampImage3,
  buttonName: 'HRstampToolButton',
  tooltip: 'Director Human Resource'});


    
     map.set('DHR', 'HRstampToolButton'); 
     map.set('AADHR', 'HRstampToolButton');
     
    instance.updateTool('HRstampTool', {
      buttonGroup: 'miscTools'
    });
   
 //--------------------------------ENGINEERING STAMP-----------------------------------------------------

const stampImage4='https://rac.co.rw/erp/img/eng_stamp_image.png';

  
  instance.registerTool({
  toolObject: ENG_StampTool, 
  toolName: 'ENGstampTool', 
  buttonImage:stampImage4,
  buttonName: 'ENGstampToolButton',
  tooltip: 'Director Eng&M Stamp'});


    
     map.set('DEMS', 'ENGstampToolButton'); 
     map.set('AADEMS', 'ENGstampToolButton');
     
      instance.updateTool('ENGstampTool', {
      buttonGroup: 'miscTools'
    });
   
//----------------------------------------AU STAMP-----------------------------------------------------
const stampImage5='https://rac.co.rw/erp/img/au_stamp_image.png';

  
  instance.registerTool({
  toolObject: OP_StampTool, 
  toolName: 'AUstampTool', 
  buttonImage:stampImage5,
  buttonName: 'AUstampToolButton',
  tooltip: 'Director AU Stamp'});

 
   
     map.set('DAU', 'AUstampToolButton'); 
     map.set('AADAU', 'AUstampToolButton');
     
      instance.updateTool('AUstampTool', {
      buttonGroup: 'miscTools'
    });
   
    //----------------------------------------ANS STAMP-----------------------------------------------------
const stampImage6='https://rac.co.rw/erp/img/ans_stamp_image.png';

  
  instance.registerTool({
  toolObject: ANS_StampTool, 
  toolName: 'ANSstampTool', 
  buttonImage:stampImage6,
  buttonName: 'ANSstampToolButton',
  tooltip: 'Director ANS Stamp'});


     map.set('DANS', 'ANSstampToolButton'); 
     map.set('AADANS', 'ANSstampToolButton');
     
    instance.updateTool('ANSstampTool', {
      buttonGroup: 'miscTools'
    });
   
 
  //--------------------------------adding signature----------------------------------------------------------
  
  var  signatureImage;
  var signatureImageButton='/erp/img/signature-300x239.png';

  instance.registerTool({
  toolObject: SIGN_StampTool, 
  toolName: 'SIG', 
  buttonImage:signatureImageButton,
  buttonName: 'customSignatureToolButton',
  tooltip:user.fn+' Signature'});

 // Add tool button in header
   instance.setHeaderItems(function(header) {
     header.get('freeHandToolGroupButton').insertBefore({
        type: 'toolButton',
        toolName: 'SIG',
        //hidden: ['tablet', 'mobile']
      });
     /* header.getHeader('tools').get('freeHandToolGroupButton').insertBefore({
        type: 'toolButton',
        toolName: 'CustomSignatureTool',
        hidden: ['tablet', 'mobile']
      });*/
    });    
  
 
instance.disableElements([ 'calloutToolButton', 'stampToolButton','cropToolButton' ,'eraserToolButton']); 

 instance.enableElements(['selectToolButton' ]);

map.forEach( (value, key, map) => {
  
  instance.disableElements([value]);  
     
    
});

if(map.has(user.pos_code_u)){
    
    instance.enableElements([map.get(user.pos_code_u)]);
}

if(map.has(user.pos_code_int)){
 
  instance.enableElements([map.get(user.pos_code_int)]);   
    
}

if(user.role==='Admin'){
   
   map.forEach( (value, key, map) => {
  
  instance.enableElements([value]);  
     
    
}); 
    
}


 
    // call methods from instance, docViewer and annotManager as needed
   docViewer.on('documentLoaded', function() {
     
     if(serverUrl!='#' && serverUrl)
     loadXfdfString(id,serverUrl).then(function(rows) {
     
      if(rows && rows.length){
       JSON.parse(rows).forEach(col => {
           var annotations ;
           if(col.annotation_id!==null){
             
             
              //annotations = annotManager.importAnnotCommand(col.annotation);  
            annotManager.importAnnotCommand(col.annotation)
  .then(importedAnnotations => {
    annotManager.drawAnnotationsFromList(importedAnnotations);
  });  
               
           }else{
               
               //annotations = annotManager.importAnnotations(col.annotation);
               
               annotManager
  .importAnnotations(col.annotation)
  .then(importedAnnotations => {
   annotManager.drawAnnotationsFromList(importedAnnotations );
  });
           }
      
        
      });
      }
      
    }); 
    
 

   
  
      
      
   
    
    
 
   annotManager.on('annotationChanged', function(annotations, action, { imported } ) {

  if (imported) return;
  
  
    
   
    if (action === 'add') {
      
    
       //const xfdfStrings = annotManager.getAnnotCommand();
      
      annotations.forEach(function(annot) {
          
       if(annot.Subject==='Signature' || annot.Subject==='Stamp'){
          
          annot.Printable = true;
         
      }else{ annot.Printable = false;}
      
       
     annot.Author=annotManager.getCurrentUser();  
           
      annotManager.exportAnnotCommand().then(xfdfStrings => {
 
  savexfdfString(id,serverUrl,annot.Id, xfdfStrings,'add',annot.Type).then(function() {
       instance.setToolMode('TextSelect'); 
       
       if(annot.Type==='Signature' || annot.Type==='Stamp' ){
          
                  Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: annot.Type+ ' added !',
  showConfirmButton: false,
  timer: 1500
})
       }
         
          
        });
});

    });
    
       
      
   
     
     
 
     
 
    
    }
    else if (action === 'modify') {
       
   
     annotations.forEach(function(annot) {
          
      if(annot.VD===null){
          
       annotManager.setCurrentUser(user.fn+" "+user.ln+" /"+user.pos);   
          
          
      }
      
        annotManager.getAnnotCommand().then(xfdfStrings => {
 
 updatexfdfString(id,serverUrl,annot.Id, xfdfStrings,'update').then(function() {
          
         
        });
});
     
     
    });
    } 
    else if (action === 'delete') {
      
      
     
      annotations.forEach(function(annot) {
        var annotType=annot.Type;
        deletexfdfString(id,serverUrl,annot.Id,'delete').then(function() {
            Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: annotType+ ' deleted !',
  showConfirmButton: false,
  timer: 1500
})
          
        });
    });
       
    }

    
    
    
  });     
       

     
       
   });
  
    var files = document.getElementsByClassName("doc-file");

for (var i=0; i <  files.length; i++) {
    files[i].onclick = function(e){
        
        e.preventDefault();
  
 instance.loadDocument(e.target.href);
  
 

    
    }
};    
      
      
  });


 
	}
	

 function getBase64Image(imgUrl, callback) {

    var img = new Image();

    // onload fires when the image is fully loadded, and has width and height

    img.onload = function(){

      var canvas = document.createElement("canvas");
      canvas.width = img.width;
      canvas.height = img.height;
      var ctx = canvas.getContext("2d");
      ctx.drawImage(img, 0, 0);
      var dataURL = canvas.toDataURL("image/png");
          //dataURL = dataURL.replace(/^data:image\/(png|jpg);base64,/, "");

      callback(dataURL); // the base64 string

    };

    // set attributes and src 
    img.setAttribute('crossOrigin', 'anonymous'); //
    img.src = imgUrl;

}



function getBase64FromImageUrl(url) {
  return new Promise(function(resolve){
    var img = new Image();
    img.setAttribute('crossOrigin', 'anonymous');

    img.onload = function () {
      var canvas = document.createElement('canvas');
      canvas.width = this.width;
      canvas.height = this.height;

      var ctx = canvas.getContext('2d');
      ctx.drawImage(this, 0, 0);

      var dataURL = canvas.toDataURL('image/png');
      resolve(dataURL);
    };
  img.src = url;
  });
}

// Make a POST request with document ID, annotation ID and XFDF string
var savexfdfString = function(documentId,serverUrl,annotationId, xfdfString,command,type) {
  return new Promise(function(resolve) {
    fetch(serverUrl+'?documentId='+documentId, {
      method: 'POST',
      body: JSON.stringify({
        annotationId,
        xfdfString,
        command,
        type
      })
    }).then(function(res) {
      
      if (res.status === 200) {
       
      
        resolve();
      }
    });
  });
};

// Make a POST request with document ID, annotation ID and XFDF string
var deletexfdfString = function(documentId,serverUrl,annotationId,command) {
  return new Promise(function(resolve) {
    fetch(serverUrl+'?documentId='+documentId, {
      method: 'POST',
      body: JSON.stringify({
        annotationId,
        command
      })
    }).then(function(res) {
       res.text().then(function(data) {
          
          resolve();
        })
    });
  });
};

// Make a POST request with document ID, annotation ID and XFDF string
var updatexfdfString = function(documentId,serverUrl,annotationId,xfdfString,command) {
  return new Promise(function(resolve) {
    fetch(serverUrl+'?documentId='+documentId, {
      method: 'POST',
      body: JSON.stringify({
        annotationId,
        xfdfString,
        command
      })
    }).then(function(res) {
        
      if (res.status === 200) {
       
      
        resolve();
      }
    });
  });
};

// Make a GET request to get XFDF string
var loadXfdfString = function(documentId,serverUrl) {
 if(documentId !=="" && serverUrl!="" )
  return new Promise(function(resolve) {
    fetch(serverUrl+'?documentId='+documentId, {
      method: 'GET'
    }).then(function(res) {
      if (res.status === 200) {
        res.text().then(function(rows) {
            
          resolve(rows);
        })
      }
    });
  });
};