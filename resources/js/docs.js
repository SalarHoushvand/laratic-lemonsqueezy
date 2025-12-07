import hljs from 'highlight.js';
import 'highlight.js/styles/atom-one-dark.css';

window.hljs = hljs;

hljs.configure({
    ignoreUnescapedHTML: true,
    debugMode: false,
});

function getI18n() {
    const { dataset } = document.body || {};
    return {
        copyTitle: (dataset && dataset.copyTitle) || 'Copy',
        copyAria: (dataset && dataset.copyAria) || 'Copy',
        copySr: (dataset && dataset.copySr) || 'Copy the response to clipboard',
    };
}

function buildCopyBtn(i18n) {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = [
        'copy-btn',
        'absolute top-2 right-2 z-10',
        'rounded-full w-fit p-1.5',
        'text-on-surface-dark/75 hover:bg-surface/10 hover:text-on-surface-dark',
        'focus:outline-hidden focus-visible:text-on-surface-dark focus-visible:outline-2',
        'focus-visible:outline-offset-0 focus-visible:outline-primary',
        'active:bg-surface/5 active:-outline-offset-2',
    ].join(' ');
    btn.setAttribute('title', i18n.copyTitle);
    btn.setAttribute('aria-label', i18n.copyAria);

    btn.innerHTML = `
        <span class="sr-only">${i18n.copySr}</span>
        <svg data-role="copy" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
            <path fill-rule="evenodd" d="M13.887 3.182c.396.037.79.08 1.183.128C16.194 3.45 17 4.414 17 5.517V16.75A2.25 2.25 0 0 1 14.75 19h-9.5A2.25 2.25 0 0 1 3 16.75V5.517c0-1.103.806-2.068 1.93-2.207.393-.048.787-.09 1.183-.128A3.001 3.001 0 0 1 9 1h2c1.373 0 2.531.923 2.887 2.182ZM7.5 4A1.5 1.5 0 0 1 9 2.5h2A1.5 1.5 0 0 1 12.5 4v.5h-5V4Z" clip-rule="evenodd" />
        </svg>
        <svg data-role="success" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4 fill-success hidden">
            <path fill-rule="evenodd" d="M11.986 3H12a2 2 0 0 1 2 2v6a2 2 0 0 1-1.5 1.937V7A2.5 2.5 0 0 0 10 4.5H4.063A2 2 0 0 1 6 3h.014A2.25 2.25 0 0 1 8.25 1h1.5a2.25 2.25 0 0 1 2.236 2ZM10.5 4v-.75a.75.75 0 0 0-.75-.75h-1.5a.75.75 0 0 0-.75.75V4h3Z" clip-rule="evenodd" />
            <path fill-rule="evenodd" d="M2 7a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7Zm6.585 1.08a.75.75 0 0 1 .336 1.005l-1.75 3.5a.75.75 0 0 1-1.16.234l-1.75-1.5a.75.75 0 0 1 .977-1.139l1.02.875 1.321-2.64a.75.75 0 0 1 1.006-.336Z" clip-rule="evenodd" />
        </svg>
    `;
    return btn;
}

function addCopyButtonsToPre(root = document) {
    const i18n = getI18n();
    root.querySelectorAll('.docs-content pre').forEach((pre) => {
        if (pre.parentElement?.classList.contains('pre-wrap-with-copy')) return;

        const wrap = document.createElement('div');
        wrap.className = 'pre-wrap-with-copy relative';
        pre.parentNode.insertBefore(wrap, pre);
        wrap.appendChild(pre);

        const btn = buildCopyBtn(i18n);
        wrap.appendChild(btn);

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
                btn.classList.add('outline', 'outline-1', 'outline-red-500/60');
                setTimeout(() => btn.classList.remove('outline', 'outline-1', 'outline-red-500/60'), 600);
            }
        });
    });
}

function slugify(text) {
    return (text || '')
        .toString()
        .normalize('NFKD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
}

function ensureH2Ids(root = document) {
    const used = new Set();
    root.querySelectorAll('h2').forEach(h => {
        h.classList.add('scroll-mt-20');
        let id = (h.id || '').trim();
        if (!id) {
            const base = slugify(h.textContent || '');
            if (!base) return; // skip if no meaningful text
            let candidate = base;
            let i = 2;
            while (used.has(candidate) || document.getElementById(candidate)) {
                candidate = `${base}-${i++}`;
            }
            h.id = candidate;
            id = candidate;
        }
        used.add(id);
    });
}

function generateQuickReferenceList(headings) {
    const quickRefContainer = document.getElementById('quickRefContainer');
    if (!quickRefContainer) return;
    let quickRefListHTML = '<ul class="flex flex-col gap-2">';
    headings.forEach((heading) => {
        const includeInQuickRef = heading.getAttribute('data-quickref') !== 'false';
        if (includeInQuickRef) {
            const id = heading.id;
            const text = heading.textContent;
            const anchorClass = 'focus:outline-hidden focus:underline';
            quickRefListHTML += `<li class="text-sm"><a href="#${id}" class="${anchorClass} text-on-surface dark:text-on-surface-dark font-medium">${text}</a></li>`;
        }
    });
    quickRefListHTML += '</ul>';
    quickRefContainer.innerHTML = quickRefListHTML;
}

document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.docs-content');
    if (!container) return;

    container.querySelectorAll('pre, code').forEach(el => {
        el.classList.add('my-2', 'max-w-full', 'overflow-x-auto');
    });

    container.querySelectorAll('pre code[data-highlighted]')
        .forEach(code => code.removeAttribute('data-highlighted'));

    if (typeof hljs.highlightAll === 'function') {
        hljs.highlightAll();
    }

    addCopyButtonsToPre(container);

    ensureH2Ids(container);
    const headings = container.querySelectorAll('h2');
    generateQuickReferenceList(headings);
}, { once: true });


