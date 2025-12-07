<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DocumentationController extends Controller
{
    /**
     * Display the documentation page for the specified topic.
     *
     * Uses a cascading fallback strategy:
     * 1. Try the current locale's view
     * 2. Fall back to English if current locale is not English
     * 3. Fall back to the default view (no locale prefix)
     *
     * @param  string  $topic  The documentation topic path (e.g., 'getting-started' or 'blog/translations')
     */
    public function show(string $topic): View
    {
        $locale = app()->getLocale();
        $dotPath = str_replace('/', '.', $topic);
        $localizedViewPath = "pages.docs.$locale.$dotPath";

        if (view()->exists($localizedViewPath)) {
            return view($localizedViewPath);
        }

        if ($locale !== 'en') {
            $englishViewPath = "pages.docs.en.$dotPath";
            if (view()->exists($englishViewPath)) {
                return view($englishViewPath);
            }
        }

        $defaultViewPath = "pages.docs.$dotPath";

        if (view()->exists($defaultViewPath)) {
            return view($defaultViewPath);
        }

        abort(404, "Documentation page not found: {$topic}");
    }
}
