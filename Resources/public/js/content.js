$( document ).ready(function() {
   // $(".treeTableGroup").treeTable();
    
    
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

$(".loadContractData").live("click", function(){
           var search_route = $(this).data("route");
           var search_link = $(this).data("link");
            $.getJSON( "/itc/ru/"+search_route+".json", {
                term: $(search_link).val()
            },  function(data){
                $('load_template_data').html(
                'valera'
            );
            });                           
     });
    