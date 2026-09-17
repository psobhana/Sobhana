// ====================================
// 1. VIDEO FUNCTIONS
// ====================================

function openVideo(id) {

    const popup = document.getElementById('videoPopup');
    const frame = document.getElementById('videoFrame');

    if (popup && frame) {

        frame.src =
            "https://www.youtube.com/embed/" +
            id +
            "?autoplay=1&enablejsapi=1";

        popup.style.display = "block";
    }
}


function closeVideo() {

    const popup = document.getElementById('videoPopup');
    const frame = document.getElementById('videoFrame');

    if (popup && frame) {

        frame.src = "about:blank";
        popup.style.display = "none";
    }
}


// ====================================
// 2. AUDIO FUNCTIONS
// ====================================

function playAudio(link) {

    const popup = document.getElementById('audioPopup');
    const player = document.getElementById('audioPlayer');

    if (popup && player) {

        player.src = link;

        popup.style.display = "block";

        player.play().catch(function () {
            // Browser may block autoplay
        });
    }
}


function closeAudio() {

    const popup = document.getElementById('audioPopup');
    const player = document.getElementById('audioPlayer');

    if (popup && player) {

        player.pause();
        player.src = "";

        popup.style.display = "none";
    }
}


// ====================================
// 3. DRAGGABLE POPUP
// ====================================

function makeDraggable(popupId, handleId) {

    const popup = document.getElementById(popupId);
    const handle = document.getElementById(handleId);

    if (!popup || !handle) return;

    let isDragging = false;

    let offsetX = 0;
    let offsetY = 0;


    // =================================
    // MOUSE
    // =================================

    handle.addEventListener("mousedown", function (e) {

        isDragging = true;

        const rect = popup.getBoundingClientRect();

        offsetX = e.clientX - rect.left;
        offsetY = e.clientY - rect.top;

        // Remove bottom/right positioning
        popup.style.right = "auto";
        popup.style.bottom = "auto";
        popup.style.margin = "0";

        e.preventDefault();
    });


    document.addEventListener("mousemove", function (e) {

        if (!isDragging) return;

        popup.style.left =
            (e.clientX - offsetX) + "px";

        popup.style.top =
            (e.clientY - offsetY) + "px";
    });


    document.addEventListener("mouseup", function () {

        isDragging = false;
    });


    // =================================
    // TOUCH / MOBILE
    // =================================

    handle.addEventListener("touchstart", function (e) {

        const touch = e.touches[0];

        const rect = popup.getBoundingClientRect();

        isDragging = true;

        offsetX = touch.clientX - rect.left;
        offsetY = touch.clientY - rect.top;

        popup.style.right = "auto";
        popup.style.bottom = "auto";
        popup.style.margin = "0";

    }, { passive: true });


    document.addEventListener("touchmove", function (e) {

        if (!isDragging) return;

        const touch = e.touches[0];

        popup.style.left =
            (touch.clientX - offsetX) + "px";

        popup.style.top =
            (touch.clientY - offsetY) + "px";

        if (e.cancelable) {
            e.preventDefault();
        }

    }, { passive: false });


    document.addEventListener("touchend", function () {

        isDragging = false;
    });


    document.addEventListener("touchcancel", function () {

        isDragging = false;
    });
}


// ====================================
// 4. INITIALIZE DRAGGING
// ====================================

makeDraggable(
    "videoPopup",
    "videoDragHandle"
);

makeDraggable(
    "audioPopup",
    "audioDragHandle"
);


// ====================================
// 5. RANDOM AUDIO PLAYER
// ====================================


async function loadSongs() {
    try {
        const response = await fetch('pages/lists/pirith.json');
        const jsonData = await response.json();
        return jsonData.songs;
    } catch (error) {
        console.error("Error loading songs:", error);
        return [];
    }
}


async function playRandomSong() {

    const songs = await loadSongs();

    if (songs.length === 0) return;

    const randomIndex =
        Math.floor(Math.random() * songs.length);

    const randomSong = songs[randomIndex];

    // Use the audio player/popup from Script 2
    playAudio(randomSong);
}