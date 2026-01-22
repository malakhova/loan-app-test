<?php

namespace app\services;

use app\models\LoanRequest;

interface LoanRequestCreationServiceInterface
{
    /**
     * Create loan request
     *
     * @param int $userId
     * @param int $amount
     * @param int $term
     * @return LoanRequest
     */
    public function createRequest(int $userId, int $amount, int $term): LoanRequest;
}
