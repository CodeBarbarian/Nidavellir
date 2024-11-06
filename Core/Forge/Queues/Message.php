<?php

namespace Core\Forge\Queues;

class Message {
    /** @var string Success message type */
    const SUCCESS = 'success';

    /** @var string Information message type */
    const INFO = 'info';

    /** @var string Warning message type */
    const WARNING = 'warning';

    /** @var string Danger message type */
    const DANGER = 'danger';

    /** @var array List of valid message types */
    private const VALID_TYPES = [
        self::SUCCESS,
        self::INFO,
        self::WARNING,
        self::DANGER,
    ];

    /**
     * Add a flash message to the session.
     *
     * @param string $message The message content
     * @param string $type The message type (e.g., success, info)
     * @return void
     * @throws \InvalidArgumentException if an invalid message type is provided
     */
    public static function addMessage(string $message, string $type = self::SUCCESS): void {
        // Check if the session is started
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Validate the message type
        if (!in_array($type, self::VALID_TYPES, true)) {
            throw new \InvalidArgumentException("Invalid message type: $type");
        }

        // Create array in the session if it doesn't already exist
        if (!isset($_SESSION['flash_notifications'])) {
            $_SESSION['flash_notifications'] = [];
        }

        // Append the message to the array
        $_SESSION['flash_notifications'][] = [
            'body' => $message,
            'type' => $type
        ];
    }

    /**
     * Retrieve all flash messages and clear them from the session.
     *
     * @return array An array of messages; empty array if no messages are set
     */
    public static function getMessages(): array {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $messages = $_SESSION['flash_notifications'] ?? [];
        unset($_SESSION['flash_notifications']);

        return $messages;
    }

    /**
     * Retrieve flash messages of a specific type.
     *
     * @param string $type The message type to retrieve
     * @return array An array of messages of the specified type
     * @throws \InvalidArgumentException if an invalid message type is provided
     */
    public static function getMessagesByType(string $type): array {
        if (!in_array($type, self::VALID_TYPES, true)) {
            throw new \InvalidArgumentException("Invalid message type: $type");
        }

        return array_filter(self::getMessages(), fn($msg) => $msg['type'] === $type);
    }
}
