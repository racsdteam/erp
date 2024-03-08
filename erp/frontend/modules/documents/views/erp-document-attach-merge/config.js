
   
   
$(document).on('viewerLoaded', function() {
  docViewer.setMargin(20);
 
  docViewer.on('fitModeUpdated', function(e, fitMode) {
    console.log('fit mode changed');
    console.log(docViewer.getZoom());
  });

 var annotManager = docViewer.getAnnotationManager();
  annotManager.on('annotationChanged', function(event, annotations, action) {
    if (action === 'add') {
      console.log('this is a change that added annotations');
      readerControl.saveAnnotations();
    } else if (action === 'modify') {
      console.log('this change modified annotations');
    } else if (action === 'delete') {
      console.log('there were annotations deleted');
    }

    annotations.forEach(function(annot) {
      console.log('annotation page number', annot.PageNumber);
    });
  });
  
});


;