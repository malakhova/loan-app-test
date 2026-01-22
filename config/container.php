<?php

use app\repositories\LoanRequestRepository;
use app\repositories\LoanRequestRepositoryInterface;
use app\services\LoanRequestCreationService;
use app\services\LoanRequestCreationServiceInterface;
use app\services\LoanRequestProcessingService;
use app\services\LoanRequestProcessingServiceInterface;

return [
    'singletons' => array(
        LoanRequestRepositoryInterface::class => LoanRequestRepository::class,

        LoanRequestCreationServiceInterface::class => LoanRequestCreationService::class,
        LoanRequestProcessingServiceInterface::class => LoanRequestProcessingService::class,
    ),
];
