<?php

namespace app\models;


use app\valueObjects\LoanRequestStatus;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "loan_request".
 *
 * @property int $id
 * @property int $user_id
 * @property int $amount Сумма займа
 * @property int $term Срок займа в днях
 * @property string $status Статус: pending, approved, declined
 * @property string $created_at
 * @property string|null $processed_at
 */
class LoanRequest extends ActiveRecord
{
    public const string ATTR_ID = 'id';
    public const string ATTR_USER_ID = 'user_id';
    public const string ATTR_AMOUNT = 'amount';
    public const string ATTR_TERM = 'term';
    public const string ATTR_STATUS = 'status';
    public const string ATTR_CREATED_AT = 'created_at';
    public const string ATTR_PROCESSED_AT = 'processed_at';

    /**
     * @inheritDoc
     */
    public static function tableName(): string
    {
        return 'loan_request';
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            [
                //todo можно и без него обойтись, просто задавая в методе репозитория
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            [[self::ATTR_USER_ID, self::ATTR_AMOUNT, self::ATTR_TERM], 'required'],
            [[self::ATTR_USER_ID, self::ATTR_AMOUNT, self::ATTR_TERM], 'integer'],
            [[self::ATTR_USER_ID, self::ATTR_AMOUNT, self::ATTR_TERM], 'default', 'value' => null],
            [[self::ATTR_STATUS ], 'default', 'value' => LoanRequestStatus::PENDING],
            [self::ATTR_STATUS, 'in', 'range' => LoanRequestStatus::getValues()],
            [[self::ATTR_PROCESSED_AT], 'safe'],
            [[self::ATTR_PROCESSED_AT], 'default', 'value' => null],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels(): array
    {
        return [
            self::ATTR_ID => 'ID',
            self::ATTR_USER_ID => 'User ID',
            self::ATTR_AMOUNT => 'Amount',
            self::ATTR_TERM => 'Term',
            self::ATTR_STATUS => 'Status',
            self::ATTR_CREATED_AT => 'Created At',
            self::ATTR_PROCESSED_AT => 'Processed At',
        ];
    }

}
