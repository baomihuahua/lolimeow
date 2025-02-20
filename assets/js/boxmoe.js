"use strict";
// 主题初始化
var theme = {
	init: function() {
        theme.menu(), 
        theme.otpVarification(), 
        theme.popovers(), 
        theme.tooltip(), 
        theme.validation()
	},
	menu: () => {
		document.querySelectorAll(".dropdown-menu a.dropdown-toggle")
			.forEach((function(e) {
				e.addEventListener("click", (function(e) {
					if (!this.nextElementSibling.classList.contains("show")) {
						this.closest(".dropdown-menu")
							.querySelectorAll(".show")
							.forEach((function(e) {
								e.classList.remove("show")
							}))
					}
					this.nextElementSibling.classList.toggle("show");
					const t = this.closest("li.nav-item.dropdown.show");
					t && t.addEventListener("hidden.bs.dropdown", (function(e) {
						document.querySelectorAll(".dropdown-submenu .show")
							.forEach((function(e) {
								e.classList.remove("show")
							}))
					})), e.stopPropagation()
				}))
			}))
	},
	popovers: () => {
		[...document.querySelectorAll('[data-bs-toggle="popover"]')].map((e => new bootstrap.Popover(e)))
	},
	tooltip: () => {
		[...document.querySelectorAll('[data-bs-toggle="tooltip"]')].map((e => new bootstrap.Tooltip(e)))
	},
	validation: () => {
		const e = document.querySelectorAll(".needs-validation");
		Array.from(e)
			.forEach((e => {
				e.addEventListener("submit", (t => {
					e.checkValidity() || (t.preventDefault(), t.stopPropagation()), e.classList.add("was-validated")
				}), !1)
			}))
	},
	otpVarification: () => {
		document.moveToNextInput = function(e) {
			if (e.value.length === e.maxLength) {
				const t = Array.from(e.parentElement.children)
					.indexOf(e),
					n = e.parentElement.children[t + 1];
				n && n.focus()
			}
		}
	}
};
theme.init();

var navbar = document.querySelector(".navbar");
const navOffCanvasBtn = document.querySelectorAll(".offcanvas-nav-btn"),
	navOffCanvas = document.querySelector(".navbar:not(.navbar-clone) .offcanvas-nav");
let bsOffCanvas;
function toggleOffCanvas() {
	bsOffCanvas && bsOffCanvas._isShown ? bsOffCanvas.hide() : bsOffCanvas && bsOffCanvas.show()
}
navOffCanvas && (bsOffCanvas = new bootstrap.Offcanvas(navOffCanvas, {
	scroll: !0,
	backdrop: true
}), navOffCanvasBtn.forEach((e => {
	e.addEventListener("click", (e => {
		toggleOffCanvas()
	}))
})));
function showToast(message, isSuccess = true) {
    const toastId = 'toast-' + Date.now();
        const toastHtml = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="${ajax_object.themeurl}/assets/images/msg-tip.png" class="rounded me-2 avatar-xs" alt="avatar">
                <strong class="me-auto">系统消息</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        document.body.appendChild(toastContainer);
    }   
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    const toastElement = document.getElementById(toastId);
    toastElement.className = `toast align-items-center ${isSuccess ? 'text-bg-success' : 'text-bg-danger'} border-0`;
    const toast = new bootstrap.Toast(toastElement, {
        autohide: true,
        delay: 5000
    });
    toast.show();
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}
// 搜索框初始化
function initSearchBox() {
    const searchBtns = document.querySelectorAll('.search-btn, .mobile-search-btn');
    const searchForms = document.querySelectorAll('.search-form, .mobile-search-form');
    
    searchBtns.forEach((btn, index) => {
        const form = searchForms[index];
        const input = form.querySelector('input[type="search"]');
        
        if (btn && form && input) {
            btn.addEventListener('click', function(e) {
                if (!form.classList.contains('active')) {
                    e.preventDefault();
                    e.stopPropagation();
                    form.classList.add('active');
                    setTimeout(() => {
                        input.focus();
                    }, 100);
                }
            });

            form.addEventListener('submit', function(e) {
                if (!input.value.trim()) {
                    e.preventDefault();
                }
            });

            document.addEventListener('click', function(e) {
                if (!form.contains(e.target) && !btn.contains(e.target)) {
                    form.classList.remove('active');
                }
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    form.classList.remove('active');
                    input.blur();
                }
            });
        }
    });
}
// 用户面板初始化
function initMobileUserPanel() {
    const mobileUserBtn = document.querySelector('.mobile-user-btn');
    const mobileUserPanel = document.querySelector('.mobile-user-panel');  
    if(mobileUserBtn && mobileUserPanel) {
        mobileUserBtn.addEventListener('click', function() {
            if (!mobileUserPanel.classList.contains('active')) {
                mobileUserPanel.classList.remove('closing');
                mobileUserPanel.classList.add('active');
            } else {
                mobileUserPanel.classList.add('closing');
                mobileUserPanel.classList.remove('active');
            }
        });
        document.addEventListener('click', function(e) {
            if(!mobileUserPanel.contains(e.target) && !mobileUserBtn.contains(e.target)) {
                if (mobileUserPanel.classList.contains('active')) {
                    mobileUserPanel.classList.add('closing');
                    mobileUserPanel.classList.remove('active');
                }
            }
        });
    }
}

