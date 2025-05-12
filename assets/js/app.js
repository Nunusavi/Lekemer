"use strict";

function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : String(i); }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
(function ($) {
  "use strict";

  /*------------------------------------------------------------------
  [Table of contents]
  SOFAX PRELOADER JS INIT
  SOFAX STICKY MENU JS INIT
  SOFAX COUNTER JS INIT
  SOFAX BRAND SLIDER JS INIT
  SOFAX TESTIMONIAL SLIDER JS INIT
  SOFAX TESTIMONIAL SLIDER 2 JS INIT
  SOFAX SLIDER LOGO WRAP JS INIT
  SOFAX INTEGRATION JS INIT
  SOFAX SERVICE CONTENT SLIDER SECTION JS INIT
  SOFAX TESTIMONIAL 2 COLUMN SLIDER JS INIT
  SOFAX MAGNIFIC POPUP JS INIT
  SOFAX TESTIMONIAL SLIDER JS INIT
  SOFAX PORTFOLIO MASONAY FILTER JS
  SOFAX MAP JS INIT
  SOFAX TOGGOLE PASSWOR JS INIT
  SOFAX SPLITING JS INIT
  SOFAX PRICING TABLE JS INIT
  -------------------------------------------------------------------*/

  /*--------------------------------------------------------------
  CUSTOM PRE DEFINE FUNCTION
  ------------------------------------------------------------*/
  /* is_exist() */
  jQuery.fn.is_exist = function () {
    return this.length;
  };
  $(function () {
    /*--------------------------------------------------------------
    SOFAX PRELOADER JS INIT
    --------------------------------------------------------------*/

    $(".sofax-preloader-wrap").fadeOut(100);

    /*--------------------------------------------------------------
    sofax STICKY MENU JS INIT
    --------------------------------------------------------------*/
    $(window).on('scroll', function () {
      if ($(window).scrollTop() > 50) {
        $('#sticky-menu').addClass('sticky-menu');
      } else {
        $('#sticky-menu').removeClass('sticky-menu');
      }
    });

    /*--------------------------------------------------------------
    sofax COUNTER JS INIT
    --------------------------------------------------------------*/
    var sofax_counter = $('#sofax-counter');
    if (sofax_counter.is_exist()) {
      var a = 0;
      $(window).scroll(function () {
        var oTop = $(sofax_counter).offset().top - window.innerHeight;
        if (a == 0 && $(window).scrollTop() > oTop) {
          $('.sofax-counter').each(function () {
            var $this = $(this),
              countTo = $this.attr('data-percentage');
            $({
              countNum: $this.text()
            }).animate({
              countNum: countTo
            }, {
              duration: 4000,
              easing: 'swing',
              step: function step() {
                $this.text(Math.floor(this.countNum));
              },
              complete: function complete() {
                $this.text(this.countNum);
              }
            });
          });
          a = 1;
        }
      });
    }
    /*--------------------------------------------------------------
    SOFAX BRAND SLIDER JS INIT
    --------------------------------------------------------------*/
    var brand_slider = $('.sofax-brand-slider');
    if (brand_slider.is_exist()) {
      brand_slider.slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 8000,
        arrows: false,
        pauseOnHover: false,
        cssEase: 'linear',
        responsive: [{
          breakpoint: 1199,
          settings: {
            slidesToShow: 3
          }
        }, {
          breakpoint: 767,
          settings: {
            slidesToShow: 2
          }
        }]
      });
    }

    /*--------------------------------------------------------------
    SOFAX TESTIMONIAL SLIDER JS INIT
    --------------------------------------------------------------*/
    var t_slider = $('.sofax-testimonial-slider');
    if (t_slider.is_exist()) {
      t_slider.slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 8000,
        arrows: false,
        pauseOnHover: false,
        cssEase: 'linear',
        responsive: [{
          breakpoint: 1349,
          settings: {
            slidesToShow: 2
          }
        }, {
          breakpoint: 767,
          settings: {
            slidesToShow: 1
          }
        }]
      });
    }

    /*--------------------------------------------------------------
    SOFAX TESTIMONIAL SLIDER 2 JS INIT
    --------------------------------------------------------------*/

    var t_slider2 = $('.sofax-testimonial-slider-2');
    if (t_slider2.is_exist()) {
      t_slider2.slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 8000,
        arrows: false,
        pauseOnHover: false,
        rtl: true,
        cssEase: 'linear',
        responsive: [{
          breakpoint: 1349,
          settings: {
            slidesToShow: 2
          }
        }, {
          breakpoint: 767,
          settings: {
            slidesToShow: 1
          }
        }]
      });
    }
    /*--------------------------------------------------------------
    SOFAX SLIDER LOGO WRAP JS INIT
    --------------------------------------------------------------*/

    var slider_logo = $('.sofax-slider-logo-wrap');
    if (slider_logo.is_exist()) {
      slider_logo.slick({
        slidesToShow: 7,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 4000,
        arrows: false,
        pauseOnHover: false,
        cssEase: 'linear',
        responsive: [{
          breakpoint: 1399,
          settings: {
            slidesToShow: 5
          }
        }, {
          breakpoint: 991,
          settings: {
            slidesToShow: 3
          }
        }, {
          breakpoint: 767,
          settings: {
            slidesToShow: 3
          }
        }, {
          breakpoint: 700,
          settings: {
            slidesToShow: 2
          }
        }, {
          breakpoint: 500,
          settings: {
            slidesToShow: 1
          }
        }]
      });
    }
    /*--------------------------------------------------------------
    SOFAX INTEGRATION IMAGES SLIDER JS INIT
    --------------------------------------------------------------*/
    var integration_slider_icon_data = $('.sofax-integration-slider-icon-data');
    if (integration_slider_icon_data.is_exist()) {
      integration_slider_icon_data.slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 5000,
        arrows: false,
        pauseOnHover: false,
        cssEase: 'linear',
        responsive: [{
          breakpoint: 1399,
          settings: {
            slidesToShow: 5
          }
        }, {
          breakpoint: 1199,
          settings: {
            slidesToShow: 4
          }
        }, {
          breakpoint: 991,
          settings: {
            slidesToShow: 3
          }
        }, {
          breakpoint: 767,
          settings: {
            slidesToShow: 2
          }
        }]
      });
    }
    var integration_slider_icon_data_wrap = $('.sofax-integration-slider-icon-data-wrap');
    if (integration_slider_icon_data_wrap.is_exist()) {
      integration_slider_icon_data_wrap.slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 5000,
        arrows: false,
        pauseOnHover: false,
        cssEase: 'linear',
        rtl: true,
        responsive: [{
          breakpoint: 1399,
          settings: {
            slidesToShow: 5
          }
        }, {
          breakpoint: 1199,
          settings: {
            slidesToShow: 4
          }
        }, {
          breakpoint: 991,
          settings: {
            slidesToShow: 3
          }
        }, {
          breakpoint: 767,
          settings: {
            slidesToShow: 2
          }
        }]
      });
    }

    // SOFAX SERVICE SLIDER SECTION JS INIT
    var slider_service_section = $('.sofax-slider-service-section');
    if (slider_service_section.is_exist()) {
      slider_service_section.slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 0,
        speed: 8000,
        arrows: false,
        pauseOnHover: false,
        cssEase: 'linear'
      });
    }

    //  sofax-testimonial-2column-sliderv5
    var testimonial_2column_sliderv5 = $('.sofax-testimonial-2column-sliderv5');
    if (testimonial_2column_sliderv5.is_exist()) {
      testimonial_2column_sliderv5.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: false,
        arrows: true,
        infinite: true,
        prevArrow: '<button class="slide-arrow sofax-t-next"></button>',
        nextArrow: '<button class="slide-arrow sofax-t-prev"></button>'
      });
    }
    /*--------------------------------------------------------------
    sofax MAGNIFIC POPUP JS INIT
    ------------------------------------------------------------*/
    var popup_youtube = $('.video-init');
    if (popup_youtube.is_exist()) {
      popup_youtube.magnificPopup({
        type: 'iframe',
        mainClass: 'mfp-fade'
      });
    }

    // testimonial slider

    $('.sofax-testimonial-2column-slider').slick(_defineProperty(_defineProperty(_defineProperty(_defineProperty({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      fade: false,
      adaptiveHeight: true,
      infinite: false,
      useTransform: true,
      speed: 400
    }, "infinite", true), "cssEase", 'cubic-bezier(0.77, 0, 0.18, 1)'), "prevArrow", '<button class="slide-arrow sofax-t-next"></button>'), "nextArrow", '<button class="slide-arrow sofax-t-prev"></button>'));
    $('.sofax-testimonial-slider-nav').on('init', function (event, slick) {
      $('.sofax-testimonial-slider-nav .slick-slide.slick-current').addClass('is-active');
    }).slick({
      slidesToShow: 7,
      slidesToScroll: 7,
      dots: false,
      focusOnSelect: false,
      infinite: false,
      responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 5,
          slidesToScroll: 5
        }
      }, {
        breakpoint: 640,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 4
        }
      }, {
        breakpoint: 420,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3
        }
      }]
    });
    $('.sofax-testimonial-2column-slider').on('afterChange', function (event, slick, currentSlide) {
      $('.sofax-testimonial-slider-nav').slick('slickGoTo', currentSlide);
      var currrentNavSlideElem = '.sofax-testimonial-slider-nav .slick-slide[data-slick-index="' + currentSlide + '"]';
      $('.sofax-testimonial-slider-nav .slick-slide.is-active').removeClass('is-active');
      $(currrentNavSlideElem).addClass('is-active');
    });
    $('.sofax-testimonial-slider-nav').on('click', '.slick-slide', function (event) {
      event.preventDefault();
      var goToSingleSlide = $(this).data('slick-index');
      $('.sofax-testimonial-2column-slider').slick('slickGoTo', goToSingleSlide);
    });
  }); /*End document ready*/

  $(window).on("resize", function () {}); // end window resize

  $(window).on("load", function () {
    /*--------------------------------------------------------------
    SOFAX PORTFOLIO MASONAY FILTER JS
    ------------------------------------------------------------*/

    var sofax_filter_gallery = $('#sofax-portfolio-grid');
    if (sofax_filter_gallery.is_exist()) {
      var $container = $(sofax_filter_gallery),
        colWidth = function colWidth() {
          var w = $container.width(),
            columnNum = 1,
            columnWidth = 0;
          if (w > 1200) {
            columnNum = 2;
          } else if (w > 900) {
            columnNum = 2;
          } else if (w > 600) {
            columnNum = 2;
          } else if (w > 450) {
            columnNum = 1;
          } else if (w > 385) {
            columnNum = 1;
          }
          columnWidth = Math.floor(w / columnNum);
          $container.find('.collection-grid-item').each(function () {
            var $item = $(this),
              multiplier_w = $item.attr('class').match(/collection-grid-item-w(\d)/),
              multiplier_h = $item.attr('class').match(/collection-grid-item-h(\d)/),
              width = multiplier_w ? columnWidth * multiplier_w[1] : columnWidth,
              height = multiplier_h ? columnWidth * multiplier_h[1] * 0.4 - 12 : columnWidth * 0.5;
            $item.css({
              width: width
              //height: height
            });
          });
          return columnWidth;
        },
        isotope = function isotope() {
          $container.isotope({
            resizable: false,
            itemSelector: '.collection-grid-item',
            masonry: {
              columnWidth: colWidth(),
              gutterWidth: 0
            }
          });
        };
      isotope();
      $(window).resize(isotope);
      var $optionSets = $('.sofax-portfolio-menu .option-set'),
        $optionLinks = $optionSets.find('li');
      $optionLinks.click(function () {
        var $this = $(this);
        var $optionSet = $this.parents('.option-set');
        $optionSet.find('.active').removeClass('active');
        $this.addClass('active');

        // make option object dynamically, i.e. { filter: '.my-filter-class' }
        var options = {},
          key = $optionSet.attr('data-option-key'),
          value = $this.attr('data-option-value');
        // parse 'false' as false boolean
        value = value === 'false' ? false : value;
        options[key] = value;
        if (key === 'layoutMode' && typeof changeLayoutMode === 'function') {
          // changes in layout modes need extra logic
          changeLayoutMode($this, options);
        } else {
          // creativewise, apply new options
          $container.isotope(options);
        }
        return false;
      });
    }
  }); // End window LODE

  $(window).on("resize", function () {}); // end window resize

  $(window).on("load", function () {}); // End window LODE

  /*--------------------------------------------------------------
  sofax MAP JS
  ------------------------------------------------------------*/
  var google_map = $('#map');
  if (google_map.is_exist()) {
    var init = function init() {
      var mapOptions = {
        zoom: 11,
        scrollwheel: false,
        navigationControl: false,
        mapTypeControl: false,
        scaleControl: false,
        draggable: true,
        disableDefaultUI: true,
        center: new google.maps.LatLng(40.6700, -73.9400),
        styles: [{
          "featureType": "landscape.man_made",
          "elementType": "geometry",
          "stylers": [{
            "color": "#f7f1df"
          }]
        }, {
          "featureType": "landscape.natural",
          "elementType": "geometry",
          "stylers": [{
            "color": "#d0e3b4"
          }]
        }, {
          "featureType": "landscape.natural.terrain",
          "elementType": "geometry",
          "stylers": [{
            "visibility": "off"
          }]
        }, {
          "featureType": "poi",
          "elementType": "labels",
          "stylers": [{
            "visibility": "off"
          }]
        }, {
          "featureType": "poi.business",
          "elementType": "all",
          "stylers": [{
            "visibility": "off"
          }]
        }, {
          "featureType": "poi.medical",
          "elementType": "geometry",
          "stylers": [{
            "color": "#fbd3da"
          }]
        }, {
          "featureType": "poi.park",
          "elementType": "geometry",
          "stylers": [{
            "color": "#bde6ab"
          }]
        }, {
          "featureType": "road",
          "elementType": "geometry.stroke",
          "stylers": [{
            "visibility": "off"
          }]
        }, {
          "featureType": "road",
          "elementType": "labels",
          "stylers": [{
            "visibility": "off"
          }]
        }, {
          "featureType": "road.highway",
          "elementType": "geometry.fill",
          "stylers": [{
            "color": "#ffe15f"
          }]
        }, {
          "featureType": "road.highway",
          "elementType": "geometry.stroke",
          "stylers": [{
            "color": "#efd151"
          }]
        }, {
          "featureType": "road.arterial",
          "elementType": "geometry.fill",
          "stylers": [{
            "color": "#ffffff"
          }]
        }, {
          "featureType": "road.local",
          "elementType": "geometry.fill",
          "stylers": [{
            "color": "black"
          }]
        }, {
          "featureType": "transit.station.airport",
          "elementType": "geometry.fill",
          "stylers": [{
            "color": "#cfb2db"
          }]
        }, {
          "featureType": "water",
          "elementType": "geometry",
          "stylers": [{
            "color": "#a2daf2"
          }]
        }]
      };
      var mapElement = document.getElementById('map');
      var map = new google.maps.Map(mapElement, mapOptions);
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(40.6700, -73.9400),
        map: map,
        // icon: 'assets/images/all-img/contact/map.png',
        title: 'fugu'
      });
      var contentString = '<div id="content">' + '<div id="tpw">' + '<h3>fugu' + '</div>';
      var infowindow = new google.maps.InfoWindow({
        content: contentString,
        maxWidth: 280
      });
      marker.setAnimation(google.maps.Animation.BOUNCE);
      setTimeout(function () {
        marker.setAnimation(null);
      }, 750); //time it takes for one bounce   

      google.maps.event.addListener(marker, 'click', function () {
        infowindow.open(map, marker);
      });
    };
    google.maps.event.addDomListener(window, 'load', init);
  }

  // external js: isotope.pkgd.js

  // SOFAX TOGGOLE PASSWOR JS INIT

  $(".toggle-password").click(function () {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });

  //sofax wow js
  var wow = new WOW({
    mobile: false,
    // default
    tablet: false
  });
  wow.init();

  // AOS.init({
  //   duration: 1200,
  // })
})(jQuery);