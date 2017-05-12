<?php
declare(strict_types=1);

namespace TreeHouse\SnapshotStore;

use Doctrine\DBAL\Connection;

final class DbalSnapshotStore implements SnapshotStoreInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $table;

    /**
     * @param Connection $connection
     * @param string $table
     */
    public function __construct(Connection $connection, $table = 'snapshot_store')
    {
        $this->connection = $connection;
        $this->table = $table;
    }

    /**
     * @inheritdoc
     */
    public function load($id)
    {
        $qb = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->where('aggregate_id = :aggregate_id')
            ->orderBy('version', 'DESC')
            ->setMaxResults(1)
        ;

        $qb
            ->setParameter('aggregate_id', $id)
        ;

        $result = $qb
            ->execute()
            ->fetch()
        ;

        if ($result) {
            $snapshot = new Snapshot(
                $result['aggregate_id'],
                (int) $result['version'],
                json_decode($result['payload'], true),
                $result['checksum'],
                $result['class']
            );

            return $snapshot->withDatetimeCreated(new \DateTime($result['datetime_created']));
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function store(SnapshotableAggregateInterface $aggregate)
    {
        $this->connection->insert(
            $this->table,
            [
                'aggregate_id' => $aggregate->getId(),
                'payload' => json_encode($aggregate->serialize()),
                'version' => $aggregate->getVersion(),
                'class' => get_class($aggregate),
                'checksum' => $aggregate::checksum(),
                'datetime_created' => (new \DateTime())->format('Y-m-d H:i:s'),
            ]
        );

    }
}
