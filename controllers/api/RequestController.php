<?php

namespace app\controllers\api;

use app\forms\CreateLoanRequestForm;
use app\services\LoanRequestCreationServiceInterface;
use Throwable;
use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;

class RequestController extends Controller
{
    public function __construct(
        $id,
        $module,
        protected LoanRequestCreationServiceInterface $loanRequestCreationService,
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
                    'create' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actionCreate(): array
    {
        try {
            $form = new CreateLoanRequestForm();
            $form->load(Yii::$app->request->post(), '');
            if (!$form->validate()) {
                Yii::$app->response->setStatusCode(400);
                return [
                    'result' => false,
                ];
            }

            $loanRequest = $this->loanRequestCreationService->createRequest(
                $form->user_id,
                $form->amount,
                $form->term
            );
            Yii::$app->response->setStatusCode(201);
            return [
                'result' => true,
                'id' => $loanRequest->id,
            ];
        } catch (Throwable $exception) {
            //todo можно добавить логирование
            Yii::$app->response->setStatusCode(400);
            return [
                'result' => false,
            ];
        }
    }
}
