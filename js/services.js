/**
 * @author Daniel
 */

$(document).ready(function(){
	
	$("#addEinkauf").click(function(){
		
		swal.setDefaults({
		  input: 'text',
		  confirmButtonText: 'Weiter &rarr;',
		  showCancelButton: true,
		  animation: false,
		  progressSteps: ['1', '2', '3']
		});

		var steps = [
		  {
		    title: 'Kassenzettel',
		    text: 'Möchtest du einen Kassenzettel hochladen?'
		  },
		  'Question 2',
		  'Question 3'
		];

		swal.queue(steps).then(function (result) {
			
			swal.resetDefaults();
  			swal({
    			title: 'All done!',
    			html:
      				'Your answers: <pre>' +
        			JSON.stringify(result) +
      				'</pre>',
    			confirmButtonText: 'Lovely!'
  			});
  			
		}, function () {
  			swal.resetDefaults();
		});
	
	});
	
	$("#addEinkaufszettel").click(function(){
		
		$("#servicesEinkaufszettel").modal();
		$('input[type=checkbox]').removeAttr('checked');
		$('#einkaufszettelCheckbox').change(function() {
        if(this.checked) {
            var returnVal = confirm("Are you sure?");
            $(this).prop("checked", returnVal);
            inputValue = $("#einkaufszettelInput")[0].value;
            console.log($("list-group"));
        	$("list-group").prepend(('<li> ' + inputValue + '</li>'));
        	$('input[type=checkbox]').removeAttr('checked');
        	console.log($('input[type=checkbox]'));
        }
        alert(this.checked);        
        });
	});
	
	
});
