$( document ).ready(function() {
    $(".treeTableGroup").treeTable();
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
