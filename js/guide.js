(function($) {
    
	var steps = [{
	  content: '<p>First look at this thing</p>',
	  highlightTarget: true,
	  nextButton: true,
	  target: jQuery('#derweili_mbot_verify_token'),
	  my: 'top center',
	  at: 'top center'
	}, {
	  content: '<p>And then at this thing</p>',
	  highlightTarget: true,
	  nextButton: true,
	  target: jQuery('#derweili_mbot_page_token'),
	  my: 'top center',
	  at: 'top center'
	}]

	var tour = new Tourist.Tour({
	  steps: steps,
	  tipClass: 'Bootstrap',
	  tipOptions:{ showEffect: 'slidein' }
	});

	tour.start();
	console.log(tour);
	//alert("test");


}(jQuery));