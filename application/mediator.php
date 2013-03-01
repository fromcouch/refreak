<?php
//http://blog.ircmaxell.com/2012/03/handling-plugins-in-php.html
class Mediator {
    protected $events = array();
    public function attach($eventName, $callback) {
        if (!isset($this->events[$eventName])) {
            $this->events[$eventName] = array();
        }
        $this->events[$eventName][] = $callback;
    }
    public function trigger($eventName, $data = null) {
        foreach ($this->events[$eventName] as $callback) {
            $callback($eventName, $data);
        }
    }
}
$mediator = new Mediator;
$mediator->attach('load', function() { echo "Loading"; });
$mediator->attach('stop', function() { echo "Stopping"; });
$mediator->attach('stop', function() { echo "Stopped"; });
$mediator->trigger('load'); // prints "Loading"
$mediator->trigger('stop'); // prints "StoppingStopped"

/**
 * RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ /index.php/$1 [L]   
 */
?>
