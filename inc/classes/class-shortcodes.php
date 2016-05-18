<?php
/**
 * Odin_Shortcodes class.
 *
 * Built Shortcodes.
 *
 * @package  Odin
 * @category Shortcodes
 * @author   WPBrasil
 * @version  2.1.4
 */
class Odin_Shortcodes {

	/**
	 * Construct Post Type.
	 */
	public function __construct() {
		add_shortcode( 'button', array( $this, 'button' ) );
		add_shortcode( 'button_group', array( $this, 'button_group' ) );
		add_shortcode( 'alert', array( $this, 'alert' ) );
		add_shortcode( 'label', array( $this, 'label' ) );
		add_shortcode( 'badge', array( $this, 'badge' ) );
		add_shortcode( 'icon', array( $this, 'icon' ) );
		add_shortcode( 'well', array( $this, 'well' ) );
		add_shortcode( 'table', array( $this, 'table' ) );
		add_shortcode( 'row', array( $this, 'row' ) );
		add_shortcode( 'col', array( $this, 'col' ) );
		add_shortcode( 'progress', array( $this, 'progress' ) );
		add_shortcode( 'panel', array( $this, 'panel' ) );
		add_shortcode( 'panel_heading', array( $this, 'panel_heading' ) );
		add_shortcode( 'panel_body', array( $this, 'panel_body' ) );
		add_shortcode( 'panel_footer', array( $this, 'panel_footer' ) );
		add_shortcode( 'tabs', array( $this, 'tabs' ) );
		add_shortcode( 'tab', array( $this, 'tab' ) );
		add_shortcode( 'tab_dropdown', array( $this, 'tab_dropdown' ) );
		add_shortcode( 'tab_contents', array( $this, 'tab_contents' ) );
		add_shortcode( 'tab_content', array( $this, 'tab_content' ) );
		add_shortcode( 'accordions', array( $this, 'accordions' ) );
		add_shortcode( 'accordion', array( $this, 'accordion' ) );
		add_shortcode( 'map', array( $this, 'map' ) );
		add_shortcode( 'tooltip', array( $this, 'tooltip' ) );
		add_shortcode( 'qrcode', array( $this, 'qrcode' ) );
		add_shortcode( 'clear', array( $this, 'clear' ) );
	}

