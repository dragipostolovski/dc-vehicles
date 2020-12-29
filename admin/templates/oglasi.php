<?php

get_header();

if(isset($_GET['location']) && $_GET['location'] != '') {
	$args = [
		'post_type' => 'vehicle',
		'tax_query' => array(
			array (
				'taxonomy' => 'locations',
				'field' => 'slug',
				'terms' => $_GET['location'],
			)
		),
	];
} else {
	$args = ['post_type' => 'vehicle'];
}

$vehicles = new WP_Query($args);
$terms = get_terms( array(
	'taxonomy' => 'locations',
	'hide_empty' => false,
) );

if ( $vehicles->have_posts() ) { ?>
	<div class="default-max-width">
		<select id="tax-locations">
			<option value=""></option>
			<?php foreach($terms as $term) { ?>
				<option <?= $_GET['location'] == $term->name ? 'selected' : ''; ?> value="<?=  $term->name ?>"><?=  $term->name ?></option>
			<?php } ?>
		</select>
	</div>

	<?php // Load posts loop.
	while ( $vehicles->have_posts() ) {
		$vehicles->the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header>
				<a href="<?php the_permalink(); ?>"><?php the_title( '<h1 class="entry-title default-max-width">', '</h1>' ); ?></a>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
		</article><!-- #post-<?php the_ID(); ?> -->


	<?php }

	// Previous/next page navigation.
	twenty_twenty_one_the_posts_navigation();

} else {

	// If no content, include the "No posts found" template.
	get_template_part( 'template-parts/content/content-none' );

}

get_footer();