// 懒加载初始化
function initLazyLoad() {
    const lazyImages = document.querySelectorAll('img.lazy');  
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.src = img.dataset.src;
          img.classList.remove('lazy');
          observer.unobserve(img);
        }
      });
    });
    lazyImages.forEach(img => imageObserver.observe(img));
  }

// 加载延迟初始化
function initBannerImage() {
    const bannerImg = document.querySelector('.boxmoe_header_banner_img');
    const siteMain = document.querySelector('.boxmoe_header_banner .site-main');
    if (!bannerImg || !siteMain) return;
    const img = bannerImg.querySelector('img');
    if (!img) return;

    if(img.complete) {
      bannerImg.classList.add('loaded');
      setTimeout(() => {
        siteMain.classList.add('loaded');
      }, 500);
    } else {
      img.addEventListener('load', () => {
        bannerImg.classList.add('loaded');
        setTimeout(() => {
          siteMain.classList.add('loaded');
        }, 500);
      });
    }
}
// Headhesive初始化
function initStickyHeader() {
  const header = document.querySelector('.boxmoe_header .navbar');
  if (!header) return;
  let lastScrollTop = 0;
  const headerHeight = header.offsetHeight;
  window.addEventListener('scroll', () => {
    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    if (!header) return;

    if (scrollTop > headerHeight) {
      if (scrollTop > lastScrollTop) {
        header.classList.add('scrolled');
        header.classList.remove('boxed', 'mx-auto', 'nav-down');
        header.classList.add('boxed', 'mx-auto', 'nav-up');
      } else {
        header.classList.add('scrolled');
        header.classList.remove('boxed', 'mx-auto', 'nav-up');
        header.classList.add('boxed', 'mx-auto', 'nav-down');
      }

    } else {
      header.classList.remove('boxed', 'mx-auto', 'scrolled', 'nav-up', 'nav-down');
    }  
    lastScrollTop = scrollTop;
  });
}

