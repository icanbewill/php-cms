<?php
class Redirect {
    public static function to($location = "") { 
        if ($location) {
            if ($location === error) {
                header('HTTP/1.0 404 Not Found');
            } 
            header("Location: /" . $location);
            header("Connection: close");
            exit();
        }
    }
}
