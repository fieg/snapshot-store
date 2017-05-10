<?php
declare(strict_types=1);

namespace TreeHouse\SnapshotStore;

use TreeHouse\Domain\AggregateInterface;
use TreeHouse\Domain\EventStreamInterface;

interface SnapshotableAggregateInterface extends AggregateInterface
{
    /**
     * @return int
     */
    public function getVersion(): int;

    /**
     * @return array
     */
    public function serialize(): array;

    /**
     * @param Snapshot $snapshot
     *
     * @return SnapshotableAggregateInterface
     */
    public static function createFromSnapshot(Snapshot $snapshot);

    /**
     * @param EventStreamInterface $stream
     *
     * @return void
     */
    public function updateFromStream(EventStreamInterface $stream);
}
