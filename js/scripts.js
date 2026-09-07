
const mobileBtn=document.getElementById('mobile-menu-btn');
const mobileMenu=document.getElementById('mobile-menu');

mobileBtn.addEventListener('click',()=>{
    const open=mobileMenu.classList.toggle('open');
    mobileBtn.textContent=open?'✕':'☰';
    mobileBtn.setAttribute('aria-expanded',open?'true':'false');
});

document.addEventListener('keydown',e=>{
    if(e.key==='Escape' && mobileMenu.classList.contains('open')){
        mobileMenu.classList.remove('open');
        mobileBtn.textContent='☰';
        mobileBtn.setAttribute('aria-expanded','false');
    }
});

function toggleSearch(){
    alert('Search the full archive of teachings, articles, and meditations.');
}

function toggleTheme(){
    const dark = document.body.classList.toggle('dark-mode');
    const icon = document.getElementById('theme-icon');
    const button = document.getElementById('theme-btn');

    icon.textContent = dark ? '☀' : '🌙';
    button.setAttribute('aria-label', dark ? 'Switch to light mode' : 'Switch to dark mode');
    button.setAttribute('title', dark ? 'Switch to light mode' : 'Switch to dark mode');

    localStorage.setItem('lionsRoarTheme', dark ? 'dark' : 'light');
}

if(localStorage.getItem('lionsRoarTheme') === 'dark'){
    document.body.classList.add('dark-mode');
    document.getElementById('theme-icon').textContent = '☀';
    document.getElementById('theme-btn').setAttribute('aria-label','Switch to light mode');
    document.getElementById('theme-btn').setAttribute('title','Switch to light mode');
}

function subscribe(e){
    e.preventDefault();
    alert('Thank you for subscribing!');
}
