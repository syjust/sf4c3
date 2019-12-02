<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @Assert\NotBlank(message="validation.contact.sender")
     * @Assert\Email
     * @Assert\Type("string")
     */
    public $sender;

    /**
     * @Assert\NotBlank(message = "validation.contact.subject")
     * @Assert\Length(min = 10, max = 50)
     * @Assert\Type("string")
     */
    public $subject;

    /**
     * @Assert\NotBlank(message = "validation.contact.message")
     * @Assert\Type("string")
     */
    public $message;
}
