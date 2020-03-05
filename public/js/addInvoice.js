

$(function() {

    var lines = 1;

    $(".add-little").off().on("click", function() {
        lines += 1;
        var row =  '<tr>'+
            '<td><input id="add_new_bill_billLines_' +lines +'_description" name="add_new_bill[billLines][' +lines +'][description]" type="text" class="form-control rounded-sm" required></td>'+
            '<td><input min="1" id="add_new_bill_billLines_' +lines +'_quantity" name="add_new_bill[billLines][' +lines +'][quantity]" type="number" class="form-control rounded-sm invoice-quantity" required></td>'+
            '<td><input min="0" id="add_new_bill_billLines_' +lines +'_price" name="add_new_bill[billLines][' +lines +'][price]" type="number" class="form-control rounded-sm invoice-price" required></td>'+
            '<td><input min="0" id="add_new_bill_billLines_' +lines +'_billLineIva" name="add_new_bill[billLines][' +lines +'][billLineIva]" type="number" class="form-control rounded-sm" required></td>'+
            '<td><input min="0" id="add_new_bill_billLines_' +lines +'_subTotal" name="add_new_bill[billLines][' +lines +'][subTotal]" type="number" class="form-control rounded-sm invoice-subtotal" disabled></td>'+
            '<td><div class="delete-little"><i class="far fa-trash-alt"></i></div></td>'+
        '</tr>';

        var counter = '<th scope="row">' +lines +'</th>';

        var select = $("tbody").children('tr').first().children('td').first();
        var name = "add_new_bill[billLines][" +lines +"][product]";
        var id = "add_new_bill_billLines_" +lines +"_product";

        $(this).parent().parent().parent().parent().children("tbody").append(row);
        $(this).parent().parent().parent().parent().children("tbody").children('tr').last().prepend("<td></td>");
        $(this).parent().parent().parent().parent().children("tbody").children('tr').last().children("td").first().prepend(select.html());
        $(this).parent().parent().parent().parent().children("tbody").children('tr').last().children('td').first().find("select").attr('name', name).attr('id', id);
        $(this).parent().parent().parent().parent().children("tbody").children('tr').last().prepend(counter);
    });

    $(".table-bordered").off().on("click", ".delete-little", function() {
        if(lines > 1) {
            lines -= 1;
            $(this).parent().parent().remove();

            for(let i = 0; i < $("tbody tr").length; i++) {
                $("tbody tr:nth-child(" +(i+1) +")").children("th").eq(0).text((i+1));
                for(let j = 0; j < 6; j++) {
                    switch(j) {
                        case 0:
                            $("tbody tr:nth-child(" +(i+1) +")").children("td").eq(j).children("input").eq(0)
                            .attr('name', 'add_new_bill[billLines][' +(i+1) +'][product]').attr('id', "add_new_bill_billLines_" +(i+1) +"_product");
                        break;
                        case 1:
                            $("tbody tr:nth-child(" +(i+1) +")").children("td").eq(j).children("input").eq(0)
                            .attr('name', 'add_new_bill[billLines][' +(i+1) +'][description]').attr('id', "add_new_bill_billLines_" +(i+1) +"_description");;
                        break;
                        case 2:
                            $("tbody tr:nth-child(" +(i+1) +")").children("td").eq(j).children("input").eq(0)
                            .attr('name', 'add_new_bill[billLines][' +(i+1) +'][quantity]').attr('id', "add_new_bill_billLines_" +(i+1) +"_quantity");;
                        break;
                        case 3:
                            $("tbody tr:nth-child(" +(i+1) +")").children("td").eq(j).children("input").eq(0)
                            .attr('name', 'add_new_bill[billLines][' +(i+1) +'][price]').attr('id', "add_new_bill_billLines_" +(i+1) +"_price");;
                        break;
                        case 4:
                            $("tbody tr:nth-child(" +(i+1) +")").children("td").eq(j).children("input").eq(0)
                            .attr('name', 'add_new_bill[billLines][' +(i+1) +'][billLineIva]').attr('id', "add_new_bill_billLines_" +(i+1) +"_billLineIva");;
                        break;
                        case 5:
                            $("tbody tr:nth-child(" +(i+1) +")").children("td").eq(j).children("input").eq(0)
                            .attr('name', 'add_new_bill[billLines][' +(i+1) +'][subTotal]').attr('id', "add_new_bill_billLines_" +(i+1) +"_subTotal");;
                        break;
                    }
                }   
            }
        }
    });

    $(".table-bordered").on("propertychange change click keyup input paste", ".invoice-price", function() {
        if($(this).parent().parent().children("td").eq(2).children("input").val() == "" ) {
            $(this).parent().parent().children("td").eq(5).children("input").val($(this).val()).change();
        }else {
            var total = $(this).val() * $(this).parent().parent().children("td").eq(2).children("input").val();
            $(this).parent().parent().children("td").eq(5).children("input").val(total).change();
        }
    });

    $(".table-bordered").on("propertychange change click keyup input paste", ".invoice-quantity", function() {
        if($(this).parent().parent().children("td").eq(3).children("input").val() != "" ) {
            var total = $(this).val() * $(this).parent().parent().children("td").eq(3).children("input").val();
            $(this).parent().parent().children("td").eq(5).children("input").val(total).change();
        }
    });

    $(".table-bordered").on("change", ".invoice-subtotal", function() {
        $("#add_new_bill_amountWithoutIVA").val($(this).val());
    });

    $(".table-bordered").on("change", "select", function () {
        var select = $(this);

        if($(this).val() != "null") {
            var url = window.location.pathname +"/linea-producto/" +$(this).val();
    
            $.ajax(url).done(function(response) {
                select.parent().parent().children("td").eq(1).children("input").val(response.name);
                select.parent().parent().children("td").eq(2).children("input").val("1");
                select.parent().parent().children("td").eq(4).children("input").val(response.iva);
                select.parent().parent().children("td").eq(3).children("input").val(response.price).change();
            });
        }else {
            select.parent().parent().children("td").eq(1).children("input").val("");
            select.parent().parent().children("td").eq(2).children("input").val("1");
            select.parent().parent().children("td").eq(4).children("input").val("");
            select.parent().parent().children("td").eq(3).children("input").val("").change();
        }
    });

    
});

function addBill() {

}

