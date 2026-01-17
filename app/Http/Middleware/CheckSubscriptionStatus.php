<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$variantIds
     */
    public function handle(Request $request, Closure $next, string ...$variantIds): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect(route('plans.start'));
        }

        $variantIds = collect($variantIds)
            ->map(fn (string $id) => trim($id))
            ->filter()
            ->values()
            ->all();

        // If one or more variant IDs are provided (middleware params), require a subscription
        // that matches any of the given variants. Otherwise, require any valid subscription.
        if (count($variantIds) > 0) {
            $hasMatchingSubscription = collect($variantIds)->contains(function ($variantId) use ($user) {
                return $user->subscribedToVariant($variantId, 'default');
            });

            if (! $hasMatchingSubscription) {
                return redirect(route('plans.start'));
            }
        }

        if (count($variantIds) === 0 && ! $user->subscribed('default')) {
            return redirect(route('plans.start'));
        }

        return $next($request);
    }
}
