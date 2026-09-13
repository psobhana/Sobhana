<?php
/**
 * Textise URL Reader
 * Opens any URL in Textise.net for clean, distraction-free reading.
 */
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Open any URL in Textise.net for distraction-free reading">
  <title>Textise URL Reader</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <?php require_once 'menubar.php'; ?>

  <main>
    <section class="hero compact">
      <h1>Textise Reader</h1>
      <p>Paste any URL to open it in a clean, text-only view. Perfect for distraction-free reading.</p>
    </section>

    <section class="form-section">
      <div class="form-card">
        <form id="urlForm">
          <div class="form-row">
            <input
              type="url"
              id="urlInput"
              name="url"
              class="input-field"
              placeholder="https://example.com/article"
              autocomplete="url"
              required
            >
            <button type="submit" class="btn-primary">
              Open in Textise
            </button>
          </div>
        </form>

        <div class="form-actions">
          <button type="button" class="btn-secondary" id="pasteButton">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
              <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
            </svg>
            Paste Clipboard
          </button>
          <button type="button" class="btn-danger" id="clearButton">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="3 6 5 6 21 6"></polyline>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            </svg>
            Clear
          </button>
        </div>

        <div class="form-message error" id="message"></div>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; <?php echo date('Y'); ?> Textise Reader. Distraction-free reading powered by Textise.net.</p>
  </footer>

  <script>
    function openInTextise(url) {
      url = url.trim();
      if (!url) return;

      if (!/^https?:\/\//i.test(url)) {
        url = "https://" + url;
      }

      try {
        const parsed = new URL(url);
        if (parsed.protocol !== "http:" && parsed.protocol !== "https:") {
          throw new Error("Invalid protocol");
        }

        const textiseUrl = "https://www.textise.net/showText.aspx?strURL=" +
          encodeURIComponent(encodeURIComponent(url));

        window.open(textiseUrl, "_blank");
      } catch (error) {
        const msg = document.getElementById("message");
        msg.textContent = "Please enter a valid HTTP or HTTPS URL.";
        msg.classList.add("show");
      }
    }

    document.getElementById("urlForm").addEventListener("submit", function(event) {
      event.preventDefault();
      document.getElementById("message").classList.remove("show");
      openInTextise(document.getElementById("urlInput").value);
    });

    document.getElementById("pasteButton").addEventListener("click", async function() {
      const message = document.getElementById("message");
      try {
        const text = await navigator.clipboard.readText();
        if (!text.trim()) {
          message.textContent = "The clipboard is empty.";
          message.classList.add("show");
          return;
        }
        document.getElementById("urlInput").value = text.trim();
        message.classList.remove("show");
      } catch (error) {
        message.textContent = "Clipboard access was blocked. Please paste the URL manually.";
        message.classList.add("show");
      }
    });

    document.getElementById("clearButton").addEventListener("click", function() {
      document.getElementById("urlInput").value = "";
      document.getElementById("message").classList.remove("show");
      document.getElementById("urlInput").focus();
    });
  </script>

</body>
</html>