# About XeCore

This plugin was required for [XeFramework](https://github.com/XeCreators/xe-framework). It added custom post types, taxonomies, fields and WPBakery Page Builder elements as they are `Plugin Territory` functionalities.

*Note: Its been deprecated after release of XeFramework v2.0.0*

## Getting Started With Core Plugin

The first thing you want to do is copy the `xe-core` plugin directory and change the name to something else (like, say, `xurais-core`), and then you'll need to do a eight-step find and replace on the name in all the templates.

1. Search for `'xe-core'` (inside single quotations) to capture the text domain.
2. Search for `_xe_core_` to capture all the function names.
3. Search for `Text Domain: xe-core` 
4. Search for ` Xe Core` (with a space before it) to capture DocBlocks.
5. Search for `xe-core-` to capture prefixed handles.
6. Search for `$xe_core` to capture global variables.
7. Search for `xe_opt` to capture theme global variables.
8. Search for `Xe_Core` to capture prefixed classes.
9. Search for `/xe-core` to capture theme folder names that are used inside plugin.

OR

1. Search for: `'xe-core'` and replace with: `'xurais-core'`
2. Search for: `_xe_core_` and replace with: `xurais-core_`
3. Search for `Text Domain: xe-core` and replace with `Text Domain: xurais-core`
4. Search for ` Xe Core` (with a space before it) and replace with `Xurais Core`
5. Search for `xe-core-` and replace with `xurais-core-`
6. Search for `$xe_core` and replace with `$xurais_core`
7. Search for `xe_opt` and replace with `xurais_opt`
8. Search for `Xe_Core` and replace with `Xurais_Core`
9. Search for `/xe-core` and replace with `/xurais-core`

Then, update the header in `xe-core.php` and change its name to your plugin directory name.

Now you're ready to go! The next step is easy to say, but harder to do: make an awesome WordPress theme. :-)

Good luck!