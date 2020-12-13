<?php

namespace App\Model;

use DateTime;

/**
 * Class Message
 */
class Message
{
    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var User
     */
    protected $sender;

    /**
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @var Discussion
     */
    protected $discussion;

    /**
     * @var string
     */
    protected $content;

    /**
     * Message constructor.
     * @param int|null $id
     * @param User $sender
     * @param Discussion $discussion
     * @param string $content
     * @param DateTime|null $createdAt
     */
    public function __construct(
        ?int $id,
        User $sender,
        Discussion $discussion,
        string $content,
        ?DateTime $createdAt = null
    ) {
        $this->id = $id;
        $this->sender = $sender;
        $this->discussion = $discussion;
        $this->content = $content;
        $this->createdAt = is_null($createdAt) ? new DateTime() : $createdAt;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getSender(): User
    {
        return $this->sender;
    }

    /**
     * @param User $sender
     */
    public function setSender(User $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return Discussion
     */
    public function getDiscussion(): Discussion
    {
        return $this->discussion;
    }

    /**
     * @param Discussion $discussion
     */
    public function setDiscussion(Discussion $discussion): void
    {
        $this->discussion = $discussion;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->content;
    }
}