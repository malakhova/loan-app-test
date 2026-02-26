<?php

namespace app\repositories;

use app\helpers\DateTimeHelper;
use app\models\LoanRequest;
use app\valueObjects\LoanRequestStatus;
use Throwable;
use Yii;
use yii\db\Transaction;

class LoanRequestRepository implements LoanRequestRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function createOne(int $userId, int $amount, int $term, LoanRequestStatus $status): LoanRequest
    {
        $loanRequest = new LoanRequest();
        $loanRequest->user_id = $userId;
        $loanRequest->amount = $amount;
        $loanRequest->term = $term;
        $loanRequest->status = $status->value;
        $loanRequest->processed_at = DateTimeHelper::getNowTimestamp();
        $loanRequest->save();
        return $loanRequest;
    }

    /**
     * @inheritDoc
     */
    public function hasApprovedByUserId(int $userId): bool
    {
        return LoanRequest::find()
            ->where([
                LoanRequest::ATTR_USER_ID => $userId,
                LoanRequest::ATTR_STATUS => LoanRequestStatus::APPROVED->value,
            ])
            ->exists();
    }

    /**
     * @inheritDoc
     */
    public function findAllPending(): array
    {
        return LoanRequest::find()
            ->where([LoanRequest::ATTR_STATUS => LoanRequestStatus::PENDING->value])
            ->all();
    }

    /**
     * @inheritDoc
     */
    public function processOne(LoanRequest $loanRequest, LoanRequestStatus $processStatus): void
    {
        $transaction = Yii::$app->db->beginTransaction(Transaction::REPEATABLE_READ);

        try {
            $lockedRequest = $this->findOneByIdAndStatus(
                $loanRequest->id,
                LoanRequestStatus::PENDING->value
            );

            if (!$lockedRequest) {
                $transaction->rollBack();
                return;
            }

            $loanRequest->status = $processStatus->value;
            $loanRequest->processed_at = DateTimeHelper::getNowTimestamp();
            $loanRequest->save();
            $transaction->commit();

        } catch (Throwable $exception) {
            $transaction->rollBack();
            throw $exception;
        }
    }

    /**
     * @param int $id
     * @param string $status
     * @return LoanRequest|null
     */
    private function findOneByIdAndStatus(int $id, string $status): ?LoanRequest
    {
        return LoanRequest::find()
            ->where([LoanRequest::ATTR_ID => $id])
            ->andWhere([LoanRequest::ATTR_STATUS => $status])
            ->one();
    }
}
