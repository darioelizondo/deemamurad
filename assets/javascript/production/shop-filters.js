let clickAwayListenerForFilters=()=>{let t=document.querySelector(".products-filters"),c=document.querySelector(".products-filters__inner"),s=document.getElementById("toggleFilters");document.addEventListener("click",e=>{c.contains(e.target)||s.contains(e.target)||t.classList.contains("active")&&(setTimeout(()=>{t.classList.remove("active")},300),c.classList.remove("active"))})};document.addEventListener("DOMContentLoaded",clickAwayListenerForFilters);