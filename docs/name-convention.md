Name Convention
================

Method Name
---------------

Generaly,  method must preceded by verb.

	-> saveData();
	-> run();
	-> showMessage();
	-> sendEmail();
	-> $email->send();
	
If method name has context with object then only use verb only

  $logger->sendMail(), but
  $email->send();

Use getter and setter only for property

	- Can have read/write only property
	- Can have behavior,  for exampele validation, etc.
	
Use simple question form for method that return boolean type
 Example :

	Car object break down 
		=>  is car break down?  
		=>  isBreakDown() 
		=> $car->isBreakDown()
					
	Object Car that has lamp        
		=> is car has lamp? 
		=> isCarHaveLamp()?
		 => $car->hasLamp()?


Method prefix

Prefix  | Postfix 	| Usage 	| Examples
=========================================

	|		| Handle property | 
 get	| 		| Return the value of property 	| $obj->getName()
 set	| 		| Set the value of property	| $obj->setName($name)
	|		|				|

Handle persistent

insert

inserts new data in storage

 load

Load data from external source

save

updates existing data or inserts new data in storage (instead of replace)

update

updates existing data in storage (instead of save/change)



Return boolean value (true/false)

is

Is object something? 
$obj->isPrimary()

exists
checks to see if a value or property exists
$car->isLampExists()
has

checks to see if a value or property exists
$car->hasLamp()
can

Can object do behavior?
$car->canTurnLeft()




