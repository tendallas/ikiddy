$(document).ready(function() {
	$( "#searchQuery" ).autocomplete({
		  minLength: 3,
		  source: function(input, output) {
		      $.ajax({
		      	type: "GET",
		      	cache: false,
		        url: "/search",			        
		        data: {
		          query: input.term
		        },
		        dataType: 'json',
		        success: function(data) {
		        	output(data);
				}
		      });
		    }
	});
});

