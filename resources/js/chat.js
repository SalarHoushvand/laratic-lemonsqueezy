import hljs from 'highlight.js';
import 'highlight.js/styles/atom-one-dark.css';
import { marked } from 'marked';
import DOMPurify from 'dompurify';

window.hljs = hljs;
window.marked = marked;
window.DOMPurify = DOMPurify;

hljs.configure({
    ignoreUnescapedHTML: true,
    debugMode: false,
});

// Localized UI strings - will be initialized from the Blade template
let i18n = {};

// Initialize i18n from data attribute
function initializeI18n() {
    const container = document.getElementById('chat-container');
    if (container && container.dataset.i18n) {
        i18n = JSON.parse(container.dataset.i18n);
    }
}

// Build a Penguin UI–styled copy button (icon toggle like your reference)
function buildCopyBtn() {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = [
        'copy-btn',
        'absolute top-2 right-2 z-1',
        'rounded-full w-fit p-1.5',
        'text-on-surface-dark/75 hover:bg-surface/10 hover:text-on-surface-dark',
        'focus:outline-hidden focus-visible:text-on-surface-dark focus-visible:outline-2',
        'focus-visible:outline-offset-0 focus-visible:outline-primary',
        'active:bg-surface/5 active:-outline-offset-2',
    ].join(' ');
    btn.setAttribute('title', i18n.copyTitle || 'Copy');
    btn.setAttribute('aria-label', i18n.copyAria || 'Copy');

    btn.innerHTML = `
        <span class="sr-only">${i18n.copySr || 'Copy the response to clipboard'}</span>
        <!-- copy icon -->
        <svg data-role="copy" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
             fill="currentColor" class="size-4">
          <path fill-rule="evenodd"
                d="M13.887 3.182c.396.037.79.08 1.183.128C16.194 3.45 17 4.414 17 5.517V16.75A2.25 2.25 0 0 1 14.75 19h-9.5A2.25 2.25 0 0 1 3 16.75V5.517c0-1.103.806-2.068 1.93-2.207.393-.048.787-.09 1.183-.128A3.001 3.001 0 0 1 9 1h2c1.373 0 2.531.923 2.887 2.182ZM7.5 4A1.5 1.5 0 0 1 9 2.5h2A1.5 1.5 0 0 1 12.5 4v.5h-5V4Z"
                clip-rule="evenodd"/>
        </svg>
        <!-- success icon -->
        <svg data-role="success" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
             fill="currentColor" class="size-4 fill-success hidden">
          <path fill-rule="evenodd"
                d="M11.986 3H12a2 2 0 0 1 2 2v6a2 2 0 0 1-1.5 1.937V7A2.5 2.5 0 0 0 10 4.5H4.063A2 2 0 0 1 6 3h.014A2.25 2.25 0 0 1 8.25 1h1.5a2.25 2.25 0 0 1 2.236 2ZM10.5 4v-.75a.75.75 0 0 0-.75-.75h-1.5a.75.75 0 0 0-.75.75V4h3Z"
                clip-rule="evenodd"/>
          <path fill-rule="evenodd"
                d="M2 7a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7Zm6.585 1.08a.75.75 0 0 1 .336 1.005l-1.75 3.5a.75.75 0 0 1-1.16.234l-1.75-1.5a.75.75 0 0 1 .977-1.139l1.02.875 1.321-2.64a.75.75 0 0 1 1.006-.336Z"
                clip-rule="evenodd"/>
        </svg>
    `;
    return btn;
}

// Add copy buttons to all <pre> blocks in a container
function addCopyButtonsToPre(root = document) {
    root.querySelectorAll('.markdown-content pre').forEach((pre) => {
        // Avoid duplicates
        if (pre.parentElement?.classList.contains('pre-wrap-with-copy')) return;

        // Wrap so we can absolutely-position the button
        const wrap = document.createElement('div');
        wrap.className = 'pre-wrap-with-copy relative';
        pre.parentNode.insertBefore(wrap, pre);
        wrap.appendChild(pre);

        // Create button
        const btn = buildCopyBtn();
        wrap.appendChild(btn);

        // Copy handler (prefer <code> text inside <pre>)
        btn.addEventListener('click', async () => {
            const copyIcon = btn.querySelector('[data-role="copy"]');
            const okIcon = btn.querySelector('[data-role="success"]');
            const codeNode = pre.querySelector('code');
            const text = (codeNode ? codeNode.innerText : pre.innerText) || '';

            try {
                await navigator.clipboard.writeText(text);
                copyIcon.classList.add('hidden');
                okIcon.classList.remove('hidden');
                setTimeout(() => {
                    okIcon.classList.add('hidden');
                    copyIcon.classList.remove('hidden');
                }, 1200);
            } catch {
                // Brief visual error state
                btn.classList.add('outline', 'outline-1', 'outline-red-500/60');
                setTimeout(() => btn.classList.remove('outline', 'outline-1',
                    'outline-red-500/60'), 600);
            }
        });
    });
}

// Replace your renderMarkdown with: sanitize → render → style → highlight (fresh) → add copy buttons
window.renderMarkdown = (text) => {
    const html = marked.parse(text || '');
    const safe = DOMPurify.sanitize(html);

    requestAnimationFrame(() => {
        // Base styling
        document.querySelectorAll('.markdown-content pre, .markdown-content code')
            .forEach(el => el.classList.add('my-2', 'max-w-full', 'overflow-x-auto'));

        // 🔧 Fix: re-highlight safely by removing the flag first
        document.querySelectorAll('.markdown-content pre code[data-highlighted]')
            .forEach(code => code.removeAttribute('data-highlighted'));

        if (window.hljs && typeof hljs.highlightAll === 'function') {
            hljs.highlightAll();
        }

        // Add Penguin UI copy buttons
        addCopyButtonsToPre(document);

        // Keep scrolled to bottom
        const scroll = document.getElementById('chatScroll');
        if (scroll) scroll.scrollTop = scroll.scrollHeight;
    });

    return safe;
};

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', initializeI18n);

// Also call initializeI18n immediately in case DOMContentLoaded already fired
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeI18n);
} else {
    initializeI18n();
}
