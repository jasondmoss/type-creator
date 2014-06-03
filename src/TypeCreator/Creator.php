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
    protected $taxonomyName;

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

    /**
     * @var string
     * @access protected
     */
    private $menuIconName = [];

    /**
     * Post icon array. Defines the icon font.
     *
     * @var array
     * @access private
     *
     * @see http://melchoyce.github.io/dashicons/
     */
    private $nativeIcons = [

        // Default Admin Menu
        'admin-appearance' => ['iconfont' => 'content:"\f100"'],
        'admin-collapse'   => ['iconfont' => 'content:"\f148"'],
        'admin-comments'   => ['iconfont' => 'content:"\f101";margin-top:1px'],
        'admin-dashboard'  => ['iconfont' => 'content:"\f226"'],
        'admin-generic'    => ['iconfont' => 'content:"\f111"'],
        'admin-links'      => ['iconfont' => 'content:"\f103"'],
        'admin-media'      => ['iconfont' => 'content:"\f104"'],
        'admin-page'       => ['iconfont' => 'content:"\f105"'],
        'admin-plugins'    => ['iconfont' => 'content:"\f106"'],
        'admin-post'       => ['iconfont' => 'content:"\f109"'],
        'admin-settings'   => ['iconfont' => 'content:"\f108"'],
        'admin-site'       => ['iconfont' => 'content:"\f112"'],
        'admin-tools'      => ['iconfont' => 'content:"\f107"'],
        'admin-users'      => ['iconfont' => 'content:"\f110"'],
        'gauge'            => ['iconfont' => 'content:"\f226"'],
        'menu'             => ['iconfont' => 'content:"\f333"'],
        'site'             => ['iconfont' => 'content:"\f319"'],

        // Custom Post Types
        'align-center'            => ['iconfont' => 'content:"\f134"'],
        'align-left'              => ['iconfont' => 'content:"\f135"'],
        'align-none'              => ['iconfont' => 'content:"\f138"'],
        'align-right'             => ['iconfont' => 'content:"\f136"'],
        'analytics'               => ['iconfont' => 'content:"\f183"'],
        'arr-alt1-down'           => ['iconfont' => 'content:"\f346"'],
        'arr-alt1-left'           => ['iconfont' => 'content:"\f340"'],
        'arr-alt1-right'          => ['iconfont' => 'content:"\f344"'],
        'arr-alt1-up'             => ['iconfont' => 'content:"\f342"'],
        'arr-alt2-down'           => ['iconfont' => 'content:"\f347"'],
        'arr-alt2-left'           => ['iconfont' => 'content:"\f341"'],
        'arr-alt2-right'          => ['iconfont' => 'content:"\f345"'],
        'arr-alt2-up'             => ['iconfont' => 'content:"\f343"'],
        'arr-down'                => ['iconfont' => 'content:"\f140"'],
        'arr-left'                => ['iconfont' => 'content:"\f141"'],
        'arr-right'               => ['iconfont' => 'content:"\f139"'],
        'arr-up'                  => ['iconfont' => 'content:"\f142"'],
        'arrow-down'              => ['iconfont' => 'content:"\f316"'],
        'arrow-up'                => ['iconfont' => 'content:"\f317"'],
        'awards'                  => ['iconfont' => 'content:"\f313"'],
        'backup'                  => ['iconfont' => 'content:"\f321"'],
        'bargraph'                => ['iconfont' => 'content:"\f185"'],
        'bargraph2'               => ['iconfont' => 'content:"\f238"'],
        'bargraph3'               => ['iconfont' => 'content:"\f239"'],
        'book'                    => ['iconfont' => 'content:"\f330"'],
        'book-alt'                => ['iconfont' => 'content:"\f331"'],
        'businessman'             => ['iconfont' => 'content:"\f338"'],
        'calendar'                => ['iconfont' => 'content:"\f145"'],
        'camera2'                 => ['iconfont' => 'content:"\f306"'],
        'cart'                    => ['iconfont' => 'content:"\f174"'],
        'category'                => ['iconfont' => 'content:"\f318"'],
        'cloud'                   => ['iconfont' => 'content:"\f176"'],
        'designers'               => ['iconfont' => 'content:"\f309"'],
        'developers'              => ['iconfont' => 'content:"\f308"'],
        'download'                => ['iconfont' => 'content:"\f316"'],
        'edit'                    => ['iconfont' => 'content:"\f327"'],
        'editor-aligncenter'      => ['iconfont' => 'content:"\f207"'],
        'editor-alignleft'        => ['iconfont' => 'content:"\f206"'],
        'editor-alignright'       => ['iconfont' => 'content:"\f208"'],
        'editor-bold'             => ['iconfont' => 'content:"\f200"'],
        'editor-customchar'       => ['iconfont' => 'content:"\f220"'],
        'editor-distractionfree'  => ['iconfont' => 'content:"\f211"'],
        'editor-help'             => ['iconfont' => 'content:"\f223"'],
        'editor-indent'           => ['iconfont' => 'content:"\f222"'],
        'editor-insertmore'       => ['iconfont' => 'content:"\f209"'],
        'editor-italic'           => ['iconfont' => 'content:"\f201"'],
        'editor-justify'          => ['iconfont' => 'content:"\f214"'],
        'editor-kitchensink'      => ['iconfont' => 'content:"\f212"'],
        'editor-ol'               => ['iconfont' => 'content:"\f204"'],
        'editor-outdent'          => ['iconfont' => 'content:"\f221"'],
        'editor-plaintext'        => ['iconfont' => 'content:"\f217"'],
        'editor-quote'            => ['iconfont' => 'content:"\f205"'],
        'editor-removeformatting' => ['iconfont' => 'content:"\f218"'],
        'editor-rtl'              => ['iconfont' => 'content:"\f320"'],
        'editor-spellcheck'       => ['iconfont' => 'content:"\f210"'],
        'editor-strikethrough'    => ['iconfont' => 'content:"\f224"'],
        'editor-textcolor'        => ['iconfont' => 'content:"\f215"'],
        'editor-ul'               => ['iconfont' => 'content:"\f203"'],
        'editor-underline'        => ['iconfont' => 'content:"\f213"'],
        'editor-unlink'           => ['iconfont' => 'content:"\f225"'],
        'editor-video'            => ['iconfont' => 'content:"\f219"'],
        'editor-word'             => ['iconfont' => 'content:"\f216"'],
        'exerpt-view'             => ['iconfont' => 'content:"\f164"'],
        'facebook1'               => ['iconfont' => 'content:"\f304"'],
        'facebook2'               => ['iconfont' => 'content:"\f305"'],
        'feedback'                => ['iconfont' => 'content:"\f175"'],
        'flag'                    => ['iconfont' => 'content:"\f227"'],
        'format-aside'            => ['iconfont' => 'content:"\f123"'],
        'format-audio'            => ['iconfont' => 'content:"\f127"'],
        'format-chat'             => ['iconfont' => 'content:"\f125"'],
        'format-gallery'          => ['iconfont' => 'content:"\f161"'],
        'format-image'            => ['iconfont' => 'content:"\f128"'],
        'format-quote'            => ['iconfont' => 'content:"\f122"'],
        'format-status'           => ['iconfont' => 'content:"\f130"'],
        'format-video'            => ['iconfont' => 'content:"\f126"'],
        'forms'                   => ['iconfont' => 'content:"\f314"'],
        'groups'                  => ['iconfont' => 'content:"\f307"'],
        'id'                      => ['iconfont' => 'content:"\f336"'],
        'id-alt'                  => ['iconfont' => 'content:"\f337"'],
        'images-alt1'             => ['iconfont' => 'content:"\f232"'],
        'images-alt2'             => ['iconfont' => 'content:"\f233"'],
        'imgedit-crop'            => ['iconfont' => 'content:"\f165"'],
        'imgedit-fliph'           => ['iconfont' => 'content:"\f169"'],
        'imgedit-flipv'           => ['iconfont' => 'content:"\f168"'],
        'imgedit-redo'            => ['iconfont' => 'content:"\f172"'],
        'imgedit-rleft'           => ['iconfont' => 'content:"\f166"'],
        'imgedit-rright'          => ['iconfont' => 'content:"\f167"'],
        'imgedit-undo'            => ['iconfont' => 'content:"\f171"'],
        'info'                    => ['iconfont' => 'content:"\f348"'],
        'leftright'               => ['iconfont' => 'content:"\f229"'],
        'lightbulb'               => ['iconfont' => 'content:"\f339"'],
        'list-view'               => ['iconfont' => 'content:"\f163"'],
        'location'                => ['iconfont' => 'content:"\f230"'],
        'location-alt'            => ['iconfont' => 'content:"\f231"'],
        'lock'                    => ['iconfont' => 'content:"\f160"'],
        'marker'                  => ['iconfont' => 'content:"\f159"'],
        'migration'               => ['iconfont' => 'content:"\f310"'],
        'network'                 => ['iconfont' => 'content:"\f325"'],
        'no'                      => ['iconfont' => 'content:"\f158"'],
        'no-alt'                  => ['iconfont' => 'content:"\f335"'],
        'performance'             => ['iconfont' => 'content:"\f311"'],
        'piechart'                => ['iconfont' => 'content:"\f184"'],
        'plus-small'              => ['iconfont' => 'content:"\f132"'],
        'portfolio'               => ['iconfont' => 'content:"\f322"'],
        'post-status'             => ['iconfont' => 'content:"\f173"'],
        'pressthis'               => ['iconfont' => 'content:"\f157"'],
        'products'                => ['iconfont' => 'content:"\f312"'],
        'rss'                     => ['iconfont' => 'content:"\f303"'],
        'screenoptions'           => ['iconfont' => 'content:"\f180"'],
        'search'                  => ['iconfont' => 'content:"\f179"'],
        'share'                   => ['iconfont' => 'content:"\f237"'],
        'share2'                  => ['iconfont' => 'content:"\f240"'],
        'share3'                  => ['iconfont' => 'content:"\f242"'],
        'shield'                  => ['iconfont' => 'content:"\f332"'],
        'shield-alt'              => ['iconfont' => 'content:"\f334"'],
        'slides'                  => ['iconfont' => 'content:"\f181"'],
        'smiley'                  => ['iconfont' => 'content:"\f328"'],
        'sort'                    => ['iconfont' => 'content:"\f156"'],
        'star-empty'              => ['iconfont' => 'content:"\f154"'],
        'star-filled'             => ['iconfont' => 'content:"\f155"'],
        'tag'                     => ['iconfont' => 'content:"\f323"'],
        'translation'             => ['iconfont' => 'content:"\f326"'],
        'twitter1'                => ['iconfont' => 'content:"\f301"'],
        'twitter2'                => ['iconfont' => 'content:"\f302"'],
        'update'                  => ['iconfont' => 'content:"\f113"'],
        'vault'                   => ['iconfont' => 'content:"\f178"'],
        'view-site'               => ['iconfont' => 'content:"\f115"'],
        'video-alt1'              => ['iconfont' => 'content:"\f234"'],
        'video-alt2'              => ['iconfont' => 'content:"\f235"'],
        'video-alt3'              => ['iconfont' => 'content:"\f236"'],
        'visibility'              => ['iconfont' => 'content:"\f177"'],
        'wordpress'               => ['iconfont' => 'content:"\f120"'],
        'wordpress-single-ring'   => ['iconfont' => 'content:"\f324"'],
        'xit'                     => ['iconfont' => 'content:"\f153"'],
        'yes'                     => ['iconfont' => 'content:"\f147"']

    ];


    /* ---------------------------------------*/


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

                    print('</select>&#160;');
                }
            }
        }
    }


    /**
     * Used to change the menu icon in the admin dashboard.
     * Pass name of predefined icon or an array of css for custom icon.
     *
     * @param mixed $icon A string of the name of the icon to use or an array of custom css.
     *
     * @return void
     * @access public
     */
    public function defineCustomMenuIcon($icon = 'post')
    {
        // If a string is passed use a predefined icon.
        if (is_string($icon)) {
            if (array_key_exists($icon, $this->nativeIcons)) {

                // Set the posts icon variable.
                $this->menuIconName = $this->nativeIcons[$icon];
            }
        } elseif (is_array($icon)) {

            // If an array of custom css is passed use that.
            $this->menuIconName = $icon;
        }

        add_action('admin_head', [$this, 'setPostIcon']);
    }


    /**
     * Sets the defined post icon.
     *
     * @return void
     * @access public
     */
    public function setPostIcon()
    {
        echo "\n".'<style type="text/css" media="screen">.icon16.icon-'. $this->postTypeName .':before,#adminmenu '
            .'.menu-icon-'. $this->postTypeName .' div.wp-menu-image:before{'. $this->menuIconName['iconfont']
            .'}.icon16.icon-'. $this->postTypeName .',.menu-icon-'. $this->postTypeName
            ." div.wp-menu-image{background-image:none!important;}</style>\n";
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
