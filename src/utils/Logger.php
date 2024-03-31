<?php

namespace app\utils;

class Logger
{
    public static function debug_to_console($data): void
    {
        if (is_array($data)) {
            foreach ($data as $item) {
                echo "<script>console.log('Debug Objects: " . $item . "');</script>";
            }
        } else {
            echo "<script>console.log('Debug Objects: " . $data . "');</script>";
        }
    }
}