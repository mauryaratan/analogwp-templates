jQuery( window ).on( 'elementor/frontend/init', () => {

	elementorFrontend.hooks.addAction( 'frontend/element_ready/html.default', function( $scope ) {
		if( $scope.hasClass( 'sk-list' ) ) {
			// Remove numbering or bullet if list item have icon
			$scope.find( 'li i, li svg' )
				.parent( 'li' )
				.css( 'list-style', 'none' );
		}
	} );

} );
