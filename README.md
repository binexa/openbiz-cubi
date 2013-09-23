OpenbizX CubiX
==============

OpenbizX CubiX is fork of Openbiz Cubi.

This project aimed to increase more better code standard and application design. 
We can not perform it on original Openbiz Project because hampered by compatibility isue.

This repo initialized from Openbiz Cubi project, version r5369.

**Note:**
This project not yet have name as brand, "OpenbizX CubiX" is only as "project code". 
Maybe this project be created as next version of original Openbiz Cubi.

Roadmap
-------

**Step 1**
* Perform Name Convention
  - change Constants:
        + give prefix OPENBIZ if use in framework directory (openbizx)
        + give prefix CUBI if only used in CUBI (out side of openbiz directory)
        + give PATH (word) for file system and URL for web system.
  - Remove "m_" character from variable name
        + $varName
        + ->varName
        + :varName
  - Reformating source code
  - Replace getSessionVar and setSession var with loadSession and saveSession on MetaObject.
    Please read name convension [here] (https://github.com/binexa/openbizx-cubix/blob/master/docs/name-convention.md)  for detail.

**Step 2**
* GUI Enhancement
  - Only using JQuery as JS library, Prototype and friends removed.
  - Initialized using Bootstrap for theme.

**Step 3**
* Design for PHP 5.3 and using PHP-Fig Standard.
* use Zend Framework 2 for core libary, replace Zend Framework 1



We are still looking for more good architecture for Openbizx Cubi.

Of course , contributor welcome.


Agus Suhartono (initiator).
