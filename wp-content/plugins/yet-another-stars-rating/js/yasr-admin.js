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


/*** Constant used by yasr

 yasrCommonDataAdmin (loaderHtml)

 ***/

/****** Yasr Metabox overall rating ******/

    function yasrDisplayTopRightMetabox(defaultbox, postid, nonceOverall, nonceSnippet, overallRating) {

        if (defaultbox === 'stars' ) {

            yasrPrintEventSendOverallWithStars(postid, nonceOverall, overallRating);

        }

        else if (defaultbox === 'numbers') {

           yasrPrintEventSendOverallWithNumbers(postid, nonceOverall);

        }

        yasrSnippetSelect(postid, nonceSnippet);

    }

    //This is for the stars
    function yasrPrintEventSendOverallWithStars(postid, nonce, overallRating) {

        //Convert string to number
        overallRating = parseFloat(overallRating);

        raterJs({
            starSize: 32,
            step: 0.1,
            showToolTip: false,
            rating: overallRating,
            readOnly: false,
            element: document.getElementById("yasr-rater-overall"),
            rateCallback: function rateCallback(rating, done) {

                jQuery('#loader-overall-rating').show();

                rating = rating.toFixed(1);
                rating = parseFloat(rating);
                this.setRating(rating);

                var data = {
                    action: 'yasr_send_overall_rating',
                    nonce: nonce,
                    rating: rating,
                    post_id: postid
                };

                //Send value to the Server
                jQuery.post(ajaxurl, data, function(response) {
                    jQuery('#loader-overall-rating').hide();
                    jQuery('#yasr_rateit_overall_value').text(response);
                }) ;

                done();
            }
        });


    }

    //This is for the numbers
    function yasrPrintEventSendOverallWithNumbers(postid, nonce) {

        var integer = jQuery('#yasr-vote-overall-numbers-int').val();

        if (integer == 5) {

                jQuery("#yasr-comma-between-select").hide();
                jQuery("#yasr-vote-overall-numbers-dec").hide();

            }

        jQuery('#yasr-vote-overall-numbers-int').on('change', function() {

            var integer = (this.value);

            if (integer == 5) {

                jQuery("#yasr-comma-between-select").hide();
                jQuery("#yasr-vote-overall-numbers-dec").hide();

            }

        });

        jQuery('#yasr-send-overall-numbers').on('click', function() {

            var integer = jQuery('#yasr-vote-overall-numbers-int').val();

            var decimal = jQuery('#yasr-vote-overall-numbers-dec').val();

            var value = integer + "." + decimal;

            var data = {
                action: 'yasr_send_overall_rating',
                nonce: nonce,
                rating: value,
                post_id: postid
            };

            //Send value to the Server
            jQuery.post(ajaxurl, data, function(response) {
                jQuery('#yasr-overall-numbers-saved-confirm').text(response);
            }) ;

            return false;

        });

    }

    //Choose snippet
    function yasrSnippetSelect(postid, nonceSnippet) {

    	jQuery('#yasr-send-review-type').on('click', function() {

    		reviewtype = jQuery('#yasr-choose-reviews-types-list').val()

        	var data = {
        		action: 'yasr_insert_review_type',
        		reviewtype: reviewtype,
        		postid: postid,
        		nonce: nonceSnippet
        	}

        	jQuery.post(ajaxurl, data, function(response) {
                jQuery('#yasr-ajax-response-review-type').text(response);
            }) ;

        	return false;

        });

    }


/****** End Yasr Metabox overall rating ******/


/****** Yasr Metabox Multiple Rating ******/

function yasrAdminMultiSet(nMultiSet, postid, setId, nonceMulti){

    nMultiSet = parseInt(nMultiSet);

    if (nMultiSet === 1) {

        yasrPrintAdminMultiSet(setId, postid, nonceMulti, nMultiSet);

    }

    else {

        jQuery('#yasr-button-select-set').on("click", function () {

            //get the multi data
            var setId = jQuery('#select_set').val();

            jQuery("#yasr-loader-select-multi-set").show();

            yasrPrintAdminMultiSet(setId, postid, nonceMulti);

        });

    }

}

