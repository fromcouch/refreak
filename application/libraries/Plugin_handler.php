<?php

class Plugin_handler {
    
    protected $events = array();
    
    public function attach($event_name, $callback, $offset = null) {
        
        if (!isset($this->events[$event_name])) {
            $this->events[$event_name] = array();
        }
        
        if (!is_null($offset))
            $this->events[$event_name][$offset] = $callback;
        else
            $this->events[$event_name][] = $callback;
        
    }
    
    public function dettach($event_name, $offset) {
        
        if (!isset($this->events[$event_name][$offset])) {
            unset($this->events[$event_name][$offset]);
        }
        
    }
    
    public function trigger($event_name, $data = null, $offset = null) {
        
        foreach ($this->events[$event_name] as $callback) {
            
            if (is_callable($callback)) { //call
                $data = $callback($event_name, $data);
            }
        }
        
        return $data;
    }
    
}

/*
$p = new Plugin_handler();
$p->attach('load', function() { echo "Loading"; });
$p->attach('stop', function() { echo "Stopping"; });
$p->attach('stop', function() { echo "Stopped"; });
$p->trigger('load'); // prints "Loading"
$p->trigger('stop'); // prints "StoppingStopped"
*/