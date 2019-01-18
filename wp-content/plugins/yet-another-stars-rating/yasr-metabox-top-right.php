<?php

/*

Copyright 2014 Dario Curvino (email : d.curvino@tiscali.it)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>
*/

    if ( ! defined( 'ABSPATH' ) ) exit('You\'re not allowed to see this page'); // Exit if accessed directly

    $post_id=get_the_ID();

	$overall_rating=yasr_get_overall_rating($post_id);

	if (!$overall_rating) {
		$overall_rating = "0";
	}

    //This is for the select
    if($overall_rating != '-1') {

        $overall_rating_array = explode(".", $overall_rating);
        $int = $overall_rating_array[0];

        if($int < 5 && array_key_exists(1, $overall_rating_array) == TRUE) {
            $dec = $overall_rating_array[1];
        }

        else {

            $dec = 0;

        }

    }

    else {
        $int = 0;
        $dec = 0;
    }

    $ajax_nonce_overall = wp_create_nonce( "yasr_nonce_insert_overall_rating" );

    $ajax_nonce_review_type = wp_create_nonce( "yasr_nonce_review_type" );

?>


<div id="yasr-matabox-top-right">

    <?php

        if (YASR_METABOX_OVERALL_RATING != 'numbers') {

            ?>

            <div id="yasr-vote-overall-stars-container">

                <div id="yasr-vote-overall-stars">

                    <span id="yasr-rateit-vote-overall-text">
                        <?php _e("Rate this article / item", 'yet-another-stars-rating'); ?>
                    </span>

                    <div id="yasr-rater-overall" >
                    </div>

                    <div id="loader-overall-rating" style="display:none;" >&nbsp;<?php _e("Loading, please wait",'yet-another-stars-rating'); ?><img src="<?php echo YASR_IMG_DIR . "/loader.gif" ?>">
                    </div>

                    </p>

                    <div>

                        <span id="yasr_rateit_overall_value"></span>

                    </div>

                </div>

            </div> <!--End stars container-->

            <?php

        } //End if (YASR_METABOX_OVERALL_RATING == 'stars') {

        else {

            ?>

            <div id="yasr-vote-with-numbers-container">

                <div id="yasr-vote-with-numbers" >

                    <span id="yasr-rateit-vote-overall-text">
                        <?php _e("Rate this article / item", 'yet-another-stars-rating'); ?>
                    </span>

                    <div id="yasr-vote-with-numbers-select-container">

                        <select name="yasr-vote-overall-numbers-int" id="yasr-vote-overall-numbers-int" class="yasr-vote-overall-numbers">

                            <?php

                            for ($i=0; $i<=5; $i++) {

                                if ($i == $int) {
                                    echo "<option value=\"$i\" selected=\"selected\">$i</option>\n";
                                }

                                else {
                                    echo "<option value=\"$i\">$i</option>\n";
                                }
                            }

                            ?>

                        </select>

                        <span id="yasr-comma-between-select">,</span>

                            <select name="yasr-vote-overall-numbers-dec" id="yasr-vote-overall-numbers-dec" class="yasr-vote-overall-numbers">

                                <?php

                                for ($i=0; $i<=9; $i++) {
                                    if ($i == $dec) {
                                        echo "<option value=\"$i\" selected=\"selected\">$i</option>\n";
                                    }

                                    else {
                                        echo "<option value=\"$i\">$i</option>\n";
                                    }
                                }

                                ?>

                            </select>

                    </div>

                    <p>

                    <button href="#" class="button-secondary" id="yasr-send-overall-numbers"><?php _e('Save Vote', 'yet-another-stars-rating'); ?></button>

                    <p>

                    <span id="yasr-overall-numbers-saved-confirm"></span>

                </div>

            </div> <!--End numbers container-->

            <?php

        } //End if YASR_METABOX_OVERALL_RATING == 'numbers'

    ?>

    <hr>

    <?php

        if (YASR_AUTO_INSERT_ENABLED == 1) {

        $is_this_post_exluded = get_post_meta($post_id, 'yasr_auto_insert_disabled', TRUE);

        ?>

        <div id="yasr-toprightmetabox-disable-auto-insert">

            <?php _e('Disable auto insert for this post or page?', 'yet-another-stars-rating'); ?>

                <br />

                <div class="yasr-onoffswitch-big" id="yasr-switcher-disable-auto-insert">
                    <input type="checkbox" name="yasr_auto_insert_disabled" class="yasr-onoffswitch-checkbox" value="yes" id="yasr-auto-insert-disabled-switch" <?php if ($is_this_post_exluded === 'yes') echo " checked='checked' "; ?> >
                    <label class="yasr-onoffswitch-label" for="yasr-auto-insert-disabled-switch">
                        <span class="yasr-onoffswitch-inner"></span>
                        <span class="yasr-onoffswitch-switch"></span>
                    </label>
                </div>


        </div>

        <hr>

        <?php

    } //End if auto insert enabled

    ?>

    <div class="yasr-choose-reviews-types"><?php _e("This review is about a...", "yet-another-stars-rating"); ?>
        <br />

        <?php yasr_select_itemtype(); ?>

        <button href="#" class="button-secondary" id="yasr-send-review-type"><?php _e('Select', 'yet-another-stars-rating'); ?></button>

        <br />

        <span id="yasr-ajax-response-review-type"></span>

    </div>

    <p>

    <div>

        <?php

            //Show this message if auto insert is off or if auto insert is not set to show overall rating (so if it is set to visitor rating)
            if( YASR_AUTO_INSERT_ENABLED == 0 || (YASR_AUTO_INSERT_ENABLED == 1 && YASR_AUTO_INSERT_WHAT === 'visitor_rating') ) {

                echo "<div>";
                  _e ("Remember to insert this shortcode <strong>[yasr_overall_rating]</strong> where you want to display this rating", 'yet-another-stars-rating');
                echo "</div>";

            }

        ?>

    </div>

    <?php

        do_action( 'yasr_add_content_bottom_topright_metabox', $post_id );

    ?>

</div>

<script type="text/javascript">

    jQuery(document).ready(function() {

        var defaultbox = <?php echo (json_encode(YASR_METABOX_OVERALL_RATING)); ?>;

        var nonceOverall = <?php echo (json_encode("$ajax_nonce_overall")); ?>;

        var nonceSnippet = <?php echo (json_encode("$ajax_nonce_review_type")); ?>;

        var postid = <?php json_encode(the_ID()); ?>;

        var overallRating = <?php echo (json_encode($overall_rating)); ?>

        yasrDisplayTopRightMetabox(defaultbox, postid, nonceOverall, nonceSnippet, overallRating);

    }); //End document ready

</script>
