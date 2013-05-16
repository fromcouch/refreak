<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Refreak Plugin Handler Library
 *
 * @package	Refreak
 * @subpackage	base
 * @category	library
 * @author	Víctor <victor@ebavs.net> fromcouch
 * @link	https://github.com/fromcouch/refreak
 */
class Plugin_handler {
    
    /**
     * Store array events 
     * 
     * @var array Events list
     */
    protected $events = array();
    
    /**
     * Attach Event 
     * 
     * @param string $event_name Event name
     * @param object $callback Function to execute
     * @param string $offset function name. If you want dettach you need specify this
     * @return void
     * @access public
     */
    public function attach($event_name, $callback, $offset = null) {
        
        if (!isset($this->events[$event_name])) {
            $this->events[$event_name] = array();
        }
        
        if (!is_null($offset))
            $this->events[$event_name][$offset] = $callback;
        else
            $this->events[$event_name][] = $callback;
        
    }
    
    /**
     * Dettach Event
     * 
     * @param string $event_name Event name
     * @param string $offset function to dettach
     * @return void
     * @access public
     */
    public function dettach($event_name, $offset) {
        
        if (!isset($this->events[$event_name][$offset])) {
            unset($this->events[$event_name][$offset]);
        }
        
    }
    
    /**
     * Launch functions from specified event
     * 
     * @param string $event_name Event name     
     * @param string $offset function name
     * @param string $data Data to send to function
     * @return mixed return data processed
     * @access public
     */
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