//print the table
function yasrPrintAdminMultiSet (setId, postid, nonceMulti, nMultiSet) {

    var data_id = {
        action: 'yasr_send_id_nameset',
        set_id: setId,
        post_id: postid
    };

    jQuery.post(ajaxurl, data_id, function(response) {

        //Hide the loader near the select only if more multiset are used
        if (nMultiSet !== 1) {
            document.getElementById('yasr-loader-select-multi-set').style.display = 'none';
        }

        var yasrMultiSetValue = JSON.parse(response);

        var content = '';

        for (var i = 0; i < yasrMultiSetValue.length; i++) {

            var valueName = yasrMultiSetValue[i]['value_name'];
            var valueRating = yasrMultiSetValue[i]['value_rating'];
            var valueID = yasrMultiSetValue[i]['value_id'];

            content += '<tr>';
            content += '<td>' + valueName + '</td>';
            content += '<td><div class="yasr-multiset-admin" id="yasr-multiset-admin-' + valueID + '" data-rating="' + valueRating + '" data-multi-idfield="'+valueID+'"></div>';
            content += '<span id="yasr-loader-multi-set-field-' + valueID + '" style="display: none">';
            content += '<img src="'+yasrCommonDataAdmin.loaderHtml+'"></span>';
            content += '</span>';
            content += '</td>';
            content += '</tr>';

            var table = document.getElementById('yasr-table-multi-set-admin');

            table.innerHTML = content;

        }

        //Show the text "Choose a vote"
        document.getElementById('yasr-multi-set-admin-choose-text').style.display='block';

        //Set rater for divs
        yasrSetRaterAdminMulti (postid, setId, nonceMulti);

        //Show shortcode
        document.getElementById('yasr-multi-set-admin-explain').style.display='block';

        document.getElementById('yasr-multi-set-admin-explain-with-id-readonly').innerHTML = '<strong>[yasr_multiset setid='+setId+']</strong>';
        document.getElementById('yasr-multi-set-admin-explain-with-id-visitor').innerHTML = '<strong>[yasr_visitor_multiset setid='+setId+']</strong>';

    });

    return false; // prevent default click action from happening!

}

//Rater for multiset
function yasrSetRaterAdminMulti (postid, setId, nonceMulti) {

    var yasrMultiSetAdmin = document.getElementsByClassName('yasr-multiset-admin');

    for (var i=0; i<yasrMultiSetAdmin.length; i++) {

        (function(i) {

            var htmlId = yasrMultiSetAdmin.item(i).id;
            var idField = yasrMultiSetAdmin.item(i).getAttribute('data-multi-idfield');

            var elem = document.getElementById(htmlId);

            raterJs({
                starSize: 32,
                step: 0.5,
                showToolTip: false,
                readOnly: false,
                element: elem,

                rateCallback: function rateCallback(rating, done) {

                    rating = rating.toFixed(1);
                    //Be sure is a number and not a string
                    rating = parseFloat(rating);
                    this.setRating(rating) //Set the rating

                    document.getElementById("yasr-loader-multi-set-field-" + idField).style.display = '';

                    jQuery("#yasr-loader-multi-set-field-" + idField).show();

                    var data = {
                        action: 'yasr_send_id_field_with_vote',
                        nonce: nonceMulti,
                        rating: rating,
                        post_id: postid,
                        id_field: idField,
                        set_type: setId
                    };

                    //Send value to the Server
                    jQuery.post(ajaxurl, data, function () {
                        document.getElementById("yasr-loader-multi-set-field-" + idField).style.display = 'none';
                    });

                    done();

                }

            });

        })(i);

    } //End for

}//End function

/****** End Yasr Metabox Multple Rating  ******/


