document.addEventListener("DOMContentLoaded", function () {
    // Vérifie si les éléments <canvas> existent
    let savingsChart = document.getElementById("savingsChart");
    let expensesChart = document.getElementById("expensesChart");

    if (savingsChart) {
        new Chart(savingsChart, {
            type: "line",
            data: {
                labels: ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin"],
                datasets: [{
                    label: "Économies",
                    data: [500, 700, 800, 600, 900, 1000],
                    backgroundColor: "rgba(54, 162, 235, 0.5)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 2,
                }],
            },
            options: {
                responsive: true,
            }
        });
    }

    if (expensesChart) {
        new Chart(expensesChart, {
            type: "bar",
            data: {
                labels: ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin"],
                datasets: [{
                    label: "Dépenses",
                    data: [200, 400, 300, 500, 600, 700],
                    backgroundColor: "rgba(255, 99, 132, 0.5)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 2,
                }],
            },
            options: {
                responsive: true,
            }
        });
    }
});
