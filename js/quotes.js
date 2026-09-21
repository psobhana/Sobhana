/* =========================
   Random Quote
   ========================= */

const quotes = <?php
echo json_encode($quotes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>;

// Select a random quote
const randomIndex = Math.floor(Math.random() * quotes.length);

const quote = quotes[randomIndex];

// Display quote
document.getElementById("quote").textContent = quote.text;

// Display reference
document.getElementById("reference").textContent = "— " + quote.reference;


/* =========================
   Sutta Quote
   ========================= */

const quotes2 = <?php
echo json_encode(
    $quotes2,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
);
?>;

// Select a random teaching
const randomIndex2 = Math.floor(Math.random() * quotes2.length);

const quote2 = quotes2[randomIndex2];

// Display teaching
document.getElementById("quote2").textContent = quote2.text2;

// Display reference
document.getElementById("reference2").textContent = "— " + quote2.reference2;

