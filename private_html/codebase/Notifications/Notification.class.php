<?php
namespace vlobby\Notifications;

\vlobby\loadClass('Database/Connect');

class Notification {
    public $id, $notification, $time, $status, $color;
}
