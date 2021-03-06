<?php
	if(function_exists("register_field_group"))
	{
		register_field_group(array (
			'id' => 'acf_vacancy-post-type',
			'title' => 'Vacancy post type',
			'fields' => array (
				array (
					'key' => 'field_58b581aba3f51',
					'label' => 'Start date',
					'name' => 'dates_%_start_date',
					'type' => 'date_picker',
					'instructions' => 'Set date to start promotion of vacancy on front page',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'd/m/Y',
					'return_format' => 'd/m/Y',
					'first_day' => 1,
				),
				array (
					'key' => 'field_58b581e8a3f52',
					'label' => 'End date',
					'name' => 'dates_%_end_date',
					'type' => 'date_picker',
					'instructions' => 'Set date to end promotion of vacancy on front page',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'd/m/Y',
					'return_format' => 'd/m/Y',
					'first_day' => 1,
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'vacancy',
						'order_no' => 0,
						'group_no' => 0,
					),
				),
			),
			'options' => array (
				'position' => 'side',
				'layout' => 'no_box',
				'hide_on_screen' => array (
				),
			),
			'menu_order' => 0,
			'position' => 'side',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));

		register_field_group(array (
		'id' => 'acf_vacancy',
		'title' => 'Vacancy',
		'fields' => array (
			array (
				'key' => 'field_58d0e4e2ece31',
				'label' => 'Vacancy attachment',
				'name' => 'vacancy_attachment',
				'type' => 'file',
				'instructions' => 'Include a pdf or description for the vacancy',
				'save_format' => 'object',
				'library' => 'all',
			),
			array (
				'key' => 'field_58ff63b7b0fd9',
				'label' => 'Apply directly',
				'name' => 'apply_directly',
				'type' => 'text',
				'instructions' => 'Enter an url if people can apply through that directly, e.g.

	https://jobs.coolcompany.com/apply
	mailto:apply@coolcompany.com',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_58fb756ca23dc',
				'label' => 'Company',
				'name' => 'company',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_58fb7c869c3ed',
				'label' => 'Location',
				'name' => 'location',
				'type' => 'text',
				'instructions' => 'The city/country/etc. where the job is located – only shows when filled out.',
				'default_value' => '',
				'placeholder' => 'Anywhere',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5e80feb2cd51b',
				'label' => 'Duration',
				'name' => 'duration',
				'type' => 'text',
				'instructions' => 'The duration of the internship (or job) – only shows when filled out.',
				'required' => 0,
				'conditional_logic' => 0,
				'default_value' => '',
				'placeholder' => '6 months',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'vacancy',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
		'position' => 'side',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
		));
	}
?>
