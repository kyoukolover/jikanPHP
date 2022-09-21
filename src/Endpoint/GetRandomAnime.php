<?php declare(strict_types=1);

namespace Jikan\JikanPHP\Endpoint;

use Jikan\JikanPHP\Exception\GetRandomAnimeBadRequestException;
use Jikan\JikanPHP\Model\RandomAnimeGetResponse200;
use Jikan\JikanPHP\Runtime\Client\BaseEndpoint;
use Jikan\JikanPHP\Runtime\Client\Endpoint;
use Jikan\JikanPHP\Runtime\Client\EndpointTrait;
use Symfony\Component\Serializer\SerializerInterface;

class GetRandomAnime extends BaseEndpoint implements Endpoint
{
    use EndpointTrait;

    public function getMethod(): string
    {
        return 'GET';
    }

    public function getUri(): string
    {
        return '/random/anime';
    }

    public function getBody(SerializerInterface $serializer, $streamFactory = null): array
    {
        return [[], null];
    }

    protected function getExtraHeaders(): array
    {
        return ['Accept' => ['application/json']];
    }

    /**
     * {@inheritdoc}
     *
     * @throws GetRandomAnimeBadRequestException
     *
     * @return null|RandomAnimeGetResponse200
     */
    protected function transformResponseBody(string $body, int $status, SerializerInterface $serializer, ?string $contentType = null)
    {
        if (!is_null($contentType) && (200 === $status && false !== mb_strpos($contentType, 'application/json'))) {
            return $serializer->deserialize($body, RandomAnimeGetResponse200::class, 'json');
        }

        if (400 === $status) {
            throw new GetRandomAnimeBadRequestException();
        }
    }

    public function getAuthenticationScopes(): array
    {
        return [];
    }
}
