$(function() {
    
    $("#save-btn").on("click", function(e) {
        
        if ($("input[name='Profile[public_fields][]']:checked").length == 0) {
            // add hidden input to fill attribute in the Model
            $("#profile-form").append('<input type="hidden" name="Profile[public_fields]" value="" />');
        }
        
        $("#profile-form").submit();
    });
    
});