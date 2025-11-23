// written by Vien

// Anonymous self-invoking function
(function() { 
    console.log("main.js loaded");
})();

// JS object blackjackUI
const blackjackUI = {
    errorBox: null,

    showError(message) {
        if (!this.errorBox) {
            this.errorBox = document.createElement("div");
            this.errorBox.className = "error-box";
            document.body.prepend(this.errorBox);
        }
        this.errorBox.textContent = message;
        this.errorBox.style.display = "block";
    },

    clearError() {
        if (this.errorBox) {
            this.errorBox.style.display = "none";
        }
    },

    // AJAX history loader
    loadHistory() {
        fetch("results.php")
            .then(res => res.json())
            .then(data => {
                const table = document.getElementById("history-table-body");
                if (!table) return;

                table.innerHTML = ""; // clear table

                data.forEach(row => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${row.player_name}</td>
                        <td>${row.outcome}</td>
                        <td>${row.player_total}</td>
                        <td>${row.dealer_total}</td>
                        <td>${row.played_at}</td>
                    `;
                    table.appendChild(tr);
                });
            })
            .catch(err => {
                console.error(err);
                alert("Could not load history.");
            });
    }
};
// Function to flash an element
const flash = (el) => {
    el.classList.add("flash");
    setTimeout(() => el.classList.remove("flash"), 300);
};



// home page input validation

document.addEventListener("DOMContentLoaded", () => {

    const nameInput = document.getElementById("playerName");
    const form = document.getElementById("nameForm");

    if (nameInput && form) {

        nameInput.addEventListener("input", () => {
            if (nameInput.value.trim().length >= 2) {
                nameInput.classList.remove("invalid");
                blackjackUI.clearError();
            }
        });

        form.addEventListener("submit", (e) => {
            if (nameInput.value.trim().length < 2) {
                e.preventDefault();
                nameInput.classList.add("invalid");
                blackjackUI.showError("Please enter a valid name (2+ characters).");
            }
        });
    }


   
    // game page DOM manipulation
   
    const hitBtn = document.querySelector("button[value='hit']");
    const standBtn = document.querySelector("button[value='stand']");
    const playerSection = document.querySelector(".player-hand");
    const dealerSection = document.querySelector(".dealer-hand");

    if (hitBtn && playerSection) {
        // Dynamic style change on hover
        hitBtn.addEventListener("mouseover", () => {
            playerSection.classList.add("highlight");
        });

        hitBtn.addEventListener("mouseout", () => {
            playerSection.classList.remove("highlight");
        });
    }

    if (standBtn && dealerSection) {
        standBtn.addEventListener("click", () => {
            flash(dealerSection);
        });
    }


   
    // history page jquery example + ajax

    if (window.jQuery) {
        $("#loadHistory").on("click", () => {
            console.log("Loading history via jQuery…");

            $.getJSON("results.php", function(data) {
                const table = $("#history-table-body");
                table.empty();

                data.forEach(row => {
                    table.append(`
                        <tr>
                            <td>${row.player_name}</td>
                            <td>${row.outcome}</td>
                            <td>${row.player_total}</td>
                            <td>${row.dealer_total}</td>
                            <td>${row.played_at}</td>
                        </tr>
                    `);
                });
            });
        });
    }

});
