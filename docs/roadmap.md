Roadmap
=======

Step 1
------
* Perform Name Convention
  - change Constants:
        + give prefix OPENBIZ if use in framework directory (openbizx)
        + give prefix CUBI if only used in CUBI (out side of openbiz directory)
        + give PATH for file system and URL for web system.
  - Remove "m_" character from variable name
        + $varName
        + ->varName
        + :varName
  - Reformating source code
  - Replace getSessionVar and setSession var with loadSession and saveSession on MetaObject.
    Please read name convension [here] (https://github.com/binexa/openbizx-cubix/blob/master/docs/name-convention.md)  for detail.

Step 2
------
* GUI Enhancement
  - Only using JQuery as JS library, Prototype and friends removed.
  - Initialized using Bootstrap for theme.

Step 3
------
* Design for PHP 5.3 and using PHP-Fig Standard.
* use Zend Framework 2 for core libary, replace Zend Framework 1
