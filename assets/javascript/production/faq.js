let faq=()=>{var e=document.querySelector(".faq__wrapper-accordion");let r=document.querySelectorAll(".faq__accordion-item");r.forEach(e=>{var a=e.querySelector(".faq__plus-minus-toggle"),e=e.querySelector(".faq__accordion-content");jQuery(a).addClass("collapsed"),jQuery(e).slideUp()}),e.addEventListener("click",e=>{var a,e=e.target.closest(".faq__accordion-title");e&&(a=e.classList.contains("active"),r.forEach(e=>{var a=e.querySelector(".faq__plus-minus-toggle"),e=e.querySelector(".faq__accordion-content");jQuery(a).addClass("collapsed"),jQuery(e).slideUp(),jQuery(".faq__accordion-title").removeClass("active")}),a||(a=e.querySelector(".faq__plus-minus-toggle"),jQuery(e).addClass("active"),jQuery(a).removeClass("collapsed"),jQuery(e).next().slideDown()))})};document.addEventListener("DOMContentLoaded",faq);