OSR 001 : Meta Object
=====================
The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD", "SHOULD NOT", "RECOMMENDED", "MAY", and "OPTIONAL" in this document are to be interpreted as described in [RFC 2119] (http://tools.ietf.org/html/rfc2119).


1. Overview
-------------
Modern framework use IoC (Inversion of Control)  to handle common component.  Every component have registered name,  and it's called from code with name.

Yii example :
```php
$mailer = Yii->app()->mailer;   // or
$mailer = Yii->app()->getComponent('mailer');
```

Symfony example :
```php
$mailer = $container->get('mailer');
```

On Yii, object Application is also as IoC container, and on Symfony or Zend Framework, they have lose coupled IoC container library.

### Namespaced IoC ID

Component on IoC container is global, so need IoC ID that namespaced. The easy 'method' is use dot (or other) as sparator. For example :

mailSender => mailer.sender

userProperty => user.property

### MetaObject

Configuration of IoC stored on one file, so if there are more-more component , IoC container will be load all configuration first. OpenBiz have solution with split configuration per component per file. With Namespaced IoC ID, we can make the directory of file as IoC namespace with following format.:

path.path.path.ComponentID => Path/path/path/ComponentID.xml

For exampe :

`"mailer.Sender"` component configuration can put on file on directory mailer : `mailer/Sender.xml`

So, we can call component like this 

```php
$mailSender = $container::getComponent('mailer.Sender');
```

Openbiz 'give name' this component as MetaObject, object that created from metadata.


2. Specification
-----------------

- Meta-namespace can use dot (.) and back-slash (\)
- Can use various storage media (XML, php array, YAML, database, etc)
- Location of metaobject can set from out of library, like Universal ClassLoader 
  REF : 
      - (https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md)
      - (https://gist.github.com/221634)

   for example:
   
   ```php
     ObjectFactory::register('MyLib', '/path/to/mylib', {'xml', 'php', 'yml'}  )
   ```   
   
| Parameter             | Description                           |
|-----------------------|---------------------------------------|
| MyLib                 | is prefix of MetaObject (Vendor Name) |
| /path/to/mylib        | is loacation of MetaObject            |
| {'xml', 'php', 'yml'} | is type of MetaObject that supported  |
        

- MetaObject is independent component that can use on other framework.
