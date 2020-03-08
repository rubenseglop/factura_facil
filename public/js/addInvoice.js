

$(function() {

    var amount_iva = 0;
    var amount_without_iva = 0;
    var lines = 1;

    lines = Number($("tbody").children('tr').last().children("th").eq(0).text()) - 1;
    
    function calculateAmountIva() {
        amount_iva = amount_iva * 0;
        $(".invoice-iva").each(function(element) {
            if($(this).parent().parent().children("td").eq(5).children("input").val() != "") {
                amount_iva = Number(amount_iva) + Number(parseFloat($(this).parent().parent().children("td").eq(5).children("input").val() * parseFloat($(this).val() / 100)).toFixed(2));
            }
        });
        $("#add_new_bill_amountIVA").val(parseFloat(Number(amount_iva)).toFixed(2));
        calculateTotalAmount();
    }

    function calculateAmountWhitoutIva() {
        amount_without_iva = 0;
        $(".invoice-subtotal").each(function(element) {
            amount_without_iva = Number(amount_without_iva) + Number($(this).val());
        });
        $("#add_new_bill_amountWithoutIVA").val(parseFloat(Number(amount_without_iva)).toFixed(2));
    }

    function calculateTotalAmount() {
        $("#add_new_bill_totalInvoiceAmount").val(parseFloat(Number(amount_iva) + Number(amount_without_iva)).toFixed(2));
    }

    function deleteLine(remove_bt) {
        if(lines > 0) {
            lines -= 1;
            remove_bt.parent().parent().remove();

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
    }

    $(".add-little").off().on("click", function() {
        lines += 1;
        var row =  '<tr>'+
            '<td><input id="add_new_bill_billLines_' +lines +'_description" name="add_new_bill[billLines][' +lines +'][description]" type="text" class="form-control rounded-sm" required></td>'+
            '<td><input min="1" id="add_new_bill_billLines_' +lines +'_quantity" name="add_new_bill[billLines][' +lines +'][quantity]" type="number" class="form-control rounded-sm invoice-quantity" required></td>'+
            '<td><input min="0" id="add_new_bill_billLines_' +lines +'_price" name="add_new_bill[billLines][' +lines +'][price]" type="number" step=".01" class="form-control rounded-sm invoice-price" required></td>'+
            '<td><input min="0" id="add_new_bill_billLines_' +lines +'_billLineIva" name="add_new_bill[billLines][' +lines +'][billLineIva]" type="number" step=".01" class="form-control rounded-sm invoice-iva" required></td>'+
            '<td><input min="0" id="add_new_bill_billLines_' +lines +'_subTotal" name="add_new_bill[billLines][' +lines +'][subTotal]" type="number" step=".01" class="form-control rounded-sm invoice-subtotal" readonly></td>'+
            '<td><div class="delete-little"><i class="far fa-trash-alt"></i></div><input type="hidden" value="-1"></td>'+
        '</tr>';

        var counter = '<th scope="row">' +(lines + 1) +'</th>';

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
        let line_id = $(this).parent().children("input").eq(0).val();
        var remove_bt = $(this);

        if(line_id != -1) {
            var url = window.location.pathname +"/borrar-linea-producto/" +line_id;
    
            $.ajax(url).done(function(response) {
                if(response.result == "ok") {
                    deleteLine(remove_bt);
                }
            });
        }else {
            deleteLine(remove_bt);
        }
        
    });

    $(".table-bordered").on("propertychange change click keyup input paste", ".invoice-price", function() {
        if($(this).parent().parent().children("td").eq(2).children("input").val() == "" ) {
            $(this).parent().parent().children("td").eq(5).children("input").val(parseFloat(Number($(this).val()))).change();
        }else {
            var total = $(this).val() * $(this).parent().parent().children("td").eq(2).children("input").val();
            $(this).parent().parent().children("td").eq(5).children("input").val(parseFloat(Number(total)).toFixed(2)).change();
        }
    });

    $(".table-bordered").on("propertychange change click keyup input paste", ".invoice-quantity", function() {
        if($(this).parent().parent().children("td").eq(3).children("input").val() != "" ) {
            var total = parseFloat(Number($(this).val())).toFixed(2) * parseFloat(Number($(this).parent().parent().children("td").eq(3).children("input").val())).toFixed(2);
            $(this).parent().parent().children("td").eq(5).children("input").val(parseFloat(Number(total)).toFixed(2)).change();
        }
    });

    $(".table-bordered").on("propertychange change click keyup input paste", ".invoice-iva", function() {
        if($(this).parent().parent().children("td").eq(5).children("input").val() != "" ) {
            calculateAmountIva();
        }
    });

    $(".table-bordered").on("change", ".invoice-subtotal", function() {
        calculateAmountWhitoutIva();
        calculateAmountIva();
        calculateTotalAmount();
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

    $(".select-client-delete").remove();

    $("#add_new_bill").off().on("submit", function(event) {
        
        var today = new Date();
        var last = $("#last-date").val();
        var format_date = $("#add_new_bill_dateBill_month").val() +"/" +$("#add_new_bill_dateBill_day").val() +"/" +$("#add_new_bill_dateBill_year").val();
        var last_date = new Date(last);
        var form_date = new Date(format_date);

        if(form_date > today) {
            alert("La fecha introducida no puede ser posterior a la del día actual");
            event.preventDefault();
        }

        if(form_date < last_date) {
            alert("La fecha introducida no puede ser anterior a la de la última factura o última fecha válida");
            event.preventDefault();
        }

    });

    var date = new Date();
    y = date.getFullYear();
    m = Number( Number(date.getMonth()) + 1) - 3;
    if(m <= 0) {
        m = 1;
    }
    d = date.getDate();

    $("#actual").text("Última fecha válida - " +d + "/" + m + "/" + y);
    $(".actual-date").val(m + "/" + d + "/" + y);
    
});
