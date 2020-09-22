<?php

namespace Eieieiei;

class Callme {
    public function CallingFunctionName() { 
        
        // Create an exception 
        $ex = new \Exception(); 
        
        // Call getTrace() function 
        $trace = $ex->getTrace(); 
        
        // Position 0 would be the line 
        // that called this function 
        $final_call = $trace[2]; 
        
        // Display associative array  
        print_r($trace); 
    } 
}
  
// Declare firstCall() function 
function firstCall($x, $y) { 
      
    // Call secondCall() function 
    secondCall($x, $y); 
} 
  
// Declare secondCall() function 
function secondCall($x, $y) { 
      
    // Call CallingFunctionName() 
    // function 
    $call = new Callme();
    $call->CallingFunctionName();
} 
  
// Call firstCall() function 
firstCall('test', 'php'); 