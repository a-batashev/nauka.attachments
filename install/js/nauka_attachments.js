BX.addCustomEvent('OnEditorInitedBefore', function() {
	
	console.log('test', BX('form_element_1_form'));
	
	var _this = this;
	this.AddButton({
		src: '/bitrix/images/nauka.attachments/nauka_attachments.png', // icon
		id: 'nauka_attachments', // button id
		name: BX.message('NAUKA_ATTACHMENTS_BUTTON_TITLE'), // button title
		handler: function() {
			BX.ajax({
				method: 'POST',
				url: '/bitrix/admin/nauka_attachments_list.php',
				dataType: 'html',
				data: { 'ID': text },
				onsuccess: function(response) {
					if (response.length > 0) {
						_this.SetContent(response, true);
					}
				}
			});
			
			
			$html = '<p>TEST</p>'
			_this.selection.InsertHTML($html);
		}
	});
});
