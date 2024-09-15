!(function ($) {
    "use strict";
    $(document).pjax("a[target!=_blank]", "#boxmoe_theme_global", {
        fragment: "#boxmoe_theme_global",
        timeout: 6000,
    });
    $(document).on("pjax:timeout", function () {
        preloader();
    });
    $(document).on("pjax:beforeReplace", function () {
        preloader();
    });
    $(document).on("pjax:start", function () {
        $('.preloader').show();
    });
    $(document).on("pjax:success", function (event, data, status, xhr) {
        var newTitle = $(data).filter("title").text();
        document.title = newTitle;
    });
    $(document).on("pjax:complete", function () {
        boxmoeload();
        theme.init();
        ajaxComt();
    });

    var preloader = function () {
        if ($(".preloader").length) {$(".preloader").delay(200).fadeOut("slow");}
    };

    $(document).ready(function () {
        if ($(".preloader").length) {$(".preloader").delay(750).fadeOut("slow");}
        boxmoeload();
        theme.init();

    });
    var boxmoeload = function () {
        $('a[href="#search"]').on("click", function (event) {
            $("#search").addClass("open");
            $('#search > form > input[type="search"]').focus();
            $(".offcanvas-start").removeClass("show");
            return false;
        });
        $("#search, #search button.close").on("click keyup", function (event) {
            if (
                event.target == this ||
                event.target.className == "close" ||
                event.keyCode == 27
            ) {
                $(this).removeClass("open");
                $(".offcanvas-start").addClass("show");
            }
        });

        $(window).scroll(function () {
            if ($(window).scrollTop() >= 250) {
                if ($("#lolijump").length) {
                    $("#lolijump").fadeIn();
                }
            } else {
                if ($("#lolijump").length) {
                    $("#lolijump").fadeOut();
                }
            }
        });

        $("#lolijump").click(function (event) {
            if ($("#lolijump").length) {
                $("html, body").animate(
                    {
                        scrollTop: 0,
                    },
                    100,
                );
            }
            return false;
        });
        // blog-post
        const colors1 = [
            "#83ea6c",
            "#1dd7c2",
            "#85b2f4",
            "#ffcf00",
            "#f4c8c6",
            "#e6f2e4",
            "#83ea6c",
            "#1dd7c2",
            "#85b2f4",
            "#0dcaf0",
            "#e8d8ff",
        ];

        const tagElements1 = $(".blog-post .tagfa");

        tagElements1.each(function (index) {
            if (index < colors1.length) {
                $(this).css("color", colors1[index]);
            }
        });
        // tag-cloud
        const colors2 = [
            "#83ea6c",
            "#1dd7c2",
            "#85b2f4",
            "#ffcf00",
            "#f4c8c6",
            "#e6f2e4",
            "#83ea6c",
            "#1dd7c2",
            "#85b2f4",
            "#0dcaf0",
            "#e8d8ff",
        ];

        const tagElements2 = $(".tag-cloud .tagfa");

        tagElements2.each(function (index) {
            if (index < colors2.length) {
                $(this).css("color", colors2[index]);
            }
        });

        var targetElement = document.getElementById("blog-sidebar");
        if (!targetElement) {
            var siblingElements = document.querySelectorAll(".d-lg-none");
            siblingElements.forEach(function(el) {
                el.style.display = "none";
            });
        }

        if ($(".prettyprint").length) {
            window.prettyPrint && prettyPrint();
        }
        var copycode = function(){
            for (var i = 0; i < $('#boxmoe_theme_container pre').length; i++) {
                $('#boxmoe_theme_container pre').eq(i).prepend('<div class="btn-copy"><span class="single-copy copy" data-clipboard-target="#copy'+ i +'" title="点击复制本段代码"><i class="fa fa-files-o"></i> 复制代码</span></div>');
                $('#boxmoe_theme_container pre> ol').eq(i).attr('id','copy'+ i);
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
        };copycode();


        $("[data-fancybox]").fancybox({
            loop: true,
            arrows: true,
            animationEffect: "fade",
            transitionEffect: "slide",
            caption: function(instance, item) {
                return $(this).data('caption');
            },
            keyboard: true,
            toolbar: true,
            infobar: true,
            buttons: [
                'zoom',
                'slideShow',
                'fullScreen',
                'download',
                'thumbs',
                'close'
            ],
            thumbs: {
                autoStart: true
            },
            slideShow: {
                autoStart: false,
                speed: 3000
            },
            fullScreen: {
                autoStart: false
            },
            hash: true
        });
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

    };

    var navbar = document.querySelector(".navbar");
    const navOffCanvasBtn = document.querySelectorAll(".offcanvas-nav-btn"),
        navOffCanvas = document.querySelector(
            ".navbar:not(.navbar-clone) .offcanvas-nav",
        );
    let bsOffCanvas;

    function toggleOffCanvas() {
        bsOffCanvas && bsOffCanvas._isShown
            ? bsOffCanvas.hide()
            : bsOffCanvas && bsOffCanvas.show();
    }
    navOffCanvas &&
    ((bsOffCanvas = new bootstrap.Offcanvas(navOffCanvas, {
        scroll: !0,
    })),
        navOffCanvasBtn.forEach((e) => {
            e.addEventListener("click", (e) => {
                toggleOffCanvas();
            });
        }));

    var theme = {
        init: function () {
            theme.menu(),
                theme.popovers(),
                theme.tooltip(),
                theme.navbaronScroll();
        },

        menu: () => {
            document.querySelectorAll(".dropdown-menu a.dropdown-toggle").forEach((function(e) {
                e.addEventListener("click", (function(e) {
                    if (!this.nextElementSibling.classList.contains("show")) {
                        this.closest(".dropdown-menu").querySelectorAll(".show").forEach((function(e) {
                            e.classList.remove("show")
                        }))
                    }
                    this.nextElementSibling.classList.toggle("show");
                    const t = this.closest("li.nav-item.dropdown.show");
                    t && t.addEventListener("hidden.bs.dropdown", (function(e) {
                        document.querySelectorAll(".dropdown-submenu .show").forEach((function(e) {
                            e.classList.remove("show")
                        }))
                    })), e.stopPropagation()
                }))
            }))
        },

        popovers: () => {
            [...document.querySelectorAll('[data-bs-toggle="popover"]')].map(
                (e) => new bootstrap.Popover(e),
            );
        },
        tooltip: () => {
            [...document.querySelectorAll('[data-bs-toggle="tooltip"]')].map(
                (e) => new bootstrap.Tooltip(e),
            );
        },
        navbaronScroll: () => {
            const $navbar = $(".navbar");
            const scrollThreshold = 100;
            if ($navbar.length) {
                function onScroll() {
                    if ($(window).scrollTop() > scrollThreshold) {
                        $navbar.addClass("scrolled");
                    } else {
                        $navbar.removeClass("scrolled");
                    }
                }
                $(window).on("scroll", onScroll);
                onScroll();
            }
        },
    };
})(window.jQuery);
  