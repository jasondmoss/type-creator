<?php

namespace TypeCreator;

/**
 * Type Creator Abstract Class.
 *
 * @category   Plugin|Class|Type|Creator|Abstract
 * @package    WordPress
 * @subpackage Type Creator
 *
 * @author     Jason D. Moss <jason@jdmlabs.com>
 * @copyright  Jason D. Moss. All Rights Freely Given.
 * @version    0.1.3
 * @license    https://www.gnu.org/copyleft/gpl.html [GPL2+ License]
 * @link       https://github.com/jasondmoss/type-creator
 */


/**
 * \TypeCreator\Creator
 *
 * @abstract
 */
abstract class Creator
{

    /**
     * @var string
     * @access protected
     */
    protected $postTypeName;

    /**
     * @var string
     * @access protected
     */
    // protected $taxonomyName;

    /**
     * @var string
     * @access protected
     */
    protected $singular;

    /**
     * @var string
     * @access protected
     */
    protected $plural;

    /**
     * @var string
     * @access protected
     */
    protected $slug;

    /**
     * @var array
     * @access protected
     */
    protected $options;

    /**
     * @var array
     * @access protected
     */
    protected $taxonomies;

    /**
     * @var array
     * @access protected
     */
    protected $taxonomyFilters;

    /**
     * @var array
     * @access protected
     */
    protected $columns;

    /**
     * @var array
     * @access protected
    */
    protected $customColumns;

    /**
     * @var array
     * @access protected
     */
    protected $sortable;


    /* ---------------------------------------------------------------------- */


    /**
     * Adds columns to the admin edit screen.
     *
     * @param array $columns
     *
     * @return array
     * @access public
     */
    public function addAdminColumns($columns)
    {
        $this->columns = $columns;
        if (! isset($this->columns)) {

            /**
             * If no user columns have been specified use the following defaults.
             */

            // Default columns.
            $columns = [
                'cb'    => '<input type="checkbox">',
                'title' => __('Title', 'type-creator')
            ];

            // If there are taxonomies registered to the post type.
            if (is_array($this->taxonomies)) {

                // Create a column for each taxonomy.
                foreach ($this->taxonomies as $tax) {
                    $taxObject = get_taxonomy($tax);
                    $columns[$tax] = __($taxObject->labels->name, 'type-creator');
                }
            }

            // If post type supports comments.
            if (post_type_supports($this->postTypeName, 'comments')) {
                $columns['comments'] = '<img alt="'. __('Comments', 'type-creator') .'" src="'
                    .admin_url('/images/comment-grey-bubble.png') .'">';
            }

            $columns['date'] = __('Date', 'type-creator');
        } else {
            $columns = $this->columns;
        }

        return $columns;
    }


    /* ---------------------------------------------------------------------- */


    /**
     * Populates custom columns on the admin edit screen.
     *
     * @param array   $column
     * @param integer $postId
     *
     * @return void
     * @access public
     */
    public function populateAdminColumns($column, $postId)
    {
        global $post;

        switch ($column) {
            case (taxonomy_exists($column)):
                $terms = get_the_terms($postId, $column);
                if (! empty($terms)) {
                    $output = [];

                    foreach ($terms as $term) {
                        $output[] = sprintf(
                            '<a href="%s">%s</a>',
                            esc_url(
                                add_query_arg(
                                    [
                                        'post_type' => $post->post_type,
                                        $column     => $term->slug
                                    ],
                                    'edit.php'
                                )
                            ),
                            esc_html(sanitize_term_field('name', $term->name, $term->term_id, $column, 'display'))
                        );
                    }

                    // Join the terms, separating them with a comma.
                    echo join(', ', $output);
                } else {
                    $taxObject = get_taxonomy($column);
                    _e('No '. $taxObject->labels->name, 'type-creator');
                }
                break;

            case 'post_id':
                echo $post->ID;
                break;

            case (preg_match('/^meta_/', $column) ? true : false):
                $colVal = substr($column, 5);
                $meta = get_post_meta($post->ID, $colVal);
                echo join(', ', $meta);
                break;

            case 'icon':
                $link = esc_url(
                    add_query_arg(
                        [
                            'post'   => $post->ID,
                            'action' => 'edit'
                        ],
                        'post.php'
                    )
                );

                if (has_post_thumbnail()) {
                    echo '<a href="'. $link .'">';
                    the_post_thumbnail([60, 60]);
                    echo '</a>';
                } else {
                    echo '<a href="'. $link .'"><img src="'. site_url('/wp-includes/images/crystal/default.png')
                        .'" alt="'. $post->post_title .'"></a>';
                }
                break;

            default:
                if (isset($this->customColumns) && is_array($this->customColumns)) {
                    if (isset($this->customColumns[$column]) && is_callable($this->customColumns[$column])) {
                        $this->customColumns[$column]($column, $post);
                    }
                }
                break;
        }
    }


