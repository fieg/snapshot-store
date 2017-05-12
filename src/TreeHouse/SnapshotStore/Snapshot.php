<?php
declare(strict_types=1);

namespace TreeHouse\SnapshotStore;

final class Snapshot
{
    /**
     * @var string
     */
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
     * @var string
     */
    private $checksum;

    /**
     * @var string
     */
    private $class;

    /**
     * @var \DateTime
     */
    private $datetimeCreated;

    /**
     * @param string $aggregateId
     * @param int $aggregateVersion
     * @param array $data
     * @param string $class
     * @param string $checksum
     */
    public function __construct($aggregateId, $aggregateVersion, array $data, $checksum, $class)
    {
        $this->aggregateId = $aggregateId;
        $this->aggregateVersion = $aggregateVersion;
        $this->data = $data;
        $this->datetimeCreated = new \DateTime();
        $this->checksum = $checksum;
        $this->class = $class;
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
     * @return string
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
     * @return string
     */
    public function getChecksum(): string
    {
        return $this->checksum;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return \DateTime
     */
    public function getDatetimeCreated(): \DateTime
    {
        return $this->datetimeCreated;
    }
}
