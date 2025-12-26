

document.getElementById("openSidebar").addEventListener("click", function() {
    document.getElementById("sidebar").style.left = "0";
    document.getElementById("topbar").classList.add("expanded");
    document.querySelector(".main-content").classList.add("expanded");
});

document.getElementById("closeSidebar").addEventListener("click", function() {
    document.getElementById("sidebar").style.left = "-250px";
    document.getElementById("topbar").classList.remove("expanded");
    document.querySelector(".main-content").classList.remove("expanded");
});





