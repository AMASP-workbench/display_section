# display section

Private module study for [LEPTON-CMS][1] 5.x
_This is nothing more than a private playground._

#### similar to "sectionPicker"
but  
- handles also header.inc and footer.inc.php of the specifi module.
- handles also specific css and js files of the module.

### use as droplet
```php

[ [display_section?sid=34]]
// sid is a valid section id
```
  
Params|Description
-----|-----
*sid*|The requested section_id.


### template
- error.lte
- or ~/templates/*frontendtemplate*/frontend/display_section/error.lte

Marker|Description
-----|-----
*message*|Holds the default (error-)message as string.
*section_id*|Holds the section_id that was requested.


### Requirements
- [LEPTON CMS][1], Version >= 5.3


[1]: https://lepton-cms.org "LEPTON CMS"
