<?php

namespace app\controllers\api;

use app\services\LoanRequestProcessingServiceInterface;
use Throwable;
use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;

class ProcessorController extends Controller
{
    public const int DEFAULT_DELAY = 5;

    public function __construct(
        $id,
        $module,
        protected LoanRequestProcessingServiceInterface $processingService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'process' => ['GET'],
                ],
            ],
        ];
    }

    public function actionProcess(int $delay = self::DEFAULT_DELAY): array
    {
        try {
            $this->processingService->processAllPending($delay);
            Yii::$app->response->setStatusCode(200);
            return [
                'result' => true
            ];
        } catch (Throwable $exception) {
            //todo можно добавить логирование
            Yii::$app->response->setStatusCode(500);
            return [
                'result' => false,
            ];
        }
    }
}
