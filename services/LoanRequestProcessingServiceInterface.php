<?php

namespace app\services;

interface LoanRequestProcessingServiceInterface
{
    /**
     * Process all pending loan requests with delay
     * @param int $delay in seconds
     */
    public function processAllPending(int $delay): void;
}
