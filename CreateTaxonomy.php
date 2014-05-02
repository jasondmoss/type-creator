<?php

namespace TypeCreator;

/**
 * Taxonomy Creator.
 *
 * @category   Plugin|Class|Type|Creator|Taxonomy
 * @package    WordPress
 * @subpackage Type Creator
 *
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  Jason D. Moss. All Rights Freely Given.
 * @version    0.1.3
 * @license    https://www.gnu.org/copyleft/gpl.html [GPL2+ License]
 * @link       https://github.com/jasondmoss/type-creator
 */


class CreateTaxonomy extends \TypeCreator\Creator
{

    /**
     * Constructor.
     *
     * @param mixed $postType      The name(s) of the post type, accepts (post type name, slug, plural, singular).
     * @param mixed $taxonomyNames The name(s) of the taxonomy.
     * @param array $options       User submitted options.
     *
     * @return void
     * @access public
     */
    public function __construct($postType, $taxonomyNames, $options = array())
    {
        $this->postTypeName = $postType;
        $this->options = $options;

        $names = array(
            'singular',
            'plural',
            'slug'
        );

        if (is_array($taxonomyNames)) {
            $this->taxonomyName = $taxonomyNames['taxonomy_name'];

            // Cycle through possible names.
            foreach ($names as $name) {
                if (isset($taxonomyNames[$name])) {
                    $this->{$name} = $taxonomyNames[$name];
                } else {

                    // Define the method to be used.
                    $method = 'get'.ucfirst($name);
                    $this->{$name} = $method("'{$this->taxonomyName}'");
                }
            }
        } else {
            $this->taxonomyName = $taxonomyNames;

            $this->plural = getPlural($this->postTypeName, $this->taxonomyName);
            $this->singular = getSingular($this->postTypeName, $this->taxonomyName);
            $this->slug = getSlug($this->postTypeName, $this->taxonomyName);
        }

        $this->taxonomies[] = $this->taxonomyName;

        add_action('init', array($this, 'registerTaxonomy'));
        add_filter("manage_edit-{$this->postTypeName}_columns", array($this, 'addAdminColumns'));
        add_action("manage_{$this->postTypeName}_posts_custom_column", array($this, 'populateAdminColumns'), 10, 2);
        add_action('restrict_manage_posts', array($this, 'addTaxonomyFilters'));
    }


    /**
     * Register a taxonomy to a post type.
     *
     * @return void
     * @access public
     *
     * @see http://codex.wordpress.org/Function_Reference/register_taxonomy
     */
    public function registerTaxonomy()
    {
        $ptName = $this->postTypeName;
        $txName = $this->taxonomyName;

        $plural = $this->plural;
        $singular = $this->singular;
        $slug = $this->slug;

        // Default options.
        $defaults = array(
            'labels' => array(
                'name'                       => _(__("{$plural}", TXTDMN)),
                'singular_name'              => _(__("{$singular}", TXTDMN)),
                'menu_name'                  => __("{$plural}", TXTDMN),
                'all_items'                  => __("All {$plural}", TXTDMN),
                'edit_item'                  => __("Edit {$singular}", TXTDMN),
                'view_item'                  => __("View {$singular}", TXTDMN),
                'update_item'                => __("Update {$singular}", TXTDMN),
                'add_new_item'               => __("Add New {$singular}", TXTDMN),
                'new_item_name'              => __("New {$singular} Name", TXTDMN),
                'parent_item'                => __("Parent {$plural}", TXTDMN),
                'parent_item_colon'          => __("Parent {$plural}:", TXTDMN),
                'search_items'               => __("Search {$plural}", TXTDMN),
                'popular_items'              => __("Popular {$plural}", TXTDMN),
                'separate_items_with_commas' => __("Seperate {$plural} with commas", TXTDMN),
                'add_or_remove_items'        => __("Add or remove {$plural}", TXTDMN),
                'choose_from_most_used'      => __("Choose from most used {$plural}", TXTDMN),
                'not_found'                  => __("No {$plural} found", TXTDMN),
            ),
            'public'            => true,
            'show_ui'           => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => false,
            'show_admin_column' => true,
            'hierarchical'      => true,
            'query_var'         => true,
            'rewrite'           => array(
                'slug'         => $slug,
                'with_front'   => true,
                'hierarchical' => true
            ),
            '_builtin'          => false
        );

        // Merge defined custom options with the default options.
        $options = optionsMerge($defaults, $this->options);

        // Register the taxonomy if it does not yet exist.
        if (! taxonomy_exists($txName)) {
            register_taxonomy($txName, $ptName, $options);
        } else {

            // If taxonomy already exists, attach it to the post type.
            register_taxonomy_for_object_type($txName, $ptName);
        }
    }
}

/* <> */
