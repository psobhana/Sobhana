<?php
/**
 * Keep Notes
 * Full-featured notes app with sidebar, search, undo/redo, and auto-save.
 * Requires api.php in the same directory.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="description" content="Full-featured notes with auto-save and dark mode">
  <title>Keep</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <?php require_once 'menubar.php'; ?>

  <div class="keep-app">
    <div id="keepOverlay" class="keep-overlay"></div>

    <aside id="keepSidebar" class="keep-sidebar">
      <div class="keep-sidebar-header">
        <h1>📝 Keep</h1>
        <input type="text" id="keepSearchInput" class="keep-search" placeholder="Search notes..." autocomplete="off">
        <button id="keepNewNoteBtn" class="keep-new-btn">+ New Note</button>
        <div id="keepNoteCount" class="keep-count">0 notes</div>
      </div>
      <div id="keepNoteList" class="keep-note-list"></div>
    </aside>

    <div class="keep-main">
      <div class="keep-toolbar">
        <button id="keepMobileToggle" class="keep-mobile-toggle">☰</button>

        <button id="keepCopyBtn" class="keep-toolbar-btn" title="Copy content">📋 Copy</button>
        <button id="keepPasteBtn" class="keep-toolbar-btn" title="Paste from clipboard">📄 Paste</button>
        <button id="keepClearBtn" class="keep-toolbar-btn" title="Clear content">✕ Clear</button>
        <button class="keep-toolbar-btn" onclick="window.location.href='notes.php';">1</button>
        <button class="keep-toolbar-btn" onclick="window.location.href='links.php';">P</button>
        <button class="keep-toolbar-btn" onclick="window.location.href='reader.php';">T</button>
        <button id="keepDeleteBtn" class="keep-toolbar-btn danger" title="Delete note">🗑 Delete</button>

        <button id="keepUndoBtn" class="keep-toolbar-btn" title="Undo (Ctrl+Z)">↩ Undo</button>
        <button id="keepRedoBtn" class="keep-toolbar-btn" title="Redo (Ctrl+Y)">↪ Redo</button>
      </div>

      <div class="keep-editor-area" id="keepEditorArea">
        <input type="text" id="keepTitleInput" class="keep-title-input" placeholder="Note title..." autocomplete="off">
        <textarea id="keepContentTextarea" class="keep-content-textarea" placeholder="Start typing your note..."></textarea>
      </div>

      <div class="keep-status-bar">
        <div>
          <span id="keepWordCount">0 words</span> &nbsp;|&nbsp;
          <span id="keepCharCount">0 chars</span>
        </div>
        <div>
          <span id="keepLastModified"></span>
          <span id="keepSaveStatus" class="keep-save-status"></span>
        </div>
      </div>
    </div>
  </div>

  <script>
  (function() {
    'use strict';

    // ===================== STATE =====================
    let notes = [];
    let currentNoteId = null;
    let autoSaveTimer = null;
    let isSaving = false;
    let undoStack = [];
    let redoStack = [];
    const MAX_HISTORY = 50;
    let lastState = null;
    let stateTimer = null;
    let lastSavedState = { title: '', content: '', color: '#ffffff' };

    // ===================== DOM =====================
    const $ = id => document.getElementById(id);
    const els = {
      noteList: $('keepNoteList'),
      searchInput: $('keepSearchInput'),
      titleInput: $('keepTitleInput'),
      contentTextarea: $('keepContentTextarea'),
      newNoteBtn: $('keepNewNoteBtn'),
      undoBtn: $('keepUndoBtn'),
      redoBtn: $('keepRedoBtn'),
      deleteBtn: $('keepDeleteBtn'),
      copyBtn: $('keepCopyBtn'),
      pasteBtn: $('keepPasteBtn'),
      clearBtn: $('keepClearBtn'),
      saveStatus: $('keepSaveStatus'),
      lastModified: $('keepLastModified'),
      wordCount: $('keepWordCount'),
      charCount: $('keepCharCount'),
      noteCount: $('keepNoteCount'),
      colorSwatches: document.querySelectorAll('.keep-color-swatch'),
      mobileToggle: $('keepMobileToggle'),
      sidebar: $('keepSidebar'),
      overlay: $('keepOverlay'),
      editorArea: $('keepEditorArea')
    };

    // ===================== INIT =====================
    function init() {
      loadNotes();
      setupEvents();
    }

    // ===================== API =====================
    async function api(action, params) {
      const url = new URL('api.php', location.href);
      url.searchParams.set('action', action);
      if (params?.search) url.searchParams.set('search', params.search);
      if (params?.id) url.searchParams.set('id', params.id);

      const opts = { method: 'GET' };
      if (params?.body) {
        opts.method = 'POST';
        opts.headers = { 'Content-Type': 'application/json' };
        opts.body = JSON.stringify(params.body);
      }

      const res = await fetch(url, opts);
      const data = await res.json().catch(() => ({ error: 'Invalid JSON response' }));

      if (!res.ok) {
        const msg = data.error || ('HTTP ' + res.status);
        throw new Error(msg);
      }
      if (data && data.error) {
        throw new Error(data.error);
      }
      return data;
    }

    // ===================== NOTES LIST =====================
    async function loadNotes(search) {
      try {
        notes = await api('list', { search: search || '' });
        renderNoteList();
      } catch (e) {
        console.error('Load failed', e);
        els.noteList.innerHTML = '<div style="padding:1rem;text-align:center;color:var(--text-secondary)">Failed to load notes: ' + esc(e.message) + '</div>';
      }
    }

    function renderNoteList() {
      els.noteList.innerHTML = '';
      els.noteCount.textContent = notes.length + ' note' + (notes.length !== 1 ? 's' : '');

      if (notes.length === 0) {
        els.noteList.innerHTML = '<div style="padding:1.5rem;text-align:center;color:var(--text-secondary);font-size:0.875rem">No notes yet.<br>Create your first note above.</div>';
        return;
      }

      notes.forEach(note => {
        const div = document.createElement('div');
        div.className = 'keep-note-item' + (note.id == currentNoteId ? ' active' : '');
        div.style.borderLeftColor = note.color || '#3b82f6';
        div.innerHTML =
          '<div class="keep-note-title">' + esc(note.title || 'Untitled') + '</div>' +
          '<div class="keep-note-preview">' + esc(note.preview || '') + '</div>' +
          '<div class="keep-note-meta">' +
            '<span>' + fmtDate(note.updated_at) + '</span>' +
          '</div>';
        div.addEventListener('click', () => selectNote(note.id));
        els.noteList.appendChild(div);
      });
    }

    function esc(t) {
      const d = document.createElement('div');
      d.textContent = t;
      return d.innerHTML;
    }
    function fmtDate(s) {
      if (!s) return '';
      const d = new Date(s.replace(' ', 'T'));
      return d.toLocaleDateString() + ' ' + d.toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'});
    }

    // ===================== SELECT / NEW =====================
    async function selectNote(id) {
      if (isSaving) return;
      if (currentNoteId && hasChanges()) {
        await saveCurrentNote();
      }
      currentNoteId = id;

      let note = null;
      try {
        note = await api('get', { id: id });
      } catch (e) {
        console.error('Failed to load note', e);
        note = notes.find(n => n.id == id);
      }

      if (note && !note.error) {
        els.titleInput.value = note.title || '';
        els.contentTextarea.value = note.content || '';
        updateColorUI(note.color);
        updateLastModified(note.updated_at);
        updateCounts();
        clearHistory();
        pushState();
        updateLastSavedState();
      }
      renderNoteList();
      closeSidebar();
      els.titleInput.focus();
    }

    function newNote() {
      if (currentNoteId && hasChanges()) {
        saveCurrentNote();
      }
      currentNoteId = null;
      els.titleInput.value = '';
      els.contentTextarea.value = '';
      updateColorUI('#ffffff');
      updateLastModified('');
      updateCounts();
      clearHistory();
      pushState();
      updateLastSavedState();
      renderNoteList();
      closeSidebar();
      els.titleInput.focus();
    }

    // ===================== SAVE =====================
    async function saveCurrentNote() {
      if (isSaving) return false;
      if (!hasChanges()) { updateSaveStatus('saved'); return true; }
      isSaving = true;
      updateSaveStatus('saving');
      try {
        const result = await api('save', {
          body: {
            id: currentNoteId,
            title: els.titleInput.value,
            content: els.contentTextarea.value,
            color: getSelectedColor()
          }
        });
        if (result.success) {
          if (!currentNoteId) currentNoteId = result.id;
          updateSaveStatus('saved');
          updateLastModified(result.updated_at);
          updateLastSavedState();
          const q = els.searchInput.value;
          notes = await api('list', { search: q });
          renderNoteList();
          return true;
        }
      } catch (e) {
        updateSaveStatus('error', e.message);
        console.error('Save error:', e);
      } finally {
        isSaving = false;
        setTimeout(() => {
          if (els.saveStatus.textContent.startsWith('Saved') || els.saveStatus.textContent.startsWith('Error')) {
            updateSaveStatus('');
          }
        }, 4000);
      }
      return false;
    }

    function autoSave() {
      clearTimeout(autoSaveTimer);
      updateSaveStatus('unsaved');
      autoSaveTimer = setTimeout(() => {
        if (hasChanges()) saveCurrentNote();
      }, 1000);
    }

    function hasChanges() {
      return els.titleInput.value !== lastSavedState.title ||
             els.contentTextarea.value !== lastSavedState.content ||
             getSelectedColor() !== lastSavedState.color;
    }

    function updateLastSavedState() {
      lastSavedState = {
        title: els.titleInput.value,
        content: els.contentTextarea.value,
        color: getSelectedColor()
      };
    }

    function updateSaveStatus(status, detail) {
      const map = {
        saving: 'Saving...',
        saved: 'Saved',
        unsaved: 'Unsaved',
        error: 'Error: ' + (detail || 'Save failed'),
        '': ''
      };
      els.saveStatus.textContent = map[status] || '';
      els.saveStatus.className = 'keep-save-status ' + status;
      if (status === 'error' && detail) {
        els.saveStatus.title = detail;
      } else {
        els.saveStatus.title = '';
      }
    }

    function updateLastModified(dt) {
      els.lastModified.textContent = dt ? 'Saved ' + fmtDate(dt) : '';
    }

    // ===================== DELETE =====================
    async function deleteNote() {
      if (!currentNoteId) { newNote(); return; }
      if (!confirm('Delete this note? This cannot be undone.')) return;
      try {
        await api('delete', { body: { id: currentNoteId } });
        currentNoteId = null;
        els.titleInput.value = '';
        els.contentTextarea.value = '';
        updateColorUI('#ffffff');
        updateCounts();
        clearHistory();
        pushState();
        updateLastSavedState();
        loadNotes(els.searchInput.value);
      } catch (e) {
        alert('Failed to delete note: ' + e.message);
      }
    }

    // ===================== UNDO / REDO =====================
    function getState() {
      return {
        title: els.titleInput.value,
        content: els.contentTextarea.value,
        color: getSelectedColor(),
        cursor: els.contentTextarea.selectionStart
      };
    }
    function setState(st) {
      els.titleInput.value = st.title;
      els.contentTextarea.value = st.content;
      updateColorUI(st.color);
      updateCounts();
      try { els.contentTextarea.setSelectionRange(st.cursor, st.cursor); } catch(e){}
    }
    function pushState() {
      const st = getState();
      if (lastState && lastState.title === st.title && lastState.content === st.content && lastState.color === st.color) return;
      undoStack.push(st);
      if (undoStack.length > MAX_HISTORY) undoStack.shift();
      redoStack = [];
      lastState = st;
      updateUndoRedoBtns();
    }
    function undo() {
      if (undoStack.length <= 1) return;
      redoStack.push(undoStack.pop());
      const prev = undoStack[undoStack.length - 1];
      setState(prev);
      lastState = prev;
      updateUndoRedoBtns();
      autoSave();
    }
    function redo() {
      if (!redoStack.length) return;
      const st = redoStack.pop();
      undoStack.push(st);
      setState(st);
      lastState = st;
      updateUndoRedoBtns();
      autoSave();
    }
    function clearHistory() {
      undoStack = []; redoStack = []; lastState = null;
      updateUndoRedoBtns();
    }
    function updateUndoRedoBtns() {
      els.undoBtn.disabled = undoStack.length <= 1;
      els.redoBtn.disabled = redoStack.length === 0;
    }

    // ===================== COLOR =====================
    function getSelectedColor() {
      const a = document.querySelector('.keep-color-swatch.active');
      return a ? a.dataset.color : '#ffffff';
    }
    function updateColorUI(color) {
      els.colorSwatches.forEach(s => s.classList.toggle('active', s.dataset.color === color));
      els.editorArea.style.borderTopColor = color || 'transparent';
    }
    function setColor(color) {
      updateColorUI(color);
      autoSave();
      pushState();
    }

    // ===================== COUNTS =====================
    function updateCounts() {
      const t = els.contentTextarea.value;
      const chars = t.length;
      const words = t.trim() === '' ? 0 : t.trim().split(/\s+/).length;
      els.wordCount.textContent = words + ' word' + (words !== 1 ? 's' : '');
      els.charCount.textContent = chars + ' char' + (chars !== 1 ? 's' : '');
    }

    // ===================== CLIPBOARD =====================
    async function copyToClipboard() {
      try {
        await navigator.clipboard.writeText(els.contentTextarea.value);
        flashBtn(els.copyBtn, 'Copied!');
      } catch (e) {
        els.contentTextarea.select();
        document.execCommand('copy');
        flashBtn(els.copyBtn, 'Copied!');
      }
    }
    async function pasteFromClipboard() {
      try {
        const text = await navigator.clipboard.readText();
        insertText(text);
      } catch (e) {
        alert('Clipboard access denied. Use Ctrl+V to paste.');
      }
    }
    function clearContent() {
      if (!els.contentTextarea.value) return;
      pushState();
      els.contentTextarea.value = '';
      onInput();
    }
    function insertText(text) {
      const ta = els.contentTextarea;
      const start = ta.selectionStart;
      const end = ta.selectionEnd;
      ta.value = ta.value.substring(0, start) + text + ta.value.substring(end);
      ta.selectionStart = ta.selectionEnd = start + text.length;
      ta.focus();
      onInput();
    }
    function flashBtn(btn, text) {
      const orig = btn.textContent;
      btn.textContent = text;
      setTimeout(() => btn.textContent = orig, 1200);
    }

    // ===================== MOBILE / SEARCH =====================
    function toggleSidebar() {
      els.sidebar.classList.toggle('open');
      els.overlay.classList.toggle('show');
    }
    function closeSidebar() {
      els.sidebar.classList.remove('open');
      els.overlay.classList.remove('show');
    }
    function onSearch() {
      loadNotes(els.searchInput.value);
    }

    // ===================== INPUT HANDLER =====================
    function onInput() {
      updateCounts();
      autoSave();
      clearTimeout(stateTimer);
      stateTimer = setTimeout(pushState, 600);
    }

    // ===================== EVENTS =====================
    function setupEvents() {
      els.newNoteBtn.addEventListener('click', newNote);
      els.undoBtn.addEventListener('click', undo);
      els.redoBtn.addEventListener('click', redo);
      els.deleteBtn.addEventListener('click', deleteNote);
      els.copyBtn.addEventListener('click', copyToClipboard);
      els.pasteBtn.addEventListener('click', pasteFromClipboard);
      els.clearBtn.addEventListener('click', clearContent);
      els.mobileToggle.addEventListener('click', toggleSidebar);
      els.overlay.addEventListener('click', closeSidebar);

      els.titleInput.addEventListener('input', onInput);
      els.contentTextarea.addEventListener('input', onInput);
      els.titleInput.addEventListener('blur', pushState);
      els.contentTextarea.addEventListener('blur', pushState);

      els.searchInput.addEventListener('input', debounce(onSearch, 300));

      els.colorSwatches.forEach(s => {
        s.addEventListener('click', () => setColor(s.dataset.color));
      });

      document.addEventListener('keydown', e => {
        const ctrl = e.ctrlKey || e.metaKey;
        if (!ctrl) return;
        if (e.key === 'z' && !e.shiftKey) { e.preventDefault(); undo(); }
        else if (e.key === 'y' || (e.key === 'z' && e.shiftKey)) { e.preventDefault(); redo(); }
        else if (e.key === 's') { e.preventDefault(); saveCurrentNote(); }
        else if (e.key === 'n') { e.preventDefault(); newNote(); }
      });

      window.addEventListener('beforeunload', e => {
        if (hasChanges()) { e.preventDefault(); e.returnValue = ''; }
      });
    }

    function debounce(fn, ms) {
      let t;
      return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); };
    }

    // ===================== START =====================
    init();
  })();
  </script>

</body>
</html>