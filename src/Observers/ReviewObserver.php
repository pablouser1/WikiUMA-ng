<?php

namespace App\Observers;

use App\Models\Review;

class ReviewObserver
{
    public function created(Review $review): void
    {
        logger()->info('New review registered', [
            'target' => $review->target,
            'type' => $review->type->displayName(),
        ]);
    }
}