/****** Yasr Settings Page ******/

	function YasrSettingsPage (activeTab, nMultiSet, autoInsertEnabled, textBeforeStars) {

		//-------------------General Settings Code---------------------

	   	if (activeTab === 'general_settings') {

	   		if (autoInsertEnabled == 0) {
	   			jQuery('.yasr-auto-insert-options-class').prop('disabled', true);
	   		}

			//First Div, for auto insert
            jQuery('#yasr_auto_insert_switch').change(function() {
    			if (jQuery(this).is(':checked')) {
    				jQuery('.yasr-auto-insert-options-class').prop('disabled', false);
    			}
                else {
                    jQuery('.yasr-auto-insert-options-class').prop('disabled', true);
                }
            });

            //for text before stars
            if(textBeforeStars == 0) {
                jQuery('.yasr-general-options-text-before').prop('disabled', true);
            }

            jQuery('#yasr-general-options-text-before-stars-switch').change(function() {
                if (jQuery(this).is(':checked')) {

                    jQuery('.yasr-general-options-text-before').prop('disabled', false);
					jQuery('#yasr-general-options-custom-text-before-overall').val('Our Score');
					jQuery('#yasr-general-options-custom-text-before-visitor').val('Our Reader Score');
                    jQuery('#yasr-general-options-custom-text-after-visitor').val('[Total: %total_count%  Average: %average%]');
					jQuery('#yasr-general-options-custom-text-already-rated').val('You have already voted for this article');

                }

                else {

                    jQuery('.yasr-general-options-text-before').prop('disabled', true);

                }

            });


			/*if (jQuery('#yasr_text_before_star_off').is(':checked')) {
				jQuery('.yasr-general-options-text-before').prop('disabled', true);
			}

			jQuery('#yasr_text_before_star_on').on('click', function(){

					jQuery('.yasr-general-options-text-before').prop('disabled', false);
					jQuery('#yasr-general-options-custom-text-before-overall').val('Our Score');
					jQuery('#yasr-general-options-custom-text-before-visitor').val('Our Reader Score');
                    jQuery('#yasr-general-options-custom-text-after-visitor').val('[Total: %total_count%  Average: %average%]');
					jQuery('#yasr-general-options-custom-text-already-rated').val('You have already voted for this article');

			});*/

            jQuery('#yasr-doc-custom-text-link').on('click', function() {
                jQuery('#yasr-doc-custom-text-div').toggle('slow');
                return false;
            });

			jQuery('#yasr-snippet-explained-link').on('click', function () {
				jQuery('#yasr-snippet-explained').toggle('slow');
				return false; // prevent default click action from happening!
			});


            /*//If on document ready "BlogPosting" is checked show the additional fields
            if (jQuery('#yasr_choose_snippet_blogposting').is(':checked')) {
                jQuery('#yasr-blogPosting-additional-info').show();
                jQuery('.yasr-blogPosting-additional-info-inputs').prop('disabled', false);
			}

            //On change show or hide the additional fields
            jQuery('#yasr-choose-snippet-type input[type=radio]').change(function(){
                var snippet_type = jQuery(this).val();

                if (snippet_type === 'Other') {

                    jQuery('#yasr-blogPosting-additional-info').show();
                    jQuery('.yasr-blogPosting-additional-info-inputs').prop('disabled', false);

                }

                else {
                    jQuery('.yasr-blogPosting-additional-info-inputs').prop('disabled', true);
                    jQuery('#yasr-blogPosting-additional-info').hide();

                }

                return false;

            });*/

		} //End if general settings

		//--------------Multi Sets Page ------------------

		if (activeTab === 'manage_multi') {

			jQuery('#yasr-multi-set-doc-link').on('click', function() {
				jQuery('#yasr-multi-set-doc-box').toggle("slow");
			});

			jQuery('#yasr-multi-set-doc-link-hide').on('click', function() {
				jQuery('#yasr-multi-set-doc-box').toggle("slow");
			});

			if (nMultiSet == 1) {

				var counter = jQuery("#yasr-edit-form-number-elements").attr('value');

		    	counter++;

				jQuery("#yasr-add-field-edit-multiset").on('click', function() {

					if(counter>9){
		           		jQuery('#yasr-element-limit').show();
		           		jQuery('#yasr-add-field-edit-multiset').hide();
		            	return false;
					}

					var newTextBoxDiv = jQuery(document.createElement('tr'))

					newTextBoxDiv.html('<td colspan="2">Element #' + counter + ' <input type="text" name="edit-multi-set-element-' + counter + '" value="" ></td>');

					newTextBoxDiv.appendTo("#yasr-table-form-edit-multi-set");

		 			counter++;

				});


			} //End if ($n_multi_set == 1)

			if (nMultiSet > 1) {

			    //If more then 1 set is used...
				jQuery('#yasr-button-select-set-edit-form').on("click", function() {

				    var data = {
				    	action : 'yasr_get_multi_set',
				    	set_id : jQuery('#yasr_select_edit_set').val()
				    }

				    jQuery.post(ajaxurl, data, function(response) {
				    	jQuery('#yasr-multi-set-response').show();
	     				jQuery('#yasr-multi-set-response').html(response);
	     			});

	     			return false; // prevent default click action from happening!

				});

				jQuery(document).ajaxComplete(function(){

					var counter = jQuery("#yasr-edit-form-number-elements").attr('value');

			    	counter++;

			    	jQuery("#yasr-add-field-edit-multiset").on('click', function() {

						if(counter>9){
			           		jQuery('#yasr-element-limit').show();
			           		jQuery('#yasr-add-field-edit-multiset').hide();
			            	return false;
						}

						var newTextBoxDiv = jQuery(document.createElement('tr'))

						newTextBoxDiv.html('<td colspan="2">Element #' + counter + ' <input type="text" name="edit-multi-set-element-' + counter + '" value="" ></td>');

						newTextBoxDiv.appendTo("#yasr-table-form-edit-multi-set");

			 			counter++;

			    	});

		  		});

		  	} //End if ($n_multi_set > 1)



		} //end if active_tab=='manage_multi'


        if (activeTab === 'style_options') {

            jQuery('#yasr-color-scheme-preview-link').on('click', function () {
                jQuery('#yasr-color-scheme-preview').toggle('slow');
                return false; // prevent default click action from happening!
            });

        }


	}

    function YasrAsk5Stars(nonceHideAskRating) {

        //This will call an ajax action that set a site transite to hide
        //for a week the metabok
        jQuery('#yasr-ask-five-star-later').on("click", function(){

            jQuery('#yasr-ask-five-stars').hide();

            var data = {
                action: 'yasr_hide_ask_rating_metabox',
                choose: 'hide',
                nonce: nonceHideAskRating

            };

            jQuery.post(ajaxurl, data);

        });


        //This will close the ask rating metabox forever
        jQuery('#yasr-ask-five-close').on("click", function(){

            jQuery('#yasr-ask-five-stars').hide();

            var data = {
                action: 'yasr_hide_ask_rating_metabox',
                choose: 'close',
                nonce: nonceHideAskRating
            };

            jQuery.post(ajaxurl, data);

        });


    }

