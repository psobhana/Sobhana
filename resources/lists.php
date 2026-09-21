<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple HTML Template</title>
    <style>
	
:root{
    --primary:#9C6644;
    --primary-dark:#7f4f2f;
    --bg:#f7f5f2;
    --white:#fff;
    --text:#292524;
    --muted:#78716c;
    --border:#e7e5e4;
    --border2:#4c2208;
    --green:#047857;
    --dark:#1c1917;
}
body.dark-mode{
    --bg:#181614;
    --white:#24211f;
    --text:#f5f5f4;
    --muted:#a8a29e;
    --border:#44403c;
    --border2:#91410f;
    --green:#34d399;
    --dark:#0c0a09;
}
        .list-basic {
    margin: 20px 0;
    padding-left: 28px;
    color: var(--text);
    line-height: 1.8;
}

.list-basic li {
    margin-bottom: 8px;
}

.list-basic li::marker {
    color: var(--primary);
    font-weight: bold;
}





.list-check {
    list-style: none;
    margin: 20px 0;
    padding: 0;
}

.list-check li {
    position: relative;
    padding: 8px 0 8px 30px;
    color: var(--text);
}

.list-check li::before {
    content: "✓";
    position: absolute;
    left: 0;
    top: 8px;
    color: var(--green);
    font-weight: bold;
}




.list-card {
    list-style: none;
    margin: 20px 0;
    padding: 0;
}

.list-card li {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 15px 20px;
    margin-bottom: 10px;
    color: var(--text);
    transition: .2s ease;
}

.list-card li:hover {
    border-color: var(--primary);
    transform: translateX(4px);
}




.list-dhamma {
    list-style: none;
    margin: 20px 0;
    padding: 0;
}

.list-dhamma li {
    border-left: 4px solid var(--primary);
    background: var(--white);
    padding: 12px 18px;
    margin-bottom: 10px;
    border-radius: 0 14px 14px 0;
    color: var(--text);
}

.list-dhamma li strong {
    color: var(--primary);
}




.list-number {
    list-style: none;
    counter-reset: list-counter;
    margin: 20px 0;
    padding: 0;
}

.list-number li {
    counter-increment: list-counter;
    position: relative;
    padding: 10px 10px 10px 48px;
    color: var(--text);
}

.list-number li::before {
    content: counter(list-counter);
    position: absolute;
    left: 0;
    top: 7px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary);
    color: #fff;
    border-radius: 50%;
    font-size: 13px;
    font-weight: bold;
}

.list-inline {
    list-style: none;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin: 20px 0;
    padding: 0;
}

.list-inline li {
    background: var(--white);
    border: 1px solid var(--border);
    color: var(--text);
    padding: 7px 14px;
    border-radius: 999px;
    font-size: 14px;
    transition: .2s ease;
}

.list-inline li:hover {
    border-color: var(--primary);
    color: var(--primary);
}


/* =========================
   Dotted List - Basic
   ========================= */

.list-dotted {
    list-style: none;
    padding-left: 0;
    margin: 20px 0;
}

.list-dotted li {
    position: relative;
    padding: 7px 0 7px 24px;
    color: var(--text);
}

.list-dotted li::before {
    content: "";
    position: absolute;
    left: 4px;
    top: 15px;
    width: 7px;
    height: 7px;
    background: var(--primary);
    border-radius: 50%;
}

/* =========================
   Dotted List - Large
   ========================= */

.list-dotted-large {
    list-style: none;
    padding-left: 0;
    margin: 20px 0;
}

.list-dotted-large li {
    position: relative;
    padding: 10px 0 10px 30px;
    color: var(--text);
    font-size: 18px;
}

.list-dotted-large li::before {
    content: "";
    position: absolute;
    left: 5px;
    top: 18px;
    width: 10px;
    height: 10px;
    background: var(--primary);
    border-radius: 50%;
}

/* =========================
   Dotted List - Hollow
   ========================= */

.list-dotted-hollow {
    list-style: none;
    padding-left: 0;
    margin: 20px 0;
}

.list-dotted-hollow li {
    position: relative;
    padding: 7px 0 7px 24px;
    color: var(--text);
}

.list-dotted-hollow li::before {
    content: "";
    position: absolute;
    left: 3px;
    top: 14px;
    width: 8px;
    height: 8px;
    border: 2px solid var(--primary);
    border-radius: 50%;
    box-sizing: border-box;
}

/* =========================
   Dotted List - Timeline
   ========================= */

.list-dotted-line {
    list-style: none;
    padding-left: 0;
    margin: 20px 0;
}

.list-dotted-line li {
    position: relative;
    padding: 8px 0 8px 32px;
    color: var(--text);
}

.list-dotted-line li::before {
    content: "";
    position: absolute;
    left: 4px;
    top: 14px;
    width: 9px;
    height: 9px;
    background: var(--primary);
    border: 3px solid var(--white);
    border-radius: 50%;
    box-shadow: 0 0 0 1px var(--primary);
    z-index: 1;
}

.list-dotted-line li:not(:last-child)::after {
    content: "";
    position: absolute;
    left: 8px;
    top: 24px;
    bottom: -8px;
    width: 1px;
    background: var(--border);
}

/* =========================
   Dotted List - Cards
   ========================= */

.list-dotted-card {
    list-style: none;
    padding: 0;
    margin: 20px 0;
    display: grid;
    gap: 10px;
}

.list-dotted-card li {
    position: relative;
    padding: 13px 18px 13px 40px;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 12px;
    color: var(--text);
    transition: 0.2s ease;
}

.list-dotted-card li::before {
    content: "";
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    width: 7px;
    height: 7px;
    background: var(--primary);
    border-radius: 50%;
}

