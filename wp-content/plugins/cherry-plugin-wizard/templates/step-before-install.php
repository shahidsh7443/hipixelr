<?php
/**
 * 1st wizard step template
 */
?>
<h2><?php cherry_plugin_wizard_interface()->before_import_title(); ?></h2>
<div class="cherry-plugin-wizard-msg"><?php esc_html_e( 'Each skin comes with custom demo content and predefined set of plugins. Depending upon the selected skin the wizard will install required plugins and some demo posts and pages', 'cherry-plugin-wizard' ); ?></div>
<div class="cherry-plugin-wizard-skins"><?php
	$skins = cherry_plugin_wizard_interface()->get_skins();

	if ( ! empty( $skins ) ) {

		foreach ( $skins as $skin => $skin_data ) {
			cherry_plugin_wizard_interface()->the_skin( $skin, $skin_data );
			cherry_plugin_wizard()->get_template( 'skin-item.php' );
		}

	}

?></div>