/****** End Yasr Settings Page ******/


/****** Yasr Ajax Page ******/


	// When click on chart hide tab-main and show tab-charts

	function yasrShortcodeCreator(nMultiSet) {

            // When click on main tab hide tab-main and show tab-charts
            jQuery('#yasr-link-tab-main').on("click", function(){

                jQuery('.yasr-nav-tab').removeClass('nav-tab-active');
                jQuery('#yasr-link-tab-main').addClass('nav-tab-active');

                jQuery('.yasr-content-tab-tinymce').hide();
                jQuery('#yasr-content-tab-main').show();

            });

			jQuery('#yasr-link-tab-charts').on("click", function(){

			    jQuery('.yasr-nav-tab').removeClass('nav-tab-active');
			    jQuery('#yasr-link-tab-charts').addClass('nav-tab-active');

			    jQuery('.yasr-content-tab-tinymce').hide();
			    jQuery('#yasr-content-tab-charts').show();

			});

			// Add shortcode for overall rating
			jQuery('#yasr-overall').on("click", function(){
			    jQuery('#yasr-overall-choose-size').toggle('slow');
			});

			    jQuery('#yasr-overall-insert-small').on("click", function(){
			        var shortcode = '[yasr_overall_rating size="small"]';

			        if(tinyMCE.activeEditor==null) {

                        //this is for tinymce used in text mode
                        jQuery("#content").append(shortcode);

                    }

                    else {

                        // inserts the shortcode into the active editor
                        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

                    }

                    // close
                    tb_remove();
                    //jQuery('#yasr-tinypopup-form').dialog('close');
			       
			    });

			    jQuery('#yasr-overall-insert-medium').on("click", function(){
			        var shortcode = '[yasr_overall_rating size="medium"]';
			        
                    // inserts the shortcode into the active editor
                    if(tinyMCE.activeEditor==null) {

                        //this is for tinymce used in text mode
                        jQuery("#content").append(shortcode);

                    }

                    else {

                        // inserts the shortcode into the active editor
                        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

                    }

                    // close
                    tb_remove();
                    //jQuery('#yasr-tinypopup-form').dialog('close');
			    });

			    jQuery('#yasr-overall-insert-large').on("click", function(){
			        var shortcode = '[yasr_overall_rating size="large"]';
			        
                    if(tinyMCE.activeEditor==null) {

                        //this is for tinymce used in text mode
                        jQuery("#content").append(shortcode);

                    }

                    else {

                        // inserts the shortcode into the active editor
                        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

                    }

                    // close
                    tb_remove();
                    //jQuery('#yasr-tinypopup-form').dialog('close');
			    });

			//Add shortcode for visitors rating
			jQuery('#yasr-visitor-votes').on("click", function(){
			    jQuery('#yasr-visitor-choose-size').toggle('slow');
			});

			    jQuery('#yasr-visitor-insert-small').on("click", function(){
			        var shortcode = '[yasr_visitor_votes size="small"]';

			        // inserts the shortcode into the active editor
			        if(tinyMCE.activeEditor==null) {

                        //this is for tinymce used in text mode
                        jQuery("#content").append(shortcode);

                    }

                    else {

                        // inserts the shortcode into the active editor
                        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

                    }

                    // close
                    tb_remove();
                    //jQuery('#yasr-tinypopup-form').dialog('close');
			    });

			    jQuery('#yasr-visitor-insert-medium').on("click", function(){
			        var shortcode = '[yasr_visitor_votes size="medium"]';

			        if(tinyMCE.activeEditor==null) {

                        //this is for tinymce used in text mode
                        jQuery("#content").append(shortcode);

                    }

                    else {

                        // inserts the shortcode into the active editor
                        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

                    }

                    // close
                    tb_remove();
                    //jQuery('#yasr-tinypopup-form').dialog('close');
			    });

			    jQuery('#yasr-visitor-insert-large').on("click", function(){
			        var shortcode = '[yasr_visitor_votes size="large"]';
			        
                    // inserts the shortcode into the active editor
			        if(tinyMCE.activeEditor==null) {

                        //this is for tinymce used in text mode
                        jQuery("#content").append(shortcode);

                    }

                    else {

                        // inserts the shortcode into the active editor
                        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

                    }

                    // close
                    tb_remove();
                    //jQuery('#yasr-tinypopup-form').dialog('close');
			    });

			if (nMultiSet > 1) {

			    //Add shortcode for multiple set
			    jQuery('#yasr-insert-multiset-select').on("click", function(){
			        var setType = jQuery("input:radio[name=yasr_tinymce_pick_set]:checked" ).val();
                    var visitorSet = jQuery("#yasr-allow-vote-multiset").is(':checked');
                    var showAverage = jQuery("#yasr-hide-average-multiset").is(':checked');

                    if (!visitorSet) {

                        var shortcode = '[yasr_visitor_multiset setid=';

                    }

                    else {

                        var shortcode = '[yasr_multiset setid=';

                    }

                    shortcode += setType;

                    if (showAverage) {

                        shortcode += ' show_average=\'no\'';

                    }


			        shortcode += ']';
                    
			        // inserts the shortcode into the active editor
                    if(tinyMCE.activeEditor==null) {

                        //this is for tinymce used in text mode
                        jQuery("#content").append(shortcode);

                    }

                    else {

                        // inserts the shortcode into the active editor
                        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

                    }

                    // close
                    tb_remove();
                    //jQuery('#yasr-tinypopup-form').dialog('close');
			    });

			} //End if

			else if (nMultiSet == 1) {

			//Add shortcode for single set (if only 1 are found)
			    jQuery('#yasr-single-set').on("click", function(){
			        var setType = jQuery('#yasr-single-set').val();
                    var showAverage = jQuery("#yasr-hide-average-multiset").is(':checked');

                    var visitorSet = jQuery("#yasr-allow-vote-multiset").is(':checked');

                    if (!visitorSet) {

                        var shortcode = '[yasr_visitor_multiset setid=';

                    }

                    else {

                        var shortcode = '[yasr_multiset setid=';

                    }

                    shortcode += setType;

                    if (showAverage) {

                        shortcode += ' show_average=\'no\'';

                    }

			        shortcode += ']';

			        // inserts the shortcode into the active editor
                    if(tinyMCE.activeEditor==null) {

                        //this is for tinymce used in text mode
                        jQuery("#content").append(shortcode);

                    }

                    else {

                        // inserts the shortcode into the active editor
                        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

                    }

                    // close
                    tb_remove();
                    //jQuery('#yasr-tinypopup-form').dialog('close');
			    });

			} //End elseif

			// Add shortcode for top 10 by overall ratings
			jQuery('#yasr-top-10-overall-rating').on("click", function(){
			    var shortcode = '[yasr_top_ten_highest_rated]';
			    
			        // inserts the shortcode into the active editor
                    if(tinyMCE.activeEditor==null) {

                        //this is for tinymce used in text mode
                        jQuery("#content").append(shortcode);

                    }

                    else {

                        // inserts the shortcode into the active editor
                        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

                    }

                    // close
                    tb_remove();
                    //jQuery('#yasr-tinypopup-form').dialog('close');
			});

			// Add shortcode for 10 highest most rated
			jQuery('#yasr-10-highest-most-rated').on("click", function(){
			    var shortcode = '[yasr_most_or_highest_rated_posts]';
			    
			        // inserts the shortcode into the active editor
                    if(tinyMCE.activeEditor==null) {

                        //this is for tinymce used in text mode
                        jQuery("#content").append(shortcode);

                    }

                    else {

                        // inserts the shortcode into the active editor
                        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

                    }

                    // close
                    tb_remove();
                    //jQuery('#yasr-tinypopup-form').dialog('close');
			});

			// Add shortcode for top 5 active reviewer
			jQuery('#yasr-5-active-reviewers').on("click", function(){
			    var shortcode = '[yasr_top_5_reviewers]';
			    
			        // inserts the shortcode into the active editor
                    if(tinyMCE.activeEditor==null) {

                        //this is for tinymce used in text mode
                        jQuery("#content").append(shortcode);

                    }

                    else {

                        // inserts the shortcode into the active editor
                        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

                    }

                    // close
                    tb_remove();
                    //jQuery('#yasr-tinypopup-form').dialog('close');
			});

			// Add shortcode for top 10 active users
			jQuery('#yasr-top-10-active-users').on("click", function(){
			    var shortcode = '[yasr_top_ten_active_users]';
			    
			        // inserts the shortcode into the active editor
                    if(tinyMCE.activeEditor==null) {

                        //this is for tinymce used in text mode
                        jQuery("#content").append(shortcode);

                    }

                    else {

                        // inserts the shortcode into the active editor
                        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);

                    }

                    // close
                    tb_remove();
                    //jQuery('#yasr-tinypopup-form').dialog('close');
			});

	} //End function

