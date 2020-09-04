<?php
/**
 * Template Name: Blog page
 *
 * Description: Blog page template
 *
 * @package WordPress
 * @subpackage Lukani_Theme
 * @since Lukani 1.0
 */
$lukani_opt = get_option( 'lukani_opt' );

get_header();
?>
<div class="main-container default-page">
    <!-- Remove default breadcrumb and title
	<div class="title-breadcrumb">
		<div class="container"> 
			<div class="title-breadcrumb-inner"> 
				<header class="entry-header title-blog">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header> 
				<?php Lukani_Class::lukani_breadcrumb(); ?> 
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	-->
	<div class="container">
		
		<div class="row"> 
			<?php
			$customsidebar = get_post_meta( $post->ID, '_lukani_custom_sidebar', true );
			$customsidebar_pos = get_post_meta( $post->ID, '_lukani_custom_sidebar_pos', true );

			if($customsidebar != ''){
				if($customsidebar_pos == 'left' && is_active_sidebar( $customsidebar ) ) {
					echo '<div id="secondary" class="col-12 col-lg-3">';
						dynamic_sidebar( $customsidebar );
					echo '</div>';
				} 
			} else {
				if( $lukani_opt['sidebarse_pos']=='left'  || !isset($lukani_opt['sidebarse_pos']) ) {
					get_sidebar('page');
				}
			} ?>
			<div class="col-12 <?php if ( $customsidebar!='' || is_active_sidebar( 'sidebar-page' ) ) : ?>col-lg-9<?php endif; ?>">
				<div class="page-content default-page <?php if($customsidebar == '') {echo 'none-sidebar';}?>">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'page' ); ?>
						<?php comments_template( '', true ); ?>
					<?php endwhile; // end of the loop. ?>
					<div class="pagination" style="display: block;">
						<?php
						global $wp_query;

						$published_posts = wp_count_posts()->publish;
						$posts_per_page = get_option('posts_per_page');
						$page_number_max = ceil($published_posts / $posts_per_page);

						$big = 999999999; // need an unlikely integer
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						$wp_query->query('posts_per_page='.$posts_per_page.'&paged='.$paged.'&post_type=post');

						if($page_number_max > 1) {
							echo '<div class="pagination-inner">';
						}
							echo paginate_links( array(
								'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format' => '?paged=%#%',
								'current' => max( 1, $paged ),
								'total' => $page_number_max,
								'prev_text'    => esc_html__('Previous', 'lukani'),
								'next_text'    =>esc_html__('Next', 'lukani'),
							) );
						if($page_number_max > 1) {
							echo '</div>';
						}
						?>
					</div>
				</div>
			</div>
			<?php
			if($customsidebar != ''){
				if($customsidebar_pos == 'right' && is_active_sidebar( $customsidebar ) ) {
					echo '<div id="secondary" class="col-12 col-lg-3">';
						dynamic_sidebar( $customsidebar );
					echo '</div>';
				} 
			} else {
				if( $lukani_opt['sidebarse_pos']=='right' ) {
					get_sidebar('page');
				}
			} ?>
		</div>
	</div>  
</div>
<?php get_footer(); ?>