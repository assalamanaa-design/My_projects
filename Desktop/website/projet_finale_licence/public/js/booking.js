document.getElementById("upgradeBtn").addEventListener("click", function () {
    document.getElementById("paymentCard").classList.add("show");
});

document.getElementById("closePayment").addEventListener("click", function () {
    document.getElementById("paymentCard").classList.remove("show");
});
