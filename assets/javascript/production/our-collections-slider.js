let ourCollectionsSwiper=()=>{document.querySelectorAll(".our-collections-slider").forEach(e=>{var t=e.querySelector(".our-collections-slider__swiper"),o=e.querySelector(".our-collections-slider__next-button"),e=e.querySelector(".our-collections-slider__prev-button");void 0!==t&&(swiper=new Swiper(t,{speed:1e3,autoplay:{delay:3500,disableOnInteraction:!1},navigation:{nextEl:o,prevEl:e},slidesPerView:1.5,spaceBetween:13,breakpoints:{640:{slidesPerView:2,spaceBetween:13},1024:{slidesPerView:3,spaceBetween:13},1280:{slidesPerView:4,spaceBetween:13}},on:{init:function(){checkNavButtons(this)},slideChange:function(){checkNavButtons(this)}}}))})};document.addEventListener("DOMContentLoaded",ourCollectionsSwiper);