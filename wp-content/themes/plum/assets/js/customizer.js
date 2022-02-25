/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	wp.customize( 'plum_page_title', function( value ) {
		value.bind( function ( to ) {
			$( 'body.home.page header.entry-header' ).toggle();
		});
	});
	wp.customize( 'plum_disable_comments', function( value ) {
		value.bind( function( to ) {
			$( '#comments' ).toggle();
		});
	} );
	wp.customize( 'plum_footer_text', function( value ) {
		value.bind( function ( to ) {
			$( '.custom-info').text( to );
		});
	});
	
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '#text-title-desc' ).css({
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute'
				});
				// Add class for different logo styles if title and description are hidden.
				$( 'body' ).addClass( 'title-tagline-hidden' );
			} else {
				
				$( '#text-title-desc' ).css({
					clip: 'auto',
					position: 'relative'
				});
				$( '.site-branding a' ).css({
					color: to
				});
				// Add class for different logo styles if title and description are visible.
				$( 'body' ).removeClass( 'title-tagline-hidden' );
			}
		});
	});
	
	wp.customize( 'plum_header_desccolor', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).css( 'color', to );
		} );
	} );
	
	wp.customize( 'plum_social_icon_style', function( value ) {
		value.bind( function( to ) {
			var	ChangeClass	=	'common ' + to;
			jQuery( '.social-icons a' ).attr( 'class', ChangeClass );
		});
	});
	
	var count = [1,2,3,4,5,6];
    jQuery.each ( count, function( index ) {
        var socialCount	=	index + 1;
        wp.customize( 'plum_social_' + socialCount, function( value ) {
            value.bind( function( to ) {
                var ClassNew	=	'fab fa-' + to;
                jQuery('.social-icons' ).find( 'i:eq(' + (socialCount - 1) +')' ).attr( 'class', ClassNew );
            });
        });
	});

    /*---- Sidebar Align ----*/

    wp.customize( 'plum_blog_sidebar_layout', function( value ) {
        value.bind( function( to ) {
            if ( to == 'sidebarleft') {
                jQuery('body.blog #primary').css('float', 'right');
            } else {
                jQuery('body.blog #primary').css('float', 'left');
            }
        });
    });

    wp.customize( 'plum_front_sidebar_layout', function( value ) {
        value.bind( function( to ) {
            if ( to == 'sidebarleft') {
                jQuery('body.home.page #primary-mono').css('float', 'right');
            } else {
                jQuery('body.home.page #primary-mono').css('float', 'left');
            }
        });
    });

} )( jQuery );
