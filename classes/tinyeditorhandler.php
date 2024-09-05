<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * TinyEditorHandler class
 *
 * @package   local_digitalta
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_digitalta;

require_once($CFG->dirroot . '/lib/editor/tiny/classes/editor.php');
require_once($CFG->dirroot . '/lib/editor/tiny/classes/manager.php');

use editor_tiny\manager;

use stdClass;

/**
 * This class is used to handle the TinyMCE editor
 *
 * @copyright 2024 ADSDR-FUNIBER Scepter Team
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class TinyEditorHandler extends \editor_tiny\editor
{

    /** @var array options provided to initalize filepicker */
    protected $_options = [
        'areamaxbytes' => FILE_AREA_MAX_BYTES_UNLIMITED,
        'autosave' => true,
        'changeformat' => 0,
        'context' => null,
        'enable_filemanagement' => true,
        'maxbytes' => 0,
        'maxfiles' => 0,
        'noclean' => 0,
        'removeorphaneddrafts' => false,
        'return_types' => 15,
        'subdirs' => 0,
        'trusttext' => 0
    ];

    /**
     * Constructor
     */
    public function __construct()
    {
        global $CFG, $PAGE;

        parent::__construct();

        if (!empty($options['maxbytes'])) {
            $this->_options['maxbytes'] = get_max_upload_file_size($CFG->maxbytes, $options['maxbytes']);
        }
    }

    /**
     * Get filepicker options
     *
     * @param object $context The context
     * @param int $draftitemid The draft item id
     */
    public static function get_filepicker_options($context, $draftitemid)
    {
        return [
            'image' => self::specific_filepicker_options(['image'], $draftitemid, $context),
            'media' => self::specific_filepicker_options(['video', 'audio'], $draftitemid, $context),
            'link' => self::specific_filepicker_options('*', $draftitemid, $context),
        ];
    }

    /**
     * Get specific filepicker options
     *
     * @param array $acceptedtypes The accepted types
     * @param int $draftitemid The draft item id
     * @param object $context The context
     */
    protected static function specific_filepicker_options($acceptedtypes, $draftitemid, $context)
    {
        $filepickeroptions = new stdClass();
        $filepickeroptions->accepted_types = $acceptedtypes;
        $filepickeroptions->return_types = FILE_INTERNAL | FILE_EXTERNAL;
        $filepickeroptions->context = $context;
        $filepickeroptions->env = 'filepicker';
        $options = initialise_filepicker($filepickeroptions);
        $options->context = $context;
        $options->client_id = uniqid();
        $options->env = 'editor';
        $options->itemid = $draftitemid;

        return $options;
    }

    /**
     * Remove unwanted plugins
     *
     * @param object $config The configuration
     */
    protected static function remove_unwanted_plugins($config)
    {
        $pluginsToRemove = [
            "code",
            "help",
            "wordcount",
            "tiny_accessibilitychecker/plugin",
            "tiny_equation/plugin",
            "tiny_autosave/plugin",
        ];

        foreach ($pluginsToRemove as $plugin) {
            if (isset($config->plugins[$plugin])) {
                unset($config->plugins[$plugin]);
            }
        }
        return $config;
    }

    /**
     * Get the configuration editor
     *
     * @param array $options The options
     * @param array $fpoptions The file picker options
     */
    public function get_config_editor($options = null, $fpoptions = null)
    {
        global $PAGE;
        $context = $PAGE->context;
        $fpoptions = $this->get_filepicker_options($context, file_get_unused_draft_itemid());
        $manager = new manager();
        
        // Ensure that the default configuration is set.
        parent::set_default_configuration($manager);

        if ($fpoptions === null) {
            $fpoptions = [];
        }


        if (isset($options['context']) && ($options['context'] instanceof \context)) {
            // A different context was provided.
            // Use that instead.
            $context = $options['context'];
        }

        // Generate the configuration for this editor.
        $siteconfig = get_config('editor_tiny');
        $config = (object) [
            // The URL to the CSS file for the editor.
            'css' => $PAGE->theme->editor_css_url()->out(false),

            // The current context for this page or editor.
            'context' => $context->id,

            // File picker options.
            'filepicker' => $fpoptions,

            'currentLanguage' => current_language(),

            'branding' => property_exists($siteconfig, 'branding') ? !empty($siteconfig->branding) : true,

            // Language options.
            'language' => [
                'currentlang' => current_language(),
                'installed' => get_string_manager()->get_list_of_translations(true),
                'available' => get_string_manager()->get_list_of_languages()
            ],

            // Placeholder selectors.
            // Some contents (Example: placeholder elements) are only shown in the editor, and not to users. It is unrelated to the
            // real display. We created a list of placeholder selectors, so we can decide to or not to apply rules, styles... to
            // these elements.
            // The default of this list will be empty.
            // Other plugins can register their placeholder elements to placeholderSelectors list by calling
            // editor_tiny/options::registerPlaceholderSelectors.
            'placeholderSelectors' => [],

            // Plugin configuration1.
            'plugins' => $manager->get_plugin_configuration($context, $options, $fpoptions, $this),

            // Nest menu inside parent DOM.
            'nestedmenu' => true,
        ];

        $config = self::remove_unwanted_plugins($config);

        if (defined('BEHAT_SITE_RUNNING') && BEHAT_SITE_RUNNING) {
            // Add sample selectors for Behat test.
            $config->placeholderSelectors = ['.behat-tinymce-placeholder'];
        }

        foreach ($fpoptions as $fp) {
            // Guess the draftitemid for the editor.
            // Note: This is the best we can do at the moment.
            if (!empty($fp->itemid)) {
                $config->draftitemid = $fp->itemid;
                break;
            }
        }

        $configoptions = json_encode(convert_to_array($config));

        $inlinejs = <<<EOF
        window.digitalta_tiny_config = $configoptions;
        EOF;

        $PAGE->requires->js_amd_inline($inlinejs);
    }
}
