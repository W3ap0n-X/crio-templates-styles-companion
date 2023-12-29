# crio-templates-styles-companion
Child theme-like overrides and style control for BoldGrid Crio

## Features
- Theme template overrides
- WooCommerce template overrides
- Custom Stylesheets
- Custom Js scripts
- Custom php snippets (via functions.php)

## Additional Info
### Adding overrrides
Add the template file to the templates directory of this plugin. This directory should mimick the theme's directory as far as where the template files are stored
For example:
if you are trying to override the crio 404 template, the crio template would be located at this path within your site's directory:
`/wp-content/themes/crio/404.php`
To override this you would create a file with the same name unddder
`/wp-content/plugins/crio-templates-styles-companion/templates/404.php`

### Adding CSS and JS 

#### JS
Add your script files to this plugin's /js folder or edit the provided my_scripts.js file to add your snippets. 
If you are adding a new file you will need to edit the crio-templates-styles-companion.php file and add the name of the script file to the $ctsc_custom_scripts array to activate it.

#### CSS 
Add your script files to this plugin's /css folder or edit the provided my_styles.css file to add your snippets. 
If you are adding a new file you will need to edit the crio-templates-styles-companion.php file and add the name of the stylesheet to the $ctsc_custom_styles array to activate it.

### Debugging
Set the CTSC_DEBUG constant to true in the plugin file to output debug info
This will output a small text box that will output the filepath of the template used. This can be good to confirm if your template overrides are working or to see what template is being loaded for what content.
