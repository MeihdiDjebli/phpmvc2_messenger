<?php

namespace App\Model;

/**
 * Class User
 */
class User
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $pseudo;

    /**
     * @var User[]
     */
    protected $contacts;

    /**
     * User constructor.
     * @param string $username
     * @param string $password
     * @param string $pseudo
     * @param array $contacts
     */
    public function __construct(string $username, string $password, string $pseudo, array $contacts = [])
    {
        $this->username = $username;
        $this->password = $password;
        $this->pseudo = $pseudo;
        $this->contacts = $contacts;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    /**
     * @param string $pseudo
     */
    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return User[]
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }

    /**
     * @param User[] $contacts
     */
    public function setContacts(array $contacts): void
    {
        $this->contacts = $contacts;
    }

    /**
     * @param User $contact
     */
    public function addContact(User $contact): void
    {
        if (array_search($contact, $this->contacts) === false) {
            $this->contacts[] = $contact;
        }
    }

    /**
     * @param User $contact
     */
    public function removeContact(User $contact): void
    {
        $indice = array_search($contact, $this->contacts);

        if ($indice !== false) {
            array_splice($this->contacts, $indice, 1);
        }
    }
}