# display section

Private module study for [LEPTON-CMS][1] 5.x|7.x  
_This is nothing more than a private playground._

### Requirements
- [LEPTON CMS][1], Version >= 5.3 (7.0 recommended)
- PHP 8.1 (8.2 recommended)

### Similar to "sectionPicker"
but  
- handles also _header.inc_ and _footer.inc.php_ of the specific module.
- handles also the _.css_ and _.js_ files of the module.

### Use as droplet
```php

[[display_section?sid=34]]
// sid is a valid section id
```
  
| Params | Description               |
|--------|---------------------------|
| *sid*  | The requested section_id. |


### Template (-filename)
- error.lte
- or ~/templates/*frontendTemplate*/frontend/display_section/error.lte

| Marker       | Description                                  |
|--------------|----------------------------------------------|
| *message*    | Holds the default (error-)message as string. |
| *section_id* | Holds the section_id that was requested.     |

#### example given (twig)
```html

{% autoescape false %}  
<span class="mod_display_section_error">{{ message }}</span>  
{% endautoescape %}

```

2023.2 - Aldus

[1]: https://lepton-cms.org "LEPTON CMS"