// 文章导读初始化
function initTableOfContents() {
    const content = document.querySelector('.single-content');
    const tocContainer = document.querySelector('.post-toc-container');
    const tocBtn = document.querySelector('.post-toc-btn');
    const toc = document.querySelector('.post-toc');
    const tocList = document.querySelector('.toc-list');   
    if(!content || !tocBtn || !toc || !tocList) return; 
    const headers = content.querySelectorAll('h1, h2, h3, h4');
    if(headers.length === 0) {
        tocContainer.style.display = 'none';
        return;
    }
    let isScrolling;
    const counters = [0, 0, 0, 0]; 
    let currentLevel = 0;
    headers.forEach((header, index) => {
        const level = parseInt(header.tagName[1]) - 1;     
        counters[level]++;
        for(let i = level + 1; i < 4; i++) counters[i] = 0; 
        
        const numberParts = [];
        for(let i = 0; i <= level; i++) {
            if(counters[i] > 0) numberParts.push(counters[i]);
        }
        const numberStr = numberParts.join('.');

        const link = document.createElement('a');
        const id = `header-${index}`;
        header.id = id;
        link.href = `#${id}`;
                link.textContent = `${numberStr} ${header.textContent}`;
        link.style.paddingLeft = `${level * 10}px`;
        tocList.appendChild(link);
    });
    const showOffset = 350;
    window.addEventListener('scroll', () => {
        const scrollPos = window.scrollY;
        if(scrollPos > showOffset) {
            tocContainer.classList.add('visible');
            tocBtn.classList.add('visible');
        } else {
            tocContainer.classList.remove('visible');
            tocBtn.classList.remove('visible');
            toc.classList.remove('show'); 
        }
        clearTimeout(isScrolling);
        isScrolling = setTimeout(() => {
            const links = tocList.querySelectorAll('a');
            let currentActive = null;
            
            const navHeight = document.querySelector('.navbar')?.offsetHeight || 0;
            const buffer = 20;
            for(let i = 0; i < headers.length; i++) {
                const headerRect = headers[i].getBoundingClientRect();
                if (headerRect.top <= navHeight + buffer && headerRect.bottom > navHeight) {
                    currentActive = links[i];
                    break;
                }
            }
            if (!currentActive) {
                for(let i = headers.length - 1; i >= 0; i--) {
                    const headerRect = headers[i].getBoundingClientRect();
                    if (headerRect.top <= navHeight + buffer) {
                        currentActive = links[i];
                        break;
                    }
                }
            }
            if(currentActive && !currentActive.classList.contains('active')) {
                links.forEach(link => link.classList.remove('active'));
                currentActive.classList.add('active');       
                const tocListRect = tocList.getBoundingClientRect();
                const activeLinkRect = currentActive.getBoundingClientRect();
                if (activeLinkRect.top < tocListRect.top) {
                    tocList.scrollTop -= (tocListRect.top - activeLinkRect.top + 50);
                } else if (activeLinkRect.bottom > tocListRect.bottom) {
                    tocList.scrollTop += (activeLinkRect.bottom - tocListRect.bottom + 50);
                }
            }
        }, 50);
    });
    tocList.addEventListener('click', (e) => {
        if(e.target.tagName === 'A') {
            e.preventDefault();     
            tocList.querySelectorAll('a').forEach(link => {
                link.classList.remove('active');
            });
            e.target.classList.add('active');
            
            const targetId = e.target.getAttribute('href').slice(1);
            const targetHeader = document.getElementById(targetId);
            
            if(targetHeader) {
                const navHeight = document.querySelector('.navbar')?.offsetHeight || 0;
                const targetPosition = targetHeader.getBoundingClientRect().top + window.scrollY - navHeight - 10;       
                const tocListRect = tocList.getBoundingClientRect();
                const clickedLinkRect = e.target.getBoundingClientRect();               
                if (clickedLinkRect.top < tocListRect.top) {
                    tocList.scrollTop += clickedLinkRect.top - tocListRect.top;
                } else if (clickedLinkRect.bottom > tocListRect.bottom) {
                    tocList.scrollTop += clickedLinkRect.bottom - tocListRect.bottom;
                }             
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        }
    });
    tocBtn.addEventListener('click', () => {
        toc.classList.toggle('show');
    });
    document.addEventListener('click', (e) => {
        if(!toc.contains(e.target) && !tocBtn.contains(e.target)) {
            toc.classList.remove('show');
        }
    });
}

// 标签颜色初始化
function initTagColors() {
    const colors = [
        "#83ea6c", "#1dd7c2", "#85b2f4", "#ffcf00", "#f4c8c6", "#e6f2e4", 
        "#83ea6c", "#1dd7c2", "#85b2f4", "#0dcaf0", "#e8d8ff", "#ffd700", 
        "#ff7f50", "#6495ed", "#b0e0e6", "#ff6347", "#98fb98", "#dda0dd", 
        "#add8e6", "#ff4500", "#d3d3d3", "#00bfff", "#ff1493", "#ff6347", 
        "#8a2be2", "#7fff00", "#d2691e", "#a52a2a", "#9acd32", "#ff8c00", 
        "#dcdcdc", "#dc143c", "#f0e68c", "#ff00ff", "#4b0082", "#8b0000", 
        "#e9967a", "#ff00ff", "#2e8b57", "#3cb371", "#f5deb3", "#ff69b4"
    ];  
    document.querySelectorAll('.blog-post .tagfa').forEach((element, index) => {
        if (index < colors.length) {
            element.style.color = colors[index];
        }
    });   
    document.querySelectorAll('.tag-cloud .tagfa').forEach((element, index) => {
        if (index < colors.length) {
            element.style.color = colors[index];
        }
    });
}

// 一言初始化
function initHitokoto() {
    if (!document.getElementById('hitokoto')) return;
    const themeScript = document.getElementById('theme-script-js-extra');
    const hitokotoParam = themeScript ? 
        JSON.parse(themeScript.textContent.match(/ajax_object\s*=\s*({[^}]+})/)[1]).hitokoto : 
        'a';
    fetch(`https://v1.hitokoto.cn/?c=${hitokotoParam}`)
        .then(response => response.json())
        .then(data => {
            const hitokotoEl = document.getElementById('hitokoto');
            hitokotoEl && (hitokotoEl.textContent = data.hitokoto);
        })
}

