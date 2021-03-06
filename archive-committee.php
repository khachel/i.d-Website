<?php get_header(); ?>

<main id="site-content">

	<h1 class="archive__title">
		<?php echo esc_attr_x('Our committees', 'archive title', 'svid-theme-domain'); ?>
	</h1>

	<div class="filters">
		<div class="filters__label">
			<?php echo esc_attr_x('Filter by group:', 'Filter by group committee label', 'svid-theme-domain');?>
			<span class="filters__master-switch" data-for="comm-group"><?php echo esc_attr_x('[none]', 'select no committee groups label', 'svid-theme-domain');?></span>
		</div>
		<div class="filters__group" id="comm-group"
			data-for="comm-group--" data-multiple="true">
			<?php
				$group_options = get_terms('committee-group');
				foreach ($group_options as $key => $group_opt):
			?>
			<label class="filters__tag committees__tag--<?=$group_opt->slug?>"
				for="<?=$group_opt->slug?>">
				<input type="checkbox" name="committee-group" checked
					value="<?=$group_opt->slug?>" id="<?=$group_opt->slug?>"
					><?=$group_opt->name?>
			</label>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="committees__grid">

	<?php
		if(have_posts()) : while(have_posts()) :
			the_post();
			$groups = get_the_terms($post, 'committee-group');
			$group_class = '';
			$group_class_styling = 'comm-group';
			$group_count = -1;
			if ($groups) {
				$group_count = count($groups);
				foreach ($groups as $group) {
					$group_class .= $group->slug . ' ';
					$group_class_styling .= ' comm-group--' . $group->slug;
				}
			}
			include 'inc/small-committee.php';
		endwhile; endif;

		wp_reset_postdata();
	?>

	</div>

</main>

<?php get_footer(); ?>
