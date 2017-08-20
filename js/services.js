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
});
