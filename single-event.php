<?php get_header(); ?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>



	<header id="site-content" class="event--page__header
		<?php if ( !has_post_thumbnail() ) echo 'event--page__header--short-header'; ?>">

		<div class="event--page__short-info event--page__short-info--short-header">

			<h1 class="event--page__name"><?php the_title(); ?></h1>

			<?php
				$start = new DateTime(get_field('start_datetime'));
				$end = new DateTime(get_field('end_datetime'));

				$start_month = $start->format('F');
				$start_day   = $start->format('jS');

				$end_month = $end->format('F');
				$end_day   = $end->format('jS');

				$start_time = $start->format('H:i');
				$end_time   = $end->format('H:i');

				$year = $start->format('Y');

				$event_duration = $start->diff($end);

				$location_name = get_field('location_name');
			?>
			<div class="event--page__datetime">
				<?php
					echo $start_month . ' ' . $start_day . ', ' . $year;

					if ($event_duration->days === 0) {
						echo ', ' . $start_time;
					}

					echo ' – ';

					if ($start_day != $end_day){
						echo $end_month . ' ' . $end_day;
					} else {
						echo $end_time;
					}
					echo ($location_name) ? ' @ ' . $location_name : '';
				?>
			</div>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="event--page__thumb">
					<?php
					the_post_thumbnail(
						'large',
						array('class' => 'event--page__img')
					);
					?>
				</div>
			<?php endif; ?>

		</div>

	</header>



	<main class="primary-content event--page__content">

		<?php
			$buttons = array();

			$buttons['fb'] = [
				'url' => get_field('facebook_url'),
				'text' => esc_attr_x('Facebook event', 'Facebook event link text', 'svid-theme-domain')
			];

			$buttons['tickets'] = [
				'url' => get_field('ticket_url'),
				'text' => esc_attr_x('Get your tickets', 'Ticket link text', 'svid-theme-domain')
			];

			$start->setTimezone(new DateTimeZone('UTC'));
			$end->setTimezone(new DateTimeZone('UTC'));
			$google_cal_url = "https://www.google.com/calendar/render?action=TEMPLATE&sf=true&output=xml";
			$google_cal_url .= "&text=" . urlencode(get_the_title());
			$google_cal_url .= "&dates=" . $start->format('Ymd\THis\Z') .
				"/" . $end->format('Ymd\THis\Z');
			$google_cal_url .= "&location=" . urlencode($location_name);
			$google_cal_url .= "&details=" . urlencode(get_the_excerpt());

			$buttons['add-to-google'] = [
				'url' => $google_cal_url,
				'text' => esc_attr_x('Add to Google Calendar', 'Google Calendar link', 'svid-theme-domain')
			];

			foreach ($buttons as $key => $butt) {
				$url = $butt['url'];
				$text = $butt['text'];
				$class = 'button--' . $key;
				if ($url !== '' && $url !== null && $url)
					echo "<a href='$url' class='button $class'>$text</a>";
			}
		?>

		<?php the_content(); ?>

		<?php include('inc/lassie-event.php'); ?>

		<?php
		// Files
		// Check if there are files
		if ( have_rows('file_list') ):
		// Check if user is logged in; if not, tell them to log in
		if ( !is_user_logged_in() ): ?>

		</main>

		<section class="event__files event__files--unauth">
			<h2 class="event__section-title"><?php echo esc_attr_x('Files', 'title above file list', 'svid-theme-domain'); ?></h2>
			<h3><?php echo esc_attr_x('To see the files, you have to log in.', 'only show files when logged in on event page', 'svid-theme-domain'); ?></h3>
			<a href="<?php echo wp_login_url( get_permalink() ); ?>" class="button">
				Login
			</a>
		</section>

		<?php else: ?>

		</main>

		<section class="event__files">
			<h2 class="event__section-title">
				<?php echo esc_attr_x('Files', 'title above file list', 'svid-theme-domain'); ?>
			</h2>
			<?php
				// loop through the files
				while ( have_rows('file_list') ) :
					the_row();
					$file = get_sub_field('file');
					if ( get_sub_field('file_name') !== '' ) {
						$file_name = get_sub_field('file_name');
					} else {
						$file_name = $file['name'];
					} ?>
					<a class="event__file" target="_blank"
						href="/download/?id=<?=$file['id']?>">
						<h3 class="event__file-name">
							<i class="fas fa-file-alt"></i>
							<?=$file_name?>
						</h3>
					</a>
				<?php endwhile;?>

			</section>

		<?php endif; else: ?>
			</main>
		<?php endif; ?>



<?php endwhile; endif; ?>

<?php get_footer(); ?>
