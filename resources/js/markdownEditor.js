import EasyMDE from 'easymde';
import 'easymde/dist/easymde.min.css';

// Initialize EasyMDE on admin post editor if present
document.addEventListener('DOMContentLoaded', () => {
    const textarea = document.getElementById('content-editor');
    const hidden = document.getElementById('contentHidden');

    if (textarea && hidden) {
        const easyMDE = new EasyMDE({
            element: textarea,
            spellChecker: false,
            autosave: {
                enabled: false,
                uniqueId: 'post-content',
                delay: 1000,
            },
            placeholder: textarea.getAttribute('placeholder') || 'Write markdown here...',
            hideIcons: ['preview', 'side-by-side'],
            // Use EasyMDE's default toolbar with icons (no custom text buttons)
            // status bar off to keep UI clean; remove this line to show default status
            status: false,
        });

        // Set initial value from Livewire hidden field
        if (hidden.value) {
            easyMDE.value(hidden.value);
        }

        // Sync changes back to Livewire via hidden input
        easyMDE.codemirror.on('change', () => {
            hidden.value = easyMDE.value();
            hidden.dispatchEvent(new Event('input', { bubbles: true }));
        });

        // When Livewire reports content changed, sync editor
        window.addEventListener('post-content-updated', (e) => {
            let latest = hidden.value;
            if (e && e.detail) {
                if (typeof e.detail === 'string') {
                    latest = e.detail;
                } else if (typeof e.detail === 'object' && typeof e.detail.content === 'string') {
                    latest = e.detail.content;
                }
            }
            if (typeof latest === 'string') {
                easyMDE.value(latest);
                hidden.value = latest;
                hidden.dispatchEvent(new Event('input', { bubbles: true }));
            }
        });
    }
});


