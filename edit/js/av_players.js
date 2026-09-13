

// 1. Video Functions
function openVideo(id) {
    const popup = document.getElementById('videoPopup');
    const frame = document.getElementById('videoFrame');
    if (popup && frame) {
        // Set the YouTube URL with autoplay and JS API enabled
        frame.src = "https://www.youtube.com/embed/" + id + "?autoplay=1&enablejsapi=1";
        popup.style.display = "block";
    }
}

function closeVideo() {
    const popup = document.getElementById('videoPopup');
    const frame = document.getElementById('videoFrame');
    if (popup && frame) {
        // Resetting to about:blank stops the video immediately and reliably
        frame.src = "about:blank"; 
        popup.style.display = "none";
    }
}

// 2. Audio Functions
function playAudio(link) {
    const popup = document.getElementById('audioPopup');
    const player = document.getElementById('audioPlayer');
    if (popup && player) {
        player.src = link;
        player.play();
        popup.style.display = "block";
    }
}

function closeAudio() {
    const popup = document.getElementById('audioPopup');
    const player = document.getElementById('audioPlayer');
    if (popup && player) {
        player.pause();
        player.src = ""; // Clear source to stop background loading
        popup.style.display = "none";
    }
}

// 3. Generic Draggable Functionality (Works for both Video and Audio)
function makeDraggable(popupId, handleId) {
    const popup = document.getElementById(popupId);
    const handle = document.getElementById(handleId);
    let isDragging = false;
    let offsetX, offsetY;

    if (!popup || !handle) return;

    handle.addEventListener("mousedown", function(e) {
        isDragging = true;
        offsetX = e.clientX - popup.offsetLeft;
        offsetY = e.clientY - popup.offsetTop;
        
        // Ensure manual positioning works
        popup.style.right = "auto";
        popup.style.bottom = "auto";
        popup.style.margin = "0";
    });

    document.addEventListener("mousemove", function(e) {
        if (isDragging) {
            popup.style.left = (e.clientX - offsetX) + "px";
            popup.style.top = (e.clientY - offsetY) + "px";
        }
    });

    document.addEventListener("mouseup", function() {
        isDragging = false;
    });
}

// Initialize dragging for both popups
makeDraggable("videoPopup", "dragHandle");
makeDraggable("audioPopup", "audioDragHandle");

// ====================================
// --- MOUSE EVENTS ---
dragHandle.addEventListener("mousedown", function(e) {
    // Don't drag if clicking a button
    if (e.target.closest('button')) return;
    startDrag(e.clientX, e.clientY);
});

document.addEventListener("mousemove", function(e) {
    doDrag(e.clientX, e.clientY);
});

document.addEventListener("mouseup", endDrag);


// --- TOUCH EVENTS (MOBILE) ---
// We use a more careful approach for touch to avoid blocking clicks
dragHandle.addEventListener("touchstart", function(e) {
    // 1. Check if we are tapping a button. If so, DO NOT preventDefault and DO NOT start dragging.
    // This allows the 'click' event to fire normally on the button.
    if (e.target.closest('button')) {
        return; 
    }
    
    // 2. If it's not a button, we can prepare for dragging.
    const touch = e.touches[0];
    startDrag(touch.clientX, touch.clientY);
    
    // 3. We DO NOT call e.preventDefault() here. 
    // Calling it in touchstart is what often kills the subsequent click event on mobile.
}, { passive: true }); // Use passive: true to improve scrolling performance and avoid blocking

document.addEventListener("touchmove", function(e) {
    if (isDragging) {
        const touch = e.touches[0];
        doDrag(touch.clientX, touch.clientY);
        
        // 4. ONLY preventDefault during the MOVE phase if we are actually dragging.
        // This prevents the page from scrolling while moving the popup.
        if (e.cancelable) {
            e.preventDefault();
        }
    }
}, { passive: false });

document.addEventListener("touchend", endDrag);
document.addEventListener("touchcancel", endDrag);
