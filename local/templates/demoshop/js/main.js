$( document ).ready(function() {
    function resize(){
        if( typeof( window.innerWidth ) == 'number' ) {
          myWidth = window.innerWidth;
          myHeight = window.innerHeight;
      } else if( document.documentElement && ( document.documentElement.clientWidth || 
      document.documentElement.clientHeight ) ) {
          myWidth = document.documentElement.clientWidth;
          myHeight = document.documentElement.clientHeight;
      } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
          myWidth = document.body.clientWidth;
          myHeight = document.body.clientHeight;
      }

      if (myWidth > 1152){

      } else if (myWidth > 767) {

      }else {
        $('.mobile-filter').html($('#left'));
      }
    };
  	$( "#accordion" ).accordion({
	  	active: 2,
	  	collapsible: true,
	  	heightStyle: "content"
    });
	$(" #hider ").click(function(){
    	if ($(" #search ").hasClass("show-s")){
    		$(" #search ").removeClass("show-s");
    	} else {
    		$(" #search ").addClass("show-s")
    	}
        return false;
	});
    $(" #filter-hider ").click(function(){
        if ($(" #left ").hasClass("show-f")){
            $(" #left ").removeClass("show-f")
            $('.filter-hide').html("Показать фильтр");
        } else {
            $(" #left ").addClass("show-f")
            $('.filter-hide').html("Скрыть фильтр");
        }
        return false;
    });
	$( " .single-slide " ).slick({
   		infinite: true,
   		speed: 500,
   		slidesToScroll: 1,
   		arrows: false
 	});
  var slideout = new Slideout({
      'panel': document.getElementById('panel'),
      'menu': document.getElementById('menu'),
      'padding': 300,
      'tolerance': 70,
      'side': 'right',
      'touch': 'false'
    });
  
   function close(eve) {
   eve.preventDefault();
   slideout.close();
 }
 slideout
  .on('beforeopen', function() {
    $(" #panel ").addClass("panel-open");
  })
  .on('open', function() {
     this.panel.addEventListener('click', close);
   })
  .on('beforeclose', function() {
    $(" #panel ").removeClass("panel-open");
    this.panel.removeEventListener('click', close);
  });

  // var filter = $('#left').html(),
  //     mfilter = $('.mobile-filter').html();

  //$('.mobile-filter').html($('#left'));

  $(window).resize(resize);
  resize();
  slideout.once('open', slideout._initTouchEvents);
  slideout.on('open', slideout.enableTouch);
  slideout.on('close', slideout.disableTouch);
  document.querySelector('.toggle-button').addEventListener('click', function() {
    slideout.toggle();
  });
  if (!document.getElementById('left')) {
    $(" .filter-hide ").addClass(" hide ");
  }
});

