! function ($) {
"use strict";
    $(document).pjax('a[target!=_blank]', '#boxmoe_global', {
        fragment: '#boxmoe_global',
        timeout: 6000
    });
	$(document).on('pjax:timeout',
    function() {
	$('#preloader').fadeOut();	
    });	
	$(document).on('pjax:send',
    function() {
	$('#preloader').show();	
    });		
    $(document).on('pjax:complete',
    function() {
        ajaxComt();
		lolimeowjs();
		$(".navbar-collapse").removeClass('show');
		$(".navbar-toggler").attr('aria-expanded','false');
		$("#preloader").delay(250).fadeOut('slow');

    });
    /* ---------------------------------------------- /*
    * preloader
    /* ---------------------------------------------- */	
	$("#preloader").delay(750).fadeOut('slow');
    $(document).ready(function() {
	lolimeowjs();
    });
	var lolimeowjs = function(){
    /* ---------------------------------------------- /*
    * Headroom
    /* ---------------------------------------------- */  
	if ($('.headroom')[0]) {
        var headroom = new Headroom(document.querySelector("#navbar-main"), {
            offset: 300,
            tolerance: {
                up: 30,
                down: 30
            },
        });
        headroom.init();
    }
    /* ---------------------------------------------- /*
    * prettyPrint
    /* ---------------------------------------------- */
    if ($('.prettyprint').length) {
        window.prettyPrint && prettyPrint();
    }
    /* ---------------------------------------------- /*
    * search
    /* ---------------------------------------------- */	
    $('a[href="#search"]').on('click',
    function(event) {
        $('#search').addClass('open');
        $('#search > form > input[type="search"]').focus();
        return false;
    });
    $('#search, #search button.close').on('click keyup',
    function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });	
    /* ---------------------------------------------- /*
    * canvas
    /* ---------------------------------------------- */	
	    $("#preloader").delay(750).fadeOut('slow');
		if ($('#canvas')[0]) {
        var canvas = document.getElementById('canvas');
        var ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        var date = Date.now();

        function draw(delta) {
            requestAnimationFrame(draw);
            canvas.width = canvas.width;
            ctx.fillStyle = "#fff";
            var randomLeft = Math.abs(Math.pow(Math.sin(delta / 1000), 2)) * 50;
            var randomRight = Math.abs(Math.pow(Math.sin((delta / 1000) + 10), 2)) * 50;
            var randomLeftConstraint = Math.abs(Math.pow(Math.sin((delta / 1000) + 2), 2)) * 50;
            var randomRightConstraint = Math.abs(Math.pow(Math.sin((delta / 1000) + 1), 2)) * 50;
            ctx.beginPath();
            ctx.moveTo(0, randomLeft);
            // ctx.lineTo(canvas.width, randomRight);
            ctx.bezierCurveTo(canvas.width / 3, randomLeftConstraint, canvas.width / 3 * 2, randomRightConstraint, canvas.width, randomRight);
            ctx.lineTo(canvas.width, canvas.height);
            ctx.lineTo(0, canvas.height);
            ctx.lineTo(0, randomLeft);
            ctx.closePath();
            ctx.fill();
        }
        requestAnimationFrame(draw);
    };	
	
    /* ---------------------------------------------- /*
    * AnimateOnScroll - Init
    /* ---------------------------------------------- */
    var wow = new WOW({
        boxClass: 'wow',
        animateClass: 'animated',
        offset: 0,
        mobile: true,
        live: true,
        callback: function(box) {
        },
        scrollContainer: null,
        resetAnimation: true,
    });
    wow.init();	
    /* ---------------------------------------------- /*
    * lolijump
    /* ---------------------------------------------- */
    $(window).scroll(function() {
        if ($(window).scrollTop() >= 100) {
            $("#lolijump").fadeIn();
        } else {

            $("#lolijump").fadeOut();
        }
    });
    $("#lolijump").click(function(event) {
        $('html,body').animate({
            scrollTop: 0
        },
        500);
        return false;
    });	

    /* ---------------------------------------------- /*
    * 点击表情在评论区插入表情代码
    /* ---------------------------------------------- */
    $('body').on('click','.dropdown-smilie a',
     function() {
     var ab = $(this).attr('href');// 抓取href内的值
     var abc = ab.split('\'');// 按符号/来分割字符串为几个数组  
     var content = $('#comment').val(); // textarea区的id
     content += abc[1];
     $('#comment').val(content); // textarea区的id

    });	
	var hide = document.getElementById('toggle-comment-author-info');
    if(!hide) {  
    }else{
    $('#comment-author-info').hide();
    }
    $('body').on('click', '.comment-reply-link',
        function () {
            addComment.moveForm("comment-" + $(this).attr('data-commentid'), $(this).attr('data-commentid'), "respond", $(this).attr('data-postid'));
            return false;
        });	
    /* ---------------------------------------------- /*
    * dropDown
    /* ---------------------------------------------- */		
	function dropDown(e) {
    if (!document.querySelector(".dropdown-hover")) {
        event.stopPropagation(),
        event.preventDefault();
        for (var t = e.parentElement.parentElement.children,
        l = 0; l < t.length; l++) t[l].lastElementChild != e.parentElement.lastElementChild && (t[l].lastElementChild.classList.remove("show"), t[l].firstElementChild.classList.remove("show"));
        e.nextElementSibling.classList.contains("show") ? (e.nextElementSibling.classList.remove("show"), e.classList.remove("show")) : (e.nextElementSibling.classList.add("show"), e.classList.add("show"))
        }
        }
    /* ---------------------------------------------- /*
    * tooltip
    /* ---------------------------------------------- */
	var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')),
	popoverList = popoverTriggerList.map(function(e) {
    return new bootstrap.Popover(e)
	}),
	tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')),
	tooltipList = tooltipTriggerList.map(function(e) {
    return new bootstrap.Tooltip(e)
	});
	function setAttributes(t, l) {
    Object.keys(l).forEach(function(e) {
        t.setAttribute(e, l[e])
    })
	}
	var myLatlng, mapOptions, map, marker, popoverList = (popoverTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="popover"]'))).map(function(e) {
    return new bootstrap.Popover(e)
	}),
	tooltipList = (tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))).map(function(e) {
    return new bootstrap.Tooltip(e)
	});	
	
	
    };

	
}(window.jQuery);