Name Convention
================

Method Name
---------------

Generaly,  method must preceded by verb.
	-> saveData()
	-> run()
	-> showMessage()
	-> sendEmail()
	-> $email->send();
	
If method name has context with object then only use verb only
  $logger->sendMail(), but
  $email->send();

Use getter and setter for property
	- Can have read/write only property
	- Can have behavior,  for exampele validation, etc.
	
Use simple question form for method that return boolean type
 Example :
	Car object break down =>  is car break down?  
					=>  isBreakDown() 
					=> $car->isBreakDown()
					
	Object Car that has lamp          => is car has lamp? 
						=> isCarHaveLamp()?
						 => $car->hasLamp()?
	
