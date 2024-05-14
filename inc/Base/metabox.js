jQuery(document).ready( function($) {
	var mediaUploader;

	$( 'upload-button' ).click(function(e) {
		e.preventDefault();
		if( mediaUploader ){
			mediaUploader.open()
			return;
		}
		mediaUploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose a Profile Picture',
			button: {
				text: 'Choose picture'
			},
			multiple: false
		});	
	});
});