// 点赞功能初始化
function initPostLikes() {
    document.querySelectorAll('.like-btn').forEach(btn => {
        const postId = btn.dataset.postId;
        if(localStorage.getItem(`post_${postId}_liked`)) {
            btn.classList.add('liked');
            btn.querySelector('i').classList.add('text-primary');
        }
        
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            
            if(this.classList.contains('processing') || localStorage.getItem(`post_${postId}_liked`)) {
                return;
            }
            
            this.classList.add('processing');
            
            try {
                const formData = new FormData();
                formData.append('action', 'post_like');
                formData.append('post_id', postId);
                
                const response = await fetch(ajax_object.ajaxurl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: formData
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    const count = data.data.count;
                    btn.querySelector('.like-count').textContent = count;
                    localStorage.setItem(`post_${postId}_liked`, 'true');
                    btn.classList.add('liked');
                    btn.querySelector('i').classList.add('text-primary');
                } else {
                    console.warn('点赞失败:', data.data.message);
                }
            } catch (error) {
                console.error('点赞请求失败:', error);
            } finally {
                this.classList.remove('processing');
            }
        });
    });
}

// 打赏功能初始化
function initReward() {
    const rewardBtn = document.querySelector('.reward-btn');
    const rewardModal = document.querySelector('.reward-modal');
    const rewardClose = document.querySelector('.reward-close');

    if (rewardBtn && rewardModal) {
        rewardBtn.addEventListener('click', () => {
            rewardModal.classList.add('show');
        });

        rewardModal.addEventListener('click', (e) => {
            if (e.target === rewardModal) {
                rewardModal.classList.remove('show');
            }
        });

        if (rewardClose) {
            rewardClose.addEventListener('click', () => {
                rewardModal.classList.remove('show');
            });
        }
    }
}

// 收藏功能初始化
function initPostFavorites() {
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        const postId = btn.dataset.postId;
        
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            
            if(this.classList.contains('processing')) {
                return;
            }
            
            this.classList.add('processing');
            
            try {
                const formData = new FormData();
                formData.append('action', 'post_favorite');
                formData.append('post_id', postId);
                
                const response = await fetch(ajax_object.ajaxurl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: formData
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    const favoriteText = this.querySelector('.favorite-text');
                    if (data.data.status) {
                        this.classList.add('favorited');
                        favoriteText.textContent = '已收藏';
                    } else {
                        this.classList.remove('favorited');
                        favoriteText.textContent = '收藏';
                    }
                } else {
                    console.warn('收藏操作失败:', data.data.message);
                }
            } catch (error) {
                console.error('收藏请求失败:', error);
            } finally {
                this.classList.remove('processing');
            }
        });
    });
}

