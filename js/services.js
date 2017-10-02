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
	
	});
	
	$('#addNote').click(function(){
		//get all information
		var item = $('#servicesEinkaufszettel').find('#item').val();
		var amount = $('#servicesEinkaufszettel').find('#amount').val();
		var unit = $('#servicesEinkaufszettel').find('#unit').val();
		
		lastEntry = $('#servicesEinkaufszettel').find('.confirmedNote ').last();
		
		//push them to DB
		$.ajax({
						url: 'einkaufszettel.php',
						data: {
							   item			  : item, 
							   amount		  : amount,
							   unit			  : unit,
							   insertNoteItem : 1
							   },
						type: 'POST',
						success: function(response){
							//append new item to list
								if(lastEntry.length == 0) {
									$('.shopping-list').prepend(  '<li class="confirmedNote">'+
													  '<div class="row note">'+
													  '<div class="col-md-2 col-2">'+
													  '<div class="checkbox">'+
													  '<input type="checkbox" value="" class="checkNoteItem">'+
													  '</div>'+
													  '</div>'+
										          	  '<div class="col-md-6 col-6 item">'+item+'</div>'+
										          	  '<div class="col-md-3 col-3 amount">'+amount+' '+unit+'</div>'+
										          	  '<div class="col-md-1 col-1 deleteNote">✗</div>'+
										        	  '</div>'+
										        	  '</li>'
										        	  );
								}
								else{
									
									$(  '<li class="confirmedNote">'+
													  '<div class="row note">'+
													  '<div class="col-md-2 col-2">'+
													  '<div class="checkbox">'+
													  '<input type="checkbox" value="" class="checkNoteItem">'+
													  '</div>'+
													  '</div>'+
										          	  '<div class="col-md-6 col-6 item">'+item+'</div>'+
										          	  '<div class="col-md-3 col-3 amount">'+amount+' '+unit+'</div>'+
										          	  '<div class="col-md-1 col-1 deleteNote">✗</div>'+
										        	  '</div>'+
										        	  '</li>'
										        	   ).insertAfter(lastEntry);
								}
									
								//clear Input
								$('#servicesEinkaufszettel').find('#item').val('');
								amount = $('#servicesEinkaufszettel').find('#amount').val('');
								unit = $('#servicesEinkaufszettel').find('#unit').val('g');		  			
							
						},
						error: function(e){		    			
							
							swal('Es ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.');
						}
					});
		
	
	});
	
	//delegated event with .on handler for dynamic content
	$('.shopping-list').on('click','.deleteNote', function() {
		$(this).parents('.confirmedNote').remove();
	});
	
	
	 $(".checkNoteItem").change(function() {
        if($(this).prop('checked') == true) {
            $(this).parents('.note ').children('.item').addClass('noteItemDone');
        } else {
            $(this).parents('.note').removeClass('noteItemDone');
        }
    });
    
    
	
});


