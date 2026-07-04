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
 * Agent for translating blog posts into other languages using AI.
 *
 * Returns a structured response with translated title, description, and markdown content.
 */
#[Provider(Lab::OpenAI)]
#[Strict]
class TranslationAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return "You are a professional translator specializing in blog post translation. Your task is to translate blog posts accurately while maintaining:\n"
            ."- The original meaning and tone\n"
            ."- The structure and formatting (headings, lists, code blocks)\n"
            ."- The author's voice and style\n"
            ."- Technical accuracy for any code examples or technical terms\n"
            ."- Preserve all Markdown formatting (H2/H3 headings, lists, code blocks, etc.)\n";
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->description('Translated H1 title for the blog post')->required(),
            'description' => $schema->string()->description('Translated 1-2 sentence summary/teaser for the post, should be 200 characters or less')->required(),
            'content' => $schema->string()->description('Full translated post body in GitHub-flavored well styled Markdown')->required(),
        ];
    }
}
