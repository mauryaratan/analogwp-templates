( function( $ ) {
	elementor.on( 'document:loaded', function() {
		elementor.hooks.addAction( 'panel/open_editor/widget/icon-list', ( panel, model, view ) => {
			const settingsModel = model.get( 'settings' );

			settingsModel.on( 'change', ( changedModel ) => {
				console.log( changedModel );
			} );

		} );
	});
}( jQuery ) );