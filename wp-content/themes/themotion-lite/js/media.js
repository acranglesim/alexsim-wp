/* global jQuery */

jQuery(document).ready(function ($) {
    'use strict';

    var firstId = $('.themotion-playlist-playing').data('id');
    var lastItemPlayingId = firstId ? firstId : -1;


    $.thmedia = {
        init: function () {
            this.openModal();
            this.closeModal();
            this.loadCarousel();
            this.playFirstVideo();
        },

        playFirstVideo: function () {
            $('.themotion-video-play-button.themotion-render-now').on('click', function () {
               var container = $(this).parent();
                $.thmedia.renderVideo( container );
                $.thmedia.playVideo( container, 'youtube' );
            });
        },

        openModal: function () {
            $(document).on('click', '.themotion-video-play-button', function() {
                var lightbox = $(this).parent().next('.themotion-lightbox');
                var videotype = lightbox.data('type');
                if( !videotype ){
                    return;
                }

                switch (videotype){
                    case 'youtube':
                        var ytContainer = lightbox.find('.youtube-player');
                        if( ytContainer.length ){
                            if( !$.trim( ytContainer.html() ).length ) {
                                $.thmedia.renderVideo( ytContainer );
                            }
                           $.thmedia.playVideo( ytContainer, videotype );
                        }
                        break;
                    case 'unknown':
                        var embedVideo = lightbox.find('video');
                        lightbox.find('.mejs-container').css({'width':'100%', 'height': '100%'});
                        if( embedVideo.length ){
                            $.thmedia.playVideo( embedVideo, videotype );
                        }
                        break;
                    case 'vimeo':
                        var vimeoContainer = lightbox.find('iframe');
                        if( vimeoContainer.length ){
                            $.thmedia.playVideo( vimeoContainer, videotype );
                        }
                        break;
                }
                lightbox.fadeToggle();
            });
        },
        
        closeModal: function () {
            $(document).on('click touch','.themotion-lightbox-inner', function(event){
                event.stopPropagation();
            });

            $('.themotion-lightbox').bind('touchstart click',function() {
                var videotype = $(this).data('type');
                switch ( videotype ){
                    case 'youtube':
                        var ytContainer = $(this).find('.youtube-player');
                        if( ytContainer.length ) {
                            $.thmedia.pauseVideo( ytContainer, videotype );
                        }
                        break;
                    case 'unknown':
                        var embedVideo = $(this).find('video');
                        if( embedVideo.length ){
                            $.thmedia.pauseVideo( embedVideo, videotype );
                        }
                        break;
                    case 'vimeo':
                        var vimeoContainer = $(this).find('iframe');
                        if( vimeoContainer.length ) {
                            $.thmedia.pauseVideo( vimeoContainer, videotype );
                        }
                        break;
                }
                $(this).fadeOut();
            });
        },
        
        renderVideo: function ( container ) {
            var videoId = container.data('id');
            var iframe = '<iframe src="https://www.youtube.com/embed/'+videoId+'" frameborder="0" allowfullscreen="1">';
            container.html(iframe);
            container.find('iframe').trigger('resize');
        },

        pauseVideo: function ( container, videoType ) {
            var iframe, videoSrc, newSrc;
            switch (videoType){
                case 'youtube':
                    iframe = container.children('iframe');
                    if( iframe.length ){
                        videoSrc = iframe.attr('src');
                        newSrc = videoSrc.replace('?autoplay=1', '');
                        iframe.attr('src', newSrc);
                    }
                    break;
                case 'unknown':
                    container.get(0).stop();
                    container.get(0).currentTime = 0;
                    break;
                case 'vimeo':
                    videoSrc = container.attr('src');
                    newSrc = videoSrc.replace('?autoplay=1', '');
                    container.attr('src', newSrc);
                    break;
            }
        },

        playVideo: function ( container, videoType ) {
            var videoSrc, newSrc, iframe;
            switch (videoType){
                case 'youtube':
                    iframe = container.find('iframe');
                    videoSrc = iframe.attr('src');
                    newSrc = videoSrc + '?autoplay=1';
                    iframe.attr('src', newSrc);
                    break;
                case 'unknown':
                    container.get(0).play();
                    break;
                case 'vimeo':
                    videoSrc = container.attr('src');
                    newSrc = videoSrc + '?autoplay=1';
                    container.attr('src', newSrc);
                    break;
            }
        },

        loadCarousel: function () {
            $('#myCarousel').carousel({
                interval: false
            });

            $(document).on('click', '[id^=carousel-selector-]', function () {
                var id = $(this).attr('data-id');
                var object = $(this);
                $.thmedia.showCarouselItem(id, object);
            });
        },

        showCarouselItem: function (id, clickItem) {
            var thisItem = $('.slide-number-' + id);


            $('.themotion-playlist-item').removeClass('themotion-playlist-playing');
            clickItem.addClass('themotion-playlist-playing');
            $('.item').removeClass('active');

            var lastItem = lastItemPlayingId !== -1 ? $('.slide-number-' + lastItemPlayingId) : false;
            if( lastItem ){
                var lastYtContainer = lastItem.children('.youtube-player');
                if( lastYtContainer.length ) {
                    $.thmedia.pauseVideo(lastYtContainer, 'youtube');
                } else {
                    var video = lastItem.find('video');
                    if( video.length ) {
                        $.thmedia.pauseVideo( video, 'unknown' );
                    }

                    var iframe = lastItem.find('iframe');
                    if( iframe.length ) {
                        $.thmedia.pauseVideo( iframe, 'vimeo' );
                    }
                }
            }
            thisItem.addClass('active');

            var videoType = clickItem.data('type');
            switch (videoType){
                case 'youtube':
                    var ytContainer = thisItem.find('.youtube-player');
                    if( ytContainer.length && ( !$.trim( ytContainer.html() ).length || ytContainer.find('img').length ) ) {
                        $.thmedia.renderVideo(ytContainer);
                    }
                    if( ytContainer.length ) {
                        $.thmedia.playVideo(ytContainer, 'youtube');
                        lastItemPlayingId = id;
                    } else {
                        lastItemPlayingId = -1;
                    }
                    break;
                case 'unknown':
                    var embedVideo = thisItem.find('video');
                    if( embedVideo.length ){
                        $.thmedia.playVideo( embedVideo, videoType );
                        lastItemPlayingId = id;
                    } else {
                        lastItemPlayingId = -1;
                    }
                    break;
                case 'vimeo':
                    var vimeoVideo = thisItem.find('iframe');
                    if( vimeoVideo.length ){
                        $.thmedia.playVideo( vimeoVideo, videoType );
                        lastItemPlayingId = id;
                    } else {
                        lastItemPlayingId = -1;
                    }
                    break;
            }


        }
    };

    $.thmedia.init();
});