<?php
/**
 * Loop item title
 */

if ( 'yes' !== $this->get_attr( 'show_title' ) ) {
	return;
}

$title_length = -1;
$title_ending = $this->get_attr( 'title_trimmed_ending_text' );

if ( filter_var( $this->get_attr( 'title_trimmed' ), FILTER_VALIDATE_BOOLEAN ) ) {
	$title_length = $this->get_attr( 'title_length' );
}

jet_elements()->utility()->attributes->get_title( array(
	'class'  => 'entry-title',
	'html'   => '<h4 %1$s><a href="%2$s">%4$s</a></h4>',
	'length' => $title_length,
	'ending' => $title_ending,
	'echo'   => true,
) );
