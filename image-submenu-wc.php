<!-- MENU CATEGORIAS -->
<div class="row">
    <?php
        wp_nav_menu( array(
            'theme_location'  => 'cat',
            'sort_column'     => 'menu_order',
            'container'       => 'nav',
            'container_class' => 'col-xs-12 col-md-12 menu-container',
            'menu_class' 	  => 'menu-cat-flex',
            'walker'		  => new img_sub()
        ) );
    ?>
</div>

<!-- ARQUIVO functions.php -->

<?php
    class img_sub extends Walker_Nav_Menu {
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
            # code...	
            $cat_id   = $item->object_id;
            $cat_link = get_category_link($cat_id);
            $thumbnail_id = get_woocommerce_term_meta( $cat_id, 'thumbnail_id', true ); // Get Category Thumbnail
            $image = wp_get_attachment_url( $thumbnail_id ); 
            if (array_search('menu-item-has-children', $item->classes)) {
                if ( $image ) {
                    # code...
                    $output .= sprintf( "\n<li data-image='%s' class='has-image %s'><a href='%s'>%s</a>\n",
                        $image,
                        ( $item->classes ) ? implode(' ', $item->classes) : '', 
                        $item->url,
                        $item->title
                    );
                }else {
                    $output .= sprintf( "\n<li class='%s'><a href='not-image %s'>%s</a>\n",
                        ( $item->classes ) ? implode(' ', $item->classes) : '',
                        $item->url,
                        $item->title
                    );
                }
            }else {
                $output .= sprintf("\n<li class='%s'><a href='%s'>%s</a>\n",
                    ( $item->classes ) ? implode(' ', $item->classes): '',
                    $item->url, 
                    $item->title
                );
            }
        }
        //Start Submenu
        function start_lvl(&$output, $depth) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"sub-menu\" role=\"menu\">\n";
        }
    }
?>