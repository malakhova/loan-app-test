<?php

namespace app\services;

use app\models\LoanRequest;
use app\repositories\LoanRequestRepositoryInterface;
use app\services\LoanRequestCreationServiceInterface;
use app\valueObjects\LoanRequestStatus;
use DomainException;

class LoanRequestCreationService implements LoanRequestCreationServiceInterface
{
    public function __construct(
        protected LoanRequestRepositoryInterface $loanRequestRepository
    ) {}

    /**
     * @inheritDoc
     */
    public function createRequest(int $userId, int $amount, int $term): LoanRequest
    {
        $hasApprovedRequests = $this->loanRequestRepository->hasApprovedByUserId($userId);
        if ($hasApprovedRequests) {
            throw new DomainException('User has approved requests');
        }
        return $this->loanRequestRepository->createOne($userId, $amount, $term, LoanRequestStatus::PENDING);
    }
}
