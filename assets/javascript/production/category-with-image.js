let categoryWithImage=()=>{var e=document.querySelectorAll(".category-with-image__link");let a=document.querySelectorAll(".category-with-image__image"),i=null;a[0].classList.add("active"),e.forEach(e=>{let t=e.dataset.id;e.addEventListener("mouseenter",()=>{var e=document.getElementById("categoryWithImageLink-image-"+t);a.forEach(e=>e.classList.remove("active")),e.classList.add("active"),i=e}),e.addEventListener("mouseleave",()=>{i&&(a.forEach(e=>e.classList.remove("active")),i.classList.add("active"))})})};document.addEventListener("DOMContentLoaded",categoryWithImage);