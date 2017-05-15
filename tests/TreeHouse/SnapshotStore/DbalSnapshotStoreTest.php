<?php
declare(strict_types=1);

namespace Tests\TreeHouse\SnapshotStore;

use Doctrine\DBAL\Cache\ArrayStatement;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Query\QueryBuilder;
use PHPUnit\Framework\Assert;
use PHPUnit_Framework_TestCase;
use Prophecy\Argument;
use TreeHouse\SnapshotStore\DbalSnapshotStore;

final class DbalSnapshotStoreTest extends PHPUnit_Framework_TestCase
{
    const ID = 'f10ec82d-52cd-466d-8a4f-c6f10e5b151b';
    const VERSION = 1;
    const DATA = [
        'foo' => 'bar'
    ];
    const DATE = '2017-05-11 09:12:12';
    const CHECKSUM = '07efad94b32bc5057d214dba7a0b2446'; // md5_file(__DIR__ . '/DummyAggregate.php');

    /**
     * @var Connection
     */
    private $connection;

    protected function setUp()
    {
        $this->connection = $this->prophesize(Connection::class);
    }

    /**
     * @test
     */
    public function it_returns_snapshot_instance()
    {
        $db = [
            [
                'id' => '1',
                'aggregate_id' => self::ID,
                'payload' => json_encode(self::DATA),
                'version' => (string) self::VERSION,
                'checksum' => (string) self::CHECKSUM,
                'class' => 'Acme\\Some\\Aggregate',
                'datetime_created' => self::DATE,
            ]
        ];

        $statement = new ArrayStatement($db);

        $this->connection->createQueryBuilder()->willReturn(new QueryBuilder($this->connection->reveal()));
        $this->connection->getDatabasePlatform()->willReturn(new MySqlPlatform());
        $this->connection->executeQuery(Argument::cetera())->willReturn($statement);

        $store = new DbalSnapshotStore(
            $this->connection->reveal()
        );

        $snapshot = $store->load(self::ID);

        $this->assertEquals(self::ID, $snapshot->getAggregateId());
        $this->assertEquals(self::VERSION, $snapshot->getAggregateVersion());
        $this->assertEquals(self::DATA, $snapshot->getData());
        $this->assertEquals(new \DateTime(self::DATE), $snapshot->getDatetimeCreated());
    }

    /**
     * @test
     */
    public function it_stores()
    {
        $store = new DbalSnapshotStore(
            $this->connection->reveal()
        );

        $aggregate = DummyAggregate::createFromData(['id' => self::ID, 'version' => self::VERSION]);

        $this->connection->insert(
            'snapshot_store',
            Argument::that(function($arg) use ($aggregate) {
                Assert::assertArraySubset(
                    [
                        'aggregate_id' => self::ID,
                        'payload' => json_encode($aggregate->serialize()),
                        'version' => self::VERSION,
                        'checksum' => self::CHECKSUM,
                    ],
                    $arg
                );

                return true;
            })
        )->shouldBeCalled();

        $store->store(
            $aggregate
        );
    }
}
