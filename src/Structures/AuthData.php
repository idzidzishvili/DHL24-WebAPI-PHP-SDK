<?php

namespace Alexcherniatin\DHL\Structures;

use Alexcherniatin\DHL\Exceptions\InvalidStructureException;

class AuthData
{

    /**
     * User login
     *
     * @var string
     */
    private $username = '';

    /**
     * User password
     *
     * @var string
     */
    private $password = '';

    public function __construct(string $username, string $password)
    {
        $this->username = $username;

        $this->password = $password;
    }

    /**
     * Auth data structure
     *
     * @throws InvalidStructureException
     *
     * @return array
     */
    public function structure(): array
    {

        if (\strlen($this->username) === 0) {
            throw new InvalidStructureException('Auth data username required');
        }

        if (\strlen($this->password) === 0) {
            throw new InvalidStructureException('Auth data password required');
        }

        return [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }
}
