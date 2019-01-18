<?php

/*** Facebook sdk, since version  0.8.8 ***/

function yasr_include_fb_sdk () {

	$lang = get_locale();

	$lang = json_encode("$lang");

	?>

	<div id="fb-root"></div>
	<script>
        (function(d, s, id) {
            var lang = <?php echo ($lang); ?>;
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/"+lang+"/sdk.js#xfbml=1&version=v2.3&appId=113845018658519";
            fjs.parentNode.insertBefore(js, fjs);
        }
        (document, 'script', 'facebook-jssdk'));
	</script>

	<?php

}

function yasr_upgrade_pro_box ($position=FALSE) {

	if ( yasr_fs()->is_free_plan() ) {

		if ( $position && $position == "bottom" ) {
			$yasr_upgrade_class = "yasr-donatedivbottom";
		}

		else {
			$yasr_upgrade_class = "yasr-donatedivdx";
		}

		?>

		<div class="<?php echo $yasr_upgrade_class ?>" style="display: none">

			<h2 style="color: #34A7C1">
				<?php _e( 'Upgrade to YASR Pro', 'yet-another-stars-rating' ); ?>
			</h2>

			<div class="yasr-upgrade-to-pro">
				<ul>
					<li><strong><?php _e( ' User Reviews', 'yet-another-stars-rating' ); ?></strong></li>
					<li><strong><?php _e( ' Custom Rankings', 'yet-another-stars-rating' ); ?></strong></li>
					<li><strong><?php _e( ' 20 + ready to use themes', 'yet-another-stars-rating' ); ?></strong></li>
					<li><strong><?php _e( ' Upload your own theme', 'yet-another-stars-rating' ); ?></strong></li>
					<li><strong><?php _e( ' Dedicate support', 'yet-another-stars-rating' ); ?></strong></li>
				</ul>
				<a href="<?php echo yasr_fs()->get_upgrade_url(); ?>"><button class="button button-primary">Upgrade Now</button></a>

			</div>

		</div>

		<?php

	}

}

/****** Facebook box, since version 0.8.8 ******/

function yasr_fb_box ($position=FALSE) {

	if ($position && $position == "bottom") {
		$yasr_fb_class = "yasr-donatedivbottom";
	}

	else {
		$yasr_fb_class = "yasr-donatedivdx";
	}

	?>

	<div class="<?php echo $yasr_fb_class; ?>" style="display:none">

		<h2><?php _e('Keep in touch!', 'yet-another-stars-rating'); ?></h2>

		<div class="fb-page" data-href="https://www.facebook.com/yetanotherstarsrating" data-hide-cover="false" data-show-facepile="true" data-show-posts="false">
			<div class="fb-xfbml-parse-ignore">
				<blockquote cite="https://www.facebook.com/yetanotherstarsrating"><a href="https://www.facebook.com/yetanotherstarsrating">YASR - Yet Another Stars Rating</a></blockquote>
			</div>
		</div>

	</div>

	<?php

}

/** Add a box on the right for asking to rate 5 stars on Wordpress.org
 *   It must be appear after 10 logged rating, after 100 and after 1000
 *   Since version 0.9.0
 */

function yasr_ask_rating ($position=FALSE) {

	$transient = get_site_transient ('yasr_hide_ask_rating');

	if (!$transient) {

		if ($position && $position == "bottom") {
			$yasr_metabox_class = "yasr-donatedivbottom";
		}

		else {
			$yasr_metabox_class = "yasr-donatedivdx";
		}

		$n_stored_ratings = yasr_count_logged_vote ();

		$div = "<div class=\"$yasr_metabox_class\" id=\"yasr-ask-five-stars\" style=\" display:none; border-left: 3px solid #7AD03A; font-size: 14px;\">";

		if($n_stored_ratings > 20) {

			$text = sprintf( __('Hey, seems like you reached %s votes on your site throught YASR! That\'s cool!', 'yet-another-stars-rating'),'<strong>'.$n_stored_ratings.'</strong>');
			$text .= "<br />";
			$text .= __('Can I ask a favor?', 'yet-another-stars-rating');
			$text .= "<br />";
			$text .= __('Can you please rate YASR 5 stars on', 'yet-another-stars-rating');
			$text .= ' <a href="https://wordpress.org/support/view/plugin-reviews/yet-another-stars-rating?filter=5">wordpress.org?</a>';
			$text .= __(' It will require just 1 min but it\'s a HUGE help for me. Thank you.' , 'yet-another-stars-rating');
			$text .= "<br /><br />";
			$text .= "<em>> Dario Curvino</em>";

			$text .= "<ul>

					<li><a href=\"https://wordpress.org/support/view/plugin-reviews/yet-another-stars-rating?filter=5\">" . __("Ok, I'm glad to help!" , 'yet-another-stars-rating') ."</a></li>
					<li><a href=\"#\" id=\"yasr-ask-five-star-later\">" . __("Remind me later!" , 'yet-another-stars-rating') ."</a></li>
					<li><a href=\"#\" id=\"yasr-ask-five-close\">" . __("Don't need to ask, I already did it!" , 'yet-another-stars-rating') ."</a></li>

			</ul>";


			$div_and_text = $div . $text . '</div>';

			echo $div_and_text;

		}

	} //End if (!transient)


}



/** Change default admin footer on yasr settings pages
 *       $text is the default wordpress text
 *		Since 0.8.9
 */

add_filter( 'admin_footer_text', 'yasr_custom_admin_footer' );

function yasr_custom_admin_footer ($text) {

	if (isset($_GET['page'])) {
		$yasr_page = $_GET[ 'page' ];

		if ($yasr_page == 'yasr_settings_page') {

			$custom_text = ' | <i>';
			$custom_text .= sprintf( __( 'Thank you for using <a href="%s" target="_blank">Yet Another Stars Rating</a>. Please <a href="%s" target="_blank">rate it</a> 5 stars on <a href="%s" target="_blank">WordPress.org</a>', 'yet-another-stars-rating' ),
				'https://yetanotherstarsrating.com',
				'https://wordpress.org/support/view/plugin-reviews/yet-another-stars-rating?filter=5',
				'https://wordpress.org/support/view/plugin-reviews/yet-another-stars-rating?filter=5' );
			$custom_text .= '</i>';

			return $text . $custom_text;

		}

		else {
			return $text;
		}

	}

	else {
		return $text;
	}

}

?>