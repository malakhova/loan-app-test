<?php

namespace app\repositories;

use app\models\LoanRequest;

interface LoanRequestRepositoryInterface
{
    /**
     * Creates new load request
     * @param int $userId
     * @param int $amount
     * @param int $term
     * @param string $status
     * @return LoanRequest
     */
    public function createOne(int $userId, int $amount, int $term, string $status): LoanRequest;

    /**
     * Check if a user has approved loan requests
     * @param int $userId
     * @return bool
     */
    public function hasApprovedByUserId(int $userId): bool;


    /**
     * Returns all loan requests with pending status
     * @return LoanRequest[]
     */
    public function findAllPending(): array;

    /**
     * Process loan request with status
     * @param LoanRequest $loanRequest
     * @param string $processStatus
     */
    public function processOne(LoanRequest $loanRequest, string $processStatus): void;
}
