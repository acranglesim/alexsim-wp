<?php
/*
** Template to Render Social Icons on Top Bar
*/
$social_icon_styles = esc_html(get_theme_mod('plum_social_icon_style','none'));
for ($i = 1; $i < 7; $i++) : 
	$social = esc_html(get_theme_mod('plum_social_'.$i));
	if ( ($social != 'none') && ($social != '') ) : ?>
	<a class="common <?php echo $social_icon_styles; ?>" href="<?php echo esc_url( get_theme_mod('plum_social_url'.$i) ); ?>"><i class="fab fa-<?php echo $social; ?>"></i></a>
	<?php endif;

endfor; ?>