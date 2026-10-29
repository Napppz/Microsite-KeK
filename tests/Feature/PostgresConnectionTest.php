<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PostgresConnectionTest extends TestCase
{
    /**
     * Test that the local PostgreSQL development connection works.
     */
    public function test_local_postgresql_connection_is_operational(): void
    {
        try {
            // Restore actual pgsql database name if overridden by phpunit in-memory sqlite
            config(['database.connections.pgsql.database' => 'kek_business_forum']);
            DB::purge('pgsql');

            $connection = DB::connection('pgsql');
            $result = $connection->select('SELECT version(), current_database()');

            $this->assertNotEmpty($result);
            $this->assertStringContainsString('PostgreSQL', $result[0]->version);
            $this->assertEquals('kek_business_forum', $result[0]->current_database);
        } catch (\Throwable $e) {
            $this->fail('Failed connecting to local PostgreSQL server: ' . $e->getMessage());
        }
    }
}
