! function ($) {
	"use strict";
    $(document).pjax('a[target!=_blank]', '#boxmoe_global', {fragment: '#boxmoe_global',timeout: 6000});
	$(document).on('pjax:timeout',function() {preloader();});
	$(document).on('pjax:beforeReplace',function() {preloader();});		
	$(document).on('pjax:start',function() {$('#preloader').show();});		
    $(document).on('pjax:complete',
    function() {
        ajaxComt();
		lolimeowjs();
		copycode();
		$(".navbar-collapse").removeClass('show');
		$(".navbar-toggler").attr('aria-expanded','false');	
    });
    $(document).ready(function() {
	lolimeowjs();
	copycode();
    });
	
	var preloader = function(){
	$("#preloader").delay(200).fadeOut('slow');
	}
		
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
	//$(".nav-link").click(function () {
    // $(".nav-link").removeClass("active");
    // $(this).addClass("active");
    //});	
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
    * prettyPrint
    /* ---------------------------------------------- */
    if ($('.prettyprint').length) {
        window.prettyPrint && prettyPrint();
    }

    /* ---------------------------------------------- /*
    * loader
    /* ---------------------------------------------- */	
	    $("#preloader").delay(750).fadeOut('slow');	
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
        100);
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

	var copycode = function(){
    for (var i = 0; i < $('.boxmoe-blog-content pre').length; i++) {
        $('.boxmoe-blog-content pre').eq(i).prepend('<div class="btn-copy"><span class="single-copy copy" data-clipboard-target="#copy'+ i +'" title="点击复制本段代码"><i class="fa fa-files-o"></i> 复制代码</span></div>');
        $('.boxmoe-blog-content pre> ol').eq(i).attr('id','copy'+ i);
    }		
    var clipboard = new ClipboardJS('.copy');
    clipboard.on('success', function(e) {
        e.clearSelection();
        $(e.trigger).html('<span style="color:#32cd32"><i class="fa fa-check-square-o" aria-hidden="true"></i> 复制成功</span>');
        setTimeout(function(){$(e.trigger).html('<i class="fa fa-files-o"></i> 复制代码</span>');},3000);
    });
    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
        alert("复制失败，请手动复制");
    });	
	}

	
}(window.jQuery);
