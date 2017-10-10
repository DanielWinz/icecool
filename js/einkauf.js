/**
 * Using the Quagga.js Library for detecting barcodes
 */

$(function() {
    	// Create the QuaggaJS config object for the live stream
    	var liveStreamConfig = {
    			inputStream: {
    				type : "LiveStream",
    				constraints: {
    					width: {min: 640},
    					height: {min: 480},
    					aspectRatio: {min: 1, max: 100},
    					facingMode: "environment" // or "user" for the front camera
    				}
    			},
    			locator: {
    				patchSize: "medium",
    				halfSample: true
    			},
    			numOfWorkers: (navigator.hardwareConcurrency ? navigator.hardwareConcurrency : 4),
    			decoder: {
    				"readers":['ean_reader']
    			},
    			locate: true
    		};
    	// The fallback to the file API requires a different inputStream option. 
    	// The rest is the same 
    	var fileConfig = $.extend(
    			{}, 
    			liveStreamConfig,
    			{
    				inputStream: {
    					size: 800
    				}
    			}
    		);
    	// Start the live stream scanner when the modal opens
    	$('#servicesEinkauf').on('shown.bs.modal', function (e) {
    		Quagga.init(
    			liveStreamConfig, 
    			function(err) {
    				if (err) {
    					$('#servicesEinkauf .modal-body .error').html('<div class="alert alert-danger"><strong><i class="fa fa-exclamation-triangle"></i> '+err.name+'</strong>: '+err.message+'</div>');
    					Quagga.stop();
    					return;
    				}
    				Quagga.start();
    			}
    		);
        });
    	
    	// Make sure, QuaggaJS draws frames an lines around possible 
    	// barcodes on the live stream
    	Quagga.onProcessed(function(result) {
    		var drawingCtx = Quagga.canvas.ctx.overlay,
    			drawingCanvas = Quagga.canvas.dom.overlay;
     
    		if (result) {
    			if (result.boxes) {
    				drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
    				result.boxes.filter(function (box) {
    					return box !== result.box;
    				}).forEach(function (box) {
    					Quagga.ImageDebug.drawPath(box, {x: 0, y: 1}, drawingCtx, {color: "green", lineWidth: 2});
    				});
    			}
     
    			if (result.box) {
    				Quagga.ImageDebug.drawPath(result.box, {x: 0, y: 1}, drawingCtx, {color: "#00F", lineWidth: 2});
    			}
     
    			if (result.codeResult && result.codeResult.code) {
    				Quagga.ImageDebug.drawPath(result.line, {x: 'x', y: 'y'}, drawingCtx, {color: 'red', lineWidth: 3});
    			}
    		}
    	});
    	
    	// Once a barcode had been read successfully, process result to FDDB
    	// stop quagga and display result in the list 
    	Quagga.onDetected(function(result) {    		
    		if (result.codeResult.code){
    		
    			$.ajax({
							url: "php/einkauf.php?ean=" + result.codeResult.code,
							type: "GET",
							success: function(item){
									console.log(item);
							}
						});
		
    			Quagga.stop();			
    		}
    	});
        
    	// Stop quagga in any case, when the modal is closed
        $('#servicesEinkauf').on('hide.bs.modal', function(){
        	if (Quagga){
        		Quagga.stop();	
        	}
        });
    	
    	// Once Button 'Neues Produkt' is pressed restart QuaggaJS
		$('#servicesEinkaufButton').click(function() {
		    Quagga.init(
    			liveStreamConfig, 
    			function(err) {
    				if (err) {
    					$('#servicesEinkauf .modal-body .error').html('<div class="alert alert-danger"><strong><i class="fa fa-exclamation-triangle"></i> '+err.name+'</strong>: '+err.message+'</div>');
    					Quagga.stop();
    					return;
    				}
    				Quagga.start();
    			}
    		);
		});
});

