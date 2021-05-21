 $(document).ready(function() {

     (function($) {
         $.fn.menumaker = function(options) {
             var cssmenu = $(this),
                 settings = $.extend({
                     //title: "",
                     format: "dropdown",
                     sticky: false
                 }, options);

             return this.each(function() {
                 cssmenu.prepend('<div id="menu-button">' + settings.title + '</div>');
                 $(this).find("#menu-button").on('click', function() {
                     $(this).toggleClass('menu-opened');
                     var mainmenu = $(this).next('ul');
                     if (mainmenu.hasClass('open')) {
                         mainmenu.slideToggle().removeClass('open');
                     } else {
                         mainmenu.slideToggle().addClass('open');
                         if (settings.format === "dropdown") {
                             mainmenu.find('ul').slideToggle();
                         }
                     }
                 });

                 cssmenu.find('li ul').parent().addClass('has-sub');

                 multiTg = function() {
                     cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
                     cssmenu.find('.submenu-button').on('click', function() {
                         $(this).toggleClass('submenu-opened');
                         if ($(this).siblings('ul').hasClass('open')) {
                             $(this).siblings('ul').removeClass('open').slideToggle();
                         } else {
                             $(this).siblings('ul').addClass('open').slideToggle();
                         }
                     });
                 };

                 if (settings.format === 'multitoggle') multiTg();
                 else cssmenu.addClass('dropdown');

                 if (settings.sticky === true) cssmenu.css('position', 'fixed');

                 resizeFix = function() {
                     if ($(window).width() > 991) {
                         cssmenu.find('ul').show();
                     }

                     if ($(window).width() <= 991) {
                         cssmenu.find('ul').hide().removeClass('open');
                     }
                 };
                 resizeFix();
                 return $(window).on('resize', resizeFix);

             });
         };
     })(jQuery);


     (function($) {
         $(document).ready(function() {

             $("#cssmenu").menumaker({
                 title: "",
                 format: "multitoggle"
             });

         });
     })(jQuery);

     $('#cssmenu > ul > li > a').click(function() {
         $('#cssmenu > ul > li > a').removeClass("active");
         $(this).addClass("active");
     });

     $('.list-filter a').click(function() {
         $('.list-filter a').removeClass("active");
         $(this).addClass("active");
     });

     $('.page-item a').click(function() {
         $('.page-item a').removeClass("active");
         $(this).addClass("active");
     });



     $('.gred-icons li').click(function() {
         $('.gred-icons li').removeClass("active");
         $(this).addClass("active");
     });

     $('.grad-row').click(function() {
         $('.item').addClass("active");
     });

     $('.grad-col').click(function() {
         $('.item').removeClass("active");
     });


     $(window).scroll(function() {
         if ($(this).scrollTop() > 1) {
             $('.header').addClass("sticky");
         } else {
             if ($(this).scrollTop() < 1) {
                 $('.header').removeClass("sticky");
             }
         }
     });


     ////////// Start Responsive css Menu


     jQuery(function() {
         jQuery("a.bla-2").YouTubePopUp({ autoplay: 1 }); // Disable autoplay
     });

     $('.seller-slider').slick({
         dots: true,
         infinite: true,
         speed: 2000,
         slidesToShow: 4,
         slidesToScroll: 1,
         autoplay: true,
         autoplaySpeed: 2000,
         responsive: [{
                 breakpoint: 1199,
                 settings: {
                     slidesToShow: 3,
                     slidesToScroll: 1
                 }
             },
             {
                 breakpoint: 991,
                 settings: {
                     slidesToShow: 2,
                     slidesToScroll: 1
                 }
             },


         ]
     });


     $('.partners-slider').slick({
         dots: true,
         infinite: true,
         speed: 2000,
         slidesToShow: 3,
         slidesToScroll: 1,
         autoplay: true,
         autoplaySpeed: 2000,
         responsive: [{
                 breakpoint: 991,
                 settings: {
                     slidesToShow: 2,
                     slidesToScroll: 1
                 }
             },
             {
                 breakpoint: 767,
                 settings: {
                     slidesToShow: 1,
                     slidesToScroll: 1
                 }
             },
         ]
     });

     function spinner() {

     }

     // (function($) {
     //     $('.spinner .btn:first-of-type').on('click', function() {
     //         $('.spinner input').val(parseInt($('.spinner input').val(), 10) + 1);
     //     });
     //     $('.spinner .btn:last-of-type').on('click', function() {
     //         $('.spinner input').val(parseInt($('.spinner input').val(), 10) - 1);
     //     });
     // })(jQuery);


     $('.onshow').click(function() {
         $('.show-card,body').addClass('active');
         $(".overlay").fadeIn("");
     });

     $('.overlay').click(function() {
         $(".show-card,body").removeClass("active");
         $(".overlay").fadeOut("");
     });

     $('.close-card').click(function() {
         $(".show-card,body").removeClass("active");
         $(".overlay").fadeOut("");
     });

     $(".delet-card").on("click", function(e) {
         e.preventDefault();
         $(this).parent().remove();
     });

     //  $('.text-chek').click(function() {
     //      $('.text-chek').removeClass("active");
     //      $(this).addClass("active");
     //  });

     $(".m-bank").click(function() {
         $(".hidebank").slideDown();
     });
     $(".m-cash").click(function() {
         $(".hidebank").slideUp();
     });


     /* 1. Visualizing things on Hover - See next part for action on click */
     $('#stars li').on('mouseover', function() {
         var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

         // Now highlight all the stars that's not after the current hovered star
         $(this).parent().children('li.star').each(function(e) {
             if (e < onStar) {
                 $(this).addClass('hover');
             } else {
                 $(this).removeClass('hover');
             }
         });

     }).on('mouseout', function() {
         $(this).parent().children('li.star').each(function(e) {
             $(this).removeClass('hover');
         });
     });

     /* 2. Action to perform on click */
     $('#stars li').on('click', function() {
         var onStar = parseInt($(this).data('value'), 10); // The star currently selected
         var stars = $(this).parent().children('li.star');

         for (i = 0; i < stars.length; i++) {
             $(stars[i]).removeClass('selected');
         }

         for (i = 0; i < onStar; i++) {
             $(stars[i]).addClass('selected');
         }

         // JUST RESPONSE (Not needed)
         var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
         var msg = "";
         if (ratingValue > 1) {
             msg = "Thanks! You rated this " + ratingValue + " stars.";
         } else {
             msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
         }
         responseMessage(msg);

     });

     lc_lightbox('.elem', {
         wrap_class: 'lcl_fade_oc',
         gallery: true,
         thumb_attr: 'data-lcl-thumb',
         skin: 'minimal',
         radius: 0,
         padding: 0,
         border_w: 0,
     });
     //End slider photo

     var date_input = $('input[name="date"]'); //our date input has the name "date"
     var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
     date_input.datepicker({
         format: 'yyyy/dd/mm',
         container: container,
         todayHighlight: true,
         autoclose: true,
     })


     // Add the following code if you want the name of the file appear on select
     $(".custom-file-input").on("change", function() {
         var fileName = $(this).val().split("\\").pop();
         $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
     });

     $('.add-w').click(function() {
         $(this).toggleClass("active");
     });

     $('.clockpicker').clockpicker()
         .find('input').change(function() {
             console.log(this.value);
         });
 });
