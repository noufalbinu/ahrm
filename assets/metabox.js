
jQuery(document).ready( function($){

	var mediaUploader;

	$('#upload_button').on('click'),function(e) {
      	e.preventDefault();
      	if( mediaUploader )
      		mediaUploader.open();
      	return
      }

      mediaUploader = wp.media.frames.file_frame =wp.media({
      	title: 'fsghlju',
      	button: {
      		text: 'shgkljh'
      	},
      	multiple:false

      	});
    });
});



