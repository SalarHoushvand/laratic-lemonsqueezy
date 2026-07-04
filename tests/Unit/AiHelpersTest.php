<?php

it('calculates text model costs from per-million token rates', function () {
    expect(ai_cost_for_model_tokens('gpt-4o-mini', 1_000_000, 1_000_000))->toBe(0.75);
    expect(ai_cost_for_model_tokens('gpt-4.1', 1_000_000, 1_000_000))->toBe(10.0);
    expect(ai_cost_for_model_tokens('gpt-5', 1_000_000, 1_000_000))->toBe(11.25);
    expect(ai_cost_for_model_tokens('o3', 1_000_000, 1_000_000))->toBe(10.0);
});

it('calculates image model costs per generated image', function () {
    expect(ai_cost_for_model_tokens('dall-e-3', 0, 1))->toBe(0.04);
    expect(ai_cost_for_model_tokens('gpt-image-1', 0, 1))->toBe(0.042);
});

it('calculates embedding costs from input tokens only', function () {
    expect(ai_cost_for_model_tokens('text-embedding-3-small', 1_000_000, 0))->toBe(0.02);
});

it('returns zero for unsupported models', function () {
    expect(ai_cost_for_model_tokens('unknown-model', 100, 100))->toBe(0.0);
});

it('exposes pricing for models used in the application', function () {
    $pricing = ai_model_pricing();

    expect($pricing)->toHaveKeys([
        'gpt-4o',
        'gpt-4o-mini',
        'gpt-4.1',
        'gpt-4.1-mini',
        'gpt-image-1',
        'dall-e-3',
    ]);
});
