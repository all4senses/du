(function ($) {
  Drupal.behaviors.du_add_advancedSlider = {
    attach: function (context, settings) {

               var sl;
               var current_slide_index = 0;
               
              
               sl = $('.advanced-slider').advancedSlider({
                 
                      slideshow: false,
                 
                        width: '100%', 
									 		 height: '100%', 
											 skin: 'minimal-small', 
										   	 shuffle: true, 
										   	 slideshowControls: true, 
										   	 slideshowControlsToggle: false, 
										   	 pauseSlideshowOnHover: true, 
										   	 slideArrowsToggle: false, 
										   	 slideButtonsNumber: true,
										   	 timerAnimationControls: false,
										   	 timerRadius: 20, 
											 timerStrokeColor1: '#ffffff', 
											 timerStrokeColor2: '#000000', 
											 timerStrokeOpacity1: 0.8, 
											 timerStrokeWidth1: 6, 
											 timerStrokeWidth2: 3, 

										   	 slideLoop: true,
										   	 overrideTransition: true,

                        effectType: 'slice',//'swipe',
												pauseSlideshowOnHover: true,
												swipeThreshold: 50,
                        
                        lightbox: true,
                        shadow: false,
                      
                      
                        /*
                        //width: '80%',
												//height: '70%',
                        
                        width: '99%',
                        height: '99%',
                        scaleType: 'insideFit',
                        
												//scaleType: 'proportionalFit', //'insideFit', 'exactFit',
                        
                        shadow: false,
                        slideMask: true,
                        //alignType: 'rightTop',
                        
                        skin: 'minimal-small', //'glossy-curved-rounded-violet', // 'glossy-square-blue',
                        //scrollbarSkin:'scrollbar-3-light', 
                        thumbnailsType:'navigation', 
                        thumbnailScrollbar:true,
                        
                        captionToggle: true,
                        
												effectType: 'slice',//'swipe',
												pauseSlideshowOnHover: true,
												swipeThreshold: 50,
                        
                        ////lightbox: true,
                        //shadow: false,
                        
                        //slideButtons: false,
												//thumbnailType: 'scroller',
                        //
												//thumbnailButtons: true,
                        thumbnailScrollerToggle: true,
												thumbnailScrollerResponsive: true,
												minimumVisibleThumbnails: 2,
                        
												//slideArrowsToggle: false,
												slideProperties:{
													0:{captionSize: 35, captionHideEffect: 'slide'},
													1:{captionPosition: 'custom', captionShowEffect: 'fade', captionHeight: 160, captionLeft: 70, slideshowDelay: 10000},
													3:{captionSize: 40},
													5:{captionPosition: 'left', captionSize: 150, captionHideEffect: 'slide'},
													7:{captionPosition: 'right', captionSize: 150, captionHideEffect: 'slide'}
												},
                        */
                        
                        transitionStart: startTransition,
                        transitionComplete: completeTransition
            		});

                var total_slides = sl.totalSlides();

                /*
                // set the initial height of the slider to 50% from the width
                $('.advanced-slider').css('height', $('.advanced-slider').width() * 0.20);
                
                
                $('.advanced-slider').advancedSlider().doSliderLayout();

                // as the window resizes, maintain the slider's height at 20% from the width
                $(window).resize(function() {
                  $('.advanced-slider').css('height', $('.advanced-slider').width() * 0.20);
                });
                */
      
      
      
                function completeTransition(event) {
                 
                  current_slide = sl.getSlideAt(event.index);
                 
                  $(current_slide.html).addClass('in');
                  current_slide_index = event.index;

                  // Doesn't work
                  /*
                  current_slide.html.each(function(){
                    $(this).addClass('in');
                  });
                  */
                }
                
                
                function startTransition(event) {
                 
                  previous_slide_index = current_slide_index;
                  
                  if (sl) {
                    previous_slide = sl.getSlideAt(previous_slide_index);
                 
                    $(previous_slide.html).removeClass('in');
                  }
                 
                }
                        
        
    }
  };
  
}(jQuery));