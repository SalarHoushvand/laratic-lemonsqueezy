@push('head')
    <title>Getting Started - {{ config('app.name') }}</title>
    <meta name="description"
        content="Learn how to get started with {{ config('app.name') }}. Our getting started guide will walk you through everything you need to know to get started with our platform and make the most of its features.">
@endpush


<x-layouts.docs :breadcrumbs="[['label' => 'Basics', 'url' => '#'], ['label' => 'Getting Started', 'url' => '#']]">

    <h1>Getting Started</h1>
    <p>Welcome to our comprehensive documentation! Our platform provides a robust set of tools and
        components designed to streamline your development process. Whether you're building a small application or a
        large-scale enterprise system, this guide will walk you through everything you need to know to get started with
        our platform and make the most of its features.</p>
    <h2>Installation</h2>
    <p>Getting started with our platform is straightforward. First, you'll need to install the
        package using Composer, our recommended dependency management tool. This will ensure you have access to all the
        latest features and security updates. Make sure you have Composer installed on your system before proceeding
        with the following steps:</p>
    <pre><code>composer require yourcompany/package</code></pre>
    <h2>Language Template</h2>
    <p>Our platform supports multiple languages through a flexible templating system. The
        language template structure follows a simple yet powerful format that allows for easy translation and
        maintenance. Below is an example of how to structure your language files for both English and Spanish:</p>
    <pre><code>// lang/es.json
{
    "welcome": "Bienvenido a nuestra plataforma",
    "getting_started": "Comenzando",
    "installation": "Instalación",
    "configuration": "Configuración"
}</code></pre>
    <h2>Configuration</h2>
    <p>After successfully installing the package, you'll need to configure it to work with your
        application. Our configuration process is designed to be flexible and straightforward, allowing you to customize
        various aspects of the platform to suit your needs. Start by publishing the configuration file to your
        application's config directory. This will give you full control over the platform's settings and allow you to
        modify them according to your requirements:</p>

    <pre><code>php artisan vendor:publish --tag="config"</code></pre>
    <h2>Basic Usage</h2>
    <p>Once you have completed the installation and configuration steps, you can start using our
        components in your application. Our components are designed with flexibility and ease of use in mind, allowing
        you to quickly integrate them into your existing projects. Here's a simple example demonstrating how to use one
        of our main components. This example showcases the basic structure and common properties you can utilize:</p>

    <pre><code>&lt;x-example-component
    title=&quot;My First Component&quot;
    description=&quot;This is a basic example of our component system&quot;&gt;
    Hello World!
&lt;/x-example-component&gt;</code></pre>
    <h2>API Setup</h2>
    <p>To leverage our powerful API features, you'll need to configure your API credentials. We
        use a secure authentication system to ensure your data remains protected. Begin by adding your API credentials
        to your environment file. This keeps your sensitive information secure and allows for different configurations
        across various environments. Make sure to never commit your actual API keys to version control:</p>

    <pre><code>PACKAGE_API_KEY=your-api-key-here
PACKAGE_API_URL=https://api.example.com
PACKAGE_API_VERSION=v1</code></pre>
    <h2>Next Steps</h2>
    <p>Now that you have successfully set up the basic configuration and understand the core
        concepts, you're ready to explore the more advanced features of our platform. We recommend going through the
        following topics to deepen your understanding and make the most of what our platform has to offer:</p>
    <ul>
        <li>Authentication Integration - Learn how to implement secure user authentication</li>
        <li>Custom Components - Discover how to create and extend components</li>
        <li>Advanced Features - Explore our advanced functionality and optimization techniques</li>
        <li>API Reference - Complete API documentation with examples and use cases</li>
        <li>Troubleshooting Guide - Common issues and their solutions</li>
    </ul>
</x-layouts.docs>
