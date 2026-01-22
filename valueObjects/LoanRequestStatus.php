<?php

namespace app\valueObjects;

class LoanRequestStatus
{
    public const string PENDING = "pending";
    public const string APPROVED = "approved";
    public const string DECLINED = "declined";

    /**
     * @return string[]
     */
    public static function getValues(): array
    {
        return [
            self::PENDING,
            self::APPROVED,
            self::DECLINED
        ];
    }
}
