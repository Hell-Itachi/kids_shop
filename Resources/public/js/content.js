$( document ).ready(function() {
    $(".treeTableGroup").treeTable();
});

$(".loadContractData").live("click", function(){
           var search_route = $(this).data("route");
           var search_link = $(this).data("link");
            $.getJSON( "/itc/ru/"+search_route+".json", {
                term: $(search_link).val()
            },  function(data){
                $('table.contract_more_data tbody').html(
                '<tr>'+
                    '<td id="numb" class = "w50px center">'+data[0].apartment+'</td>'+
                    '<td id="fio" class = "w150px center">'+data[0].fio+'</td>'+
                    '<td id="all" class = "w50px center">'+data[0].all+'</td>'+
                    '<td id="live" class = "w50px center">'+data[0].live+'</td>'+
                    '<td id="balcony" class = "w50px center">'+data[0].balcony+'</td>'+
                '</tr>'
            );
            });                           
     });
