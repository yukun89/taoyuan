jQuery(".entry-content").find("h2,h3,h4,h5,h6").each(function(i, item) {
  if (jQuery(item).text() != "相关文章") {
    var tag = jQuery(item).get(0).localName;
    jQuery(item).attr("id", "wow" + i);
    jQuery("#anchorContent").append(
      '<p><a class = "title-' + tag +
      ' anchor-link" onclick = "return false;" href = "#" link = "#wow' + i +
      '">' + jQuery(this).text() + '</a></p>');
    jQuery(".title-h2").css("margin-left", 0);
    jQuery(".title-h3").css("margin-left", 20);
    jQuery(".title-h4").css("margin-left", 40);
    jQuery(".title-h5").css("margin-left", 60);
    jQuery(".title-h6").css("margin-left", 80);
  }
});

jQuery("#anchorContentToggle").click(function(){
    var text = jQuery(this).html();
    if(text=="导航[-]"){
        jQuery(this).html("导航[+]");
        jQuery(this).attr({"title":"展开"});
    }else{
        jQuery(this).html("导航[-]");
        jQuery(this).attr({"title":"收起"});
    }
    jQuery("#anchorContent").toggle();
});

jQuery(".anchor-link").click(function(){
    jQuery("html,body").animate({scrollTop: jQuery(jQuery(this).attr("link")).offset().top}, 400);
});