/****** End YAsr Ajax page ******/

/****** Yasr db functions ******/

    //Vote log
	jQuery(document).ready(function() {

		//Log
		jQuery('.yasr-log-pagenum').on('click', function() {

			jQuery('#yasr-loader-log-metabox').show();

			var data = {
				action : 'yasr_change_log_page',
				pagenum: jQuery(this).val(),
                totalpages: jQuery('#yasr-log-total-pages').data('yasr-log-total-pages')

			};

			jQuery.post(ajaxurl, data, function(response) {
				jQuery('#yasr-loader-log-metabox').hide();
				jQuery('#yasr-log-container').html(response);
			});

		});

		jQuery(document).ajaxComplete(function() {

			jQuery('.yasr-log-page-num').on('click', function() {

				jQuery('#yasr-loader-log-metabox').show();

				var data = {
					action : 'yasr_change_log_page',
					pagenum: jQuery(this).val(),
                    totalpages: jQuery('#yasr-log-total-pages').data('yasr-log-total-pages')
				};

				jQuery.post(ajaxurl, data, function(response) {
					jQuery('#yasr-log-container').html(response); //This will hide the loader gif too
				});

			});

		});

	});



    //Vote user log
    jQuery(document).ready(function() {

        //Log
        jQuery('.yasr-user-log-pagenum').on('click', function() {

            jQuery('#yasr-loader-user-log-metabox').show();

            var data = {
                action : 'yasr_change_user_log_page',
                pagenum: jQuery(this).val(),
                totalpages: jQuery('#yasr-user-log-total-pages').data('yasr-user-log-total-pages')

            };

            jQuery.post(ajaxurl, data, function(response) {
                jQuery('#yasr-loader-log-metabox').hide();
                jQuery('#yasr-user-log-container').html(response);
            });

        });

        jQuery(document).ajaxComplete(function() {

            jQuery('.yasr-user-log-page-num').on('click', function() {

                jQuery('#yasr-loader-user-log-metabox').show();

                var data = {
                    action : 'yasr_change_user_log_page',
                    pagenum: jQuery(this).val(),
                    totalpages: jQuery('#yasr-user-log-total-pages').data('yasr-user-log-total-pages')
                };

                jQuery.post(ajaxurl, data, function(response) {
                    jQuery('#yasr-user-log-container').html(response); //This will hide the loader gif too
                });

            });

        });

    });

/****** End yasr db functions ******/
