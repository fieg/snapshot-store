<?php
declare(strict_types=1);

namespace TreeHouse\SnapshotStore;

final class Snapshot
{
    private $aggregateId;

    /**
     * @var int
     */
    private $aggregateVersion;

    /**
     * @var array
     */
    private $data;

    /**
     * @var \DateTime
     */
    private $datetimeCreated;

    /**
     * @param $aggregateId
     * @param int $aggregateVersion
     * @param array $data
     */
    public function __construct($aggregateId, $aggregateVersion, array $data)
    {
        $this->aggregateId = $aggregateId;
        $this->aggregateVersion = $aggregateVersion;
        $this->data = $data;
        $this->datetimeCreated = new \DateTime();
    }

    /**
     * @param \DateTime $datetimeCreated
     *
     * @return Snapshot
     */
    public function withDatetimeCreated(\DateTime $datetimeCreated)
    {
        $self = clone $this;

        $self->datetimeCreated = $datetimeCreated;

        return $self;
    }

    /**
     * @return mixed
     */
    public function getAggregateId()
    {
        return $this->aggregateId;
    }

    /**
     * @return int
     */
    public function getAggregateVersion(): int
    {
        return $this->aggregateVersion;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return \DateTime
     */
    public function getDatetimeCreated(): \DateTime
    {
        return $this->datetimeCreated;
    }
}
