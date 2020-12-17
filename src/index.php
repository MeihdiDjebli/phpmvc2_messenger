<?php

namespace App;

require_once 'autoload.php';

use App\Model\DiscussionRepository;
use App\Model\User;
use App\Model\Discussion;
use App\Model\Message;
use App\Model\UserRepository;
use function App\Utils\dump;

if (isset($_GET['init'])) {
    $userRepository = new UserRepository();

    $users = $userRepository->findAll();

    if (count($users) === 0) {
        $bobby = new User('bobby', 'MyPassword', 'Bob');
        $janet = new User('janet', '1234', 'Jane');

        $userRepository->insert($bobby);
        $userRepository->insert($janet);
    } else {
        $bobby = $users[0];
        $janet = $users[1];
    }

    $discussion = new Discussion(0, [$bobby, $janet]);
    $message = new Message(null, $bobby, $discussion, "Hello");
    $discussion->addMessage($message);

    (new DiscussionRepository())->insert($discussion);

    echo "<h1>init OK</h1>";
} elseif (isset($_GET['action']) && $_GET['action'] === 'view') {
    if (!isset($_GET['discussion'])) {
        throw new \Exception("NOT FOUND");
    }

    /** @var Discussion $discussion */
    $discussion = (new DiscussionRepository())->find($_GET['discussion']);

    if ($discussion === null) {
        throw new \Exception("NOT FOUND");
    }

    echo sprintf("<h1>Thread n°%d</h1>", $discussion->getId());

    foreach ($discussion->getMessages() as $message) {
        echo sprintf("<b>%s</b> said : %s<br>", $message->getSender()->getPseudo(), $message);
    }
} elseif (isset($_GET['action']) && $_GET['action'] === 'talk') {
    if (!isset($_GET['message'], $_GET['discussion'])) {
        throw new \Exception("NOT FOUND");
    }

    $discussionRepository = new DiscussionRepository();

    /** @var Discussion $discussion */
    $discussion = $discussionRepository->find($_GET['discussion']);

    $bobby = (new UserRepository())->find('bobby');
    $message = new Message(null, $bobby, $discussion, $_GET['message']);
    $discussion->addMessage($message);
    $discussionRepository->update($discussion, $discussion->getId());

    header('location: /?action=view&discussion=' . $discussion->getId());
}