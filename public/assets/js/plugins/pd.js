$('.glr').on('mouseover', '.glri', function() {
	var img = $(this).find('img').attr('src');
	$('.sptlt img').attr('src', img);
});