
<?php
/**
 * YouTube URL Cleaner
 * Removes query parameters from YouTube URLs.
 */
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Clean YouTube URLs by removing unnecessary parameters">
  <title>YouTube URL Converter</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <?php require_once 'menubar.php'; ?>

  <main>
    <section class="hero compact">
      <h1>YouTube URL Converter</h1>
      <p>Paste YouTube URL(s) to remove unnecessary parameters. Supports multiple URLs at once.</p>
    </section>

    <section class="converter-section">
      <div class="converter-card">

        <textarea
          id="input"
          class="converter-textarea"
          placeholder="Paste YouTube URL(s) here, one per line..."
        ></textarea>

        <div class="toolbar">

          <button id="convertBtn" class="btn-primary" disabled>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
              <polyline points="16 3 21 3 21 8"></polyline>
              <line x1="4" y1="20" x2="21" y2="3"></line>
              <path d="M21 16v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            </svg>
            Convert
          </button>

          <button id="copyBtn" class="btn-secondary" disabled>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
              <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
              <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
            </svg>
            Copy Output
          </button>

          <button id="clearBtn" class="btn-danger">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            </svg>
            Clear
          </button>

        </div>

        <div id="output" class="output-area"></div>
        <div id="message" class="msg-success"></div>

      </div>
    </section>
  </main>

  <footer>
    <p>&copy; <?php echo date('Y'); ?> YouTube URL Converter.</p>
  </footer>

  <script>
    (function() {
      'use strict';

      const input      = document.getElementById("input");
      const output     = document.getElementById("output");
      const convertBtn = document.getElementById("convertBtn");
      const copyBtn    = document.getElementById("copyBtn");
      const message    = document.getElementById("message");

      function updateButton() {
        convertBtn.disabled = input.value.trim() === "";
      }

      input.addEventListener("input", updateButton);

      input.addEventListener("paste", function() {
        setTimeout(updateButton, 10);
      });

      function convertLinks() {

        const lines = input.value.trim().split(/\r?\n/);

        let results = [];
        let plainText = [];

        for (const line of lines) {

          const original = line.trim();

          if (original === "") {
            continue;
          }

          try {

            const url = new URL(original);

            /*
             * Accept:
             * https://www.youtube.com/live/VIDEO_ID?anything
             * https://www.youtube.com/watch?v=VIDEO_ID&anything
             * https://youtu.be/VIDEO_ID?anything
             */

            let youtube = "";

            // YouTube /live/ URLs
            if (
              (url.hostname === "www.youtube.com" ||
               url.hostname === "youtube.com") &&
              url.pathname.startsWith("/live/")
            ) {

              const videoID = url.pathname.split("/live/")[1].split("/")[0];

              if (videoID) {
                youtube = "https://www.youtube.com/live/" + videoID;
              }

            }

            // YouTube /watch URLs
            else if (
              (url.hostname === "www.youtube.com" ||
               url.hostname === "youtube.com") &&
              url.pathname === "/watch"
            ) {

              const videoID = url.searchParams.get("v");

              if (videoID) {
                youtube = "https://www.youtube.com/watch?v=" + videoID;
              }

            }

            // YouTube short URLs
            else if (
              url.hostname === "youtu.be"
            ) {

              const videoID = url.pathname.substring(1).split("/")[0];

              if (videoID) {
                youtube = "https://youtu.be/" + videoID;
              }

            }

            if (youtube) {

              results.push(
                '<div class="link-youtube">' +
                  '<a href="' + youtube + '" target="_blank" rel="noopener noreferrer">' +
                    youtube +
                  '</a>' +
                '</div>'
              );

              plainText.push(youtube);

            } else {

              results.push(
                '<div class="msg-error">' +
                  'Invalid YouTube URL:<br>' +
                  original +
                '</div>'
              );

            }

          } catch (e) {

            results.push(
              '<div class="msg-error">' +
                'Invalid URL:<br>' +
                original +
              '</div>'
            );

          }
        }

        output.innerHTML = results.join("<hr>");
        output.dataset.copy = plainText.join("\n");

        copyBtn.disabled = plainText.length === 0;
      }

      convertBtn.addEventListener("click", convertLinks);

      copyBtn.addEventListener("click", function() {

        const text = output.dataset.copy;

        navigator.clipboard.writeText(text)
          .then(function() {

            message.textContent = "Copied to clipboard!";
            message.classList.add("show");

            setTimeout(function() {
              message.classList.remove("show");
            }, 2000);

          })
          .catch(function() {

            message.textContent = "Copy failed.";
            message.classList.add("show");

          });

      });

      document.getElementById("clearBtn").addEventListener("click", function() {

        input.value = "";
        output.innerHTML = "";
        output.dataset.copy = "";

        message.classList.remove("show");
        message.textContent = "";

        convertBtn.disabled = true;
        copyBtn.disabled = true;

        input.focus();

      });

    })();
  </script>

</body>
</html>

