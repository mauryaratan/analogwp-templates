jQuery( window ).on( 'elementor/frontend/init', () => {

	elementorFrontend.hooks.addAction( 'frontend/element_ready/html.default', function( $scope ) {
		if( $scope.hasClass( 'sk-list' ) ) {
			$scope.find('ol li:not(:has(i,svg))').addClass('sk-custom-count');
			$scope.find('ul li:not(:has(i,svg))').addClass('sk-custom-marker');
		}
	} );

} );
