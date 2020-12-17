<?php

namespace App\Model;

/**
 * Class Discussion
 */
class Discussion
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var User[]
     */
    protected $participants;

    /**
     * @var Message[]
     */
    protected $messages;

    /**
     * Discussion constructor.
     * @param int $id
     * @param User[] $participants
     * @param Message[] $messages
     */
    public function __construct(int $id, array $participants, array $messages = [])
    {
        $this->id = $id;
        $this->participants = $participants;
        $this->messages = array_map(
            function (Message $message) { $message->setDiscussion($this); return $message; },
            $messages
        );
    }

    /**
     * @return int
     */
    public function getId(): int
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
     * @return User[]
     */
    public function getParticipants(): array
    {
        return $this->participants;
    }

    /**
     * @param User[] $participants
     */
    public function setParticipants(array $participants): void
    {
        $this->participants = $participants;
    }

    /**
     * @param User $participant
     */
    public function addParticipant(User $participant): void
    {
        if (array_search($participant, $this->participants) === false) {
            $this->participants[] = $participant;
        }
    }

    /**
     * @param User $participant
     */
    public function removeParticipant(User $participant): void
    {
        $indice = array_search($participant, $this->participants);

        if ($indice !== false) {
            array_splice($this->participants, $indice, 1);
        }
    }

    /**
     * @return Message[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param Message $message
     */
    public function addMessage(Message $message): void
    {
        if (array_search($message->getSender(), $this->participants) !== false) {
            $this->messages[] = $message;
        }
    }

}