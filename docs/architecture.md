Draf of OpenbizX Architecture
=============================

All Library
-----------------
- Use power of namespace
- Use Universal AutoLoad and use ClassMap increase performance
- If possible, library of Openbiz is group of components, that each component is independent, can use on other framework 
- If possible, lybrary must lose couple, so easy to performe unit test.

MetaObject
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
    
DataObject
--------------------       
- Value that returned by method must Use same form. If not, must use name extension.
- DataObject can save data on various storage media, not only database, but can save on text, xml, session, etc
- Use base interface and can extend for any use.

Form :
-------------------
Form can handle not only AJAX app, but also clasic web. This good for CMS or other front-end application
For business framework, can handle master detail transaction, for example: POS application

MVC
-------------------
- Front Controller cal still call View directly
  but also can call Controller/Presenter (on original MVC/MPV term)
- Action on Controller can call View

example :

```php
   class MyController {

      public function actionMemberList() {      
           $view = new Openbiz\View\StandarView();
           $view->setTemplate('.......')
           $view->addForm(...);
           $view->addForm(...);
           $view->render();
      }

      public function actionMemberList2() {      
           $view = new \Openbiz\System\ObjectFactory('Collab\MemberListView');
           $view->render();
      }

      public function actionMemberList3() {      
           $data = new \Openbiz\System\ObjectFactory('\MyPrefix\namespase\Member');
           echo '<pre>';           
           print_r( $data->loadAll() );           
      }

      public function actionOtherAction() 
         echo 'Openbiz, the next generation';
     )

  }
```
