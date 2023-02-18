(function($){
	"use strict";
	
	function gdlr_core_sidebar_ajax( options ){
		var settings = $.extend({
			error: function(jqXHR, textStatus, errorThrown){
				gdlr_core_alert_box({ status: 'failed', head: gdlr_core_sidebar_generator.error_head, message: gdlr_core_sidebar_generator.error_message });
				
				// for displaying the debug text
				console.log(jqXHR, textStatus, errorThrown);
			},
			success: function(data){
				// default to adding sidebar action
				if( data.status == 'success' ){
					location.reload();
				}else if( data.status == 'failed' ){
					gdlr_core_alert_box({status: data.status, head: data.head, message: data.message});		
				}
			}
		}, options);
		
		$.ajax({
			type: 'POST',
			url: gdlr_core_sidebar_generator.ajaxurl,
			data: settings.data,
			dataType: 'json',
			error: settings.error,
			success: settings.success
		});			
	}
	
	$(document).ready(function(){
		
		var widget_right = $('.block-editor-block-list__layout.is-root-container');
		
		// initiate the instance
		var widget_form = $('<form class="gdlr-core-sidebar-generator-wrapper">\
				<div class="gdlr-core-sidebar-generator-title">' + gdlr_core_sidebar_generator.title_text + '</div>\
				<input type="text" name="sidebar_name" />\
				<input type="hidden" name="security" value="' + gdlr_core_sidebar_generator.nonce + '" />\
				<input type="hidden" name="action" value="gdlr_core_add_sidebar" />\
				<input type="submit" value="' + gdlr_core_sidebar_generator.add_new_text + '" />\
			</form>').insertAfter(widget_right);

		// action to add new sidebar 
		widget_form.submit(function(){
			gdlr_core_sidebar_ajax({ data: $(this).serialize() });
			return false;
		});
		
		var t = setInterval(function(){ 

			var widget_area = widget_right.find('[data-widget-area-id]');

			if( widget_area.length ){

				// add remove button for dynamic sidebar
				widget_right.find('[data-widget-area-id]').each(function(){
					var widget_item = $(this).closest('.wp-block-widget-area').parent();
					var widget_id = $(this).attr('data-widget-area-id');
					var ignores = ['footer-1', 'footer-2', 'footer-3', 'footer-4', 'gdlr-core-sidebar-preset', 'wp_inactive_widgets'];
					if( ignores.indexOf(widget_id) >= 0 ){
						return true;
					}

					var remove_button = $('<div class="gdlr-core-delete-sidebar"></div>');
					remove_button.click(function(){
						gdlr_core_confirm_box({success: function(){
							gdlr_core_sidebar_ajax({ 
								data:{
									'action':'gdlr_core_remove_sidebar', 
									'security':gdlr_core_sidebar_generator.nonce, 
									'sidebar_id':widget_id
								},
								success: function(data){
									if( data.status == 'success' ){
										widget_item.slideUp(250, function(){
											$(this).remove();
											// wpWidgets.saveOrder();
										});
									}else if( data.status == 'failed' ){
										gdlr_core_alert_box({status: data.status, head: data.head, message: data.message});	
									}
								}
							});	// gdlr-core-sidebar-ajax				
						}}); // confirm box
						
						return false;
					}); // remove button
					
					widget_item.find('.components-panel__body-title').append(remove_button);
				});

				clearTimeout(t);
			}

		}, 500);

		
		
			
	});

})(jQuery);	