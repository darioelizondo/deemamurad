let toggleOpenCloseMenu=()=>{var e=document.getElementById("btnHamburgerIcon");let t=document.getElementById("hamburgerIcon"),n=document.getElementById("headerCenter"),l=document.querySelectorAll(".wrapper-submenu"),s=document.querySelectorAll(".submenu--second-level");e.addEventListener("click",e=>{e.preventDefault(),t.classList.toggle("active"),n.classList.toggle("active"),l.forEach(e=>{jQuery(e).removeClass("active"),jQuery(e).prev().removeClass("active")}),s.forEach(e=>{jQuery(e).slideUp(),jQuery(e).find(".menu__plus-minus-toggle").removeClass("collapsed")})})},toggleOpenCloseMegaMenu=()=>{document.querySelectorAll(".menu__has-child--first-level").forEach(t=>{t.addEventListener("click",e=>{e.preventDefault(),jQuery(t).addClass("active"),jQuery(t).next().addClass("active")})})},toggleOpenCloseSubmenu=()=>{let n=!1,e=document.querySelectorAll(".submenu--first-level .menu__has-child");var t=window.matchMedia("(max-width: 1024px)");let l=(e,t)=>{e.preventDefault(),jQuery(t).next().slideToggle(),jQuery(t).find(".menu__plus-minus-toggle").toggleClass("collapsed")},s=(n=t.matches,t.addEventListener("change",e=>{n=e.matches,s()}),()=>{e.forEach(t=>{n&&(jQuery(t).next().slideUp(),t.addEventListener("click",e=>l(e,t))),n||(jQuery(t).next().slideDown(),t.removeEventListener("change",l))})});s()},clickAwayListenerForSubmenu=()=>{let t=document.querySelector(".menu"),n=document.querySelector(".wrapper-submenu");document.addEventListener("click",e=>{t.contains(e.target)||n.classList.contains("active")&&(n.classList.remove("active"),n.previousSibling.classList.remove("active"))})};document.addEventListener("DOMContentLoaded",toggleOpenCloseMenu,!1),document.addEventListener("DOMContentLoaded",toggleOpenCloseMegaMenu,!1),document.addEventListener("DOMContentLoaded",toggleOpenCloseSubmenu,!1),document.addEventListener("DOMContentLoaded",clickAwayListenerForSubmenu,!1);