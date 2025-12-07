@push('head')
    <title>Docs - Traducciones - {{ config('app.name') }}</title>
    <meta name="description"
        content="Aprende cómo traducir tus páginas de documentación usando el controlador de documentación con soporte de idiomas de Laratic.">
@endpush

<x-layouts.docs :breadcrumbs="[['label' => 'Documentación', 'url' => '#'], ['label' => 'Traducciones', 'url' => '#']]">

    <h1>Traducciones de Documentación</h1>
    <p class="text-on-surface-muted dark:text-on-surface-dark-muted">
        {{ config('app.name') }} facilita la localización de tu documentación. El controlador de documentación busca
        automáticamente una traducción en el idioma activo y recurre al inglés si no hay una disponible.
    </p>

    <h2>Cómo Funciona la Recuperación de Idioma</h2>
    <p>
        Todas las páginas de documentación son manejadas por <code>App\Http\Controllers\DocumentationController</code>.
        Cuando alguien visita <code>/docs/{topic}</code>, el controlador:
    </p>

    <ol>
        <li>Obtiene el idioma actual usando <code>app()-&gt;getLocale()</code>.</li>
        <li>Convierte el tema (por ejemplo, <code>blog/translations</code>) en una ruta con puntos.</li>
        <li>Intenta cargar
            <code>resources/views/pages/docs/&lt;locale&gt;/&lt;topic&gt;.blade.php</code>.
        </li>
        <li>Si no existe y el idioma no es <code>en</code>, recurre a la versión en inglés bajo
            <code>resources/views/pages/docs/en</code>.
        </li>
    </ol>

    <p>Para el tema <strong>changelog</strong>, el orden de búsqueda es:</p>

    <ol>
        <li><code>resources/views/pages/docs/&lt;locale&gt;/changelog.blade.php</code></li>
        <li><code>resources/views/pages/docs/en/changelog.blade.php</code></li>
        <li><code>resources/views/pages/docs/changelog.blade.php</code> (soportado, pero no se usa por defecto)</li>
    </ol>

    <h2>Agregar una Traducción</h2>
    <p>Para agregar una página de documentación traducida (por ejemplo, español <code>es</code>):</p>

    <ol>
        <li>Crea la carpeta del idioma si no existe:
            <code>resources/views/pages/docs/es</code>.
        </li>
        <li>Copia la página en inglés en esa carpeta. Por ejemplo:<br>
            <code>resources/views/pages/docs/en/changelog.blade.php</code> →
            <code>resources/views/pages/docs/es/changelog.blade.php</code>
        </li>
        <li>Traduce el texto en el nuevo archivo manteniendo el mismo diseño y componentes Blade.</li>
        <li>Cambia el idioma de la aplicación a <code>es</code>, luego visita <code>/docs/changelog</code> para ver el resultado.</li>
    </ol>

    <h2>Consejos</h2>
    <ul>
        <li>Usa los mismos componentes Blade (como <code>&lt;x-blocks.docs.changelog-section /&gt;</code>) para mantener tu diseño consistente entre idiomas.</li>
        <li>Puedes traducir cadenas más pequeñas dentro de las vistas usando <code>__()</code>.</li>
        <li>Solo necesitas crear archivos traducidos para las páginas que quieres localizar; todo lo demás recurre al inglés automáticamente.</li>
    </ul>

</x-layouts.docs>

