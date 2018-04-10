
var canvas = document.getElementById('signature-pad');

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

var signaturePad = new SignaturePad(canvas, {
  backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
});

document.getElementById('sbmt-btn').addEventListener('click', function (e) {
    //
  if (signaturePad.isEmpty()) {
    e.preventDefault();
    return alert("Please provide a signature first.");

  }
  
  var data = signaturePad.toDataURL('image/png');
 // alert(data);
  document.getElementById("clientsign").value = data;
  

});


document.getElementById('clear').addEventListener('click', function () {
  signaturePad.clear();
});

