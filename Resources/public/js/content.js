$( document ).ready(function() {
    $(".treeTableGroup").treeTable();
    
    
    $(".change_position_object_template").live('click', function(){
        var obj = $(this);
        var action = obj.data("action");
        var kod = parseInt($(obj.data("form")).find("input[name='form[kod]']").val());
        if (action == 'up'){
            kod--;
            if (kod == 0) return;
        }else{
            kod++;        
        }
        $(obj.data("form")).find("input[name='form[kod]']").val(kod);
        $(obj.data("form")).ajaxSubmit({
            'datatype': 'xml',
            'success' : function( data ){
                $(obj.data("link")).replaceWith(data);
            }
        });
    });
});

function Reset(check){
    var attr   = check.attr('rel');
    var prodid = check.val();
    $(".chekidattr").val(attr);
    $(".chekidprod").val(prodid);
    $("#form_ckeck").submit();
    
}
    