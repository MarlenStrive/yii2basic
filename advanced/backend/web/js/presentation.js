$(function() {
    
    $("#save-btn").on("click", function(e) {
        
        var pageNumber = parseInt($('select[name="Presentation[image_preview]"] option:selected').val());
        var pageContent = $("#slides").contents().find("#page-" + pageNumber).get(0);
        
        html2canvas(pageContent, {
            width: 400,
            height: 400
        }).then(function(canvas) {
            
            var image = canvas.toDataURL("image/png");
            $("<textarea name='Presentation[image-preview-content]' class='hide'>" + image + "</textarea>")
                    .appendTo("#presentation-form");
            
            $("#presentation-form").submit();
        });
    });
    
});