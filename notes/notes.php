
<?php
/**
 * Notes - Database-loaded, auto-saving notepad
 * Requires config_notes.php, load.php and save.php
 */
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Simple auto-saving notes">
  <title>Notes</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <?php require_once 'menubar.php'; ?>

  <main class="notes-page">
    <div class="notes-toolbar">
      <button class="btn-primary" onclick="copyClipboard()">
        📄 Copy
      </button>

      <button class="btn-secondary" onclick="pasteClipboard()">
        📋 Paste
      </button>

      <button class="btn-danger" onclick="clearNote()">
        🗑 Clear
      </button>
    </div>

    <div class="notes-status" id="s">Loading notes...</div>

    <textarea
      id="n"
      class="notes-textarea"
      spellcheck="false"
      placeholder="Start typing your notes here..."
      readonly
    ></textarea>
  </main>

  <script>
    (function () {
      'use strict';

      const n = document.getElementById('n');
      const s = document.getElementById('s');

      let tm;
      let loaded = false;

      // Load the saved note from the database.
      async function load() {
        n.readOnly = true;
        s.textContent = 'Loading notes...';

        try {
          const response = await fetch('load.php', {
            method: 'GET',
            cache: 'no-store'
          });

          if (!response.ok) {
            throw new Error('Could not load the database content.');
          }

          // Replace the textarea content with the saved database content.
          const content = await response.text();

          n.value = content;
          loaded = true;
          n.readOnly = false;

          s.textContent = 'Notes loaded successfully';

        } catch (error) {
          loaded = false;
          n.readOnly = true;
          s.textContent = 'Failed to load notes. Please reload the page.';
          console.error('Loading notes failed:', error);
        }
      }

      // Save the current note to the database.
      async function save() {
        if (!loaded) return;

        const fd = new FormData();
        fd.append('content', n.value);

        s.textContent = 'Saving...';

        try {
          const response = await fetch('save.php', {
            method: 'POST',
            body: fd
          });

          if (!response.ok) {
            throw new Error('The server could not save the note.');
          }

          s.textContent =
            'Saved ' + new Date().toLocaleTimeString();

        } catch (error) {
          s.textContent = 'Save failed. Please try again.';
          console.error('Saving notes failed:', error);
        }
      }

      function triggerSave() {
        if (!loaded) return;

        clearTimeout(tm);
        tm = setTimeout(save, 800);
      }

      n.addEventListener('input', function () {
        triggerSave();
      });

      window.clearNote = function () {
        if (!loaded) return;

        n.value = '';
        triggerSave();
        n.focus();

        s.textContent = 'Note cleared';
      };

      window.copyClipboard = async function () {
        try {
          await navigator.clipboard.writeText(n.value);
          s.textContent = 'Copied to clipboard';

        } catch (error) {
          n.select();

          const copied = document.execCommand('copy');

          s.textContent = copied
            ? 'Copied to clipboard'
            : 'Copy failed';
        }
      };

      window.pasteClipboard = async function () {
        if (!loaded) return;

        try {
          const text = await navigator.clipboard.readText();

          const start = n.selectionStart;
          const end = n.selectionEnd;

          n.setRangeText(text, start, end, 'end');

          triggerSave();
          s.textContent = 'Pasted from clipboard';

        } catch (error) {
          alert(
            'Clipboard access was denied.\n\n' +
            'Tap inside the note and use your browser\'s Paste option.'
          );
        }
      };

      // Load database content before enabling editing and auto-saving.
      load();

    })();
  </script>

</body>
</html>
