var existingTags = [];
function totalTags(){
    var tags = [];
    $('.tag:not(.makeTag)').each(function(){
        tags.push($(this).text());
    })
    $('#tagSend').val(JSON.stringify(tags));
    existingTags = tags;
    return tags;
}
$(function () {
    $("#postBox").jqte();
    // menu stuff
    $('.navbar-toggle-sidebar').click(function () {
        $('.navbar-nav').toggleClass('slide-in');
        $('.side-body').toggleClass('body-slide-in');
        $('#search').removeClass('in').addClass('collapse').slideUp(200);
    });

    function addTag(subject, newTag){
        // dont add existing tag
        tag = "tag"+(newTag?" new":"");
        console.log(tag);
        if(existingTags.indexOf("#"+subject)==-1){
            $('#tagPlace').append("<div class='"+tag+"'>"+
                                  "#"+subject+
                                  "</div>");
            totalTags();
        }
    }
    function addTagList(subject){
        // dont add existing tag
        $('#tagSelector').append("<div class='tag makeTag'>"+
                              "#"+subject+
                              "</div>");
    }


    //tags
    var existing = $("#tagSend").val();
    existing     = JSON.parse(existing);
    $(existing).each(function(){
        addTag(this);
    })
    $("#tagSend").val("");
    $('#tagEnter').bind("keypress", function(e) {
        if (e.keyCode == 13) {
            string      = $("#tagEnter").val();
            if(string.charAt(0) == "#"){
                string  = string.substr(1);
            }
            addTag(string, 1);
            $("#tagEnter").val("");
            return false;
        }
    });


    // delete tag on click
    $("#tagPlace").on("click", ".tag", function(){
        $(this).fadeOut(function(){
            if(!$(this).hasClass('new'))
                addTagList($(this).text().substr(1));
            $(this).remove();
            totalTags();
        });
    });

    $("#tagSelector").on("click", ".tag", function(){
        $(this).fadeOut(function(){
            $(this).remove();
            addTag($(this).text().substr(1));
        });
    })

});
