
    $(document).ready(function() {
		$('.close-modal').click(function () {
		    $('.bg-modal-product').hide();
		    $('.bg-modal-client').hide();
		    $('.bg-modal-editClient').hide();
		    $('.bg-modal-editProduct').hide();
		    $('html').css('overflow','visible');
		});
	});