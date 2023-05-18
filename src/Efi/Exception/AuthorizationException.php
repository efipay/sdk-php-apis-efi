<?php

namespace Efi\Exception;

use Exception;

/**
 * Exception class for authorization errors.
 */
class AuthorizationException extends Exception
{
    private $status;
    private $reason;
    private $body;

    /**
     * Initializes a new instance of the AuthorizationException class.
     *
     * @param int    $status The HTTP status code.
     * @param string $reason The reason for the authorization error.
     * @param mixed  $body   The response body associated with the error.
     */
    public function __construct(int $status, string $reason, mixed $body = null)
    {
        $this->status = $status;
        $this->reason = $reason;
        $this->body = $body;
        parent::__construct($reason, $status);
    }

    /**
     * Returns a string representation of the exception.
     *
     * @return string The string representation of the exception.
     */
    public function __toString()
    {
        return 'Authorization Error ' . $this->status . ': ' . $this->message . "\n";
    }

    /**
     * Magic getter method to access the properties of the exception.
     *
     * @param string $property The property name.
     * @return mixed|null The value of the property or null if it doesn't exist.
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return null;
    }
}
