BX.addCustomEvent('OnEditorInitedBefore', function() {
	var _this = this;
	this.AddButton({
		src: '/bitrix/images/nauka.attachments/nauka_attachments.png', // button icon
		id: 'nauka_attachments', // button id
		name: BX.message('NAUKA_ATTACHMENTS_BUTTON_TITLE'), // button title
		handler: function() { // button onclick
			
			// Take post data from URL
			var content_post = window.location.search.match(/((IBLOCK_ID|ID)=\d+)/g).join("&");
			
			var NaukaDialog = new BX.CDialog({
				title: BX.message('NAUKA_ATTACHMENTS_DIALOG_TITLE'),
				//content: "No files attached.", //BX.findChildByClassName(BX('tr_PROPERTY_5808'), 'adm-detail-content-cell-r'),
				content_url: '/bitrix/admin/nauka_attachments_list.php',
				content_post: content_post,
				width: 600,
				height: 600,
				buttons:
				[
					/*{
						title: BX.message('NAUKA_ATTACHMENTS_DIALOG_PASTE'),
						id: 'nauka_paste',
						action: function() {
							
							console.log(this);
							
							this.parentWindow.Close();
						},
					},*/
					BX.CDialog.prototype.btnClose
				]
			});
			NaukaDialog.Show();
			
			BX.bindDelegate(
				BX(NaukaDialog.GetContent()),
				'click',
				{
					className: 'insert-files'
				},
				function () {
					console.log(this);
					_this.selection.InsertHTML(this.innerHTML);
				}
			);
			
			//console.log(BX(NaukaDialog.GetContent()));
			
			
			//$html = '<p>TEST</p>'
			//_this.selection.InsertHTML($html);
		}
	});
});
