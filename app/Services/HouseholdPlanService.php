<?php

namespace App\Services;

use App\Models\Household;
use Illuminate\Validation\ValidationException;

class HouseholdPlanService
{
    public function assertWithinLimit(Household $household, string $resource): void
    {
        $plan = $household->subscription?->plan;
        $relation = $resource === 'transactions' ? 'entries' : $resource;
        $limit = $plan?->{'max_' . $resource};
        if ($limit !== null && $household->{$relation}()->count() >= $limit) {
            throw ValidationException::withMessages([$resource => "The current plan limit for {$resource} has been reached."]);
        }
    }
}
