=== Yasr - Yet Another Stars Rating ===
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=AXE284FYMNWDC
Tags: ratings, rating, postrating, google rating, 5 star, review, reviews, star rating, vote, votes
Requires at least: 4.3.0
Contributors: Dudo
Tested up to: 5.0.2
Requires PHP: 5.3
Stable tag: 1.8.5
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Boost the way people interact with your website, e-commerce or blog with an easy and intuitive WordPress rating system! 

== Description ==
Improving the user experience (UX) with your website is a top priority for everyone who cares about their online activity, as it promotes familiarity and loyalty with your brand, and enhances visibility of your activity.

Yasr - Yet Another Stars Rating is a powerful way to add SEO-friendly user-generated reviews and testimonials to your website posts, pages and CPT, without affecting its speed.

= How To use =

= Reviewer Vote =
Once YASR is installed, when you create or update a page or a post, a box (metabox) will be available in the upper right corner where you'll
be able to insert the overall rating. You can either place the overall rating automatically at the beginning or the end of a post (look in "Settings"
-> "Yet Another Stars Rating: Settings"), or wherever you want in the page using the shortcode [yasr_overall_rating] (easily added through the visual editor).

= Visitor Votes =
You can give your users the ability to vote, pasting the shortcode [yasr_visitor_votes] where you want the stars to appear.
Again, this can be placed automatically at the beginning or the end of each post; the option is in "Settings" -> "Yet Another Stars Rating: Settings".
This may not works if you use a caching plugin.

= Multi Set =
Multisets give the opportunity to score different aspects for each review: for example, if you're reviewing a videogame, you can create the aspects "Graphics",
"Gameplay", "Story", etc.


= Supported Languages =

