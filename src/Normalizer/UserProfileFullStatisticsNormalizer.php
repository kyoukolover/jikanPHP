<?php declare(strict_types=1);

namespace Jikan\JikanPHP\Normalizer;

use ArrayObject;
use Jane\Component\JsonSchemaRuntime\Reference;
use Jikan\JikanPHP\Model\UserProfileFullStatistics;
use Jikan\JikanPHP\Model\UserProfileFullStatisticsAnime;
use Jikan\JikanPHP\Model\UserProfileFullStatisticsManga;
use Jikan\JikanPHP\Runtime\Normalizer\CheckArray;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserProfileFullStatisticsNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;

    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return UserProfileFullStatistics::class === $type;
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return is_object($data) && $data instanceof UserProfileFullStatistics;
    }

    /**
     * @param mixed      $data
     * @param mixed      $class
     * @param null|mixed $format
     *
     * @return mixed
     */
    public function denormalize($data, $class, $format = null, array $context = []): Reference|UserProfileFullStatistics
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }

        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }

        $userProfileFullStatistics = new UserProfileFullStatistics();
        if (null === $data || !\is_array($data)) {
            return $userProfileFullStatistics;
        }

        if (\array_key_exists('anime', $data)) {
            $userProfileFullStatistics->setAnime($this->denormalizer->denormalize($data['anime'], UserProfileFullStatisticsAnime::class, 'json', $context));
        }

        if (\array_key_exists('manga', $data)) {
            $userProfileFullStatistics->setManga($this->denormalizer->denormalize($data['manga'], UserProfileFullStatisticsManga::class, 'json', $context));
        }

        return $userProfileFullStatistics;
    }

    /**
     * @param mixed      $object
     * @param null|mixed $format
     *
     * @return array|string|int|float|bool|ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        $data = [];
        if (null !== $object->getAnime()) {
            $data['anime'] = $this->normalizer->normalize($object->getAnime(), 'json', $context);
        }

        if (null !== $object->getManga()) {
            $data['manga'] = $this->normalizer->normalize($object->getManga(), 'json', $context);
        }

        return $data;
    }
}
