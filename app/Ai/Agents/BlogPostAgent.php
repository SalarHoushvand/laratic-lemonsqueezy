<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Strict;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Promptable;
use Stringable;

/**
 * Agent for generating structured blog posts using AI.
 *
 * Returns a structured response with title, description, and markdown content.
 */
#[Provider(Lab::OpenAI)]
#[Strict]
class BlogPostAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'You are a travel and Laravel web development blog writer. Write in story like '
            .'but simple and natural English some very short and interesting code snippets, if required, '
            .'and are related to the destination or the topic of the post. '
            .'No buzzwords, corporate tone, or self-references. Use clear transitions between sections.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->description('Compelling H1 title for the blog post')->required(),
            'description' => $schema->string()->description('1-2 sentence summary/teaser for the post, should be 200 characters or less')->required(),
            'content' => $schema->string()->description('Full blog post body in well formatted Markdown')->required(),
        ];
    }
}
