<?php
/**
 * $Id: plugin.php 22 2010-03-24 19:37:03Z stefan $
 * 
 * Collect the currently used TVs and sort them to tabs which created on there
 * associated categories
 * 
 * 
 *
 * Updated by Piotr Matysiak (pmfx) on 2016-09-27: Now works with multiTV
 * 
 * 
 * 
 * Plugin code:
 * include MODX_BASE_PATH . 'assets/plugins/tv_categorized_tabs/plugin.php';
 *
 *
 * 
 * Plugin system events:
 * OnDocFormPrerender
 * OnDocFormRender
 *
 *
 *
 * Plugin configuration:
 * {
 *  "move_tv": [
 *    {
 *      "label": " <h5>Tab TV</h5><p>Transform Tv-section to a tab</p>",
 *      "type": "list",
 *      "value": "false",
 *      "options": "true,false",
 *      "default": "false",
 *      "desc": ""
 *    }
 *  ],
 *  "move_content": [
 *    {
 *      "label": " <h5>Tab Content</h5><p>Transform Content-section to a tab</p>",
 *      "type": "list",
 *      "value": "false",
 *      "options": "true,false",
 *      "default": "false",
 *      "desc": ""
 *    }
 *  ],
 *  "use_cm": [
 *    {
 *      "label": " <h5>Categories Manager in use?</h5><p>What's that?</p><p>The categories could displayed by a ordered ranking.<br><strong>If true and the Manager is not installed, an error will occur</strong></p><p>Please visit: http://modxcms.com/extras/package/587</p>",
 *      "type": "list",
 *      "value": "false",
 *      "options": "true,false",
 *      "default": "true",
 *      "desc": ""
 *    }
 *  ],
 *  "pluginConfig": [
 *    {
 *      "events": "OnDocFormPrerender,OnDocFormRender",
 *      "filePath": ""
 *    }
 *  ]
 * }
 * 
 * 
 * 
 * 
 * @version 0.3.2
 *
 * @TODO  
 *      # Get/create all categories/tabs and remove the empty ones via js from the DOM
 *      # Create a new tabpane under General-tab to collect general,content,tvs
 *       
 * fixed bugs:
 *      # Content Encoding Error:
 *        if output compression is set via htaccess (php_flag zlib.output_compression ON)
 *        An error occur on the template page
 *
 *        "ob_end_clean() [ref.outcontrol]: failed to delete buffer zlib output compression."
 *
 * v0.3.2 changes
 *      # Create loading-mask to hide rebuild-process
 *
 * v0.3.1 changes
 *      # Function of content-vars checkboxes are broken
 * 
 * v0.3.0 changes: 
 *      # Groups/Permissions are tabs now by default 1.0.2
 *      # rename content-fields checkboxes for better accessibility
 *      # add id to tab headers for better accessibility
 *      # split menuindex and showinmenu
 *      # move example for date-format to the same row where the 
 *        calendar-inputfield is. So its possible to move the complete row
 *      # hidemenu and menuindex in separate rows
 *      # which_editor in accessible table 
 *        move it to the settings tab
 *        $('field-which_edtor').injectInside('fieldcontainer-settings');
 * 
 * v0.2.5 fixed bugs:
 * 
 *      # If "@EVAL runSnippet()" used as Value for a tv, an error appear:
 *           "Undefined property: SystemEvent::$params"
 *              
 *          probably $e will be overwritten?
 *          
 *          var_dump( $e ); // = object
 *          echo renderFormElement($row['type'], $row['id'], $row['default_text'], $row['elements'], $tvPBV, 'style="width:300px;"');
 *          var_dump( $e ); // = NULL
 *          
 *          Solution could be:
 *          ------------------
 *          $p = new stdClass();
            $p->params = $e->params;
 *          
 *          var_dump( $e ); // = object
 *          
 *          echo renderFormElement($row['type'], $row['id'], $row['default_text'], $row['elements'], $tvPBV, 'style="width:300px;"');
 *          
 *          var_dump( $e ); // = NULL
 *          var_dump( $p ); // = object
 *          
 *          But this looks like a bad hack and anyway the cause of it is not longer
 *          touch this script.
 *
 *      # If a tv is a richtext field, it was not possible to save the in input.
 *      # All break down if "Tab Groups" selected but the section doesn't exist.
 *      # Won't work if other plugins injected div.sectionBody before this plugin
 *      # Nothing display if no Template-Var assigned
 */

