<?php

namespace App\Model;

use function App\Utils\dump;

/**
 * Class DiscussionRepository
 * @package App\Model
 */
class DiscussionRepository extends AbstractRepository
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var MessageRepository
     */
    private $messageRepository;

    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        parent::__construct("discussion", "id");
        $this->userRepository = new UserRepository();
        $this->messageRepository = new MessageRepository();
    }

    /**
     * @param Discussion $object
     * @return Discussion|null
     */
    public function insert($object)
    {
        $query = "INSERT INTO %s VALUES (null, \"%s\", \"%s\")";
        $id = $this->database::query(sprintf($query, $this->table, "", ""));

        if (is_null($id)) {
            return null;
        }

        $object->setId($id);

        foreach ($object->getMessages() as $message) {
            $message->setDiscussion($object);
            $this->messageRepository->insert($message);
        }

        foreach ($object->getParticipants() as $participant) {
            $query = "INSERT INTO discussion_participants VALUES (%d, \"%s\")";
            $this->database::query(sprintf($query, $id, $participant->getUsername()));
        }

        return $this->find($id);
    }

    /**
     * @param Discussion $object
     * @param int $id
     * @return mixed|void
     */
    public function update($object, $id)
    {
        $query = "UPDATE %s SET id = %d WHERE id = %d";

        $result = $this->database::query(sprintf($query, $this->table, $object->getId(), $id));

        if ($result === false) {
            return null;
        }

        $deleteParticipants = "DELETE FROM discussion_participants WHERE discussion_id = %d";
        $deleteMessages = "DELETE FROM message WHERE discussion_id = %d";
        $this->database::query(sprintf($deleteParticipants, $id));
        $this->database::query(sprintf($deleteMessages, $id));

        foreach ($object->getMessages() as $message) {
            $message->setDiscussion($object);
            $this->messageRepository->insert($message);
        }

        foreach ($object->getParticipants() as $participant) {
            $query = "INSERT INTO discussion_participants VALUES (%d, \"%s\")";
            $this->database::query(sprintf($query, $object->getId(), $participant->getUsername()));
        }

        return $this->find($object->getId());
    }

    /**
     * @param array $data
     * @return Discussion
     */
    protected function convertToObject(array $data): Discussion
    {
        $participants = $this->getParticipants($data['id']);
        $messages = $this->getMessages($data['id']);
        return new Discussion($data['id'], $participants, $messages);
    }

    /**
     * @param int $id
     * @return User[]
     */
    private function getParticipants(int $id): array
    {
        $query = "SELECT user_username FROM discussion_participants WHERE discussion_id = %d";
        $results = $this->database::query(sprintf($query, $id))->fetch_all(MYSQLI_ASSOC);

        return array_map(
            function (array $result) { return $this->userRepository->find($result['user_username']); },
            $results
        );
    }

    /**
     * @param int $id
     * @return Message[]
     */
    private function getMessages(int $id): array
    {
        $query = "SELECT id FROM message WHERE discussion_id = %d";
        $results = $this->database::query(sprintf($query, $id))->fetch_all(MYSQLI_ASSOC);

        return array_map(
            function (array $result) { return $this->messageRepository->find($result['id']); },
            $results
        );
    }

}