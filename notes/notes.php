<?php
/**
 * Notes - Auto-saving notepad
 * Requires load.php and save.php in the same directory
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

    <div class="notes-status" id="s"></div>

    <textarea id="n" class="notes-textarea" spellcheck="false" placeholder="Start typing your notes here..."></textarea>
  </main>

  <script>
    (function() {
      'use strict';

      const n = document.getElementById('n');
      const s = document.getElementById('s');
      let tm;

      async function load() {
        try {
          const t = await fetch('load.php');
          n.value = await t.text();
        } catch (e) {
          s.textContent = 'Ready';
        }
      }

      async function save() {
        const fd = new FormData();
        fd.append('content', n.value);

        try {
          await fetch('save.php', {
            method: 'POST',
            body: fd
          });
          s.textContent = 'Saved ' + new Date().toLocaleTimeString();
        } catch (e) {
          s.textContent = 'Save failed';
        }
      }

      n.addEventListener('input', () => {
        clearTimeout(tm);
        tm = setTimeout(save, 800);
      });

      function triggerSave() {
        clearTimeout(tm);
        tm = setTimeout(save, 100);
      }

      window.clearNote = function() {
        n.value = '';
        triggerSave();
        n.focus();
        s.textContent = 'Note cleared';
      };

      window.copyClipboard = async function() {
        try {
          await navigator.clipboard.writeText(n.value);
          s.textContent = 'Copied to clipboard';
        } catch (e) {
          n.select();
          document.execCommand('copy');
          s.textContent = 'Copied to clipboard';
        }
      };

      window.pasteClipboard = async function() {
        try {
          const text = await navigator.clipboard.readText();
          const start = n.selectionStart;
          const end   = n.selectionEnd;
          n.setRangeText(text, start, end, 'end');
          triggerSave();
          s.textContent = 'Pasted from clipboard';
        } catch (e) {
          alert('Clipboard access was denied.\n\nTap inside the note and use your browser\'s Paste option.');
        }
      };

      load();
    })();
  </script>

</body>
</html>