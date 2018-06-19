/**
 * File customize-preview.js.
 *
 * Theme Customizer handling for the preview.
 */

import CustomizeUtil from './customize/customize-util';
import { findParent } from './common/utils';

( ( wp, data ) => {

	const customizeUtil = new CustomizeUtil( wp.customize );

	data = data || {};

	// Site title.
	customizeUtil.bindSettingValue( 'blogname', value => {
		Array.from( document.querySelectorAll( '.site-title a' ) ).forEach( element => {
			element.textContent = value;
		});
	});

	// Site description.
	customizeUtil.bindSettingValue( 'blogdescription', value => {
		Array.from( document.querySelectorAll( '.site-description' ) ).forEach( element => {
			element.textContent = value;
		});
	});

	// Sidebar mode.
	customizeUtil.bindSettingValue( 'sidebar_mode', value => {
		const classes = Object.keys( data.sidebarModeChoices ).map( setting => setting.replace( '_', '-' ) );
		const index   = classes.indexOf( value.replace( '_', '-' ) );

		value = value.replace( '_', '-' );

		if ( index > -1 ) {
			classes.splice( index, 1 );
			classes.forEach( cssClass => document.body.classList.remove( cssClass ) );
			document.body.classList.add( value );
		}
	});

	// Sidebar size.
	customizeUtil.bindSettingValue( 'sidebar_size', value => {
		const classes = Object.keys( data.sidebarSizeChoices ).map( setting => 'sidebar-' + setting );
		const index   = classes.indexOf( 'sidebar-' + value );

		value = 'sidebar-' + value;

		if ( index > -1 ) {
			classes.splice( index, 1 );
			classes.forEach( cssClass => document.body.classList.remove( cssClass ) );
			document.body.classList.add( value );
		}
	});

	// Navbar position.
	customizeUtil.bindSettingValue( 'navbar_position', value => {
		const classes = Object.keys( data.navbarPositionChoices ).map( setting => 'navbar-' + setting );
		const index   = classes.indexOf( 'navbar-' + value );

		value = 'navbar-' + value;

		if ( index > -1 ) {
			classes.splice( index, 1 );
			classes.forEach( cssClass => document.body.classList.remove( cssClass ) );
			document.body.classList.add( value );
		}
	});

	// Navbar Justify Content.
	customizeUtil.bindSettingValue( 'navbar_justify_content', value => {
		const classes = Object.keys( data.navbarJustifyContentChoices );
		const index   = classes.indexOf( value );
		const navbar  = document.getElementById( 'site-navbar' );

		if ( navbar && index > -1 ) {
			classes.splice( index, 1 );
			classes.forEach( cssClass => navbar.classList.remove( cssClass ) );
			navbar.classList.add( value );
		}
	});

	// Top Bar Justify Content.
	customizeUtil.bindSettingValue( 'top_bar_justify_content', value => {
		const classes = Object.keys( data.topBarJustifyContentChoices );
		const index   = classes.indexOf( value );
		const topBar  = document.getElementById( 'site-top-bar' );

		if ( topBar && index > -1 ) {
			classes.splice( index, 1 );
			classes.forEach( cssClass => topBar.classList.remove( cssClass ) );
			topBar.classList.add( value );
		}
	});

	// Bottom Bar Justify Content.
	customizeUtil.bindSettingValue( 'bottom_bar_justify_content', value => {
		const classes   = Object.keys( data.bottomBarJustifyContentChoices );
		const index     = classes.indexOf( value );
		const bottomBar = document.getElementById( 'site-bottom-bar' );

		if ( bottomBar && index > -1 ) {
			classes.splice( index, 1 );
			classes.forEach( cssClass => bottomBar.classList.remove( cssClass ) );
			bottomBar.classList.add( value );
		}
	});

	// Wide footer widget area.
	customizeUtil.bindSettingValue( 'wide_footer_widget_area', value => {
		Array.from( document.querySelectorAll( '.footer-widget-column' ) ).forEach( element => {
			if ( value === element.id ) {
				element.classList.add( 'footer-widget-column-wide' );
			} else {
				element.classList.remove( 'footer-widget-column-wide' );
			}
		});
	});

	wp.customize.selectiveRefresh.partialConstructor.SuperAwesomeThemePostPartial = wp.customize.selectiveRefresh.Partial.extend({
		placements: function() {
			var partial = this, selector;

			selector = partial.params.selector || '';
			if ( selector ) {
				selector += ', ';
			}
			selector += '[data-customize-partial-id="' + partial.id + '"]';

			return Array.from( document.querySelectorAll( selector ) ).map( element => {
				return new wp.customize.selectiveRefresh.Placement({
					partial: partial,
					container: element,
					context: {
						post_id: parseInt( findParent( element, 'article.hentry' ).id.replace( 'post-', '' ), 10 ),
					},
				});
			});
		},
	});
})( window.wp, window.themeCustomizeData );
