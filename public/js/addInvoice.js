

$(function() {

    var lines = 1;

    $(".add-little").off().on("click", function() {
        lines += 1;
        var row =  '<tr>'+
            '<td><input id="add_new_bill_billLines_' +lines +'_description" name="add_new_bill[billLines][' +lines +'][description]" type="text" class="form-control rounded-sm" required></td>'+
            '<td><input id="add_new_bill_billLines_' +lines +'_quantity" name="add_new_bill[billLines][' +lines +'][quantity]" type="number" class="form-control rounded-sm" required></td>'+
            '<td><input id="add_new_bill_billLines_' +lines +'_price" name="add_new_bill[billLines][' +lines +'][price]" type="number" class="form-control rounded-sm" required></td>'+
            '<td><input id="add_new_bill_billLines_' +lines +'_billLineIva" name="add_new_bill[billLines][' +lines +'][billLineIva]" type="number" class="form-control rounded-sm" required></td>'+
            '<td><input id="add_new_bill_billLines_' +lines +'_subTotal" name="add_new_bill[billLines][' +lines +'][subTotal]" type="number" class="form-control rounded-sm" required></td>'+
            '<td><div class="delete-little"><i class="far fa-trash-alt"></i></div></td>'+
        '</tr>';

        var counter = '<th scope="row">' +lines +'</th>';

        var select = $("tbody").children('tr').first().children('td').first();
        var name = "add_new_bill[billLines][" +lines +"][product]";

        $(this).parent().parent().parent().parent().children("tbody").append(row);
        $("tbody").children('tr').last().prepend("<td></td>");
        $("tbody").children('tr').last().children("td").first().prepend(select.html());
        $("tbody").children('tr').last().children('td').first().find("select").attr('name', name);
        $("tbody").children('tr').last().prepend(counter);
    });

    $(".table-bordered").off().on("click", ".delete-little", function() {
        if(lines > 1) {
            lines -= 1;
            $(this).parent().parent().remove();

            for(let i = 0; i < $("tbody tr").length; i++) {
                $("tbody tr:nth-child(" +(i+1) +")").children("th").eq(0).text((i+1));
                console.log($("tbody tr:nth-child(" +(i+1) +")").children("td").children("input").eq(0).attr('name'))
                for(let j = 0; j < 5; j++) {
                    switch(j) {
                        case 0:
                            $("tbody tr:nth-child(" +(i+1) +")").children("td").eq(j).children("input").eq(0).attr('name', 'add_new_bill[billLines][' +(i+1) +'][description]');
                        break;
                        case 1:
                            $("tbody tr:nth-child(" +(i+1) +")").children("td").eq(j).children("input").eq(0).attr('name', 'add_new_bill[billLines][' +(i+1) +'][quantity]');
                        break;
                        case 2:
                            $("tbody tr:nth-child(" +(i+1) +")").children("td").eq(j).children("input").eq(0).attr('name', 'add_new_bill[billLines][' +(i+1) +'][price]');
                        break;
                        case 3:
                            $("tbody tr:nth-child(" +(i+1) +")").children("td").eq(j).children("input").eq(0).attr('name', 'add_new_bill[billLines][' +(i+1) +'][billLineIva]');
                        break;
                        case 4:
                            $("tbody tr:nth-child(" +(i+1) +")").children("td").eq(j).children("input").eq(0).attr('name', 'add_new_bill[billLines][' +(i+1) +'][subTotal]');
                        break;
                    }
                }   
            }
        }
    });

    $(".table-bordered").on("keyup", ".invoice-price", function() {
        if($(this).parent().parent().children("td").eq(2).children("input").val() == "" ) {
            $(this).parent().parent().children("td").eq(5).children("input").val($(this).val());
        }else {
            var total = $(this).val() * $(this).parent().parent().children("td").eq(2).children("input").val();
            $(this).parent().parent().children("td").eq(5).children("input").val(total);
        }
    });

    $(".table-bordered").on("keyup", ".invoice-price", function() {
        if($(this).parent().parent().children("td").eq(2).children("input").val() == "" ) {
            $(this).parent().parent().children("td").eq(5).children("input").val($(this).val());
        }else {
            var total = $(this).val() * $(this).parent().parent().children("td").eq(2).children("input").val();
            $(this).parent().parent().children("td").eq(5).children("input").val(total);
        }
    });
    
});

