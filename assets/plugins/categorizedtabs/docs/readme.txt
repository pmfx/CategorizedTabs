# CategorizedTabs

Sort Template Variables to their categories and replace the default Template Variables section with categorized tabs. As an additional feature, you can transform the sections resource Content, Template Variables to single tabs within the default tabpane.

![screenshot_1](https://cloud.githubusercontent.com/assets/10888055/19413848/fad8e2ca-933a-11e6-843b-b49900f01823.png)

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

&move_tv = TV tab;list;true,false;false;desc;Transform Tv-section to a tab. &move_content = Content tab;list;true,false;false;desc;Transform Content-section to a tab. &use_cm = Order tabs by category rank;list;true,false;false;desc;If you are using MODX older than 1.2 you will need to install CategoriesManager module https://github.com/pmfx/CategoriesManager to use it, or an error will occur. NOTE: Since MODX 1.2 there is no need to install module as it is built-in into system.

Note:

The switch "Categories Manager in use" is depend on the module 
"MODx Categories Manager" - https://modx.com/extras/package/modxcategoriesmanager
That module gives you the possibility to manage and sort the modx-categories.

6 Save plugin

**History**

- 2016-10-21 Minor text change regarding new MODX "Manage Categories" feature (pmfx)
- 2016-10-16 Make plugin compatible with MODX install script (pmfx)
- 2016-10-01 Now works with MultiTV (pmfx)
- 2010-03-26 Original v0.3.2 release by stefan

**Credits**

Plugin originaly created by stefan https://modx.com/extras/author/stefan