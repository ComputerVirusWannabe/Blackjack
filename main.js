// written by Vien, edited and added to by David

// Anonymous self-invoking function
(function() { 
    console.log("main.js loaded");
})();

//Arrow function
const formatDate = (dateString) => new Date(dateString).toLocaleString();

// JS object blackjackUI
const blackjackUI = {
    errorBox: null,

    showError(message) {
        if (!this.errorBox) {
            this.errorBox = document.createElement("div");
            this.errorBox.className = "error-box";
            this.errorBox.setAttribute("role", "alert");
            this.errorBox.setAttribute("aria-live", "assertive");
            document.body.prepend(this.errorBox);
        }
        this.errorBox.textContent = message;
        this.errorBox.style.display = "block";
    },
    clearError() {
        if (this.errorBox) {
            this.errorBox.style.display = "none";
            this.errorBox.textContent = "";
        }
    },

    //Win celebration
    celebrateWin() {
        const winBox = document.createElement("div");
        winBox.className = "success-box";
        winBox.textContent = "You Win!";
        winBox.setAttribute("role", "status");
        winBox.setAttribute("aria-live", "polite");
        document.body.prepend(winBox);
        setTimeout(() => winBox.remove(), 4000);
    },

    //Visual bust feedback
    triggerBustEffect() {
        document.body.classList.add("bust-effect");
        setTimeout(() => document.body.classList.remove("bust-effect"), 1000);
    }
};
function flash(el) {
    if (!el) return;
    el.classList.add("flash");
    setTimeout(() => el.classList.remove("flash"), 400);
}
document.addEventListener("DOMContentLoaded", () => {

    //Home page, client-side validation with feedback
    const nameInput = document.getElementById("playerName");
    const form = document.getElementById("nameForm");
    if (nameInput && form) {
        nameInput.addEventListener("input", () => {
            const val = nameInput.value.trim();
            if (val.length >= 2 && /^[A-Za-z0-9_]+$/.test(val)) {
                nameInput.classList.remove("invalid");
                blackjackUI.clearError();
            }
        });
        form.addEventListener("submit", (e) => {
            const val = nameInput.value.trim();
            if (val.length < 2 || !/^[A-Za-z0-9_]+$/.test(val)) {
                e.preventDefault();
                nameInput.classList.add("invalid");
                blackjackUI.showError("Name must be 2–20 characters, letters, numbers, or _ only");
            } else {
                nameInput.classList.remove("invalid");
                blackjackUI.clearError();
            }
        });
        nameInput.focus(); //Accessibility
    }

    //Game page dynamic behaviors
    const hitBtn = document.querySelector("button[value='hit']");
    const standBtn = document.querySelector("button[value='stand']");
    const playerHand = document.querySelector(".player-hand");
    if (hitBtn && playerHand) {
        hitBtn.addEventListener("mouseover", () => playerHand.classList.add("highlight"));
        hitBtn.addEventListener("mouseout", () => playerHand.classList.remove("highlight"));
        hitBtn.addEventListener("click", () => flash(hitBtn));
    }
    if (standBtn) {
        standBtn.addEventListener("click", () => {
            const dealerHand = document.querySelector(".dealer-hand");
            if (dealerHand) flash(dealerHand);
        });
    }

    //Detect bust on page load
    const playerTotalEl = document.querySelector(".player-hand p:last-child");
    if (playerTotalEl && playerTotalEl.textContent.includes("Total:")) {
        const totalMatch = playerTotalEl.textContent.match(/\d+/);
        if (totalMatch) {
            const total = parseInt(totalMatch[0]);
            if (total > 21) {
                blackjackUI.triggerBustEffect();
                blackjackUI.showError("BUSTED! You went over 21!");
            }
        }
    }

    //Result page, win celebration
    const resultText = document.querySelector(".result-container p")?.textContent;
    if (resultText && resultText.includes("You Win")) {
        blackjackUI.celebrateWin();
        document.body.classList.add("win-celebration");
    }

    //History page, jQuery AJAX
    if (window.jQuery) {
        $("#loadHistory").on("click", () => {
            console.log("Loading history via jQuery…");
            $.getJSON("api/results.php", function(data) {
                const table = $("#history-table-body");
                table.empty();
                if (data.length === 0) {
                    table.append("<tr><td colspan='5'>No games played yet.</td></tr>");
                } else {
                    data.forEach(row => {
                        const outcomeClass = row.outcome === 'win' ? 'text-success' : 
                                           row.outcome === 'lose' ? 'text-danger' : 'text-warning';
                        table.append(`
                            <tr>
                                <td>${row.player_name}</td>
                                <td><strong class="${outcomeClass}">${row.outcome.toUpperCase()}</strong></td>
                                <td>${row.player_total}</td>
                                <td>${row.dealer_total}</td>
                                <td>${formatDate(row.played_at)}</td>
                            </tr>
                        `);
                    });
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error("History load failed:", textStatus, errorThrown);
                alert("Could not load history. Check that api/results.php is accessible.");
            });
        });
    }
});