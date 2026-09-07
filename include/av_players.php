<!-- YouTube Popup -->
<!-- YouTube PiP Popup -->

<div id="videoPopup" class="video-popup">

    <!-- Drag handle -->
    <div id="videoDragHandle" class="popup-drag-handle">
        <span class="drag-dots">⋮⋮</span>
    </div>

    <!-- Close button -->
    <span class="popup-close" onclick="closeVideo()">✖</span>

    <!-- YouTube video -->
    <iframe
        id="videoFrame"
        src=""
        frameborder="0"
        allow="autoplay; encrypted-media"
        allowfullscreen>
    </iframe>

</div>


<!-- Floating Audio PiP Popup -->

<div id="audioPopup" class="video-popup audio-popup">

    <!-- Drag handle -->
    <div id="audioDragHandle" class="popup-drag-handle">
        <span class="drag-dots">⋮⋮</span>
    </div>

    <!-- Close button -->
    <span class="popup-close" onclick="closeAudio()">✖</span>

    <!-- Audio player -->
    <div class="audio-player-container">
        <audio id="audioPlayer" controls>
            <source src="" type="audio/mpeg">
            Your browser does not support audio.
        </audio>
    </div>

</div>