// 主题切换初始化
const ThemeSwitcher = (() => {
    "use strict";
    const getStoredTheme = () => localStorage.getItem("theme");
    const getPreferredTheme = () => {
        const storedTheme = getStoredTheme();
        return storedTheme || (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light");
    };
    const setTheme = theme => {
        const isAutoDark = theme === "auto" && window.matchMedia("(prefers-color-scheme: dark)").matches;
        document.documentElement.setAttribute("data-bs-theme", isAutoDark ? "dark" : theme);
    };
    const updateActiveState = (theme, focus = false) => {
        const themeSwitcher = document.querySelector(`[data-bs-theme-value="${theme}"]`);
        if (!themeSwitcher) return;

        document.querySelectorAll("[data-bs-theme-value]").forEach(btn => {
            btn.classList.toggle("active", btn === themeSwitcher);
            btn.setAttribute("aria-pressed", btn === themeSwitcher);
        });
        const mainThemeBtn = document.querySelector('.bd-theme i');
        if (mainThemeBtn) {
            mainThemeBtn.className = theme === 'light' ? 'fa fa-sun-o' :
                                   theme === 'dark' ? 'fa fa-moon-o' :
                                   'fa fa-adjust';
        }

        focus && themeSwitcher.focus();
    };
    const init = () => {
        const preferredTheme = getPreferredTheme();
        setTheme(preferredTheme);
        updateActiveState(preferredTheme);
        document.querySelectorAll("[data-bs-theme-value]").forEach(button => {
            button.addEventListener("click", () => {
                const theme = button.dataset.bsThemeValue;
                localStorage.setItem("theme", theme);
                setTheme(theme);
                updateActiveState(theme, true);
            });
        });
        window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", e => {
            const storedTheme = getStoredTheme();
            storedTheme === "auto" && setTheme(getPreferredTheme());
        });
    };

    return { init };
})();

// 代码高亮初始化
function initPrettyPrint() {
    const prettyprintElements = document.querySelectorAll('.prettyprint');
    if (prettyprintElements.length && window.prettyPrint) {
        window.prettyPrint();
    }
}

function initCodeCopy() {
    const container = document.querySelector('.boxmoe-container');
    if (!container) return;
    const preElements = container.querySelectorAll('pre');
    preElements.forEach((pre, index) => {
        const btnCopy = document.createElement('div');
        btnCopy.className = 'btn-copy';
        const copySpan = document.createElement('span');
        copySpan.className = 'single-copy copy';
        copySpan.setAttribute('data-clipboard-target', `#copy${index}`);
        copySpan.setAttribute('title', '点击复制本段代码');
        copySpan.innerHTML = '<i class="fa fa-files-o"></i> 复制代码';
        btnCopy.appendChild(copySpan);
        pre.insertBefore(btnCopy, pre.firstChild);
        const codeList = pre.querySelector('ol');
        if (codeList) {
            codeList.id = `copy${index}`;
        }
    });
    const clipboard = new ClipboardJS('.copy');
    clipboard.on('success', function(e) {
        e.clearSelection();
        const trigger = e.trigger;
        trigger.innerHTML = '<span style="color:#32cd32"><i class="fa fa-check-square-o" aria-hidden="true"></i> 复制成功</span>';     
        setTimeout(() => {
            trigger.innerHTML = '<i class="fa fa-files-o"></i> 复制代码';
        }, 3000);
    });
    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
        alert("复制失败，请手动复制");
    });
}

// Preloader初始化
function initPreloader() {
    const preloader = document.querySelector('.preloader');
    if (!preloader) return;
    preloader.style.display = 'flex';
    window.addEventListener('load', () => {
        setTimeout(() => {
            preloader.style.opacity = '0';
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500); 
        }, 1000);
    });
}

function initRunningDays() {
    const webstar = new Date(ajax_object.running_days);
    const webnow = new Date();
    const dotime = webnow.getTime() - webstar.getTime();
    const donow = Math.floor(dotime / (1000 * 60 * 60 * 24));
    const runningDaysElement = document.getElementById('running-days');
    if (runningDaysElement) {
        runningDaysElement.textContent = donow;
    }
}

// DOM加载完成后初始化
document.addEventListener("DOMContentLoaded", () => {
    initPreloader();
    initSearchBox();
    initLazyLoad();
    initMobileUserPanel();
    initBannerImage();
    initStickyHeader();
    initTableOfContents();
    initTagColors();
    initHitokoto();
    initPostLikes(); 
    initReward(); 
    initPostFavorites(); 
    ThemeSwitcher.init(); 
    initPrettyPrint();
    initCodeCopy();
    initRunningDays();
    Fancybox.bind("[data-fancybox]", {});
    document.querySelectorAll('.switch-account-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const guestInputs = document.querySelector('.guest-inputs');
            if(guestInputs) {
                guestInputs.classList.toggle('active');
                btn.classList.toggle('active');
            }
        });
    });
    
});