    /**
     * User function to choose columns to be displayed on the admin edit screen.
     *
     * @param array $columns An array of columns to be displayed.
     *
     * @return void
     * @access public
     */
    public function columns($columns = [])
    {
        if (isset($columns)) {
            $this->columns = $columns;
        }
    }


    /**
     * User function to define what and how to populate a specific admin column.
     *
     * @param string   $columnName The name of the column to populate.
     * @param function $function   An anonymous function to run when populating the column.
     *
     * @return void
     * @access public
     */
    public function populateColumn($columnName, $function)
    {
        $this->customColumns[$columnName] = $function;
    }


    /**
     * Public function sortable. User function define what columns are sortable in admin edit screen.
     *
     * @param array $columns An array of the columns that are sortable.
     *
     * @return void
     * @access private
     */
    private function sortable($columns = [])
    {
        $this->sortable = $columns;

        // Run filter to make columns sortable.
        add_filter("manage_edit-{$this->postTypeName}_sortable_columns", [$this, 'makeColumnsSortable']);

        // Run action that sorts columns on request.
        add_action('load-edit.php', [$this, 'loadEdit']);
    }


    /**
     * Public function makeColumnsSortable. Internal function that adds any user defined sortable columns to
     * WordPress' default columns.
     *
     * @param array $columns
     *
     * @return array
     * @access public
     */
    public function makeColumnsSortable($columns = [])
    {
        // For each sortable column.
        foreach ($this->sortable as $column => $values) {
            $sortable_columns[$column] = $values[0];
        }

        // Merge sortable columns array into wordpress sortable columns.
        $columns = array_merge($sortable_columns, $columns);

        return $columns;
    }


    /**
     * Public function loadEdit. Only sort columns on the edit.php page when requested.
     *
     * @return void
     * @access public
     */
    public function loadEdit()
    {
        // Run filter to sort columns when requested.
        add_filter('request', [$this, 'sortColumns']);
    }


    /**
     * Public function sort columns. Internal function that sorts columns on request.
     *
     * @param array $vars The query vars submitted by user.
     *
     * @return array
     * @access public
     */
    public function sortColumns($vars = [])
    {
        // Cycle through all sortable columns submitted by the user.
        foreach ($this->sortable as $column => $values) {
            $metaKey = $values[0];

            if (isset($values[1]) && true === $values[1]) {

                // Values needed to be ordered by integer value.
                $orderby = 'meta_value_num';
            } else {

                // Values are to be ordered by string value.
                $orderby = 'meta_value';
            }

            // Check if we're viewing this post type.
            if (isset($vars['post_type']) && $this->postTypeName == $vars['post_type']) {

                // Find the meta key we want to order posts by.
                if (isset($vars['orderby']) && $metaKey == $vars['orderby']) {
                    $vars = array_merge(
                        $vars,
                        [
                            'meta_key' => $metaKey,
                            'orderby'  => $orderby
                        ]
                    );
                }
            }
        }

        return $vars;
    }


    /**
     * Creates select fields for filtering posts by taxonomies on admin edit screen.
     *
     * @return void
     * @access public
     */
    public function addTaxonomyFilters()
    {
        global $typenow, $wp_query;

        // Must set this to the post type you want the filter(s) displayed on.
        if ($typenow == $this->postTypeName) {

            // If custom filters are defined use those.
            if (is_array($this->taxonomyFilters)) {
                $filters = $this->taxonomyFilters;
            } else {
                $filters = $this->taxonomies;
            }

            foreach ($filters as $taxSlug) {
                $tax = get_taxonomy($taxSlug);
                $args = [
                    'orderby'    => 'name',
                    'hide_empty' => false
                ];

                $terms = get_terms($taxSlug, $args);
                if ($terms) {
                    printf(' &nbsp;<select name="%s" class="postform">', $taxSlug);
                    printf('<option value="0">%s</option>', "Show all {$tax->label}");

                    // Foreach term create an option field.
                    foreach ($terms as $term) {

                        // If filtered by this term make it selected.
                        if (isset($_GET[$taxSlug]) && $term->slug === $_GET[$taxSlug]) {
                            printf(
                                '<option value="%s" selected="selected">%s (%s)</option>',
                                $term->slug,
                                $term->name,
                                $term->count
                            );
                        } else {
                            printf('<option value="%s">%s (%s)</option>', $term->slug, $term->name, $term->count);
                        }
                    }

                    print '</select>&#160;';
                }
            }
        }
    }


    /**
     * Merges user submitted options array with default settings, preserving default data if not included in
     * user options.
     *
     * @param array $defaults The default option array.
     * @param array $options  User submitted options to add/override defaults.
     *
     * @return array
     * @access protected
     */
    protected function optionsMerge($defaults, $options)
    {
        $newArray = $defaults;
        foreach ($options as $key => $value) {
            if (isset($defaults[$key])) {
                if (is_array($defaults[$key])) {
                    $newArray[$key] = self::optionsMerge($defaults[$key], $options[$key]);
                } else {
                    $newArray[$key] = $options[$key];
                }
            } else {
                $newArray[$key] = $value;
            }
        }

        return $newArray;
    }
}

/* <> */
