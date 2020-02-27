(function($){
    "use strict";

    jQuery(document).on('ready', function () {
        
		/* Menu JS */
        $('.navbar .navbar-nav li a, .main-banner .btn, .welcome-area .link-btn').on('click', function(e){
            var anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $(anchor.attr('href')).offset().top - 50
            }, 1500);
            e.preventDefault();
        });
		
		$('.navbar .navbar-nav li a').on('click', function(){
			$('.navbar-collapse').collapse('hide');
		});
		
        /* Header Sticky */
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 50){  
                $('.header-sticky').addClass("is-sticky");
            }
            else{
                $('.header-sticky').removeClass("is-sticky");
            }
        });
		
		/* Text Animation */
		var TxtType = function(el, toRotate, period) {
			this.toRotate = toRotate;
			this.el = el;
			this.loopNum = 0;
			this.period = parseInt(period, 10) || 2000;
			this.txt = '';
			this.tick();
			this.isDeleting = false;
		};

		TxtType.prototype.tick = function() {
			var i = this.loopNum % this.toRotate.length;
			var fullTxt = this.toRotate[i];

			if (this.isDeleting) {
			this.txt = fullTxt.substring(0, this.txt.length - 1);
			} else {
			this.txt = fullTxt.substring(0, this.txt.length + 1);
			}

			this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

			var that = this;
			var delta = 200 - Math.random() * 100;

			if (this.isDeleting) { delta /= 2; }

			if (!this.isDeleting && this.txt === fullTxt) {
			delta = this.period;
			this.isDeleting = true;
			} else if (this.isDeleting && this.txt === '') {
			this.isDeleting = false;
			this.loopNum++;
			delta = 500;
			}

			setTimeout(function() {
			that.tick();
			}, delta);
		};

		window.onload = function() {
			var elements = document.getElementsByClassName('typewrite');
			for (var i=0; i<elements.length; i++) {
				var toRotate = elements[i].getAttribute('data-type');
				var period = elements[i].getAttribute('data-period');
				if (toRotate) {
				  new TxtType(elements[i], JSON.parse(toRotate), period);
				}
            }
            
			var css = document.createElement("style");
			css.type = "text/css";
			css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
			document.body.appendChild(css);
		};

        /* Practicle JS One */
        if(document.getElementById("particles-js")) particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 50, "density": {
                        "enable": true, "value_area": 800
                    }
                }
                , "color": {
                    "value": "#ffffff"
                }
                , "shape": {
                    "type": "circle", "stroke": {
                        "width": 0, "color": "#000000"
                    }
                    , "polygon": {
                        "nb_sides": 5
                    }
                    , "image": {
                        "src": "img/github.svg", "width": 100, "height": 100
                    }
                }
                , "opacity": {
                    "value": 0.5, "random": false, "anim": {
                        "enable": false, "speed": 1, "opacity_min": 0.1, "sync": false
                    }
                }
                , "size": {
                    "value": 5, "random": true, "anim": {
                        "enable": false, "speed": 40, "size_min": 0.1, "sync": false
                    }
                }
                , "line_linked": {
                    "enable": true, "distance": 150, "color": "#ffffff", "opacity": 0.4, "width": 1
                }
                , "move": {
                    "enable": true, "speed": 6, "direction": "none", "random": false, "straight": false, "out_mode": "out", "attract": {
                        "enable": false, "rotateX": 600, "rotateY": 1200
                    }
                }
            }
            , "interactivity": {
                "detect_on": "canvas", "events": {
                    "onhover": {
                        "enable": true, "mode": "repulse"
                    }
                    , "onclick": {
                        "enable": true, "mode": "push"
                    }
                    , "resize": true
                }
                , "modes": {
                    "grab": {
                        "distance": 400, "line_linked": {
                            "opacity": 1
                        }
                    }
                    , "bubble": {
                        "distance": 400, "size": 40, "duration": 2, "opacity": 8, "speed": 3
                    }
                    , "repulse": {
                        "distance": 200
                    }
                    , "push": {
                        "particles_nb": 4
                    }
                    , "remove": {
                        "particles_nb": 2
                    }
                }
            }
            , "retina_detect": true, "config_demo": {
                "hide_card": false, "background_color": "#b61924", "background_image": "", "background_position": "50% 50%", "background_repeat": "no-repeat", "background_size": "cover"
            }
        });

        /* Particles Js two */
        if(document.getElementById("particles-js-two")) particlesJS("particles-js-two", {
            "particles": {
                "number": {
                    "value":200, "density": {
                        "enable": true, "value_area": 800
                    }
                }
                , "color": {
                    "value": "#fff"
                }
                , "shape": {
                    "type":"circle", "stroke": {
                        "width": 0, "color": "#000000"
                    }
                    , "polygon": {
                        "nb_sides": 5
                    }
                    , "image": {
                        "src": "img/github.svg", "width": 100, "height": 100
                    }
                }
                , "opacity": {
                    "value":0.5, "random":true, "anim": {
                        "enable": false, "speed": 1, "opacity_min": 0.1, "sync": false
                    }
                }
                , "size": {
                    "value":10, "random":true, "anim": {
                        "enable": false, "speed": 40, "size_min": 0.1, "sync": false
                    }
                }
                , "line_linked": {
                    "enable": false, "distance": 500, "color": "#ffffff", "opacity": 0.4, "width": 2
                }
                , "move": {
                    "enable":true, "speed":6, "direction":"bottom", "random":false, "straight":false, "out_mode":"out", "bounce":false, "attract": {
                        "enable": false, "rotateX": 600, "rotateY": 1200
                    }
                }
            }
            , "interactivity": {
                "detect_on":"canvas", "events": {
                    "onhover": {
                        "enable": true, "mode": "bubble"
                    }
                    , "onclick": {
                        "enable": true, "mode": "repulse"
                    }
                    , "resize":true
                }
                , "modes": {
                    "grab": {
                        "distance":400, "line_linked": {
                            "opacity": 0.5
                        }
                    }
                    , "bubble": {
                        "distance": 400, "size": 4, "duration": 0.3, "opacity": 1, "speed": 3
                    }
                    , "repulse": {
                        "distance": 200, "duration": 0.4
                    }
                    , "push": {
                        "particles_nb": 4
                    }
                    , "remove": {
                        "particles_nb": 2
                    }
                }
            }
            , "retina_detect":true
        });
		
		/* Go To Top */
        $(function(){
            //Scroll event
            $(window).on('scroll', function(){
                var scrolled = $(window).scrollTop();
                if (scrolled > 300) $('.go-top').fadeIn('slow');
                if (scrolled < 300) $('.go-top').fadeOut('slow');
            });  
            //Click event
            $('.go-top').on('click', function() {
                $("html, body").animate({ scrollTop: "0" },  1000);
            });
        });

    });

    /* Page Loader */
    jQuery(window).on('load', function() {
        $('.preloader').fadeOut();
    });
}(jQuery));
