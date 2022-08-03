<?php

// Access values like an array https://www.php.net/manual/en/class.arrayaccess.php

/**
* This class represents a bom app
*/
class RedApp implements ArrayAccess{
  public $red_app;
  public $red_app_id;
  public $app_components = array();
  function __construct($red_app_assoc_array) {
    $this->red_app = $red_app_assoc_array;
    $this->red_app_id = $red_app_assoc_array['app_id'];
  }

  public function offsetSet($offset, $value) {
    if (is_null($offset)) {
      $this->red_app[] = $value;
    } else {
      $this->red_app[$offset] = $value;
    }
  }

  public function offsetExists($offset) {
    return isset($this->red_app[$offset]);
  }

  public function offsetUnset($offset) {
    unset($this->red_app[$offset]);
  }

  public function offsetGet($offset) {
    return isset($this->red_app[$offset]) ? $this->red_app[$offset] : null;
  }

  function addAppComponent(&$app_component){
    if($app_component['app_id'] == $this['app_id']){
      $this->app_components[] = $app_component;
    } else {
      foreach ($this->app_components as &$component) {
        if($component->addAppComponent($app_component)){
          break;
        }
      }
    }
  }

}

/**
* This class represents an app component
**/
class AppComponent implements ArrayAccess{
  public $app_component;
  private $component_level;
  public $children = array();

  function __construct($app_component_assoc_array){
    $this->app_component = $app_component_assoc_array;
    $this->component_level = 0;
  }

  public function offsetSet($offset, $value) {
    if (is_null($offset)) {
      $this->app_component[] = $value;
    } else {
      $this->app_component[$offset] = $value;
    }
  }

  public function offsetExists($offset) {
    return isset($this->app_component[$offset]);
  }

  public function offsetUnset($offset) {
    unset($this->app_component[$offset]);
  }

  public function offsetGet($offset) {
    return isset($this->app_component[$offset]) ? $this->app_component[$offset] : null;
  }

  // Add an app component. returns true if it was added false otherwise
  function addAppComponent(&$new_component){
    if($new_component['app_id'] == $this['cmpt_id']){
      $this->children[] = $new_component;
      return true;
    } else {
      foreach ($this->children as &$child) {
        if($child->addAppComponent($new_component)){
          return true;
        }
      }
    }
    return false;
  }

  public function compareToBy($other_component, $comparison_variable){
    if($this[$comparison_variable] == $other_component[$comparison_variable]){
      return true;
    }
    return false;
  }
}

?>
