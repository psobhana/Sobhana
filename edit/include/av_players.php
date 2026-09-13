
<!-- YouTube Popup -->
<div id="videoPopup" class="video-popup">
    <div class="video-header" id="dragHandle">
        Now Playing
        <span onclick="closeVideo()" style="cursor:pointer;">✖</span>
    </div>
    <iframe id="videoFrame"
        src=""
        frameborder="0"
        allow="autoplay; encrypted-media"
        allowfullscreen>
    </iframe>
</div>

<!-- Floating Audio Player -->
<div id="audioPopup" class="video-popup">
    <div class="video-header" id="audioDragHandle">
        Now Playing
        <span onclick="closeAudio()" style="cursor:pointer;">✖</span>
    </div>
    <div style="padding:10px; background:#111;">
        <audio id="audioPlayer" controls style="width:100%;">
            <source src="" type="audio/mpeg">
            Your browser does not support audio.
        </audio>
    </div>
</div>
