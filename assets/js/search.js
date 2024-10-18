// ORIGINAL

// $(document).ready(function () {
//     // When user types in search input
//     $("#searchInput").on("keyup", function () {
//         // Get the search value
//         var value = $(this).val().toLowerCase();

//         // Filter the table rows based on the value
//         $("#customers_table tbody tr").filter(function () {
//             // Check if the text matches the search query
//             $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
//         });
//     });
// });

// NEW

// $(document).ready(function () {
//     // When user types in search input
//     $('#searchInput').on('keyup', function () {
//         var search = $(this).val();
        
//         // Make an AJAX request to search.php
//         $.post('core/ajax/search.php', {search: search}, function (data) {
//             $('.search-result').html(data);
//             if (search === "") {
//                 $('.search-result').html("");
//             }
//         });
//     });
// });


// COMBINE

$(document).ready(function () {
    // Search for home.php
    $('#searchInput').on('keyup', function () {
        var search = $(this).val();
        
        // Make an AJAX request to search.php for home
        $.post('core/ajax/search.php', {search: search}, function (data) {
            $('.search-result').html(data);
            if (search === "") {
                $('.search-result').html("");
            }
        });
    });

    // Search for admin_panel.php
    $('#adminSearchInput').on('keyup', function () {
        var value = $(this).val().toLowerCase();

        // Filter the table rows based on the value
        $("#customers_table tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});




// $(function(){
	
//     // the function pass the post var without form to search.php
// 	$('.search-input').keyup(function(){
// 		var search = $(this).val();
// 		$.post('core/ajax/search.php', {search:search}, function(data){
// 			$('.search-result').html(data);
// 			if(search == ""){
// 				$('.search-result').html("");
// 				$('.search-result li').click(function(){
// 					$('.search-result li').hide();
// 				});	
// 			}
// 		});
//     });
    



// });