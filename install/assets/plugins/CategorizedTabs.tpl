//<?php
/**
 * CategorizedTabs
 *
 * Sort Template Variables to their categories and replace the default Template Variables section with categorized tabs.
 *
 * @category    plugin
 * @version     1.0.1
 * @license     http://creativecommons.org/licenses/GPL/2.0/ GNU Public License (GPL v2)
 * @internal    @properties &move_tv = TV tab;list;true,false;false;desc;Transform Tv-section to a tab. &move_content = Content tab;list;true,false;false;desc;Transform Content-section to a tab. &use_cm = Order tabs by category rank;list;true,false;false;desc;If you are using MODX older than 1.2 you will need to install CategoriesManager module https://github.com/pmfx/CategoriesManager to use it, or an error will occur. NOTE: Since MODX 1.2 there is no need to install module as it is built-in into system.
 * @internal    @events OnDocFormPrerender,OnDocFormRender
 * @internal    @modx_category Manager and Admin
 * @internal    @installset base
 * @reportissues https://github.com/pmfx/CategorizedTabs
 * @link        Original stefan release https://modx.com/extras/package/tvcategorizedtabs
 * @author      stefan https://modx.com/extras/author/stefan
 * @author      pmfx https://github.com/pmfx
 * @lastupdate  21/10/2016
 */

include MODX_BASE_PATH . 'assets/plugins/categorizedtabs/plugin.php';