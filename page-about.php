<?php

/**
 * Template Name: about page
 */

get_header(); ?>



<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
<?php
	$morestring = '<!--more-->';
	$explode_content = explode( $morestring, $post->post_content );
	$content_before = apply_filters( 'get_the_content', $explode_content[0] );
	$content_after = apply_filters( 'the_content', $explode_content[1] );
?>
<main id="site-content" class="page-top">

	<h1 class="page-top__title"><?php the_title(); ?></h1>
	<p class="page-top__descr"><?php echo $content_before; ?></p>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="page-top__thumb">
			<?php the_post_thumbnail('post-thumbnail',
				array( 'class' => 'page-top__img')
			); ?>
		</div>
	<?php endif; ?>
</main>

<section class="about__descr-rest">
	<?php echo $content_after; ?>
</section>

<p class="about__jump">
	Jump to our:
	<a class="about__jump-link" href="#board"><?php echo esc_attr_x('board', 'Current board link', 'svid-theme-domain'); ?></a> –
	<a class="about__jump-link" href="#committees"><?php echo esc_attr_x('committees', 'Our committees link', 'svid-theme-domain'); ?></a> –
	<a class="about__jump-link" href="#master_communities"><?php echo esc_attr_x('master communities', 'Our master communities link', 'svid-theme-domain'); ?></a> –
	<a class="about__jump-link" href="#distinguished_members"><?php echo esc_attr_x('distinguished members', 'Our honorary members link', 'svid-theme-domain'); ?></a>
</p>

<?php endwhile; endif; ?>



<section class="board" id="board">

	<?php
		wp_reset_postdata();
		$args = array( 'post_type' => 'board', 'posts_per_page' => 1 );
		$loop = new WP_Query( $args );
    if($loop->have_posts()) : while($loop->have_posts()) :
			$loop->the_post();?>

		<p class="board__indication">
			<?php echo esc_attr_x('The current board', 'Current board title', 'svid-theme-domain'); ?>
		</p>
		<h2 class="about__sub-title">
			<?php the_title(); ?>
		</h2>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="board__thumb">
				<?php the_post_thumbnail('post-thumbnail',
					array( 'class' => 'board__img')
				); ?>
			</div>
		<?php endif; ?>

		<div class="board__description">
			<?php the_content(); ?>
		</div>

	<?php
		endwhile; endif;
		wp_reset_postdata();
	?>

	<a class="button committees__all"
		href="<?php echo get_post_type_archive_link( 'board' ); ?>">
		<?php echo esc_attr_x('View previous boards', 'View previous boards button text', 'svid-theme-domain'); ?>
	</a>

</section>



<hr class="divider">



<section class="committees" id="committees">

	<h2 class="about__sub-title"><?php echo esc_attr_x('Some of our committees', 'Our committees title', 'svid-theme-domain'); ?></h2>

	<div class="committees__grid">
	<?php
		wp_reset_postdata();

		// Get groups/types of committees
		$groups = get_terms( array(
    	'taxonomy' => 'committee-group',
    	'hide_empty' => true,
		) );

		// Cycle through those types and spawn
		foreach ($groups as $key => $group) {
			$args = array(
				'post_type' => 'committee',
				'posts_per_page' => 1,
				'tax_query' => array(
        	array(
            'taxonomy' => 'committee-group',
            'field' => 'slug',
            'terms' => array($group->slug)
        	)
    		)
			);

			$group_class = $group->slug;
			$group_class_styling = 'comm-group comm-group--' . $group->slug;
			$group_name = $group->name;

			$loop = new WP_Query( $args );
	    if($loop->have_posts()) :
				while($loop->have_posts()) :
					$loop->the_post();
					include 'inc/small-committee.php';
				endwhile;
			endif;
			wp_reset_postdata();
		} ?>

	</div>

	<a class="button committees__all"
		href="<?php echo get_post_type_archive_link( 'committee' ); ?>">
		<?php echo esc_attr_x('View all committees', 'View all committees button text', 'svid-theme-domain'); ?>
	</a>

</section>



<hr class="divider">



<section class="master-coms" id="master_communities">
	<h2 class="about__sub-title"><?php echo esc_attr_x('Our master communities', 'Our master communities title', 'svid-theme-domain'); ?></h2>
	<div class="master-coms__list">
		<?php
			$args = array(
		    'post_type'      => 'page',
		    'posts_per_page' => -1,
		    'post_parent'    => get_the_ID(),
		    'order'          => 'ASC',
				'orderby'        => 'menu_order'
			);
			$parent = new WP_Query( $args );
			if ( $parent->have_posts() ) :
				while ( $parent->have_posts() ) :
					$parent->the_post(); ?>

					<article class="master-com">
						<a class="master-com__link"
							href="<?php the_permalink(); ?>">
						<?php
							the_post_thumbnail('medium',
								array( 'class' => 'master-com__thumb')
							);
						?>
							<h3>
									<?php the_title(); ?>
							</h3>
						</a>
					</article>

				<?php
				endwhile;
			endif;
			wp_reset_query();
		?>
	</div>
</section>



<?php
	$args = array( 'post_type' => 'honorary_member' );
	$loop = new WP_Query( $args );
	if($loop->have_posts()) : ?>

	<hr class="divider">

	<section class="hon-mems" id="distinguished_members">

		<h2 class="about__sub-title">
			<?php echo esc_attr_x('Our distinguished members', 'Honorary members title about page', 'svid-theme-domain'); ?>
		</h2>

		<div class="hon-mems__explanation">
			<p><?php echo esc_attr_x('ID thanks industrial designers with important contributions to the professional domain and the study association by making them Honorary Members. People who are not neccessarily active as industrial designers but did—or sometimes still do—contribute a lot to the study association, become Members of Merit.', 'Distinguished members explanation', 'svid-theme-domain'); ?></p>
		</div>

		<div class="hon-mems__list">
			<?php while($loop->have_posts()) : $loop->the_post();?>

			<article class="hon-mem">
				<a href="<?php the_permalink(); ?>" class="hon-mem__link">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="hon-mem__avatar">
							<?php the_post_thumbnail('medium'); ?>
						</div>
					<?php endif; ?>
					<h3 class="hon-mem__name">
							<?php the_title(); ?>
					</h3>
				</a>
				<p class="hon-mem__type"><?php print_r(get_the_category()[0]->name); ?></p>
			</article>

			<?php endwhile; ?>
		</div>

	</section>
<?php endif; wp_reset_postdata(); ?>



<?php get_footer(); ?>
