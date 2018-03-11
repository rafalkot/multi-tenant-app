<?php

declare (strict_types=1);

namespace App\Entity\Common;

final class Tenant implements \JsonSerializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var DatabaseConfig
     */
    private $dbConfig;

    public function __construct(string $name, string $domain, DatabaseConfig $dbConfig)
    {
        $this->name = $name;
        $this->domain = $domain;
        $this->dbConfig = $dbConfig;
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function domain(): string
    {
        return $this->domain;
    }

    /**
     * @return DatabaseConfig
     */
    public function dbConfig(): DatabaseConfig
    {
        return $this->dbConfig;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'domain' => $this->domain
        ];
    }
}
