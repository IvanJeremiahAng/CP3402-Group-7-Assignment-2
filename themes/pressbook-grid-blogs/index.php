<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PressBook_Grid_Blogs
 */

get_header();
?>

	<div class="pb-content-sidebar u-wrapper">
		<main id="primary" class="<?php echo esc_attr( PressBook_Grid_Blogs_Options::blog_site_main_class() ); ?>">

		<?php
		if ( have_posts() ) {
			if ( is_home() && ! is_front_page() ) {
				?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
				<?php
			} elseif ( is_archive() ) {
				?>
				<header>
					<h1 class="page-title screen-reader-text"><?php the_archive_title(); ?></h1>
				</header>
				<?php
			} elseif ( is_search() ) {
				?>
				<header>
					<h1 class="page-title screen-reader-text"><?php /* translators: %s: search query */ printf( esc_html__( 'Search Results for: %s', 'pressbook-grid-blogs' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
				</header>
				<?php
			}

			?>
			<div class="<?php echo esc_attr( PressBook_Grid_Blogs_Options::grid_post_row_class() ); ?>">
			<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content-grid' );
			}
			?>
			</div>
			<?php

			the_posts_pagination();
		} else {
			get_template_part( 'template-parts/content', 'none' );
		}
		?>

		</main><!-- #primary -->

		<?php
		if ( ! have_posts() ) {
			get_sidebar( 'left' );
			get_sidebar();
		}
		?>
	</div><!-- .pb-content-sidebar -->

<?php
get_footer();
