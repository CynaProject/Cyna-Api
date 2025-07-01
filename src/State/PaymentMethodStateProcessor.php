<?php

namespace App\State;

use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\PaymentMethod;
use App\Service\EncryptionService;

class PaymentMethodStateProcessor implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $persistProcessor,
        private EncryptionService $encryptionService,
    ) {}

    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($data instanceof PaymentMethod) {
            if ($data->getNumber()) {
                $data->setNumber($this->encryptionService->encrypt($data->getNumber()));
            }
            if ($data->getCvv()) {
                $data->setCvv($this->encryptionService->encrypt($data->getCvv()));
            }
            if ($data->getExpirationDate()) {
                $data->setExpirationDate($this->encryptionService->encrypt($data->getExpirationDate()));
            }
        }

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
