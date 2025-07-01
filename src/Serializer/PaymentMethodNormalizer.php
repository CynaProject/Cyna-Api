<?php
namespace App\Serializer;

use ApiPlatform\Serializer\Normalizer\AbstractItemNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use App\Entity\PaymentMethod;
use App\Service\EncryptionService;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PaymentMethodNormalizer implements ContextAwareNormalizerInterface
{
    private $normalizer;
    private $encryptionService;

    public function __construct(NormalizerInterface $normalizer, EncryptionService $encryptionService)
    {
        $this->normalizer = $normalizer;
        $this->encryptionService = $encryptionService;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof PaymentMethod;
    }

    public function normalize($object, string $format = null, array $context = [])
{
    $data = $this->normalizer->normalize($object, $format, $context);

    foreach (['number', 'cvv', 'expirationDate'] as $field) {
        if (isset($data[$field]) && $data[$field]) {
            $decrypted = $this->encryptionService->decrypt($data[$field]);
            $data[$field] = $decrypted ?? $data[$field]; 
        }
    }
    

    return $data;
}
}
