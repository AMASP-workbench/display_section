# display section

Private module study for [LEPTON-CMS][1] 5.x  
_This is nothing more than a private playground._

### Requirements
- [LEPTON CMS][1], Version >= 5.3
- PHP 7.4 (8.0 recommented)

### similar to "sectionPicker"
but  
- handles also header.inc and footer.inc.php of the specific module.
- handles also the .css and .js files of the module.

### Use as droplet
```php

[[display_section?sid=34]]
// sid is a valid section id
```
  
Params|Description
-----|-----
*sid*|The requested section_id.


### Template
- error.lte
- or ~/templates/*frontendtemplate*/frontend/display_section/error.lte

Marker|Description
-----|-----
*message*|Holds the default (error-)message as string.  
*section_id*|Holds the section_id that was requested.  

#### example given (twig)
```html

{% autoescape false %}  
<span class="mod_display_section_error">{{ message }}</span>  
{% endautoescape %}

```

2022.5 - Aldus

[1]: https://lepton-cms.org "LEPTON CMS"
