<?php

namespace Jikan\Request\User;

use Jikan\Helper\Constants;
use Jikan\Request\RequestInterface;

/**
 * Class UserHistoryRequest
 *
 * @package Jikan\Request
 */
class UserHistoryRequest implements RequestInterface
{

    /**
     * @var string
     */
    private $username;

    /**
     * @var string|null
     */
    private $type;

    /**
     * UserHistoryRequest constructor.
     *
     * @param string $username
     * @param null   $type
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $username, $type = '') // "" means empty string so get all history anime+manga
    {
        $this->username = $username;

        if (null !== $type) {
            if (!\in_array($type, ['anime', 'manga'])) {
                throw new \InvalidArgumentException(sprintf('Type %s is not valid', $type));
            }

            $this->type = $type;
        }
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return sprintf(Constants::BASE_URL.'/user/%s/history/%s', $this->username, $this->type);
    }
}