global $content, $_lang, $default_template, $id, $docgrp;
$e =& $modx->event;
switch( $e->name )
{
    case 'OnDocFormPrerender' :
        $e->output('
            <div id="uix-loadingmask" style="background-color: #f7f7f7; position:absolute; top:0; z-index:10;"></div>
            <script type="text/javascript">
			//<![CDATA[
                $("uix-loadingmask").setStyles({
                    width  : window.getScrollWidth(),
                    height : window.getScrollHeight()
                });
            //]]>
            </script>
        ');
        return;
        break; 
    case 'OnDocFormRender' :
        $template = $default_template;
        $table_prefix                    = $modx->db->config['table_prefix'];
        $dbase                           = $modx->db->config['dbase'];
        $tbl_site_tmplvars               = $modx->getFullTableName('site_tmplvars');
        $tbl_site_tmplvar_templates      = $modx->getFullTableName('site_tmplvar_templates');
        $tbl_site_tmplvar_contentvalues  = $modx->getFullTableName('site_tmplvar_contentvalues');
        $tbl_site_tmplvar_access         = $modx->getFullTableName('site_tmplvar_access');
        
        if( $_SESSION['mgrDocgroups'] )
        {
            $docgrp = implode(',', $_SESSION['mgrDocgroups']);
        }
    
        if (isset ($_REQUEST['newtemplate'])) {
            $template = $_REQUEST['newtemplate'];
        } else {
            if (isset ($content['template']))
                $template = $content['template'];
        }
    
        $sql = 'SELECT DISTINCT tv.*, IF(tvc.value!=\'\',tvc.value,tv.default_text) as value '.
               'FROM '.$tbl_site_tmplvars.' AS tv '.
               'INNER JOIN '.$tbl_site_tmplvar_templates.' AS tvtpl ON tvtpl.tmplvarid = tv.id '.
               'LEFT JOIN '.$tbl_site_tmplvar_contentvalues.' AS tvc ON tvc.tmplvarid=tv.id AND tvc.contentid=\''.$id.'\' '.
               'LEFT JOIN '.$tbl_site_tmplvar_access.' AS tva ON tva.tmplvarid=tv.id '.
               'WHERE tvtpl.templateid=\''.$template.'\' AND (1=\''.$_SESSION['mgrRole'].'\' OR ISNULL(tva.documentgroup)'.
               (!$docgrp ? '' : ' OR tva.documentgroup IN ('.$docgrp.')').
               ') ORDER BY tvtpl.rank,tv.rank';
    
        $rs             = $modx->db->query($sql);
        $limit          = $modx->db->getRecordCount($rs);
        $tv_categories  = array();
        if( $limit > 0 )
        {
            /**
             * Get the categories
             * Sort them by the column rank... or not.
             */
            $_rank = '';
            if( $e->params['use_cm'] === 'true' )
            {
                $_rank = '`rank`, ';
            }
            $table_categories    = $table_prefix.'categories';
            $sql                 = 'SELECT `id`,`category` FROM `' . $table_categories . '` ORDER BY '. $_rank .'`category` ASC';
            $categories_result   = $modx->db->query( $sql );
            while( $category = $modx->db->getRow( $categories_result ) )
            {
                $tv_categories[$category['id']] = array(
                    'id'            => $category['id'],
                    'category'      => $category['category'],
                    'tplvars_data'  => array()
                );
            }
            // default category
            $tv_categories[0] = array(
                'id'           => 0,
                'category'     => $_lang['no_category'],
                'tplvars_data' => array()
            );
    
            for( $i=0; $i<$limit; $i++ )
            {
                $row = $modx->db->getRow($rs);
                if( isset( $tv_categories[$row['category']] ) )
                {
                    $tv_categories[$row['category']]['tplvars_data'][] = $row;
                }
                else
                {
                    $tv_categories[0]['tplvars_data'][] = $row;
                }
            }
        }
        include realpath( dirname( __FILE__ ) ) . '/ondocformrender.phtml';
        $e->output( ob_get_clean() );
        ob_start();   
        break;
    default:
    return;
        break;
}
return;