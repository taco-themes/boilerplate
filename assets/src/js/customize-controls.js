/**
 * File customize-controls.js.
 *
 * Theme Customizer handling for the interface.
 */

( ( wp, data ) => {
	const api = wp.customize;

	data = data || {};

	function updateAvailableWidgets( collection, expanded ) {
		collection.each( widget => {
			if ( widget && ! data.inlineWidgets.includes( widget.get( 'id_base' ) ) ) {
				widget.set( 'is_disabled', expanded );
			}
		});
	}

	api.bind( 'ready', () => {
		if ( data.inlineWidgetAreas.length ) {
			api.section.each( section => {
				if ( 'sidebar' !== section.params.type ) {
					return;
				}

				if ( ! data.inlineWidgetAreas.includes( section.params.sidebarId ) ) {
					return;
				}

				section.expanded.bind( expanded => {
					updateAvailableWidgets(
						api.Widgets.availableWidgetsPanel.collection,
						expanded
					);
				});
			});
		}
	});

} )( window.wp, window.themeCustomizeData );