	/**
	 * Button shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Button HTML.
	 */
	function button( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type'      => 'default',
			'size'      => false,
			'link'      => '#',
			'class'     => false,
			'tooltip'   => false,
			'direction' => 'top'
		), $atts ) );

		$html = '<a href="' . esc_url( $link ) . '" class="btn';
		$html .= ( $type ) ? ' btn-' . esc_attr( $type ) : '';
		$html .= ( $size ) ? ' btn-' . esc_attr( $size ) : '';
		$html .= ( $class ) ? ' ' . esc_attr( $class ) : '';
		$html .= ( $tooltip ) ? ' odin-tooltip' : '';
		$html .= '"';
		$html .= ( $tooltip ) ? ' data-placement="' . esc_attr( $direction ) . '" data-toggle="tooltip" data-original-title="' . esc_attr( $tooltip ) . '"' : '';
		$html .= '>';
		$html .= do_shortcode( $content );
		$html .= '</a>';

		return $html;
	}

	/**
	 * Button Group shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Button Group HTML.
	 */
	function button_group( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type'  => 'group',
			'size'  => false,
			'justified' => false
		), $atts ) );

		$html = '<div class="btn-' . esc_attr( $type ) . '';
		$html .= ( $size ) ? ' btn-group-' . esc_attr( $size ) : '';
		$html .= ( $justified ) ? ' btn-group-justified' : '';
		$html .= '">';
		$html .= str_replace( '<br />', '', do_shortcode( $content ) );
		$html .= '</div>';

		return $html;
	}

	/**
	 * Alert shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Alert HTML.
	 */
	function alert( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type'  => 'info',
			'close' => false
		), $atts ) );

		$html = '<div class="alert alert-' . esc_attr( $type );
		$html .= ( $close ) ? ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' : '">';
		$html .= do_shortcode( $content );
		$html .= '</div>';

		return $html;
	}

	/**
	 * Label shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Label HTML.
	 */
	function label( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type' => 'default'
		), $atts ) );

		return '<span class="label label-' . esc_attr( $type ) . '">' . do_shortcode( $content ) . '</span>';
	}

	/**
	 * Badge shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Badge HTML.
	 */
	function badge( $atts, $content = null ) {
		return '<span class="badge">' . do_shortcode( $content ) . '</span>';
	}

	/**
	 * Icon shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 *
	 * @return string          Icon HTML.
	 */
	function icon( $atts ) {
		extract( shortcode_atts( array(
			'type' => 'thumbs-up'
		), $atts ) );

		return '<span class="glyphicon glyphicon-' . esc_attr( $type ) . '"></span>';
	}

	/**
	 * Well shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Well HTML.
	 */
	function well( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'size' => false
		), $atts ) );

		$html = '<div class="well';
		$html .= ( $size ) ? ' well-' . esc_attr( $size ) . '">' : '">';
		$html .= do_shortcode( $content );
		$html .= '</div>';

		return $html;
	}

	/**
	 * Table shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Table HTML.
	 */
	function table( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type'   => false,
			'border' => false,
			'cols'   => '',
			'rows'   => ''
		), $atts ) );

		$html = '<table class="table';
		$html .= ( $type ) ? ' table-' . esc_attr( $type ) : '';
		$html .= ( $border ) ? ' table-bordered">' . PHP_EOL : '">' . PHP_EOL;
		$html .= '<thead>' . PHP_EOL;
		$html .= '<tr>' . PHP_EOL;

		foreach ( explode( ',', $cols ) as $col ) {
			$html .= '<th>' . $col . '</th>' . PHP_EOL;
		}

		$html .= '</tr>' . PHP_EOL;
		$html .= '</thead>' . PHP_EOL;
		$html .= '<tbody>' . PHP_EOL;

		foreach ( explode( '|', $rows ) as $row ) {
			$html .= '<tr>' . PHP_EOL;

			foreach ( explode( ',', $row ) as $item ) {
				$html .= '<td>' . $item . '</td>' . PHP_EOL;
			}

			$html .= '</tr>' . PHP_EOL;
		}

		$html .= '</tbody>' . PHP_EOL;
		$html .= '</table>' . PHP_EOL;

		return $html;
	}

	/**
	 * Row shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Row HTML.
	 */
	function row( $atts, $content = null ) {
		return '<div class="row">' . str_replace( 'div><br />', 'div>', do_shortcode( $content ) ) . '</div>';
	}

	/**
	 * Col shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Col HTML.
	 */
	function col( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'class' => false
		), $atts ) );

		$html = '<div';
		$html .= ( $class ) ? ' class="' . esc_attr( $class ) . '"' : '';
		$html .= '>';
		$html .= do_shortcode( $content );
		$html .= '</div>';

		return $html;
	}

	/**
	 * Progress shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Progress HTML.
	 */
	function progress( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type'  => false,
			'class' => false,
			'value' => 50,
			'max'   => 100,
			'min'   => 0
		), $atts ) );

		$html = '<div class="progress';
		$html .= ( $class ) ? ' ' . esc_attr( $class ) . '">' : '">';
		$html .= '<div class="progress-bar';
		$html .= ( $type ) ? ' progress-bar-' . esc_attr( $type ) . '" ' : '" ';
		$html .= 'role="progressbar" ';
		$html .= 'aria-valuenow="' . esc_attr( $value ) . '" ';
		$html .= 'aria-valuemin="' . esc_attr( $min ) . '" ';
		$html .= 'aria-valuemax="' . esc_attr( $max ) . '" ';
		$html .= 'style="width: ' . esc_attr( $value ) . '%">';
		$html .= ( $content ) ? '<span class="sr-only">' . $content . '</span>' : '';
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Panel shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Panel HTML.
	 */
	function panel( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'type'  => 'default'
		), $atts ) );

		return '<div class="panel panel-' . esc_attr( $type ) . '">' . str_replace( '<br />', '', do_shortcode( $content ) ) . '</div>';
	}

	/**
	 * Panel Heading shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Panel Heading HTML.
	 */
	function panel_heading( $atts, $content = null ) {
		return '<div class="panel-heading">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * Panel Body shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Panel Body HTML.
	 */
	function panel_body( $atts, $content = null ) {
		return '<div class="panel-body">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * Panel Footer shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Panel Footer HTML.
	 */
	function panel_footer( $atts, $content = null ) {
		return '<div class="panel-footer">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * Tabs shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Tabs HTML.
	 */
	function tabs( $atts, $content = null ) {
		return '<ul class="nav nav-tabs odin-tabs">' . str_replace( '<br />', '', do_shortcode( $content ) ) . '</ul>';
	}

	/**
	 * Tab shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Tab HTML.
	 */
	function tab( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'id'     => '',
			'active' => false
		), $atts ) );

		$html = '<li';
		$html .= ( $active ) ? ' class="active"' : '';
		$html .= '>';
		$html .= '<a href="#' . esc_attr( $id ) . '">';
		$html .= do_shortcode( $content );
		$html .= '</a>';
		$html .= '</li>';

		return $html;
	}

	/**
	 * Tab Dropdown shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Tab Dropdown HTML.
	 */
	function tab_dropdown( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' => '',
		), $atts ) );

		$id = sanitize_title( $title );

		$html = '<li class="dropdown">';
		$html .= '<a href="#" id="' . esc_attr( $id ) . '" class="dropdown-toggle" data-toggle="dropdown">';
		$html .= $title;
		$html .= ' <b class="caret"></b>';
		$html .= '</a>';
		$html .= '<ul class="dropdown-menu" role="menu" aria-labelledby="' . esc_attr( $id ) . '">';
		$html .= do_shortcode( $content );
		$html .= '</ul>';
		$html .= '</li>';

		return $html;
	}

	/**
	 * Tabs Contents shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Tabs Contents HTML.
	 */
	function tab_contents( $atts, $content = null ) {
		return '<div class="tab-content">' . str_replace( '<br />', '', do_shortcode( $content ) ) . '</div>';
	}

	/**
	 * Tabs Content shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Tabs Content HTML.
	 */
	function tab_content( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'id' => '',
			'active' => false,
		), $atts ) );

		$html = '<div class="tab-pane';
		$html .= ( $active ) ? ' active"' : '"';
		$html .= ' id="' . esc_attr( $id ) . '">';
		$html .= do_shortcode( $content );
		$html .= '</div>';

		return $html;
	}

	/**
	 * Accordions shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Accordions HTML.
	 */
	function accordions( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'id' => 'odin-accordion',
		), $atts ) );

		$html = '<div class="panel-group odin-accordion" id="' . esc_attr( $id ) . '">';
		$html .= str_replace( '<br />', '', do_shortcode( $content ) );
		$html .= '</div>';

		return $html;
	}

	/**
	 * Accordion shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Accordion HTML.
	 */
	function accordion( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'id'     => 'odin-accordion',
			'title'  => '',
			'type'   => 'default',
			'active' => false
		), $atts ) );

		$accordion = sanitize_title( $title );

		$html = '<div class="panel panel-' . esc_attr( $type ) . '">';
		$html .= '<div class="panel-heading"><h4 class="panel-title">';
		$html .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="#' . esc_attr( $id ) . '" href="#' . esc_attr( $accordion ) . '">';
		$html .= $title;
		$html .= '</a>';
		$html .= '</h4></div>';
		$html .= '<div id="' . esc_attr( $accordion ) . '" class="panel-collapse collapse';
		$html .= ( $active ) ? ' in">' : '">';
		$html .= '<div class="panel-body">';
		$html .= do_shortcode( $content );
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Tooltip shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Tooltip HTML.
	 */
	function tooltip( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title'     => '',
			'link'      => '#',
			'direction' => 'top'
		), $atts ) );

		$html = '<a class="odin-tooltip" data-original-title="' . esc_attr( $title ) . '" href="' . esc_url( $link ) .'" data-placement="' . esc_attr( $direction ) . '" data-toggle="tooltip">';
		$html .= do_shortcode( $content );
		$html .= '</a>';

		return $html;
	}

	/**
	 * Google Maps shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 * @param  string $content Content.
	 *
	 * @return string          Google Maps HTML.
	 */
	function map( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'id'                => 'odin_map',
			'latitude'          => '0',
			'longitude'         => '0',
			'zoom'              => '10',
			'width'             => '600',
			'height'            => '400',
			'maptype'           => 'ROADMAP',
			'address'           => false,
			'kml'               => false,
			'kmlautofit'        => true,
			'marker'            => false,
			'markerimage'       => false,
			'traffic'           => false,
			'bike'              => false,
			'fusion'            => false,
			'infowindow'        => false,
			'infowindowdefault' => true,
			'hidecontrols'      => 'false',
			'scale'             => 'false',
			'scrollwheel'       => 'true'
		), $atts ) );

		// JS var.
		$id = str_replace( '-', '_', $id );

		$html = '<div class="odin-map" id="' . esc_attr( $id ) . '" style="width: ' . esc_attr( $width ) . 'px; height: ' . esc_attr( $height ) . 'px;"></div>';

		$js = '<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>';
		$html .= apply_filters( 'odin_map_shortcode_js_' . $id, $js );
		$html .= '<script type="text/javascript">var latlng = new google.maps.LatLng(' . esc_js( $latitude ) . ', ' . esc_js($longitude ) . ');var myOptions = {zoom: ' . esc_js( $zoom ) . ',center: latlng,scrollwheel: ' . esc_js( $scrollwheel ) .',scaleControl: ' . esc_js( $scale ) .',disableDefaultUI: ' . esc_js( $hidecontrols ) .',mapTypeId: google.maps.MapTypeId.' . esc_js( $maptype ) . '};var ' .esc_js(  $id ) . ' = new google.maps.Map(document.getElementById("' . esc_js( $id ) . '"), myOptions);';

		// Kml.
		if ( $kml ) {
			if ( $kmlautofit ) {
				$html .= 'var kmlLayerOptions = {preserveViewport:true};';
			} else {
				$html .= 'var kmlLayerOptions = {preserveViewport:false};';
			}

			$html .= 'var kmllayer = new google.maps.KmlLayer("' . esc_js( html_entity_decode( $kml ) ) . '", kmlLayerOptions);
				kmllayer.setMap(' . esc_js( $id ) . ');';
		}

		// Traffic.
		if ( $traffic ) {
			$html .= 'var trafficLayer = new google.maps.TrafficLayer();trafficLayer.setMap(' . esc_js( $id ) . ');';
		}

		// Bike.
		if ( $bike ) {
			$html .= 'var bikeLayer = new google.maps.BicyclingLayer();bikeLayer.setMap(' . esc_js( $id ) . ');';
		}

		// Fusion tables.
		if ( $fusion ) {
			$html .= 'var fusionLayer = new google.maps.FusionTablesLayer(' . esc_js( $fusion ) . ');fusionLayer.setMap(' . esc_js( $id ) . ');';
		}

		// Address.
		if ( $address ) {
			$html .= 'var geocoder_' . esc_js( $id ) . ' = new google.maps.Geocoder();var address = \'' . esc_js( $address ) . '\';geocoder_' . $id . '.geocode( { \'address\': address}, function(results, status) { if (status == google.maps.GeocoderStatus.OK) {' . esc_js( $id ) . '.setCenter(results[0].geometry.location);';

			if ( $marker ) {
				// Add custom image.
				if ( $markerimage ) {
					$html .= 'var image = "'. esc_js( $markerimage ) .'";';
				}

				$html .= 'var marker = new google.maps.Marker({ map: ' . esc_js( $id ) . ',';
				if ( $markerimage ) {
					$html .= 'icon: image,';
				}

				$html .= 'position: ' . esc_js( $id ) . '.getCenter() });';

				// Infowindow
				if ( $infowindow ) {
					// First convert and decode html chars.
					$thiscontent = htmlspecialchars_decode( $infowindow );
					$html .= 'var contentString = "' . esc_js( $thiscontent ) . '";var infowindow = new google.maps.InfoWindow({content: contentString});google.maps.event.addListener(marker, \'click\', function() { infowindow.open(' . esc_js( $id ) . ',marker);});';

					// Infowindow default
					if ( $infowindowdefault ) {
						$html .= 'infowindow.open(' . esc_js( $id ) . ', marker);';
					}
				}
			}

			$html .= '} else { document.getElementById(' . esc_js( $id ) . ').style.display = "block"; }});';
		}

		// Marker: show if address is not specified.
		if ( $marker && $address ) {
			// Add custom image.
			if ( $markerimage ) {
				$html .= 'var image = "'. esc_js( $markerimage ) .'";';
			}

			$html .= 'var marker = new google.maps.Marker({ map: ' . esc_js( $id ) . ',';

			if ( $markerimage ) {
				$html .= 'icon: image,';
			}

			$html .= 'position: ' . esc_js( $id ) . '.getCenter()});';

			// Infowindow.
			if ( $infowindow ) {
				$html .= 'var contentString = "' . esc_js( $infowindow ) . '";var infowindow = new google.maps.InfoWindow({content: contentString});google.maps.event.addListener(marker, \'click\', function() {infowindow.open(' . $id . ',marker);});';

				// Infowindow default
				if ( $infowindowdefault ) {
					$html .= 'infowindow.open(' . esc_js( $id ) . ',marker);';
				}
			}
		}

		$html .= '</script>';

		return $html;
	}

	/**
	 * QR Code shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 *
	 * @return string          QR Code HTML.
	 */
	function qrcode( $atts ) {
		extract( shortcode_atts( array(
			'data'  => '',
			'size'  => '150x150',
			'title' => '',
			'alt'   => '',
		), $atts ) );

		$url = 'http://api.qrserver.com/v1/create-qr-code/?data=' . rawurlencode( $data ) . '&size=' . $size;

		return '<img src="' . esc_url( $url ) . '" title="' . esc_attr( $title ) . '" alt="' . esc_attr( $alt ) . '" />';
	}

	/**
	 * Clear Float shortcode.
	 *
	 * @param  array  $atts    Shortcode attributes.
	 *
	 * @return string          Clear Float HTML.
	 */
	function clear( $atts ) {
		return '<br class="clear" />';
	}

}

new Odin_Shortcodes;
