window.createStampTool = function(instance,w,h,url,type) {
  var docViewer = instance.docViewer;
  var annotManager = instance.annotManager;
  var Annotations = instance.Annotations;
  var Tools = instance.Tools;

  // Custom stamp tool constructor that inherits generic annotation create tool
  var StampCreateTool = function() {
    // Inherit generic annotation create tool
    Tools.GenericAnnotationCreateTool.call(this, docViewer, Annotations.StampAnnotation);
    delete this.defaults.StrokeColor;
    delete this.defaults.FillColor;
    delete this.defaults.StrokeThickness;
  };

  StampCreateTool.prototype = new Tools.GenericAnnotationCreateTool();
  // Override mouseLeftDown
  StampCreateTool.prototype.mouseLeftDown = Tools.AnnotationSelectTool.prototype.mouseLeftDown;

  // Override mouseMove
  StampCreateTool.prototype.mouseMove = Tools.AnnotationSelectTool.prototype.mouseMove;

  // Override mouseLeftUp
  /*jshint -W025 */
  StampCreateTool.prototype.mouseLeftUp = async function(e) {
    Tools.GenericAnnotationCreateTool.prototype.mouseLeftDown.call(this, e);
    var annotation;
    if (this.annotation) {
      var width = w;
      var height =h;
      var rotation = this.docViewer.getCompleteRotation(this.annotation.PageNumber) * 90;
      this.annotation.Rotation = rotation;
      if (rotation === 270 || rotation === 90) {
        var t = height;
        height = width;
        width = t;
      }
      // 'ImageData' can be a bas64 ImageString or an URL. If it's an URL, relative paths will cause issues when downloading
      this.annotation.ImageData = await getBase64FromImageUrl(url);
      this.annotation.Width = width;
      this.annotation.Height = height;
      this.annotation.X -= width / 2;
      this.annotation.Y -= height / 2;
      this.annotation.MaintainAspectRatio = true;
      this.annotation.Type=type;
      annotation = this.annotation;
    }

    Tools.GenericAnnotationCreateTool.prototype.mouseLeftUp.call(this, e);

    if (annotation) {
      annotManager.redrawAnnotation(annotation);
    }
  }

  return new StampCreateTool();
};

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