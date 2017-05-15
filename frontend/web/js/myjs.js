jQuery(document).ready(function () {
	

//Показать подкатегории
	$(document).on('click', '.rotate', function () {
		
        
		var picture_id = $(this).data('picture');

		

      $.ajax({
          type: "POST",
          url: '/picture/ajax-rotate',
			cache: false,
			data: {picture_id:picture_id},
			dataType: 'html',
			success: function(data){
			location.reload();
			
              }
            });

					 
    });
  

});
