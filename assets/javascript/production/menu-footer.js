let menuFooter=()=>{let n=!1,e=document.querySelectorAll(".menu-footer .menu-item-has-children .menu-footer__has-child");var t=window.matchMedia("(max-width: 1024px)");let o=(e,t)=>{e.preventDefault(),jQuery(t).next().slideToggle(),jQuery(t).find(".menu-footer__plus-minus-toggle").toggleClass("collapsed")},d=(n=t.matches,t.addEventListener("change",e=>{n=e.matches,d()}),()=>{e.forEach(t=>{n&&(jQuery(t).next().slideUp(),t.addEventListener("click",e=>o(e,t))),n||(jQuery(t).next().slideDown(),t.removeEventListener("change",o))})});d()};document.addEventListener("DOMContentLoaded",menuFooter);