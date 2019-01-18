(function (e) {
    "use strict";
    var n = window.WRITE_JS || {};
    var iScrollPos = 0;
    var ebody = e('body');

    /*Used for ajax loading posts*/
    var loadType, loadButton, loader, pageNo, loading, morePost, scrollHandling;
    /**/
    n.mobileMenu = {
        init: function () {
            this.toggleMenu(), this.menuArrow()
        },

        toggleMenu: function () {
            e('.nav-toogle').on('click', function (event) {
                e('body').toggleClass('extended-menu');
            });

            e('.main-navigation').on('click', 'ul.menu a i', function (event) {
                event.preventDefault();
                var ethis = e(this),
                    eparent = ethis.closest('li'),
                    esub_menu = eparent.find('> .sub-menu');
                if (esub_menu.css('display') == 'none') {
                    esub_menu.slideDown('300');
                    ethis.addClass('active');
                } else {
                    esub_menu.slideUp('300');
                    ethis.removeClass('active');
                }
                return false;
            });
        },

        menuArrow: function () {
            if (e('.main-navigation ul.menu').length) {
                e('.main-navigation ul.menu .sub-menu').parent('li').find('> a').append('<i class="icon-nav-down">');
            }
        }
    },


        n.ThemematticSearch = function () {
            e('.icon-search').on('click', function (event) {
                e('body').toggleClass('reveal-search');
            });
            e('.close-popup').on('click', function (event) {
                e('body').removeClass('reveal-search');
            });
        },

        n.ThemematticPreloader = function () {
            e(window).load(function () {
                e("body").addClass("page-loaded");
            });
        },

        n.ThemematticSlider = function () {
            if (e('.insta-slider').length > 0) {
                e('.insta-slider.insta-slider-enable').slick({
                    slidesToShow: 6,
                    slidesToScroll: 1,
                    dots: false,
                    infinite: false,
                    nextArrow: '<i class="navcontrol-icon slide-next ion-ios-arrow-right"></i>',
                    prevArrow: '<i class="navcontrol-icon slide-prev ion-ios-arrow-left"></i>',
                    responsive: [
                        {
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        }
                    ]
                });
            }

            /*Single Column Gallery*/
            n.SingleColGallery('gallery-columns-1, .wp-block-gallery.columns-1');
            /**/

        },

        n.SingleColGallery = function (gal_selector) {
            if (e.isArray(gal_selector)) {
                e.each(gal_selector, function (index, value) {
                    e("#" + value).find('.gallery-columns-1').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: false,
                        infinite: false,
                        nextArrow: '<i class="navcontrol-icon slide-next ion-ios-arrow-right"></i>',
                        prevArrow: '<i class="navcontrol-icon slide-prev ion-ios-arrow-left"></i>'
                    });
                });
            } else {
                e("." + gal_selector).slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false,
                    infinite: false,
                    nextArrow: '<i class="navcontrol-icon slide-next ion-ios-arrow-right"></i>',
                    prevArrow: '<i class="navcontrol-icon slide-prev ion-ios-arrow-left"></i>'
                });
            }
        },

        n.MagnificPopup = function () {
            e('.zoom-gallery').magnificPopup({
                delegate: 'a',
                type: 'image',
                closeOnContentClick: false,
                closeBtnInside: false,
                mainClass: 'mfp-with-zoom mfp-img-mobile',
                image: {
                    verticalFit: true,
                    titleSrc: function (item) {
                        return item.el.attr('title');
                    }
                },
                gallery: {
                    enabled: true
                },
                zoom: {
                    enabled: true,
                    duration: 300,
                    opener: function (element) {
                        return element.find('img');
                    }
                }
            });

            e('.widget .gallery').each(function () {
                e(this).magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    gallery: {
                        enabled: true
                    },
                    zoom: {
                        enabled: true,
                        duration: 300,
                        opener: function (element) {
                            return element.find('img');
                        }
                    }
                });
            });

            n.GalleryPopup();

        },


        n.GalleryPopup = function () {
            e('.entry-content .gallery, .blocks-gallery-item').each(function () {
                e(this).magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    gallery: {
                        enabled: true
                    },
                    zoom: {
                        enabled: true,
                        duration: 300,
                        opener: function (element) {
                            return element.find('img');
                        }
                    }
                });
            });
        },

        n.DataBackground = function () {
            var pageSection = e(".data-bg");
            pageSection.each(function (indx) {

                if (e(this).attr("data-background")) {
                    e(this).css("background-image", "url(" + e(this).data("background") + ")");
                }
            });

            e('.bg-image').each(function () {
                var src = e(this).children('img').attr('src');
                e(this).css('background-image', 'url(' + src + ')').children('img').hide();
            });
        },

        // SHOW/HIDE SCROLL UP //
        n.show_hide_scroll_top = function () {
            if (e(window).scrollTop() > e(window).height() / 2) {
                e("#scroll-up").fadeIn(300);
            } else {
                e("#scroll-up").fadeOut(300);
            }
        },

        // SCROLL UP //
        n.scroll_up = function () {
            e("#scroll-up").on("click", function () {
                e("html, body").animate({
                    scrollTop: 0
                }, 800);
                return false;
            });

        },

        n.ms_masonry = function () {
            if (e('.masonry-grid').length > 0) {

                /*Default masonry animation*/
                var hidden = 'scale(0.5)';
                var visible = 'scale(1)';
                /**/

                /*Get masonry animation*/
                if (writeBlogVal.masonry_animation === 'none') {
                    hidden = 'translateY(0)';
                    visible = 'translateY(0)';
                }

                if (writeBlogVal.masonry_animation === 'slide-up') {
                    hidden = 'translateY(50px)';
                    visible = 'translateY(0)';
                }

                if (writeBlogVal.masonry_animation === 'slide-down') {
                    hidden = 'translateY(-50px)';
                    visible = 'translateY(0)';
                }

                if (writeBlogVal.masonry_animation === 'zoom-out') {
                    hidden = 'translateY(-20px) scale(1.25)';
                    visible = 'translateY(0) scale(1)';
                }
                /**/

                var $grid = e('.masonry-grid').imagesLoaded(function () {
                    //e('.masonry-grid article').fadeIn();
                    $grid.masonry({
                        itemSelector: 'article',
                        hiddenStyle: {
                            transform: hidden,
                            opacity: 0
                        },
                        visibleStyle: {
                            transform: visible,
                            opacity: 1
                        }
                    });
                });
            }
        },

        n.thememattic_matchheight = function () {
            jQuery('.theiaStickySidebar', 'body').parent().theiaStickySidebar({
                additionalMarginTop: 30
            });
        },

        n.thememattic_reveal = function () {
            e('#thememattic-reveal').on('click', function (event) {
                e('body').toggleClass('reveal-box');
            });
            e('.close-popup').on('click', function (event) {
                e('body').removeClass('reveal-box');
            });
        },

        n.setLoadPostDefaults = function () {
            if (e('.load-more-posts').length > 0) {
                loadButton = e('.load-more-posts');
                loader = e('.load-more-posts .ajax-loader');
                loadType = loadButton.attr('data-load-type');
                pageNo = 2;
                loading = false;
                morePost = true;
                scrollHandling = {
                    allow: true,
                    reallow: function () {
                        scrollHandling.allow = true;
                    },
                    delay: 400
                };
            }
        },

        n.fetchPostsOnScroll = function () {
            if (e('.load-more-posts').length > 0 && 'scroll' === loadType) {
                var iCurScrollPos = e(window).scrollTop();
                if (iCurScrollPos > iScrollPos) {
                    if (!loading && scrollHandling.allow && morePost) {
                        scrollHandling.allow = false;
                        setTimeout(scrollHandling.reallow, scrollHandling.delay);
                        var offset = e(loadButton).offset().top - e(window).scrollTop();
                        if (2000 > offset) {
                            loading = true;
                            n.ShowPostsAjax();
                        }
                    }
                }
                iScrollPos = iCurScrollPos;
            }
        },

        n.fetchPostsOnClick = function () {
            if (e('.load-more-posts').length > 0 && 'click' === loadType) {
                e('.load-more-posts a').on('click', function (event) {
                    event.preventDefault();
                    n.ShowPostsAjax();
                });
            }
        },
        n.masonryOnClickUpdate = function() {
            setTimeout(function() {
                $('.masonry-grid').masonry();
                console.log("Hello world! init");
            },100);
        }

        n.fetchPostsOnMenuClick = function () {
            e('.trigger-icon-wraper').on('click', function (event) {
                event.preventDefault();
                var $grid = e('.masonry-grid');
                n.masonryOnClickUpdate();
            });
        },

        n.ShowPostsAjax = function () {
            e.ajax({
                type: 'GET',
                url: writeBlogVal.ajaxurl,
                data: {
                    action: 'minimal_grid_load_more',
                    nonce: writeBlogVal.nonce,
                    page: pageNo,
                    post_type: writeBlogVal.post_type,
                    search: writeBlogVal.search,
                    cat: writeBlogVal.cat,
                    taxonomy: writeBlogVal.taxonomy,
                    author: writeBlogVal.author,
                    year: writeBlogVal.year,
                    month: writeBlogVal.month,
                    day: writeBlogVal.day
                },
                dataType: 'json',
                beforeSend: function () {
                    loader.addClass('ajax-loader-enabled');
                },
                success: function (response) {
                    if (response.success) {

                        var gallery = false;
                        var gal_selectors = [];
                        var $content_join = response.data.content.join('');

                        if ($content_join.indexOf("gallery-columns-1") >= 0) {
                            gallery = true;
                            /*Push the post ids having galleries so that new gallery instance can be created*/
                            e($content_join).find('.entry-gallery').each(function () {
                                gal_selectors.push(e(this).closest('article').attr('id'));
                            });
                        }

                        if (e('.masonry-grid').length > 0) {
                            var $content = e($content_join);
                            $content.hide();
                            var $grid = e('.masonry-grid');
                            $grid.append($content);
                            $grid.imagesLoaded(function () {

                                $content.show();

                                /*Init new Gallery*/
                                if (true === gallery) {
                                    n.SingleColGallery(gal_selectors);
                                }
                                /**/

                                if (writeBlogVal.relayout_masonry) {
                                    $grid.masonry('appended', $content).masonry();
                                } else {
                                    $grid.masonry('appended', $content);
                                }

                                loader.removeClass('ajax-loader-enabled');
                            });
                        } else {
                            e('.minimal-grid-posts-lists').append(response.data.content);
                            /*Init new Gallery*/
                            if (true === gallery) {
                                n.SingleColGallery(gal_selectors);
                            }
                            /**/
                            loader.removeClass('ajax-loader-enabled');
                        }

                        pageNo++;
                        loading = false;
                        if (!response.data.more_post) {
                            morePost = false;
                            loadButton.fadeOut();
                        }

                        /*For audio and video to work properly after ajax load*/
                        e('video, audio').mediaelementplayer({alwaysShowControls: true});
                        /**/

                        /*For Gallery to work*/
                        n.GalleryPopup();
                        /**/

                        loader.removeClass('ajax-loader-enabled');


                    } else {
                        loadButton.fadeOut();
                    }
                }
            });
        },

        e(document).ready(function () {
            n.mobileMenu.init(), n.ThemematticSearch(), n.ThemematticPreloader(), n.ThemematticSlider(), n.MagnificPopup(), n.DataBackground(), n.scroll_up(), n.thememattic_reveal(), n.thememattic_matchheight(), n.ms_masonry(), n.setLoadPostDefaults(), n.fetchPostsOnClick(), n.fetchPostsOnMenuClick();
        }),
        e(window).scroll(function () {
            n.show_hide_scroll_top(), n.fetchPostsOnScroll();
        })
})(jQuery);