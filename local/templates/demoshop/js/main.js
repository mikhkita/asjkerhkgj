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
   		arrows: false,
        dots: true
 	});
    var slideout = new Slideout({
      'panel': document.getElementById('panel'),
      'menu': document.getElementById('menu'),
      'padding': 300,
      'tolerance': 70,
      'side': 'right',
      'touch': false
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
    slideout.once('open', slideout._initTouchEvents);
    slideout.on('open', slideout.enableTouch);
    slideout.on('close', slideout.disableTouch);
    document.querySelector('.toggle-button').addEventListener('click', function() {
    slideout.toggle();
    });

  // var filter = $('#left').html(),
  //     mfilter = $('.mobile-filter').html();

  //$('.mobile-filter').html($('#left'));

    $(window).resize(resize);
    resize();

    if (myWidth <= 767){
        $('.mobile-filter').html($('#left'));
    }

    if (document.getElementById('left')) {

        $('#old-meta-title').html(document.title);
        $('#old-navi-chain').html( $('#chain-hint').html() );
        objFilter.setOrder(huitaOrder);
        objFilter.init(
            huita[0],
            huita[1],
            huita[2],
            huita[3],
            huita[4],
            huita[5],
            huita[6],
            huita[7],
            huita[8],
            huita[9],
            huita[10],
            huita[11],
            huita[12],
            huita[13],
            huita[14],
            huita[15],
            huita[16],
            huita[17],
            huita[18]
        );
        $('.accordion-toggle').each(function(){
            var element = $(this).attr('href');
            if($.trim(element)!="")
            {
                var cookieName = $(element).attr('id');
                if(readCookie(cookieName) == 'true')
                {
                    $(element).addClass('in');
                    $(element).removeClass('height0');
                } else {
                    $(element).removeClass('in');
                    if(cookieName=='collapse-SECTION_CODE'){
                        $(element).addClass('height0');
                    }
                    $(".accordion-toggle").each(function(){
                        if($(this).attr("href")==element){
                            $(this).addClass('collapsed');
                        }
                    });
                    
                }
            }
        });
        $('.accordion-toggle').click(function(){
            var element = $(this).attr('href');
            if($.trim(element)!="")
            {
                $(element).removeClass('height0');
                var inClass = !$(element).hasClass('in');
                var cookieName = $(element).attr('id');
                createCookie(cookieName,inClass,365);
            }
        });
    }
    if (document.getElementById('left')){
        $(" #filter-hider ").addClass("show");
        $(" #accordion1 ").addClass("show");
    }
});

