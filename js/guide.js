(function($) {
    
	/*var steps = [{
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
	//alert("test");*/

STEP_OPTIONS = {
    one: 1,
    two: 2
  };

  STEPS = [{
    content: "<p>Please enter the ID of the \
     Facebook Page you want to connect. \
     <a href=\"#TB_inline?width=600&height=550&inlineId=derweiliThickboxPageID\" class=\"thickbox\">Where can I find the Page ID?</a> \
     </p>",
    highlightTarget: true,
    nextButton: true,
    target: $('#derweili_mbot_page_id'),
    my: 'top center',
    at: 'bottom center'
  },{
    content: '<p>Please enter the ID of you Facebook App \
    	<a href=\"#TB_inline?width=600&height=550&inlineId=derweiliThickboxAppID\" class=\"thickbox\">Don\'t know where to find the App ID or what a Facebook App is?</a> \
    </p>',
    highlightTarget: true,
    nextButton: true,
    target: $('#derweili_mbot_messenger_app_id'),
    my: 'top center',
    at: 'bottom center'
  },{
    content: '<p>Please enter the Page Token. \
    	<a href=\"#TB_inline?width=600&height=550&inlineId=derweiliThickboxPageToken\" class=\"thickbox\">Where do I get the Page Token?</a> \
    </p>',
    highlightTarget: true,
    nextButton: true,
    target: $('#derweili_mbot_page_token'),
    my: 'top center',
    at: 'bottom center'
  },{
    content: '<p>Please add a unique verify token.</p>',
    highlightTarget: true,
    nextButton: true,
    target: $('#derweili_mbot_verify_token'),
    my: 'top center',
    at: 'bottom center'
  }]

  TOUR = new Tourist.Tour({
    stepOptions: STEP_OPTIONS,
    steps: STEPS,
    //cancelStep: @finalQuit
    //successStep: @finalSucceed
    tipClass: 'QTip',
    tipOptions:{
      style: {
        classes: 'qtip-tour qtip-bootstrap'
      }
    }
  });
  //TOUR.start();

  $('#mbot_settings_tutorial_button').click(function(e){
  	TOUR.start();
  })


}(jQuery));