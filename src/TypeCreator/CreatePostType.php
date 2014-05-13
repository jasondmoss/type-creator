<?php

namespace TypeCreator;

/**
 * Post Type Creator.
 *
 * @category   Plugin|Class|Type|Creator|PostType
 * @package    WordPress
 * @subpackage Type Creator
 *
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  Jason D. Moss. All Rights Freely Given.
 * @version    0.1.3
 * @license    https://www.gnu.org/copyleft/gpl.html [GPL2+ License]
 * @link       https://github.com/jasondmoss/type-creator
 */


use \TypeCreator\Creator;

/**
 * \TypeCreator\CreatePostType
 *
 */
class CreatePostType extends Creator
{

    /**
     * Constructor.
     *
     * @param mixed $typeNames The name(s) of the post type, accepts (post type name, slug, plural, singular).
     * @param array $options   User submitted options.
     *
     * @return void
     * @access public
     */
    public function __construct($typeNames, $options = array())
    {
        $this->options = $options;

        if (is_array($typeNames)) {
            $names = array(
                'singular',
                'plural',
                'slug'
            );

            $this->postTypeName = $typeNames['post_type_name'];

            // Cycle through possible names.
            foreach ($names as $name) {
                if (isset($typeNames[$name])) {
                    $this->{$name} = $typeNames[$name];
                } else {

                    // Define the method to be used.
                    $method = 'get'. ucfirst($name);
                    $this->{$name} = $method("'{$this->postTypeName}'");
                }
            }
        } else {
            $this->postTypeName = $typeNames;
            $this->plural = getPlural($this->postTypeName);
            $this->singular = getSingular($this->postTypeName);
            $this->slug = getSlug($this->postTypeName);
        }

        // Register the post type.
        add_action('init', array($this, 'registerPostType'));
    }


    /* ---------------------------------------*/


    /**
     * Register_post_type function. Object function to register the post type.
     *
     * @return void
     * @access public
     *
     * @see http://codex.wordpress.org/Function_Reference/register_post_type
     */
    public function registerPostType()
    {
        $plural = $this->plural;
        $singular = $this->singular;
        $slug = $this->slug;

        $labels = array(
            'name'               => __("{$plural}", TXTDMN),
            'singular_name'      => __("{$singular}", TXTDMN),
            'menu_name'          => __("{$plural}", TXTDMN),
            'all_items'          => __("{$plural}", TXTDMN),
            'add_new'            => __('Add New', TXTDMN),
            'add_new_item'       => __("Add New {$singular}", TXTDMN),
            'edit_item'          => __("Edit {$singular}", TXTDMN),
            'new_item'           => __("New {$singular}", TXTDMN),
            'view_item'          => __("View {$singular}", TXTDMN),
            'search_items'       => __("Search {$plural}", TXTDMN),
            'not_found'          => __("No {$plural} found", TXTDMN),
            'not_found_in_trash' => __("No {$plural} found in Trash", TXTDMN),
            'parent_item_colon'  => __("Parent {$singular}:", TXTDMN)
        );

        // default options
        $defaults = array(
            'label'               => __("{$plural}", TXTDMN),
            'labels'              => $labels,
            'public'              => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_nav_menus'   => true,
            'show_in_menu'        => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'menu_icon'           => 'post',
            //'capability_type'     => 'post',
            'hierarchical'        => false,
            'supports'            => array(
                // 'author',
                // 'editor',
                // 'thumbnail',
                // 'title'
            ),
            'has_archive' => true,
            'rewrite'     => array(
                'slug'       => $slug,
                'with_front' => true,
                'feeds'      => true,
                'pages'      => true
            ),
            'query_var'  => $this->postTypeName,
            'can_export' => true
        );

        $options = optionsMerge($defaults, $this->options);
        $this->options = $options;

        // Check that the post type doesn't already exist.
        if (! post_type_exists($this->postTypeName)) {
            register_post_type($this->postTypeName, $options);
        }
    }
}

/* <> */