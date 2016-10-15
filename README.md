# CategorizedTabs

This plugin sort the TVs to their categories and replace the default tv-section with a tabpane which includes the categories as tabs. As an additional feature, you can transform the sections content, template-variables and permissions to single tabs within the default tabpane.

**Install**

Use Package Manager or install manually:

1 Copy the files to assets/plugins/categorizedtabs

2 Create new Plugin "CategorizedTabs"

3 Set Plugin-Event

"OnDocFormPrerender"
"OnDocFormRender"

4 Set Plugin-Code to

include MODX_BASE_PATH . 'assets/plugins/categorizedtabs/plugin.php';

5 Set Plugin-Configuration to

&move_tv = Tab TV;list;true,false;true;desc;Transform Tv-section to a tab. 
&move_content = Tab Content;list;true,false;false;desc;Transform Content-section to a tab. 
&use_cm = Categories Manager in use;list;true,false;false;desc;The categories could displayed by a ordered ranking. If true and the Categories Manager is not installed, an error will occur.

Note:

The switch "Categories Manager in use" is depend on the module 
"MODx Categories Manager" - https://modx.com/extras/package/modxcategoriesmanager
That module gives you the possibility to manage and sort the modx-categories.

6 Save plugin

**History**

- 2016-10-16 Make plugin compatible with MODX install script (pmfx)
- 2016-10-01 Now works with MultiTV (pmfx)
- 2010-03-26 Original v0.3.2 release by stefan

**Credits**

Plugin originaly created by stefan https://modx.com/extras/author/stefan