Check [here](https://translate.wordpress.org/projects/wp-plugins/yet-another-stars-rating/dev) to see if your translation is up to date.
Write on the [forum](https://wordpress.org/support/plugin/yet-another-stars-rating) to ask to become a validator :)

In this video I'll show you the "Auto Insert" feature and manual placement of YASR basic shortcodes.
[youtube https://www.youtube.com/watch?v=M47xsJMQJ1E]

= Related Link =
* News and doc at [Yasr Official Site](https://yetanotherstarsrating.com/)
* [Demo page for Overall Rating and Vistor Rating](https://yetanotherstarsrating.com/yasr-basics-shortcode/)
* [Demo page for Multi Sets](https://yetanotherstarsrating.com/yasr-multi-sets/)
* [Demo page for Rankings](https://yetanotherstarsrating.com/yasr-rankings/)

= Press =
* [WPMUDEV](http://premium.wpmudev.org/blog/free-wordpress-ratings-testimonials-subscriber-count-plugins/)
* [BRIANLI.COM](http://brianli.com/yet-another-stars-rating-wordpress-plugin-review/)
* [WPEXPLORER](http://www.wpexplorer.com/google-rich-snippets-wordpress/)
* [SOURCEWP](http://www.sourcewp.com/best-post-voting-plugins-wordpress/)
* [HOWSHOST](https://howshost.com/add-post-rating-system-in-wordpress/)

Do you want more feature? [Check out Yasr Pro!](https://yetanotherstarsrating.com/#yasr-pro-anchor)

== Installation ==
1. Install Yet Another Stars Rating either via the WordPress.org plugin directory, or by uploading the files to your server
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the Yet Another Star Rating menu in Settings and set your options.

== Frequently Asked Questions ==

= What is "Overall Rating"? =
It is the vote given by who writes the review: readers are able to see this vote in read-only mode. Reviewer can vote using the box on the top rigth when writing a new article or post (he or she must have at least the "Author" role). Remember to insert this shortcode **[yasr_overall_rating]** to make it appear where you like. You can choose to make it appear just in a single post/page or in archive pages too (e.g. default Index, category pages, etc).

= What is "Visitor Rating"? =
It is the vote that allows your visitors to vote: just paste this shortcode **[yasr_visitor_votes]** where you want the stars to appear. This may not works if you use a caching plugin.

[Demo page for Overall Rating and Vistor Rating](https://yetanotherstarsrating.com/yasr-basics-shortcode/)


= What is "Multi Set"? =
It is the feature that makes YASR awesome. Multisets give the opportunity to score different aspects for each review: for example, if you're reviewing a videogame, you can create the aspects "Graphics", "Gameplay", "Story", etc. and give a vote for each one. To create a set, just go in "Settings" -> "Yet Another Stars Rating: Settings" and click on the "Multi Sets" tab. To insert it into a post, just paste the shortcode that YASR will create for you.

[Demo page for Multi Sets](https://yetanotherstarsrating.com/yasr-multi-sets/)

= What is "Ranking reviews" ? =
It is the 10 highest rated item chart by reviewer. In order to insert it into a post or page, just paste this shortcode **[yasr_top_ten_highest_rated]**

= What is "Users' ranking" ? =
This is 2 charts in 1. Infact, this chart shows both the most rated posts/pages or the highest rated posts/pages.
For an item to appear in this chart, it has to be rated twice at least.
Paste this shortcode to make it appear where you want **[yasr_most_or_highest_rated_posts]**

= What is "Most active reviewers" ? =
If in your site there are more than 1 person writing reviews, this chart will show the 5 most active reviewers. Shortcode is **[yasr_top_5_reviewers]**

= What is "Most active users" ? =
When a visitor (logged in or not) rates a post/page, his rating is stored in the database. This chart will show the 10 most active users, displaying the login name if logged in or "Anonymous" otherwise. The shortcode : **[yasr_top_ten_active_users]**

[Demo page for Rankings](https://yetanotherstarsrating.com/yasr-rankings/)

= Wait, wait! Do I need to keep in mind all this shortcode? =
Of course not: you can easily add it on the visual editor just by clicking the "Yasr Shortcode" button just above the editor

= Why I don't see stars in google? =
Please be sure that if you use mostly the "yasr_visitor_votes" shortcode, you've to select "Aggregate Rating" to the question "Which rich snippet do you want to use?" in the General Settings.
If, instead, your website use mostly the "yasr_overall_rating" shortcode, you've to select "Review Rating".
Google will need some days to index the stars.
You can use the [Structured Data Testing Tool](https://search.google.com/structured-data/testing-tool/u/0/) to validate your page.
If you set up everythings fine, in 99% of cases your stars will appear in a week.
If doesn't, it's suggested to ask in a SEO oriented forum.



== Screenshots ==
1. Example of yasr in a videogame review
2. Another example of a restaurant review
3. User's ranking showing most rated posts
4. User's ranking showing highest rated posts
5. Ranking reviews
6. Yasr Stars Settings 

== Changelog ==

The full changelog can be found in the plugin's directory. Recent entries:

= 1.8.5 =
* Fixed: is now possible to insert more than once a shortcode in the same page
* Fixed: Full RTL support (remeber to delete all your caches)

= 1.8.4 =
* Small changes on stars images to better look on dark backgrounds
* Partial rtl support

= 1.8.3 =
* FIXED: multiset doesn't show up in the edit screen if only 1 is used



= 1.8.2 =
* FIXED: widgets didn't load in front end

= 1.8.1 =
* Rounded stars again available

= 1.8.0 =
* This is a very important release. A lot of code has been cleaned up/rewritten. Images are not png anymore, but svg.
Everthing is now fresher and even more lightweight then before. If you customized your stars set, check it again in the settings.


= 1.7.4 =
* Css fixes

= 1.7.3 =
* FIXED: Multi set's field name is now 40 chars long instead of 23
* TWEAKED: progress bars doesn't use jquery anymore, it's css only
* TWEAKED: tooltip for yasr_visitor_votes doesn't use jquery anymore, but uses [tippy](https://atomiks.github.io/tippyjs/) instead
* TWEAKED: A lot of under the hood changes



= 1.7.2 =
* FIXED: yasr_visitor_multiset didn't work

= 1.7.1 =
* FIXED: security fix


= Additional Info =
External Libraries: [Rater](https://github.com/fredolss/rater-js)
[tippy](https://atomiks.github.io/tippyjs/)

Svg star icon made by [Freepik](http://www.freepik.com)
from [www.flaticon.com](https://www.flaticon.com/) is licensed by [CC 3.0 BY](http://creativecommons.org/licenses/by/3.0/)
