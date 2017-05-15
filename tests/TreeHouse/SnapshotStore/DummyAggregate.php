<?php
declare(strict_types=1);

namespace Tests\TreeHouse\SnapshotStore;

use TreeHouse\Domain\AggregateInterface;
use TreeHouse\Domain\EventStreamInterface;
use TreeHouse\Domain\RecordsEventsTrait;
use TreeHouse\SnapshotStore\Snapshot;
use TreeHouse\SnapshotStore\SnapshotableAggregateInterface;

final class DummyAggregate implements SnapshotableAggregateInterface
{
    use RecordsEventsTrait;

    private $id;
    private $version = 1;

    private $foo = 'bar';

    /**
     * @param mixed $data
     *
     * @return AggregateInterface
     */
    public static function createFromData($data)
    {
        $self = new self();
        $self->id = $data['id'];
        $self->version = $data['version'];

        return $self;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'version' => $this->version,
            'foo' => $this->foo,
        ];
    }

    /**
     * @param Snapshot $snapshot
     *
     * @return SnapshotableAggregateInterface
     */
    public static function createFromSnapshot(Snapshot $snapshot)
    {
        return new self();
    }

    /**
     * @param EventStreamInterface $stream
     *
     * @return void
     */
    public function updateFromStream(EventStreamInterface $stream)
    {
        foreach ($stream as $event) {
            // should mutate
        }
    }

    /**
     * Return md5 checksum of this class
     *
     * @return string
     */
    public static function checksum(): string
    {
        return md5_file(__FILE__);
    }
}
