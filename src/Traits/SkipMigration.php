<?php

declare (strict_types=1);


namespace App\Traits;

trait SkipMigration
{
    public function skipIfCommonDatabase()
    {
        $this->skipIf($this->connection->getDatabase() === 'db_common');
    }

    public function skipIfNotCommonDatabase()
    {
        $this->skipIf($this->connection->getDatabase() !== 'db_common');
    }
}
