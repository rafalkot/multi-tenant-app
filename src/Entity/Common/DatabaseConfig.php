<?php

declare (strict_types=1);

namespace App\Entity\Common;

final class DatabaseConfig
{
    /**
     * @var string
     */
    private $database;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * DatabaseConfig constructor.
     *
     * @param string $database
     * @param string $host
     * @param string $user
     * @param string $password
     */
    public function __construct(string $database, string $host, string $user, string $password)
    {
        $this->database = $database;
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function database(): string
    {
        return $this->database;
    }

    /**
     * @return string
     */
    public function host(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function user(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }
}
