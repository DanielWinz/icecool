/**
 *  The three service functionalities are provided in this file.
 *  1) APPLY PURCHASE
 * 	2) WRITE SHOPPING LIST
 * 	   a) FETCH SHOPPING LIST
 * 	   b) WRITE SHOPPING NOTE
 *     c) DELETE SHOPPING ITEM
 * 	   d) HANDLING DONE PROPERTY
 * 	3) SEE STORED ITEMS
 */

$(document).ready(function(){
	
	// =============================================================
    // 1) APPLY PURCHASE
    // =============================================================
	
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
	
	// =============================================================
    // 2) WRITE SHOPPING LIST
    // =============================================================
    
    //a) FETCH SHOPPING LIST
	$("#addEinkaufszettel").click(function(){
		
		
		$.ajax({
		url: 'php/einkaufszettel.php',
        type: 'POST', 
        data: {fetchAllNotes : 1},
        async: false,
        success: function(s){
        
        	notes = jQuery.parseJSON(s);
        	$.each(notes, function(i,prop){
        		// checked="false" is not possible => changing prop erledigt to "checked" / ""
        		if(prop.erledigt == false) {
        			prop.erledigt = "";
        		}
        		else if(prop.erledigt == true) {
        			prop.erledigt = "checked";
        		}
        		
        		
        		$('.shopping-list').prepend(  '<li class="confirmedNote"  id='+prop.id+'>'+
													  '<div class="row note">'+
													  '<div class="col-md-2 col-2">'+
													  '<div class="checkbox">'+
													  '<input type="checkbox" value="" class="checkNoteItem" '+prop.erledigt+'>'+
													  '</div>'+
													  '</div>'+
										          	  '<div class="col-md-6 col-6 item">'+prop.name+'</div>'+
										          	  '<div class="col-md-3 col-3 amount">'+prop.menge+' '+prop.einheit+'</div>'+
										          	  '<div class="col-md-1 col-1 deleteNote">✗</div>'+
										        	  '</div>'+
										        	  '</li>'
										        	  );
				
        		
        		
        	});
        	
       },
       error: function(e){		    			
				swal('Es ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.');
		}
       
	});
		$('.shopping-list').find('.checkNoteItem:checked').parents('.note').children('.item').addClass('noteItemDone');
		$("#servicesEinkaufszettel").modal();
	
	});
	
	//b) WRITE SHOPPING NOTE
	$('#addNote').click(function(){
		//get all information
		var item = $('#servicesEinkaufszettel').find('#item').val();
		var amount = $('#servicesEinkaufszettel').find('#amount').val();
		var unit = $('#servicesEinkaufszettel').find('#unit').val();
		
		lastEntry = $('#servicesEinkaufszettel').find('.confirmedNote ').last();
		
		//push them to DB
		$.ajax({
						url: 'php/einkaufszettel.php',
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
	
	//c) DELETE SHOPPING ITEM
	//delegated event with .on handler for dynamic content => deleting Item
	$('.shopping-list').on('click','.deleteNote', function() {
		deleteId = $(this).parents('.confirmedNote').attr('id');
		element = $(this);
		$.ajax({
			url: 'php/einkaufszettel.php',
	        type: 'POST', 
	        data: {
	        		id: deleteId,
	        		deleteItem : 1},
	        async: false,
	        success: function(s){
	        	element.parents('.confirmedNote').fadeOut();
	        },
	        error: function(e){
	        	swal('Es ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.');
	        }
	  });
        	
		
	});
	
	//d) HANDLING DONE PROPERTY
	// Eventhandler for adding done property
	 $('.shopping-list').on('change', '.checkNoteItem', function() {
        if($(this).prop('checked') == true) {
            $(this).parents('.note ').children('.item').addClass('noteItemDone');
        } else if($(this).prop('checked') == false) {
            $(this).parents('.note').children('.item').removeClass('noteItemDone');
        }
    });
    
    
	
});






