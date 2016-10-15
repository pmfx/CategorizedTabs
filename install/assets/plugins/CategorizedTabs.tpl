//<?php
/**
 * CategorizedTabs
 *
 * This plugin sort the TVs to their categories and replace the default tv-section
 *
 * @category    plugin
 * @version     1.0.0
 * @license     http://creativecommons.org/licenses/GPL/2.0/ GNU Public License (GPL v2)
 * @internal    @properties &move_tv = Tab TV;list;true,false;false;desc;Transform Tv-section to a tab. &move_content = Tab Content;list;true,false;false;desc;Transform Content-section to a tab. &use_cm = Categories Manager in use;list;true,false;false;desc;The categories could displayed by a ordered ranking. If true and the Categories Manager is not installed, an error will occur.
 * @internal    @events OnDocFormPrerender,OnDocFormRender
 * @internal    @modx_category Manager and Admin
 * @internal    @installset base
 * @reportissues https://github.com/pmfx/CategorizedTabs
 * @link        Original stefan release https://modx.com/extras/package/tvcategorizedtabs
 * @author      stefan https://modx.com/extras/author/stefan
 * @author      pmfx https://github.com/pmfx
 * @lastupdate  15/10/2016
 */

include MODX_BASE_PATH . 'assets/plugins/categorizedtabs/plugin.php';