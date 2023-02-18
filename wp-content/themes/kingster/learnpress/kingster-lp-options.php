<?php

	add_action('after_setup_theme', 'kingster_init_lp_options', 11);
	if( !function_exists('kingster_init_lp_options') ){
		function kingster_init_lp_options(){

			global $kingster_admin_option;

			if( !empty($kingster_admin_option) ){
				$kingster_admin_option->add_element(apply_filters('kingster_color_options',array(
	
					// color head section
					'title' => esc_html__('Learnpress', 'kingster'),
					'slug' => 'kingster_lp',
					'icon' => get_template_directory_uri() . '/include/options/images/color.png',
					'options' => array(

						'general' => array(
							'title' => esc_html__('General Settings', 'kingster'),
							'options' => array(
								'display-single-course-info' => array(
									'title' => esc_html__('Display Single Course Info', 'kingster'),
									'type' => 'checkbox',
									'default' => 'disable'
								),
								'enable-navigation-course-search' => array(
									'title' => esc_html__('Enable Navigation Course Search', 'kingster'),
									'type' => 'checkbox',
									'default' => 'disable',
									'description' => esc_html__('Enable this option to override default navigation search to display only learnpress courses', 'kingster')
								),

								/*
								'navigation-course-search-top-margin' => array(
									'title' => esc_html__('Navigation Course Search Top Margin', 'kingster'),
									'type' => 'text',
									'data-type' => 'pixel',
									'data-input-type' => 'pixel',
									'default' => '-18px',
									'selector' => 'form.kingster-lp-menu-search{ margin-top: #gdlr#; }',
									'condition' => array('enable-navigation-course-search' => 'enable')
								),
								'navigation-course-search-background' => array(
									'title' => esc_html__('Navigation Course Search Background', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#f5f5f5',
									'selector' => 'form.kingster-lp-menu-search input[type="text"]{ background: #gdlr#; }'
								),
								'navigation-course-search-text' => array(
									'title' => esc_html__('Navigation Course Search Text', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#748494',
									'selector' => 'form.kingster-lp-menu-search input[type="text"]{ color: #gdlr#; }' .
										'form.kingster-lp-menu-search input[type="text"]::placeholder{  color: #gdlr#; opacity: 1; }' .
										'form.kingster-lp-menu-search input[type="text"]:-ms-input-placeholder{ color: #gdlr#; }' .
										'form.kingster-lp-menu-search input[type="text"]::-ms-input-placeholder{ color: #gdlr#; }'
								)
								*/
							)
						),

						'course-settings' => array(
							'title' => esc_html__('Course Settings', 'kingster'),
							'options' => array(
								'course-lesson-content-max-width' => array(
									'title' => esc_html__('Course Lesson Content Max Width', 'kingster'),
									'type' => 'text',
									'data-input-type' => 'pixel',
									'data-type' => 'pixel',
									'default' => '900px', 
									'selector' => 'body.kingster-body.course-item-popup #learn-press-content-item .content-item-wrap{ max-width: #gdlr#; }' . 
										'body #popup-course #popup-content #learn-press-content-item .content-item-wrap, body #popup-course #popup-footer{ width: #gdlr#; }'
								),
								'enable-single-course-social-share' => array(
									'title' => esc_html__('Enable Single Course Social Share', 'kingster'),
									'type' => 'checkbox',
									'default' => 'enable'
								),
								'enable-single-course-related' => array(
									'title' => esc_html__('Enable Single Course Related', 'kingster'),
									'type' => 'combobox',
									'options' => array(
										'disable' => esc_html__('Disable', 'kingster'),
										'course_tag' => esc_html__('By Course Tag', 'kingster'),
										'course_category' => esc_html__('By Course Category', 'kingster'),
									),
									'default' => 'course_tag'
								),
								'single-course-related-view-all' => array(
									'title' => esc_html__('Single Course Related View All Url', 'kingster'),
									'type' => 'combobox',
									'options' => array('' => esc_html__('None', 'kingster')) + gdlr_core_get_post_list('page'),
									'condition' => array('enable-single-course-related' => array('course_tag', 'course_category'))
								),
								'single-course-related-num-fetch' => array(
									'title' => esc_html__('Single Course Related Num Fetch', 'kingster'),
									'type' => 'text',
									'default' => '3',
									'condition' => array('enable-single-course-related' => array('course_tag', 'course_category'))
								),
								'single-course-related-column-size' => array(
									'title' => esc_html__('Single Course Related Column Size', 'kingster'),
									'type' => 'combobox',
									'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5 ),
									'default' => '20',
									'condition' => array('enable-single-course-related' => array('course_tag', 'course_category'))
								),
								'single-course-related-thumbnail-size' => array(
									'title' => esc_html__('Single Course Related Thumbnail Size', 'kingster'),
									'type' => 'combobox',
									'options' => 'thumbnail-size',
									'condition' => array('enable-single-course-related' => array('course_tag', 'course_category'))
								),
								'enable-bottom-subscription' => array(
									'title' => esc_html__('Enable Bottom Subscription (Newsletter Plugin)', 'kingster'),
									'type' => 'checkbox',
									'default' => 'disable',
								),
								'bottom-subscription-background' => array(
									'title' => esc_html__('Bottom Subscription Background', 'kingster'),
									'type' => 'upload',
									'data-type' => 'file', 
									'selector' => '.kingster-lp-course-buttom-subscription{ background-image: url(#gdlr#); }',
								),
								'bottom-subscription-text-title' => array(
									'title' => esc_html__('Bottom Subscription Text Title', 'kingster'),
									'type' => 'text'
								),
								'bottom-subscription-text-caption' => array(
									'title' => esc_html__('Bottom Subscription Text Caption', 'kingster'),
									'type' => 'text'
								)
							)
						), // profile-settings

						'profile-settings' => array(
							'title' => esc_html__('Profile Settings', 'kingster'),
							'options' => array(
								'course-list-thumbnail-size' => array(
									'title' => esc_html__('Course List Thumbnail Size', 'kingster'),
									'type' => 'combobox',
									'options' => 'thumbnail-size',
									'default' => 'full'
								)
							)
						), // profile-settings

						'general-color' => array(
							'title' => esc_html__('General Color', 'kingster'),
							'options' => array(

								'theme-color' => array(
									'title' => esc_html__('Theme Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#3495fb',
									'selector' => 'body #learn-press-profile-nav .tabs > li.active > a{ color: #gdlr#; }'.
										'body .lp-tab-sections .section-tab.active span{ border-color: #gdlr#; }' .
										'body .quiz-result.passed .result-achieved, body .quiz-result.passed .result-message strong{ color: #gdlr#; }' .
										'body .quiz-result .result-grade .result-achieved:after{ border-color: #gdlr#; }' .
										'body button, body.kingster-body.confirm #popup_container #popup_panel input[type="button"]{ background-color: #gdlr#; }' .
										'body .lp-list-table thead tr th{ background: #gdlr#; }' .
										'body .learn-press-subtab-content .lp-sub-menu span{ border-color: #gdlr#; }' .
										'body .lp-list-table tbody tr td.column-order-action a, body .lp-list-table tbody tr td.column-order-action a:hover{ color: #gdlr#; }' .
										'body .quiz-progress .progress-items .progress-item .progress-number{ color: #gdlr#; }' .
										'body .course-rate .review-bar .rating{ background: #gdlr#; }' .
										'body .answer-options .answer-option:hover .option-title .option-title-content{ color: #gdlr#; }' .
										'body table.order_details tr th{ background: #gdlr#; }' .
										'body .course-item-nav .prev:hover a.kingster-nav, body .course-item-nav .next:hover a.kingster-nav{ color: #gdlr#; }' .
										'body ul.learn-press-nav-tabs .course-nav.active a{ color: #gdlr#; }' .
										'body .kingster-tab-slidebar .kingster-tab-slidebar-border{ border-color: #gdlr#; }' .
										'body .kingster-tab-slidebar .kingster-tab-slidebar-border:before { border-color: #gdlr# transparent transparent; }' .
										'body .kingster-lp-course-info-item .kingster-tail a,' .
										'body .kingster-lp-course-info-item .kingster-tail a:hover,' .
										'body .kingster-lp-course-info-item .kingster-lp-course-info.kingster-type-wishlist i{ color: #gdlr#; }' . 
										'.kingster-lp-course-left-thumbnail .kingster-lp-course-wishlist i, ' . 
										'.kingster-lp-course-left-thumbnail .kingster-lp-course-info a, ' . 
										'.kingster-lp-course-left-thumbnail .kingster-lp-course-info a:hover,' .
										'.kingster-lp-course-left-thumbnail .kingster-author-content a{ color: #gdlr#; }' . 
										'.kingster-lp-course-grid .kingster-lp-course-info.kingster-type-category a,' .
										'.kingster-lp-course-grid .kingster-lp-course-bottom-info.kingster-type-price,' .
										'.kingster-lp-course-grid .kingster-lp-course-bottom-info.kingster-type-wishlist i{ color: #gdlr#; }' . 
										'body .question-numbers li.current a{ background: #gdlr#; }' . 
										'body .course-curriculum ul.curriculum-sections .section-content .course-item.has-status.passed .course-item-status, ' . 
										'body .course-curriculum ul.curriculum-sections .section-content .course-item.has-status.status-started .course-item-status, ' .
										'.learn-press-form.completed{ color: #gdlr#; }' . 
										'.course-curriculum ul.curriculum-sections .section-content .course-item.current .item-name{ color: #gdlr#; }' . 
										'@media screen and (max-width: 768px) { body #course-item-content-header .toggle-content-item{ background: #gdlr#; color: #fff; } }'  . 
										'body #popup-course #popup-sidebar .course-curriculum .section .section-content .course-item.current .item-name{ color: #gdlr#; }'  .
										'body #popup-course #sidebar-toggle:before{ color: #gdlr#; }' . 
										'body .learn-press-breadcrumb li a, body .learn-press-breadcrumb li a:hover{ color: #gdlr#; }' .
										'#popup-course #popup-sidebar .course-curriculum .section .section-content .course-item .section-item-link:before{ color: #gdlr#; }' .
										'body #learn-press-checkout-form a, body #learn-press-checkout-form a:hover{ color: #gdlr#; }' .
										'body #checkout-payment #checkout-order-action button, body #checkout-payment #checkout-order-action button:hover{ background: #gdlr#; }' .
										'html body #learn-press-profile #profile-nav .lp-profile-nav-tabs li.active > a{ color: #gdlr#; }' .
										'html body #learn-press-profile #profile-nav .lp-profile-nav-tabs li.active > a i:before{ color: #gdlr#; }'  . 
										'html body #learn-press-profile #profile-nav .lp-profile-nav-tabs > li.wishlist.active > a::before{ color: #gdlr#; }'  . 
										'.learn-press-tabs .learn-press-tabs__tab.active label, .learn-press-subtab-content .learn-press-filters > li > span{ border-bottom-color: #gdlr#; }' .
										'body #learn-press-profile-basic-information button, body form[name="profile-change-password"] button,' .
										'body #learn-press-profile-basic-information button:hover, body form[name="profile-change-password"] button:hover{ background: #gdlr#; }' .
										'.lp-list-table tbody tr td.column-order-actions a, .lp-list-table tbody tr td.column-order-actions a:hover{ color: #gdlr#; }' .
										'body .learn-press-form-login button[type="submit"], body .learn-press-form-register button[type="submit"]{ background: #gdlr#; }' . 
										'body #popup-course #popup-content .lp-button, body.learnpress-page .lp-button, body.learnpress-page .lp-button:hover, body.learnpress-page #lp-button, body.learnpress-page #lp-button:hover{ background: #gdlr#; color: #fff; }'  .
										'body .lp-modal-dialog .lp-modal-content .lp-modal-header{ background: #gdlr#; }' . 
										'.quiz-intro .quiz-intro-item::before { color: #gdlr#; }' .
										'body #popup-course #popup-content #learn-press-quiz-app .questions-pagination .nav-links .page-numbers.current, ' .
										'body #popup-course #popup-content #learn-press-quiz-app .questions-pagination .nav-links .page-numbers:hover{ color: #gdlr#; }'  .
										'body .learn-press-profile-course__tab__inner a.active, body .learn-press-course-tab-filters .learn-press-filters a.active{ border-color: #gdlr#; }'  .
										'body .lp-list-table tbody tr td a:hover, body .lp-list-table tbody tr th a:hover,  body .lp-list-table tfoot tr td a:hover, body .lp-list-table tfoot tr th a:hover{ color: #gdlr#; }'
								),
								'sub-button-gray-background-color' => array(
									'title' => esc_html__('Sub Button Background Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#ededed',
									'selector' => 'form[name="profile-avatar"] button#lp-upload-photo, .review-form button.close, body #lp-user-edit-avatar #lp-avatar-actions a{ background: #gdlr#; }'
								),
								'sub-button-gray-text-color' => array(
									'title' => esc_html__('Sub Button Text Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#262626',
									'selector' => 'form[name="profile-avatar"] button#lp-upload-photo, .review-form button.close, body #lp-user-edit-avatar #lp-avatar-actions a{ color: #gdlr#; } '
								),
								'failed-color' => array(
									'title' => esc_html__('Failed Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#f63434',
									'selector' => '.quiz-result.failed .result-achieved, .quiz-result.failed .result-message strong{ color: #gdlr#; }'
								),
								'finish-complete-label-color' => array(
									'title' => esc_html__('Finish/Complete Label Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#eabd53',
									'selector' => 'body .lp-label.label-finished, body .lp-label.label-completed{ background: #gdlr#; color: #fff; }'
								),
								'rating-color' => array(
									'title' => esc_html__('Rating Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#eebc25',
									'selector' => '.review-stars > li span:before, .review-stars > li span.hover:before{ color: #gdlr#; }' . 
										'.review-stars-rated .review-stars.empty, .review-stars-rated .review-stars.filled{ color: #gdlr#; }'
								),
								'popup-background-color' => array(
									'title' => esc_html__('Popup Background Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#f7f7f7',
									'selector' => 'body.confirm #popup_container, .review-form{ background-color: #gdlr#; }'
								),
								'popoup-close-button-color' => array(
									'title' => esc_html__('Popup Close Button Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#a8a8a8',
									'selector' => 'body.confirm #popup_container .close{ color: #gdlr#; } '
								),
								'course-preview-badge-color' => array(
									'title' => esc_html__('Course Preview Badge Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#00adff',
									'selector' => 'body .course-curriculum ul.curriculum-sections .section-content .course-item.item-preview .course-item-status{ background-color: #gdlr#; }'  . 
										'body #learn-press-course-curriculum.course-curriculum ul.curriculum-sections .section-content .course-item.item-preview .course-item-preview{ background-color: #gdlr#; }' . 
										'#popup-course #popup-sidebar .course-curriculum .section .section-content .course-item .section-item-link .course-item-meta .item-meta.course-item-preview:before{ background-color: #gdlr#; }'
								),
								'course-question-badge-color' => array(
									'title' => esc_html__('Course Question Badge Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#d1988b',
									'selector' => 'body .course-curriculum ul.curriculum-sections .section-content .course-item .course-item-meta .count-questions{ color: #gdlr#; }'  . 
									'body #learn-press-course-curriculum.course-curriculum ul.curriculum-sections .section-content .course-item .course-item-meta .count-questions{ color: #gdlr#; }' . 
									'#popup-course #popup-sidebar .course-curriculum .section .section-content .course-item .section-item-link .course-item-meta .item-meta.count-questions{ color: #gdlr#; }'
								),
								'course-question-badge-background' => array(
									'title' => esc_html__('Course Question Badge Background', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#ffe5e0',
									'selector' => 'body .course-curriculum ul.curriculum-sections .section-content .course-item .course-item-meta .count-questions{ background: #gdlr#; }'  . 
									'body #learn-press-course-curriculum.course-curriculum ul.curriculum-sections .section-content .course-item .course-item-meta .count-questions{ background-color: #gdlr#; }' . 
									'#popup-course #popup-sidebar .course-curriculum .section .section-content .course-item .section-item-link .course-item-meta .item-meta.count-questions{ background-color: #gdlr#; }'
								),
								'course-failed-icon-color' => array(
									'title' => esc_html__('Course Failed Icon Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#feb5b6',
									'selector' => 'body .course-curriculum ul.curriculum-sections .section-content .course-item.has-status.status-completed.failed .course-item-status:before{ color: #gdlr#; }'
								),
								'top-bar-user-icon-background' => array(
									'title' => esc_html__('Top Bar User Icon Background', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#2b3f65',
									'selector' => '.kingster-lp-top-bar-user-button{ background-color: #gdlr#; }'
								)
							)
						), // general

						'profile-color' => array(
							'title' => esc_html__('Profile Color', 'kingster'),
							'options' => array(

								'profile-header-color' => array(
									'title' => esc_html__('Profile Header Color Username/Email', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#222',
									'selector' => '#learn-press-profile-header .profile-name{ color: #gdlr#; }'
								),
								'profile-nav-text-color' => array(
									'title' => esc_html__('Profile Nav Text Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#6e6e6e',
									'selector' => 'body #learn-press-profile-nav .tabs > li > a, body #learn-press-profile-nav .tabs > li:hover:not(.active) > a{ color: #gdlr#; }' . 
										'body #learn-press-profile #profile-nav .lp-profile-nav-tabs > li a, body #learn-press-profile #profile-nav .lp-profile-nav-tabs > li a:hover, ' . 
										'body #learn-press-profile #profile-nav .lp-profile-nav-tabs > li > a > i, body #learn-press-profile #profile-nav .lp-profile-nav-tabs > li.wishlist > a::before, ' . 
										'body #learn-press-profile #profile-nav .lp-profile-nav-tabs > li > a:hover > i, body #learn-press-profile #profile-nav .lp-profile-nav-tabs > li.wishlist > a:hover::before{ color: #gdlr#; }'
								),
								'profile-nav-background-color' => array(
									'title' => esc_html__('Profile Nav Background Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#f5f5f5',
									'selector' => 'body #learn-press-profile-nav .tabs > li > a, body #learn-press-profile-nav .tabs > li:hover:not(.active) > a{ background: #gdlr#; }' . 
										'body #learn-press-profile #profile-nav .lp-profile-nav-tabs > li a, body #learn-press-profile #profile-nav .lp-profile-nav-tabs > li a:hover{ background-color: #gdlr#; }'
								),
								'profile-nav-active-background-color' => array(
									'title' => esc_html__('Profile Nav Active Background Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#fbfbfb',
									'selector' => 'body #learn-press-profile-nav .tabs > li.active > a{ background: #gdlr#; }'  . 
										'body #learn-press-profile #profile-nav .lp-profile-nav-tabs > li.active a{ background: #gdlr#; }'
								),
								'profile-logout-color' => array(
									'title' => esc_html__('Profile Logout Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#a4a4a4',
									'selector' => 'body a.kingster-learn-press-profile-nav-logout, body a.kingster-learn-press-profile-nav-logout:hover{ color: #gdlr#; }' .
										'body #learn-press-profile #profile-nav .lp-profile-nav-tabs > li.logout:hover, body #learn-press-profile #profile-nav .lp-profile-nav-tabs > li.logout a, body #learn-press-profile #profile-nav .lp-profile-nav-tabs > li.logout a:hover{ background: transparent; color: #gdlr#; }'
								),
								'profile-tab-text-color' => array(
									'title' => esc_html__('Profile Tab Text Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#696969',
									'selector' => '.lp-tab-sections .section-tab a, .lp-tab-sections .section-tab a:hover, .lp-tab-sections .section-tab span{ color: #gdlr#; }' .
										'.lp-sub-menu li a, .lp-sub-menu li a:hover, .lp-sub-menu li span{ color: #gdlr#; }' .
										'body .learn-press-tabs .learn-press-tabs__tab > label a{ color: #gdlr# !important; }'  . 
										'.learn-press-subtab-content .learn-press-filters > li > span, .learn-press-subtab-content .learn-press-filters > li > a{ color: #gdlr#; }' . 
										'body .learn-press-profile-course__tab__inner a.active, body .learn-press-course-tab-filters .learn-press-filters a.active, body .learn-press-profile-course__tab__inner a, body .learn-press-profile-course__tab__inner a:hover { color: #gdlr#; }'
								),
								'profile-form-label-color' => array(
									'title' => esc_html__('Profile Form Label/Title Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#292929',
									'selector' => '.learn-press-form .form-fields .form-field label{ color: #gdlr#; }' .
										'body.confirm #popup_container #popup_content #popup_message,' .
										'.review-form h3, .review-form .review-fields > li > label{ color: #gdlr#; }' .
										'.lp-list-table tbody tr td.column-course a, .lp-list-table tbody tr td.column-course a:hover{ color: #gdlr#; }' .
										'.lp-list-table tbody tr td.column-order-number, .lp-list-table tbody tr td.column-order-number a, .lp-list-table tbody tr td.column-order-number a:hover{ color: #gdlr#; }' .
										'.lp-list-table tr td.course-name, .lp-list-table tr td.course-name a, .lp-list-table tr td.course-name a:hover{ color: #gdlr#; }' .
										'.checkout-review-order tr td.course-total,' .
										'.checkout-review-order tr.cart-subtotal td,' .
										'.checkout-review-order tr.order-total td{ color: #gdlr#; }' . 
										'.lp-list-table.order-table-details tr td, ' .
										'.lp-list-table.order-table-details tfoot tr:last-child th,' .
										'.lp-list-table.order-table-details tfoot tr td, ' .
										'.lp-list-table.order-table-details tfoot tr th{ color: #gdlr#; }' .
										'body #checkout-order .lp-checkout-order__inner .course-name a, body #checkout-order .lp-checkout-order__inner .course-name a:hover{ color: #gdlr#; }'
								),
								'profile-form-input-color' => array(
									'title' => esc_html__('Profile Form Input/Description/Table Content Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#969696',
									'selector' => '.learn-press-form .form-fields .form-field .description{ color: #gdlr#; }' . 
										'.learn-press-form .form-fields .form-field input[type="text"], ' . 
										'.learn-press-form .form-fields .form-field input[type="email"], ' . 
										'.learn-press-form .form-fields .form-field input[type="number"], ' . 
										'.learn-press-form .form-fields .form-field input[type="password"], ' . 
										'.learn-press-form .form-fields .form-field textarea,' . 
										'.learn-press-form .form-fields .form-field select{ color: #gdlr#; }' . 
										'.review-form .review-fields > li input[type="text"], ' . 
										'.review-form .review-fields > li textarea{ color: #gdlr#; }' . 
										'#learn-press-user-profile .learn-press-form-login a{ color: #gdlr#; border-color: #gdlr#; }' . 
										'.lp-list-table tbody tr td, .lp-list-table tbody tr td a, .lp-list-table tbody tr td a:hover,' . 
										'.lp-list-table tfoot tr th, .lp-list-table tfoot tr th a, .lp-list-table tfoot tr th a:hover{ color: #gdlr#; }' . 
										'.learn-press-checkout-comment textarea{ color: #gdlr#; }' . 
										'form#learn-press-checkout + a{ color: #gdlr#; border-color: #gdlr#; }' . 
										'.learn-press-form .form-fields .form-field .kingster-lp-combobox{ border-color: #gdlr#; }'
								),
								'profile-form-input-border-color' => array(
									'title' => esc_html__('Profile Form Input/Table Border Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#e7e7e7',
									'selector' => 'body .learn-press-form .form-fields .form-field input[type="text"],' .
										'body .learn-press-form .form-fields .form-field input[type="text"]:focus,' .
										'body .learn-press-form .form-fields .form-field input[type="email"], ' .
										'body .learn-press-form .form-fields .form-field input[type="email"]:focus, ' .
										'body .learn-press-form .form-fields .form-field input[type="number"], ' .
										'body .learn-press-form .form-fields .form-field input[type="password"], ' .
										'body .learn-press-form .form-fields .form-field input[type="password"]:focus, ' .
										'body .learn-press-form .form-fields .form-field textarea,' .
										'body .learn-press-form .form-fields .form-field select{ border-color: #gdlr#; border-width: 1px 1px 2px; border-style: solid; outline: none !important; box-shadow: none !important; }' .
										'.review-form .review-fields > li input[type="text"], ' .
										'.review-form .review-fields > li textarea{ border-color: #gdlr#; }' .
										'.lp-list-table th, .lp-list-table td{ border-color: #gdlr#; }' .
										'.learn-press-checkout-comment textarea{ color: #gdlr#; }' . 
										'.lp-list-table.order-table-details{ border-color: #gdlr#; }' .
										'body #learn-press-profile-basic-information .form-field .form-field-input input, body #learn-press-profile-basic-information .form-field .form-field-input input:focus, ' .
										'body #learn-press-profile-basic-information .form-field .form-field-input textarea, body #learn-press-profile-basic-information .form-field .form-field-input textarea:focus{ border-color: #gdlr#; }'
								),
								'profile-table-summary-text-color' => array(
									'title' => esc_html__('Profile Table Summary Text Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#a0a0a0',
									'selector' => '.lp-list-table .list-table-nav td{ color: #gdlr#; }' . 
										'#profile-content-order-details{ color: #gdlr#; }'
								)

							)
						), // profile

						'single-course-color' => array(
							'title' => esc_html__('Single Course Color', 'kingster'),
							'options' => array(

								'course-progress-bar-background-color' => array(
									'title' => esc_html__('Course Progress Bar Background Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#e1e1e1',
									'selector' => '.learn-press-progress .progress-bg{ background: #gdlr#; }' .
										'.course-rate .review-bar{ background: #gdlr#; }'
								),
								'course-progress-bar-filled-background-color' => array(
									'title' => esc_html__('Course Progress Bar Filled Background Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#0082fa',
									'selector' => '.learn-press-course-results-progress .items-progress .lp-course-status .grade.passed, ' .
										'.learn-press-course-results-progress .course-progress .lp-course-status .grade.passed, ' .
										'.learn-press-progress .progress-bg .progress-active{ background: #gdlr#; }'
								),
								'course-price-text-color' => array(
									'title' => esc_html__('Course Price Text Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#222',
									'selector' => '.kingster-lp-course-price-item .course-price .price, .lp-single-course .course-price .price{ color: #gdlr#; }'
								),
								'course-orignal-price-text-color' => array(
									'title' => esc_html__('Course Original Price Text Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#b1b1b1',
									'selector' => '.kingster-lp-course-price-item .origin-price, .lp-single-course .course-price .origin-price{ color: #gdlr#; }'
								),
								'enrolled-background-color' => array(
									'title' => esc_html__('Enrolled/Purchase Button Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#2ed47d',
									'selector' => '.kingster-lp-course-price-item button.lp-button, .kingster-lp-course-price-item button.lp-button:hover, .lp-label.label-enrolled, .lp-label.label-started{ background: #gdlr#; }'	.
										'.wp-core-ui .kingster-lp-course-price-item button, .wp-core-ui .kingster-lp-course-price-item button:hover{ background: #gdlr#; color: #fff; }'
								),
								'course-tab-head-text-color' => array(
									'title' => esc_html__('Course Tab Head Text Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#777',
									'selector' => 'ul.learn-press-nav-tabs .course-nav a, #learn-press-course-tabs .course-nav label{ color: #gdlr#; }'
								),
								'course-rating-summary-background-color' => array(
									'title' => esc_html__('Course Rating Summary Background Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#f7f7f7',
									'selector' => '.kingster-course-rating-summary{ background: #gdlr#; }'
								),
								'course-rating-summary-rating-color' => array(
									'title' => esc_html__('Course Rating Summary Rating Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#454545',
									'selector' => '.kingster-course-rating-summary .kingster-course-rating-summary-amount{ color: #gdlr#; }'
								),
								'course-rating-summary-rating-amount-color' => array(
									'title' => esc_html__('Course Rating Summary Rating Amount Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#696969',
									'selector' => '.kingster-course-rating-summary .kingster-course-rating-summary-number{ color: #gdlr#; }'
								),
								'course-share-text-color' => array(
									'title' => esc_html__('Course Share Text Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#969696',
									'selector' => '.kingster-lp-course-social-share, .kingster-lp-course-social-share .gdlr-core-social-share-wrap a{ color: #gdlr#; }'
								),
								'course-share-hover-color' => array(
									'title' => esc_html__('Course Share Hover Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#00d65c',
									'selector' => '.kingster-lp-course-social-share .gdlr-core-social-share-wrap a:hover{ background-color: #gdlr#; border-color: #gdlr#; }'
								),
								'course-nav-text-color' => array(
									'title' => esc_html__('Course Nav Text Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#222222',
									'selector' => 'body .course-item-nav a.kingster-nav{ color: #gdlr#; }'
								),
								'course-nav-hover-border-color' => array(
									'title' => esc_html__('Course Nav Hover Border Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#c5c5c5',
									'selector' => '.course-item-nav .prev:hover a.kingster-nav, .course-item-nav .next:hover a.kingster-nav{ border-bottom-color: #gdlr#; }'
								),
								'course-nav-title-color' => array(
									'title' => esc_html__('Course Nav Title Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#aeaeae',
									'selector' => 'body .course-item-nav a.kingster-nav-title{ color: #gdlr#; }'
								),
								'checkout-payment-method-background-color' => array(
									'title' => esc_html__('Checkout Payment Method Background Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#f4f4f4',
									'selector' => '#learn-press-payment .payment-methods .lp-payment-method > label{ background: #gdlr#; }'
								),
								'checkout-payment-method-selected-background-color' => array(
									'title' => esc_html__('Checkout Payment Method Selected Background Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#f2f8ff',
									'selector' => '#learn-press-payment .payment-methods .lp-payment-method.selected > label{ background: #gdlr#; }'
								),
								'order-summary-background-color' => array(
									'title' => esc_html__('Order Summary Background Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#f3f3f3',
									'selector' => 'table.order_details tr td{ background: #gdlr#; }'
								),
								'order-summary-text-color' => array(
									'title' => esc_html__('Order Summary Text Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#787878',
									'selector' => 'table.order_details tr td, table.order_details tr td a, table.order_details tr td a:hover{ color: #gdlr#; }'
								),
							)
						), // single-course-color
						

						'single-course-color2' => array(
							'title' => esc_html__('Single Course Color 2', 'kingster'),
							'options' => array(

								'course-curriculum-border-color' => array(
									'title' => esc_html__('Course Curriculum Border Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#e7e7e7',
									'selector' => 'body .course-curriculum ul.curriculum-sections .section-header,' .
										'body .course-curriculum ul.curriculum-sections .section-content .course-item,' .
										'body ul.learn-press-nav-tabs{ border-bottom-color: #gdlr#; }' .
										'body #course-item-content-header .course-item-search,' .
										'body.kingster-body.course-item-popup #learn-press-course-curriculum{ border-right-color: #gdlr#; }'
								),
								'course-curriculum-active-background-color' => array(
									'title' => esc_html__('Course Curriculum Active Background Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#f8faff',
									'selector' => '.course-curriculum ul.curriculum-sections .section-content .course-item.current{ background: #gdlr#; }' .
										'body #popup-course #popup-sidebar .course-curriculum .section .section-content .course-item.current{ background: #gdlr#; }'
								),
								'course-curriculum-title-color' => array(
									'title' => esc_html__('Course Curriculum Title Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#222',
									'selector' => '.course-curriculum ul.curriculum-sections .section-content .course-item .item-name{ color: #gdlr#; }' .
										'body #learn-press-course-curriculum.course-curriculum ul.curriculum-sections .section-content .course-item .item-name,' . 
										'body #learn-press-course-curriculum.course-curriculum ul.curriculum-sections .section-content .course-item .section-item-link:hover .item-name{ color: #gdlr#; }'
								),
								'course-curriculum-lecture-number-color' => array(
									'title' => esc_html__('Course Curriculum Lecture Number/Duration Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#a1a1a1',
									'selector' => '.course-curriculum ul.curriculum-sections .section-content .course-item .item-name .kingster-head{ color: #gdlr#; }' .
										'.course-curriculum ul.curriculum-sections .section-content .course-item .course-item-meta .duration{ background: transparent; color: #gdlr#; }' . 
										'body #learn-press-course-curriculum.course-curriculum ul.curriculum-sections .section-content .course-item .course-item-meta .duration{ background: transparent; color: #gdlr#; }'
								),

								'course-bottom-subscription-background' => array(
									'title' => esc_html__('Course Bottom Subscription Background', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#1c2a44',
									'selector' => '.kingster-lp-course-buttom-subscription{ background-color: #gdlr#; }'
								),
								'course-bottom-subscription-title' => array(
									'title' => esc_html__('Course Bottom Subscription Title', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#ffffff',
									'selector' => '.kingster-lp-course-buttom-subscription .kingster-title{ color: #gdlr#; }'
								),
								'course-bottom-subscription-caption' => array(
									'title' => esc_html__('Course Bottom Subscription Caption', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#ffffff',
									'selector' => '.kingster-lp-course-buttom-subscription .kingster-caption{ color: #gdlr#; }'
								),
								'course-bottom-subscription-input-background' => array(
									'title' => esc_html__('Course Bottom Subscription Input Background', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#2f4773',
									'selector' => '.kingster-lp-course-buttom-subscription input[type="email"]{ background: #gdlr#; }'
								),
								'course-bottom-subscription-input-text' => array(
									'title' => esc_html__('Course Bottom Subscription Input Text', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#c1c1c1',
									'selector' => '.kingster-lp-course-buttom-subscription input[type="email"]{ color: #gdlr#; }' .
										'.kingster-lp-course-buttom-subscription input[type="email"]::placeholder{  color: #gdlr#; opacity: 1; }' .
										'.kingster-lp-course-buttom-subscription input[type="email"]:-ms-input-placeholder{ color: #gdlr#; }' .
										'.kingster-lp-course-buttom-subscription input[type="email"]::-ms-input-placeholder{ color: #gdlr#; }'
								),
								'course-bottom-subscription-button-background' => array(
									'title' => esc_html__('Course Bottom Subscription Button Background', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#2ed47d',
									'selector' => '.kingster-lp-course-buttom-subscription input[type="submit"]{ background: #gdlr#; }'
								),

							)
						), // single-course-color2

						'quiz-color' => array(
							'title' => esc_html__('Quiz Color', 'kingster'),
							'options' => array(

								'quiz-progress-background-color' => array(
									'title' => esc_html__('Quiz Progress Background Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#f5f5f5',
									'selector' => '.quiz-progress{ background: #gdlr#; }'
								),
								'quiz-progress-label-color' => array(
									'title' => esc_html__('Quiz Progress Label Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#696969',
									'selector' => '.quiz-progress .progress-items .progress-item .progress-label{ color: #gdlr#; }'
								),
								'quiz-answer-option-background-color' => array(
									'title' => esc_html__('Quiz Answer Option Background Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#f5f5f5',
									'selector' => '.answer-options .answer-option{ background: #gdlr#; }'
								),
								'quiz-answer-option-background-hover-color' => array(
									'title' => esc_html__('Quiz Answer Option Background Hover Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#ecf5ff',
									'selector' => '.answer-options .answer-option:hover{ background: #gdlr#; }'
								),
								'quiz-answer-option-border-color' => array(
									'title' => esc_html__('Quiz Answer Option Border Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#e6e6e6',
									'selector' => '.answer-options .answer-option input[type="checkbox"]{ border-color: #gdlr#; }'
								),
								'quiz-answer-option-text-color' => array(
									'title' => esc_html__('Quiz Answer Option Text Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#696969',
									'selector' => '.answer-options .answer-option .option-title .option-title-content{ color: #gdlr#; }'
								),
								'quiz-skip-button-background-color' => array(
									'title' => esc_html__('Quiz Skip/Complete Button Background Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#ededed',
									'selector' => 'form.skip-question button, form.complete-quiz button{ background: #gdlr#; }'
								),
								'quiz-skip-button-background-text-color' => array(
									'title' => esc_html__('Quiz Skip/Complete Button Text Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#999',
									'selector' => 'form.skip-question button, form.complete-quiz button{ color: #gdlr#; }'
								)
							)
						), // quiz-color

						'item-color' => array(
							'title' => esc_html__('Item Color', 'kingster'),
							'options' => array(
								'lp-course-item-title-color' => array(
									'title' => esc_html__('Course Item Title Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#545454',
									'selector' => '.kingster-lp-course-title a{ color: #gdlr#; }'
								),
								'lp-course-orignal-price-text-color' => array(
									'title' => esc_html__('Course Item Original Price Text Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#b1b1b1',
									'selector' => '.kingster-lp-course-grid .origin-price, kingster-lp-course-left-thumbnail .origin-price{ color: #gdlr#; }'
								),
								'lp-course-item-title-hover-color' => array(
									'title' => esc_html__('Course Item Title Hover Color', 'kingster'),
									'type' => 'colorpicker',
									'default' => '#545454',
									'selector' => '.kingster-lp-course-title a:hover{ color: #gdlr#; }'
								),
								'lp-course-search-input-background' => array(
									'title' => esc_html__('Course Search Input Background', 'kingster'),
									'type' => 'colorpicker', 
									'default' => '#f2f2f2',
									'selector' => '.kingster-lp-course-search-item input[name="s"], .kingster-lp-course-search-item .kingster-combobox select{ background: #gdlr#; }'
								),
								'lp-course-search-input-text' => array(
									'title' => esc_html__('Course Search Input Text', 'kingster'),
									'type' => 'colorpicker', 
									'default' => '#777',
									'selector' => '.kingster-lp-course-search-item input[name="s"], .kingster-lp-course-search-item .kingster-combobox select{ color: #gdlr#; }'
								),	
								'lp-course-search-input-text-placeholder' => array(
									'title' => esc_html__('Course Search Input Text Placeholder', 'kingster'),
									'type' => 'colorpicker', 
									'default' => '#bbb',
									'selector' => '.kingster-lp-course-search-item input[name="s"]::placeholder{ color: #gdlr#; opacity: 1; }' .
										'.kingster-lp-course-search-item input[name="s"]:-ms-input-placeholder{ color: #gdlr#; }' .
										'.kingster-lp-course-search-item input[name="s"]::-ms-input-placeholder{ color: #gdlr#; }'
								),
								'lp-course-search-submit-background' => array(
									'title' => esc_html__('Course Search Submit Button Background', 'kingster'),
									'type' => 'colorpicker', 
									'default' => '#2ed47d',
									'selector' => '.kingster-lp-course-search-item input[type="submit"]{ background: #gdlr#; }'
								),	
							)
						),

					)
				)), 10);	
			}
		} // kingster_init_lp_options
	} // function_exists