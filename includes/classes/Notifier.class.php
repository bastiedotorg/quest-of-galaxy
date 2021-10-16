<?php

class Notifier
{

    protected static ?Notifier $_instance = null;

    static function get(): Notifier
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    protected function __construct()
    {
        if (!is_array($_SESSION['notifications'])) {
            $_SESSION['notifications'] = [];
        }
    }

    public function addNotification($notification_title, $notification_text): bool
    {
        $_SESSION['notifications'][] = ["title" => $notification_title, "text" => $notification_text];
        return true;
    }

    public function readNotification(): ?array
    {
        return array_pop($_SESSION['notifications']);
    }
}