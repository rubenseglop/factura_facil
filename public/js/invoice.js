

function loadPdf(url, invoice_number) {

    $.ajax(url).done(function(response){

        console.log($(response).filter("#table-invoice").html())
        var table_invoice = $(response).filter("#table-invoice");
        var table_invoice_lines = $(response).filter("#table-invoice-lines");
        console.log(table_invoice.children("tbody").children("tr").children("td").eq(0).text());

        console.log(table_invoice_lines.children().children("tr").length);
        if(table_invoice_lines.children().children("tr").length > 1) {
            for(let i = 1; i < table_invoice_lines.children().children("tr").length; i++) {
                console.log(table_invoice_lines.children().children("tr").eq(i).children("td").eq(0).text());
            }
        }

        var img = new Image();
        var pdf = new jsPDF();
        var today = new Date();

        var top_margin = 44;

        var pdfname = invoice_number +'_' +today.getFullYear()+(today.getMonth()+1)+today.getDate() +today.getHours() +today.getSeconds();
        
        img.src = document.getElementById("logo").src;
        img.onload = function () {

            pdf.setProperties({
                title: pdfname
            });

            pdf.addImage(img, 'JPEG', 8, 8, 20, 20);

            pdf.setFontSize(20);
            pdf.setTextColor(40);
            pdf.setFontStyle('normal');
            
            pdf.text("Fáctura Fácil", 32, 21);
        
            // pdf.line(3, 20, 200, 20);
            
            if(table_invoice_lines.children().children("tr").length > 1) {
                
                var rows = Array();

                for(let i = 1; i < table_invoice_lines.children().children("tr").length; i++) {
                    var colums = [table_invoice_lines.children().children("tr").eq(i).children("td").eq(1).text(), 
                    table_invoice_lines.children().children("tr").eq(i).children("td").eq(2).text(), 
                    table_invoice_lines.children().children("tr").eq(i).children("td").eq(3).text(),
                    table_invoice_lines.children().children("tr").eq(i).children("td").eq(4).text(),
                    table_invoice_lines.children().children("tr").eq(i).children("td").eq(5).text()];
                    rows.push(colums);
                }

                pdf.autoTable({
                    bodyStyles: { fontSize: 12 },
                    headStyles: { fillColor: [137, 186, 227], fontSize: 13 },
                    head: [['Concepto', 'Cantidad', 'Precio (€)', 'I.V.A. (%)', 'Total Línea (€)']],
                    margin: { top: top_margin },
                    body: rows,
                });
            }

            top_margin = top_margin + 32;

            pdf.autoTable({
                bodyStyles: { fontSize: 12 },
                headStyles: { fillColor: [137, 186, 227], fontSize: 13 },
                head: [['Nº de factura', 'Fecha', 'Descripción', 'I.V.A (%)', 'Importe total (€)']],
                margin: { top: top_margin },
                body: [
                    [table_invoice.children("tbody").children("tr").children("td").eq(0).text(),
                    table_invoice.children("tbody").children("tr").children("td").eq(1).text(), 
                    table_invoice.children("tbody").children("tr").children("td").eq(2).text(), 
                    table_invoice.children("tbody").children("tr").children("td").eq(3).text(),
                    table_invoice.children("tbody").children("tr").children("td").eq(4).text()],
                ],
            });
        
            pdf.save(pdfname +'.pdf');
            pdf.output("dataurlnewwindow");

        };
    });
}


$(".table").off().on("click", ".show-pdf", function(event) {
    event.preventDefault();
    loadPdf($(this).attr("href"), $(this).parent().parent().children('td').eq(0).text());
});