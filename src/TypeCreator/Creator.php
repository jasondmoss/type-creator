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
    private $menuIconName = array();

    /**
     * Post icon array. Defines the icon font.
     *
     * @var array
     * @access private
     *
     * @see http://melchoyce.github.io/dashicons/
     */
    private $nativeIcons = array(

        // Default Admin Menu
        'admin-appearance' => array('iconfont' => 'content:"\f100"'),
        'admin-collapse'   => array('iconfont' => 'content:"\f148"'),
        'admin-comments'   => array('iconfont' => 'content:"\f101";margin-top:1px'),
        'admin-dashboard'  => array('iconfont' => 'content:"\f226"'),
        'admin-generic'    => array('iconfont' => 'content:"\f111"'),
        'admin-links'      => array('iconfont' => 'content:"\f103"'),
        'admin-media'      => array('iconfont' => 'content:"\f104"'),
        'admin-page'       => array('iconfont' => 'content:"\f105"'),
        'admin-plugins'    => array('iconfont' => 'content:"\f106"'),
        'admin-post'       => array('iconfont' => 'content:"\f109"'),
        'admin-settings'   => array('iconfont' => 'content:"\f108"'),
        'admin-site'       => array('iconfont' => 'content:"\f112"'),
        'admin-tools'      => array('iconfont' => 'content:"\f107"'),
        'admin-users'      => array('iconfont' => 'content:"\f110"'),
        'gauge'            => array('iconfont' => 'content:"\f226"'),
        'menu'             => array('iconfont' => 'content:"\f333"'),
        'site'             => array('iconfont' => 'content:"\f319"'),

        // Custom Post Types
        'align-center'            => array('iconfont' => 'content:"\f134"'),
        'align-left'              => array('iconfont' => 'content:"\f135"'),
        'align-none'              => array('iconfont' => 'content:"\f138"'),
        'align-right'             => array('iconfont' => 'content:"\f136"'),
        'analytics'               => array('iconfont' => 'content:"\f183"'),
        'arr-alt1-down'           => array('iconfont' => 'content:"\f346"'),
        'arr-alt1-left'           => array('iconfont' => 'content:"\f340"'),
        'arr-alt1-right'          => array('iconfont' => 'content:"\f344"'),
        'arr-alt1-up'             => array('iconfont' => 'content:"\f342"'),
        'arr-alt2-down'           => array('iconfont' => 'content:"\f347"'),
        'arr-alt2-left'           => array('iconfont' => 'content:"\f341"'),
        'arr-alt2-right'          => array('iconfont' => 'content:"\f345"'),
        'arr-alt2-up'             => array('iconfont' => 'content:"\f343"'),
        'arr-down'                => array('iconfont' => 'content:"\f140"'),
        'arr-left'                => array('iconfont' => 'content:"\f141"'),
        'arr-right'               => array('iconfont' => 'content:"\f139"'),
        'arr-up'                  => array('iconfont' => 'content:"\f142"'),
        'arrow-down'              => array('iconfont' => 'content:"\f316"'),
        'arrow-up'                => array('iconfont' => 'content:"\f317"'),
        'awards'                  => array('iconfont' => 'content:"\f313"'),
        'backup'                  => array('iconfont' => 'content:"\f321"'),
        'bargraph'                => array('iconfont' => 'content:"\f185"'),
        'bargraph2'               => array('iconfont' => 'content:"\f238"'),
        'bargraph3'               => array('iconfont' => 'content:"\f239"'),
        'book'                    => array('iconfont' => 'content:"\f330"'),
        'book-alt'                => array('iconfont' => 'content:"\f331"'),
        'businessman'             => array('iconfont' => 'content:"\f338"'),
        'calendar'                => array('iconfont' => 'content:"\f145"'),
        'camera2'                 => array('iconfont' => 'content:"\f306"'),
        'cart'                    => array('iconfont' => 'content:"\f174"'),
        'category'                => array('iconfont' => 'content:"\f318"'),
        'cloud'                   => array('iconfont' => 'content:"\f176"'),
        'designers'               => array('iconfont' => 'content:"\f309"'),
        'developers'              => array('iconfont' => 'content:"\f308"'),
        'download'                => array('iconfont' => 'content:"\f316";'),
        'edit'                    => array('iconfont' => 'content:"\f327"'),
        'editor-aligncenter'      => array('iconfont' => 'content:"\f207"'),
        'editor-alignleft'        => array('iconfont' => 'content:"\f206"'),
        'editor-alignright'       => array('iconfont' => 'content:"\f208"'),
        'editor-bold'             => array('iconfont' => 'content:"\f200"'),
        'editor-customchar'       => array('iconfont' => 'content:"\f220"'),
        'editor-distractionfree'  => array('iconfont' => 'content:"\f211"'),
        'editor-help'             => array('iconfont' => 'content:"\f223"'),
        'editor-indent'           => array('iconfont' => 'content:"\f222"'),
        'editor-insertmore'       => array('iconfont' => 'content:"\f209"'),
        'editor-italic'           => array('iconfont' => 'content:"\f201"'),
        'editor-justify'          => array('iconfont' => 'content:"\f214"'),
        'editor-kitchensink'      => array('iconfont' => 'content:"\f212"'),
        'editor-ol'               => array('iconfont' => 'content:"\f204"'),
        'editor-outdent'          => array('iconfont' => 'content:"\f221"'),
        'editor-plaintext'        => array('iconfont' => 'content:"\f217"'),
        'editor-quote'            => array('iconfont' => 'content:"\f205"'),
        'editor-removeformatting' => array('iconfont' => 'content:"\f218"'),
        'editor-rtl'              => array('iconfont' => 'content:"\f320"'),
        'editor-spellcheck'       => array('iconfont' => 'content:"\f210"'),
        'editor-strikethrough'    => array('iconfont' => 'content:"\f224"'),
        'editor-textcolor'        => array('iconfont' => 'content:"\f215"'),
        'editor-ul'               => array('iconfont' => 'content:"\f203"'),
        'editor-underline'        => array('iconfont' => 'content:"\f213"'),
        'editor-unlink'           => array('iconfont' => 'content:"\f225"'),
        'editor-video'            => array('iconfont' => 'content:"\f219"'),
        'editor-word'             => array('iconfont' => 'content:"\f216"'),
        'exerpt-view'             => array('iconfont' => 'content:"\f164"'),
        'facebook1'               => array('iconfont' => 'content:"\f304"'),
        'facebook2'               => array('iconfont' => 'content:"\f305"'),
        'feedback'                => array('iconfont' => 'content:"\f175"'),
        'flag'                    => array('iconfont' => 'content:"\f227"'),
        'format-aside'            => array('iconfont' => 'content:"\f123"'),
        'format-audio'            => array('iconfont' => 'content:"\f127"'),
        'format-chat'             => array('iconfont' => 'content:"\f125"'),
        'format-gallery'          => array('iconfont' => 'content:"\f161"'),
        'format-image'            => array('iconfont' => 'content:"\f128"'),
        'format-quote'            => array('iconfont' => 'content:"\f122"'),
        'format-status'           => array('iconfont' => 'content:"\f130"'),
        'format-video'            => array('iconfont' => 'content:"\f126"'),
        'forms'                   => array('iconfont' => 'content:"\f314"'),
        'groups'                  => array('iconfont' => 'content:"\f307"'),
        'id'                      => array('iconfont' => 'content:"\f336"'),
        'id-alt'                  => array('iconfont' => 'content:"\f337"'),
        'images-alt1'             => array('iconfont' => 'content:"\f232"'),
        'images-alt2'             => array('iconfont' => 'content:"\f233"'),
        'imgedit-crop'            => array('iconfont' => 'content:"\f165"'),
        'imgedit-fliph'           => array('iconfont' => 'content:"\f169"'),
        'imgedit-flipv'           => array('iconfont' => 'content:"\f168"'),
        'imgedit-redo'            => array('iconfont' => 'content:"\f172"'),
        'imgedit-rleft'           => array('iconfont' => 'content:"\f166"'),
        'imgedit-rright'          => array('iconfont' => 'content:"\f167"'),
        'imgedit-undo'            => array('iconfont' => 'content:"\f171"'),
        'info'                    => array('iconfont' => 'content:"\f348"'),
        'leftright'               => array('iconfont' => 'content:"\f229"'),
        'lightbulb'               => array('iconfont' => 'content:"\f339"'),
        'list-view'               => array('iconfont' => 'content:"\f163"'),
        'location'                => array('iconfont' => 'content:"\f230"'),
        'location-alt'            => array('iconfont' => 'content:"\f231"'),
        'lock'                    => array('iconfont' => 'content:"\f160"'),
        'marker'                  => array('iconfont' => 'content:"\f159"'),
        'migration'               => array('iconfont' => 'content:"\f310"'),
        'network'                 => array('iconfont' => 'content:"\f325"'),
        'no'                      => array('iconfont' => 'content:"\f158"'),
        'no-alt'                  => array('iconfont' => 'content:"\f335"'),
        'performance'             => array('iconfont' => 'content:"\f311"'),
        'piechart'                => array('iconfont' => 'content:"\f184"'),
        'plus-small'              => array('iconfont' => 'content:"\f132"'),
        'portfolio'               => array('iconfont' => 'content:"\f322"'),
        'post-status'             => array('iconfont' => 'content:"\f173"'),
        'pressthis'               => array('iconfont' => 'content:"\f157"'),
        'products'                => array('iconfont' => 'content:"\f312"'),
        'rss'                     => array('iconfont' => 'content:"\f303"'),
        'screenoptions'           => array('iconfont' => 'content:"\f180"'),
        'search'                  => array('iconfont' => 'content:"\f179"'),
        'share'                   => array('iconfont' => 'content:"\f237"'),
        'share2'                  => array('iconfont' => 'content:"\f240"'),
        'share3'                  => array('iconfont' => 'content:"\f242"'),
        'shield'                  => array('iconfont' => 'content:"\f332"'),
        'shield-alt'              => array('iconfont' => 'content:"\f334"'),
        'slides'                  => array('iconfont' => 'content:"\f181"'),
        'smiley'                  => array('iconfont' => 'content:"\f328"'),
        'sort'                    => array('iconfont' => 'content:"\f156"'),
        'star-empty'              => array('iconfont' => 'content:"\f154"'),
        'star-filled'             => array('iconfont' => 'content:"\f155"'),
        'tag'                     => array('iconfont' => 'content:"\f323"'),
        'translation'             => array('iconfont' => 'content:"\f326"'),
        'twitter1'                => array('iconfont' => 'content:"\f301"'),
        'twitter2'                => array('iconfont' => 'content:"\f302"'),
        'update'                  => array('iconfont' => 'content:"\f113"'),
        'vault'                   => array('iconfont' => 'content:"\f178"'),
        'view-site'               => array('iconfont' => 'content:"\f115"'),
        'video-alt1'              => array('iconfont' => 'content:"\f234"'),
        'video-alt2'              => array('iconfont' => 'content:"\f235"'),
        'video-alt3'              => array('iconfont' => 'content:"\f236"'),
        'visibility'              => array('iconfont' => 'content:"\f177"'),
        'wordpress'               => array('iconfont' => 'content:"\f120"'),
        'wordpress-single-ring'   => array('iconfont' => 'content:"\f324"'),
        'xit'                     => array('iconfont' => 'content:"\f153"'),
        'yes'                     => array('iconfont' => 'content:"\f147"')
    );


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
            $columns = array(
                'cb'    => '<input type="checkbox">',
                'title' => __('Title', TXTDMN)
            );

            // If there are taxonomies registered to the post type.
            if (is_array($this->taxonomies)) {

                // Create a column for each taxonomy.
                foreach ($this->taxonomies as $tax) {
                    $taxObject = get_taxonomy($tax);
                    $columns[$tax] = __($taxObject->labels->name, TXTDMN);
                }
            }

            // If post type supports comments.
            if (post_type_supports($this->postTypeName, 'comments')) {
                $columns['comments'] = '<img alt="'. __('Comments', TXTDMN) .'" src="'
                    .admin_url('/images/comment-grey-bubble.png') .'">';
            }

            $columns['date'] = __('Date', TXTDMN);
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
                    $output = array();

                    foreach ($terms as $term) {
                        $output[] = sprintf(
                            '<a href="%s">%s</a>',
                            esc_url(add_query_arg(
                                array(
                                    'post_type' => $post->post_type,
                                    $column     => $term->slug
                                ),
                                'edit.php'
                            )),
                            esc_html(sanitize_term_field('name', $term->name, $term->term_id, $column, 'display'))
                        );
                    }

                    // Join the terms, separating them with a comma.
                    echo join(', ', $output);
                } else {
                    $taxObject = get_taxonomy($column);
                    _e('No '. $taxObject->labels->name, TXTDMN);
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
                $link = esc_url(add_query_arg(
                    array(
                        'post'   => $post->ID,
                        'action' => 'edit'
                    ),
                    'post.php'
                ));

                if (has_post_thumbnail()) {
                    echo '<a href="'. $link .'">';
                    the_post_thumbnail(array(60, 60));
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
    public function columns($columns = array())
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
    private function sortable($columns = array())
    {
        $this->sortable = $columns;

        // Run filter to make columns sortable.
        add_filter("manage_edit-{$this->postTypeName}_sortable_columns", array($this, 'makeColumnsSortable'));

        // Run action that sorts columns on request.
        add_action('load-edit.php', array($this, 'loadEdit'));
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
    public function makeColumnsSortable($columns = array())
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
        add_filter('request', array($this, 'sortColumns'));
    }


    /**
     * Public function sort columns. Internal function that sorts columns on request.
     *
     * @param array $vars The query vars submitted by user.
     *
     * @return array
     * @access public
     */
    public function sortColumns($vars = array())
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
                        array(
                            'meta_key' => $metaKey,
                            'orderby'  => $orderby
                        )
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
                $args = array(
                    'orderby'    => 'name',
                    'hide_empty' => false
                );

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

        add_action('admin_head', array($this, 'setPostIcon'));
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
}

/* <> */
