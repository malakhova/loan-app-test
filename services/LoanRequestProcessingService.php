<?php

namespace app\services;

use app\repositories\LoanRequestRepositoryInterface;
use app\valueObjects\LoanRequestStatus;
use InvalidArgumentException;

class LoanRequestProcessingService implements LoanRequestProcessingServiceInterface
{
    public function __construct(
        protected LoanRequestRepositoryInterface $loanRequestRepository,
    ) {}

    /**
     * @inheritDoc
     */
    public function processAllPending(int $delay): void
    {
        if ($delay < 0) {
            throw new InvalidArgumentException('Delay must be more than 0 seconds');
        }
        $pendingRequests = $this->loanRequestRepository->findAllPending();
        foreach ($pendingRequests as $request) {
            sleep($delay);
            $hasApproved = $this->loanRequestRepository->hasApprovedByUserId($request->user_id);
            $shouldApproved = !$hasApproved && $this->shouldApprove();
            $this->loanRequestRepository->processOne(
                $request,
                $shouldApproved ? LoanRequestStatus::APPROVED : LoanRequestStatus::DECLINED);
        }
    }

    /**
     * Check if loan request should be approved by calculating the probability
     * @return bool
     */
    private function shouldApprove(): bool
    {
        return (mt_rand(1, 100) <= $this->getApprovalPercentage());
    }

    /**
     * Return approval percentage
     * @return int
     */
    private function getApprovalPercentage(): int
    {
        return 10;
    }
}
