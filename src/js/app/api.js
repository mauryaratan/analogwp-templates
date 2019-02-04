const { apiFetch } = wp;
const { decodeEntities } = wp.htmlEntities;

export async function markFavorite( id, favorite = true ) {
	return await apiFetch( {
		path: '/agwp/v1/mark_favorite',
		method: 'post',
		data: {
			template_id: id,
			favorite,
		},
	} ).then( response => response );
}

export async function requestTemplateList() {
	return await apiFetch( { path: '/agwp/v1/templates' } ).then(
		response => response
	);
}

export async function requestDirectImport( template, withPage = false ) {
	return await apiFetch( {
		path: '/agwp/v1/import/elementor/direct',
		method: 'post',
		data: {
			template,
			with_page: withPage,
		},
	} ).then( response => {
		return response;
	} );
}

export async function requestImportLayout( template ) {
	const editorId =
		'undefined' !== typeof ElementorConfig ? ElementorConfig.post_id : false;

	apiFetch( {
		path: '/agwp/v1/import/elementor',
		method: 'post',
		data: {
			template_id: template.id,
			editor_post_id: editorId,
		},
	} ).then( data => {
		const parsedTemplate = JSON.parse( data );

		if ( typeof elementor !== 'undefined' ) {
			const model = new Backbone.Model( {
				getTitle: function getTitle() {
					return 'Test';
				},
			} );

			elementor.channels.data.trigger( 'template:before:insert', model );
			for ( let i = 0; i < parsedTemplate.content.length; i++ ) {
				elementor.getPreviewView().addChildElement( parsedTemplate.content[ i ] );
			}
			elementor.channels.data.trigger( 'template:after:insert', {} );
			window.analogModal.hide();
		}
	} );
}

export async function getSettings() {
	return await apiFetch( { path: '/agwp/v1/get/settings' } ).then(
		response => response
	);
}

export async function requestSettingUpdate( key, value ) {
	if ( ! key || ! value ) {
		console.warn('No key/value pair found to update settings.'); // eslint-disable-line
		return false;
	}

	return await apiFetch( {
		path: '/agwp/v1/update/settings',
		method: 'POST',
		data: {
			key,
			value,
		},
	} ).then( response => response );
}

export async function requestLicenseInfo( action = 'check' ) {
	return await apiFetch( {
		path: '/agwp/v1/license',
		method: 'post',
		data: {
			action,
		},
	} ).then( response => {
		return response;
	} );
}

export async function getLicenseStatus() {
	return await apiFetch( { path: '/agwp/v1/license/status' } ).then(
		response => response
	);
}
