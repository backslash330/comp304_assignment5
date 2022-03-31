// use javascript to limit the options of search_operator to =
// when the search_type is 'name' or 'artist'

// set the search_operator to =
// when the search_type is 'name' or 'artist'
// using jQuery
$(document).ready(function() {
    // echo succes  
    $('#search_type').change(function() {
        if ($('#search_type').val() == 'name' || $('#search_type').val() == 'artist') {
            // limit the options to =
            $('#search_operator').html('<option value="=">=</option>');
        } else {
            // enable all options (=, <, >, <=, >=)
            $('#search_operator').html('<option value="=">=</option><option value="<">&lt;</option><option value=">">&gt;</option><option value="<=">&lt;=</option><option value=">=">&gt;=</option>');
        }
    });
});
