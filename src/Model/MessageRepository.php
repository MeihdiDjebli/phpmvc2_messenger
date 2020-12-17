<?php

namespace App\Model;

/**
 * Class MessageRepository
 * @package App\Model
 */
class MessageRepository extends AbstractRepository
{
    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        parent::__construct("message", "id");
    }

    /**
     * @param Message $object
     * @return Message|null
     */
    public function insert($object): ?Message
    {
        $query = "INSERT INTO %s VALUES (null, \"%s\", \"%s\", \"%s\")";
        return $this->database::query(
            sprintf($query, $this->table, $object->getContent(), $object->getSender()->getUsername(), $object->getDiscussion()->getId())
        )
            ? $this->find($object->getId())
            : null;
    }

    /**
     * @param Message $object
     * @param string $id
     * @return Message|null
     */
    public function update($object, $id)
    {
        $query = "UPDATE %s SET id = \"%d\", content = \"%s\", sender_username = \"%s\" WHERE id = %d";
        return $this->database::query(
            sprintf($query, $this->table, $object->getId(), addslashes($object->getContent()), $object->getSender()->getUsername(), $id)
        )
            ? $this->find($object->getId())
            : null;
    }

    /**
     * @param array $data
     * @return Message
     * @throws \Exception
     */
    protected function convertToObject(array $data): Message
    {
        $sender = (new UserRepository())->find($data['sender_username']);
        $discussion = new Discussion($data['discussion_id'], []);
        return new Message($data['id'], $sender, $discussion, $data['content']);
    }

}