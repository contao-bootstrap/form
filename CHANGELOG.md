
Changelog
=========

2.1.6
-----

[Full Changelog](https://github.com/contao-bootstrap/form/compare/2.1.5...2.1.6)

### Fixed

 - Fix widget type detection for widgets not providing type information

2.1.5
-----

[Full Changelog](https://github.com/contao-bootstrap/form/compare/2.1.4...2.1.5)

### Fixed

 - Show missing asterisk for confirming password (#45)

2.1.4 (2019-03-19)
------------------

[Full Changelog](https://github.com/contao-bootstrap/form/compare/2.1.3...2.1.4)

### Changed

 - Catch `Contao\CoreBundle\DataContainer\PaletteNotFoundException` for forward compatibility (#42). Resolves also 
   contao/contao#378  

2.1.3 (2018-09-28)
------------------

[Full Changelog](https://github.com/contao-bootstrap/form/compare/2.1.2...2.1.3)
 
 - Fix captcha for Contao 4.6 (#41)
 - Force error message being visible (#40)

2.1.2 (2018-08-24)
------------------

[Full Changelog](https://github.com/contao-bootstrap/form/compare/2.1.1...2.1.2)
 
 - Make service "contao_bootstrap.form.listener.form_field_dca" public for symfony/dependency-container v4 compatibility.
 
2.1.1 (2018-07-03)
------------------

[Full Changelog](https://github.com/contao-bootstrap/form/compare/2.1.0...2.1.1)
 
 - Add missing getRowClass().

2.1.0 (2018-07-03)
------------------

[Full Changelog](https://github.com/contao-bootstrap/form/compare/2.0.5...2.1.0)

 - Add javascript to fd_control_upload_bs_custom to update the label.
 - Add fd_control_upload_bs_custom_no_js to keep option without js.
 - Use `form-row` instead of `row` as default grid row class.
 - Make row class configurable in the form layout.

2.0.5 (2018-06-28)
------------------

[Full Changelog](https://github.com/contao-bootstrap/form/compare/2.0.4...2.0.5)

 - Fix upload label class for custom file uploads.

2.0.4 (2018-05-28)
------------------

[Full Changelog](https://github.com/contao-bootstrap/form/compare/2.0.3...2.0.4)

 - Fix error markup for fields with input groups.
 - Bugfix: Add offset if no label is defined.
 - Bugfix: Add missing grid column classes.
 - Update translations.

2.0.3 (2018-01-24)
------------------

[Full Changelog](https://github.com/contao-bootstrap/form/compare/2.0.2...2.0.3)

 - Fix issue that undefined palettes thrown an exception in the form view (#31)
 - Fix spdx license format
 - Fix adding bootstrap form styles for hidden captca (#27)

2.0.2 (2018-01-10)
------------------

[Full Changelog](https://github.com/contao-bootstrap/form/compare/2.0.1...2.0.2)

 - Bugfix: Changed MetaPalettes Namespace (#30)

2.0.1 (2018-01-05)
------------------

[Full Changelog](https://github.com/contao-bootstrap/form/compare/2.0.0...2.0.1)

 - Bugfix: Add input-group-text wrappers

2.0.0 (2018-01-05)
------------------

[Full Changelog](https://github.com/contao-bootstrap/form/compare/2.0.0beta2...2.0.0)

 - Apply markup changes of Bootstrap 4 beta 3 (#29)
 - Support Metapalettes v2.0
 

2.0.0-beta1 (2017-12-01)
------------------------

[Full Changelog](https://github.com/contao-bootstrap/form/compare/2.0.0-beta1...2.0.0-beta2)

 - Make listener services public as Contao requires it.

2.0.0-beta1 (2017-09-27)
------------------------

[Full Changelog](https://github.com/contao-bootstrap/form/compare/1.1.5...2.0.0-beta1)

Implemented enhancements:

 - Rework as Contao 4 bundle
 - Replace form-helper with form-designer
 - Bootstrap 4 support