.list-dotted-card li:hover {
    border-color: var(--primary);
    transform: translateY(-1px);
}

/* =========================
   Dotted List - Brown
   ========================= */

.list-dotted-brown {
    list-style: none;
    padding-left: 0;
    margin: 20px 0;
}

.list-dotted-brown li {
    position: relative;
    padding: 8px 0 8px 28px;
    color: var(--text);
    border-bottom: 1px dotted var(--border);
}

.list-dotted-brown li::before {
    content: "•";
    position: absolute;
    left: 5px;
    top: 2px;
    color: var(--primary);
    font-size: 24px;
    line-height: 1.5;
}

.list-dotted-brown li:last-child {
    border-bottom: none;
}

/* =========================
   Dotted List - Double Dot
   ========================= */

.list-dotted-double {
    list-style: none;
    padding-left: 0;
    margin: 20px 0;
}

.list-dotted-double li {
    position: relative;
    padding: 8px 0 8px 32px;
    color: var(--text);
}

.list-dotted-double li::before,
.list-dotted-double li::after {
    content: "";
    position: absolute;
    border-radius: 50%;
    background: var(--primary);
}

.list-dotted-double li::before {
    left: 4px;
    top: 14px;
    width: 8px;
    height: 8px;
}

.list-dotted-double li::after {
    left: 16px;
    top: 14px;
    width: 5px;
    height: 5px;
    opacity: 0.6;
}

/* =========================
   Dotted List - Soft
   ========================= */

.list-dotted-soft {
    list-style: none;
    padding: 10px 15px;
    margin: 20px 0;
    background: var(--bg);
    border-radius: 16px;
}

.list-dotted-soft li {
    position: relative;
    padding: 8px 0 8px 26px;
    color: var(--text);
}

.list-dotted-soft li::before {
    content: "";
    position: absolute;
    left: 5px;
    top: 15px;
    width: 7px;
    height: 7px;
    background: var(--primary);
    border-radius: 50%;
}

/* ========================================
   DOTTED LISTS - DARK MODE
   ======================================== */

body.dark-mode .list-dotted li,
body.dark-mode .list-dotted-large li,
body.dark-mode .list-dotted-hollow li,
body.dark-mode .list-dotted-line li,
body.dark-mode .list-dotted-card li,
body.dark-mode .list-dotted-brown li,
body.dark-mode .list-dotted-double li,
body.dark-mode .list-dotted-soft li {
    color: var(--text);
}

/* Card lists */
body.dark-mode .list-dotted-card li {
    background: var(--white);
    border-color: var(--border);
}

body.dark-mode .list-dotted-card li:hover {
    border-color: var(--primary);
}

/* Timeline */
body.dark-mode .list-dotted-line li::before {
    border-color: var(--white);
}

body.dark-mode .list-dotted-line li:not(:last-child)::after {
    background: var(--border);
}

/* Soft list */
body.dark-mode .list-dotted-soft {
    background: var(--bg);
}

/* Brown dotted list */
body.dark-mode .list-dotted-brown li {
    border-bottom-color: var(--border);
}


    </style>
</head>
<body>
    <header>
        <h1>Welcome to My Website</h1>
    </header>
    
	<ul class="list-basic">
    <li>Teachings of the Buddha</li>
    <li>Theravada Buddhist meditation</li>
    <li>Tipitaka chanting</li>
    <li>Dhamma talks and discussions</li>
</ul>


<ul class="list-check">
    <li>Listen to Dhamma teachings</li>
    <li>Explore the Tipitaka</li>
    <li>Study meditation instructions</li>
    <li>Browse Buddhist resources</li>
</ul>

<ul class="list-card">
    <li>Majjhima Nikāya</li>
    <li>Dīgha Nikāya</li>
    <li>Saṃyutta Nikāya</li>
    <li>Aṅguttara Nikāya</li>
</ul>

<ul class="list-dhamma">
    <li><strong>Dhamma</strong> — The teaching of the Buddha</li>
    <li><strong>Sīla</strong> — Ethical conduct</li>
    <li><strong>Samādhi</strong> — Concentration and collectedness</li>
    <li><strong>Paññā</strong> — Wisdom and understanding</li>
</ul>

<ul class="list-number">
    <li>Hearing the Dhamma</li>
    <li>Reflecting on the teaching</li>
    <li>Practising meditation</li>
    <li>Developing wisdom</li>
</ul>


<ul class="list-inline">
    <li>Tipitaka</li>
    <li>Meditation</li>
    <li>Suttas</li>
    <li>Chanting</li>
    <li>Dhamma Talks</li>
</ul>

<ul class="list-dotted">
    <li>The Four Noble Truths</li>
    <li>The Noble Eightfold Path</li>
    <li>The Three Characteristics</li>
    <li>The Five Aggregates</li>
</ul>

<ul class="list-dotted-card">
    <li>Introduction to the Dhamma</li>
    <li>Understanding Anicca</li>
    <li>Understanding Dukkha</li>
    <li>Understanding Anatta</li>
</ul>

<ul class="list-dotted-brown">
    <li>Introduction to the Dhamma</li>
    <li>Understanding Anicca</li>
    <li>Understanding Dukkha</li>
    <li>Understanding Anatta</li>
</ul>

<ul class="list-dotted-double">
    <li>Introduction to the Dhamma</li>
    <li>Understanding Anicca</li>
    <li>Understanding Dukkha</li>
    <li>Understanding Anatta</li>
</ul>

<ul class="list-dotted-soft">
    <li>Introduction to the Dhamma</li>
    <li>Understanding Anicca</li>
    <li>Understanding Dukkha</li>
    <li>Understanding Anatta</li>
</ul>


</body>
</html>
