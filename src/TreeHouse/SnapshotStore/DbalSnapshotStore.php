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
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @inheritdoc
     */
    public function load($id)
    {
        $qb = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('snapshot_store')
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
                json_decode($result['payload'], true)
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
        $snapshot = new Snapshot(
            $aggregate->getId(),
            $aggregate->getVersion(),
            $aggregate->serialize()
        );

        $this->connection->insert(
            'snapshot_store',
            [
                'aggregate_id' => $snapshot->getAggregateId(),
                'payload' => json_encode($snapshot->getData()),
                'version' => $snapshot->getAggregateVersion(),
                'datetime_created' => ($snapshot->getDatetimeCreated())->format('Y-m-d H:i:s'),
            ]
        );

    }
}