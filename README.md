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


Note:

The switch "Categories Manager in use" is depend on the module 

6 Save plugin

**History**

- 2016-10-01 Now works with MultiTV (pmfx)
- 2010-03-26 Original v0.3.2 release by stefan

**Credits**

Plugin originaly created by stefan https://modx.com/extras/author/stefan