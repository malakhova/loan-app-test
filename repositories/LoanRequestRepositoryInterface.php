<?php

namespace app\repositories;

use app\models\LoanRequest;
use app\valueObjects\LoanRequestStatus;

interface LoanRequestRepositoryInterface
{
    /**
     * Creates new load request
     * @param int $userId
     * @param int $amount
     * @param int $term
     * @param LoanRequestStatus $status
     * @return LoanRequest
     */
    public function createOne(int $userId, int $amount, int $term, LoanRequestStatus $status): LoanRequest;

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
     * @param LoanRequestStatus $processStatus
     */
    public function processOne(LoanRequest $loanRequest, LoanRequestStatus $processStatus): void;
}
