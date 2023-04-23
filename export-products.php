<?php 
/*
Plugin Name: Export Products
Description: Export product plugin
Version:1.0
Author: Renos Perdiaris
Text Doamin: export-products
Licence: GPLv2 or later
Domain Path: /languages
*/

if (!defined('ABSPATH')){
	die;
}

function export_admin_menu()
{
	add_menu_page(        
		'Export Products for Woocommerce',        
		'Export Products',        
		'manage_options',        
		'export-products',        
		'export_page',        
		'dashicons-download',        
		'50'
	);

	
}

add_action('admin_menu', 'export_admin_menu');


function export_page()
{ ?>
	<h3><?php esc_html_e(get_admin_page_title()); ?></h3>
	
	


<?php

$params = array( 'post_type' => 'product');
$wc_query = new WP_Query($params);
?>
<?php if ($wc_query->have_posts()) : ?>
<?php while ($wc_query->have_posts()) :
                $wc_query->the_post(); ?>
<div class="no" style="display: none;">                
<?php the_title(); ?><?php echo "test"?> <?php the_id(); ?><br>
</div>

<?php endwhile; ?>
<div class="butt">
    <form method="post">
    <input type="submit" name="products" Value="Get Products" >
</form>
</div>

<div class="button_categories">
    <form method="post">
        <input type="submit" name="category" value="Get Categories">
    </form>
</div>

<?php if(isset($_POST['products']))
{?>
    <?php while ($wc_query->have_posts()) :
                $wc_query->the_post(); ?>
    <?php  the_title();?><br>
    <?php endwhile; ?>
<?php
}?>

<?php if (isset($_POST['category']))
{ ?>
        

        <ul class="product-categories">
    <?php
    $product_categories = get_terms( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
    ) );

    foreach ( $product_categories as $product_category ) {
        $term_link = get_term_link( $product_category );
        echo '<li><a href="' . esc_url( $term_link ) . '">' . $product_category->name . '</a></li>';
    }
    ?>
</ul>
<?php
        $orderby='name';
        $order='desc';
        $cat_args=array(
            'orderby'=>$orderby,
            'order'=>$order
        );

        $categories=get_term('product_cat', $cat_args);

        if(!empty($categories)){
            foreach ($categories as  $key=>$catego) {
                echo $catego->name; 
            }
        };
         ?>
   <?php }?>

<?php endif; 

}?>

