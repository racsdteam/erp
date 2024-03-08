

	function showViewer(fullpath,serverUrl,id,author,vcontainer){
	
	var myObj = {
  author:author
};
var viewerElement = document.getElementById(vcontainer);

  
  var myWebViewer = new PDFTron.WebViewer({
    path: 'https://rac.co.rw/erp/lib',
    l:'Rwanda Airports Company(rac.co.rw):ENTERP:RAC ERP::B+:AMS(20200310):A2A591AD0457A60A3360B13AC9A2737820616F996CB37A0595857BAA1AE768AE62B431F5C7',
    initialDoc:fullpath,
    documentType: 'pdf',
    custom: JSON.stringify(myObj),
    config: "https://rac.co.rw/erp/lib/config.js",
    serverUrl: serverUrl,
    documentId:id
    // replace with your own PDF file
    // optionally use WebViewer Server backend, demo.pdftron.com would later need to be replaced with your own server
    // pdftronServer: 'https://demo.pdftron.com'
  }, viewerElement);
 
	}
/*
viewerElement.addEventListener('ready', function() {
    var viewerInstance = myWebViewer.getInstance(); // instance is ready here

    var docViewer =viewerInstance.docViewer;
    // Call APIs here
  });*/