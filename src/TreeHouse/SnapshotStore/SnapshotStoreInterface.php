<?php
declare(strict_types=1);

namespace TreeHouse\SnapshotStore;

interface SnapshotStoreInterface
{
    /**
     * @param mixed $id
     *
     * @return Snapshot|null
     */
    public function load($id);

    /**
     * @param SnapshotableAggregateInterface $aggregate
     */
    public function store(SnapshotableAggregateInterface $aggregate);
}
