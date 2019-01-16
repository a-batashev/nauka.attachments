BX.addCustomEvent('OnEditorInitedBefore', function() {
	var _this = this;
	this.AddButton({
		src: '/bitrix/images/nauka.attachments/nauka_attachments.png', // button icon
		id: 'nauka_attachments', // button id
		name: BX.message('NAUKA_ATTACHMENTS_BUTTON_TITLE'), // button title
		handler: function() { // button onclick

			// Take IBLOCK_ID and ID from URL
			var content_post = window.location.search.match(/((IBLOCK_ID|ID)=\d+)/g).join("&");

			var NaukaDialog = new BX.CDialog({
				title: BX.message('NAUKA_ATTACHMENTS_DIALOG_TITLE'),
				content_url: '/bitrix/admin/nauka_attachments_list.php',
				content_post: content_post,
				width: 640,
				buttons: [BX.CDialog.prototype.btnClose]
			});
			NaukaDialog.Show();

			BX.bindDelegate(
				BX(NaukaDialog.GetContent()),
				'click',
				{
					className: 'insert-file'
				},
				function() {
					var
						isImage = this.hasAttribute('data-image'),
						src = this.getAttribute('data-src'),
						filename = this.getAttribute('data-filename'),
						innerHtml = '';
					if (isImage) {
						innerHtml = '<img src="' + src + '" alt="' + filename + '" />';
					} else {
						innerHtml = '<a href="' + src + '">' + filename + '</a>';
					}
					_this.selection.InsertHTML(innerHtml);
				}
			);

		}
	});
});
