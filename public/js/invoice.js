

var splitRegex = /\r\n|\r|\n/g;
jsPDF.API.textEx = function (text, x, y, hAlign, vAlign) {
    var fontSize = this.internal.getFontSize() / this.internal.scaleFactor;

    // As defined in jsPDF source code
    var lineHeightProportion = 1.15;

    var splittedText = null;
    var lineCount = 1;
    if (vAlign === 'middle' || vAlign === 'bottom' || hAlign === 'center' || hAlign === 'right') {
        splittedText = typeof text === 'string' ? text.split(splitRegex) : text;

        lineCount = splittedText.length || 1;
    }

    // Align the top
    y += fontSize * (2 - lineHeightProportion);

    if (vAlign === 'middle')
        y -= (lineCount / 2) * fontSize;
    else if (vAlign === 'bottom')
        y -= lineCount * fontSize;

    if (hAlign === 'center' || hAlign === 'right') {
        var alignSize = fontSize;
        if (hAlign === 'center')
            alignSize *= 0.5;

        if (lineCount > 1) {
            for (var iLine = 0; iLine < splittedText.length; iLine++) {
                this.text(splittedText[iLine], x - this.getStringUnitWidth(splittedText[iLine]) * alignSize, y);
                y += fontSize * lineHeightProportion;
            }
            return this;
        }
        x -= this.getStringUnitWidth(text) * alignSize;
    }

    this.text(text, x, y);
    return this;
};

function loadPdf(url, invoice_number) {

    $.ajax(url).done(function(response){

        var table_invoice = $(response).filter("#table-invoice");
        var table_invoice_lines = $(response).filter("#table-invoice-lines");
        
        $.ajax(url +"/detalle-factura").done(function(response2) {

            if(table_invoice_lines.children().children("tr").length > 1) {
                for(let i = 1; i < table_invoice_lines.children().children("tr").length; i++) {
                    table_invoice_lines.children().children("tr").eq(i).children("td").eq(0).text();
                }
            }
    
            var img = new Image();
            var pdf = new jsPDF();
            var today = new Date();
    
            var top_margin = 128;
    
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

                // Datos empresa
                pdf.setFontSize(13);
                pdf.setFontStyle('bold');
                pdf.text(response2.company_name, 14, 43);
                pdf.setFontSize(12);
                pdf.setFontStyle('normal');
                pdf.text(response2.company_email, 14, 52);
                pdf.text(response2.company_name, 14, 60);
                pdf.text("c/" +response2.company_fiscalAddress, 14, 68);
                pdf.text("NIF: " +response2.company_nif, 14, 76);

                // Datos factura
                pdf.setFontSize(13);
                pdf.setFontStyle('bold');
                pdf.text("Factura", 14, 89);
                pdf.setFontSize(12);
                pdf.setFontStyle('normal');
                pdf.text("Factura nº: " +response2.invoice_number, 14, 98);
                pdf.text("Fecha: " +response2.invoice_date.date.split(" ")[0], 14, 106);
                pdf.text("Descripción: " +response2.invoice_description, 14, 114);

                // Datos cliente
                pdf.setFontSize(13);
                pdf.setFontStyle('bold');
                pdf.textEx('Cliente', 194, 43, 'right', 'middle');
                pdf.setFontSize(12);
                pdf.setFontStyle('normal');
                pdf.textEx(response2.client_name, 194, 52, 'right', 'middle');
                pdf.textEx(response2.client_email, 194, 60, 'right', 'middle');
                pdf.textEx(response2.client_phone, 194, 68, 'right', 'middle');
                pdf.textEx("NIF: " +response2.client_nif, 194, 76, 'right', 'middle');

            
                // pdf.line(3, 20, 200, 20);
                
                if(table_invoice_lines.children().children("tr").length > 1) {
    
                    var rows = Array();
    
                    for(let i = 1; i < table_invoice_lines.children().children("tr").length; i++) {
                        var colums = [
                        table_invoice_lines.children().children("tr").eq(i).children("td").eq(0).text(), 
                        table_invoice_lines.children().children("tr").eq(i).children("td").eq(1).text(), 
                        table_invoice_lines.children().children("tr").eq(i).children("td").eq(2).text(),
                        table_invoice_lines.children().children("tr").eq(i).children("td").eq(3).text(),
                        table_invoice_lines.children().children("tr").eq(i).children("td").eq(4).text()];
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
                    head: [['Importe I.V.A. (€)', 'Importe sin I.V.A. (€)', 'Importe total (€)']],
                    margin: { top: top_margin },
                    body: [
                        [table_invoice.children("tbody").children("tr").children("td").eq(0).text(),
                        table_invoice.children("tbody").children("tr").children("td").eq(1).text(), 
                        table_invoice.children("tbody").children("tr").children("td").eq(2).text()],
                    ],
                });
            
                pdf.save(pdfname +'.pdf');
                pdf.output("dataurlnewwindow");

            };

        });
    });
}

$(function() {

    $(".table").off().on("click", ".show-pdf", function(event) {
        event.preventDefault();
        loadPdf($(this).attr("href"), $(this).parent().parent().children('td').eq(0).text());
    });
    
    
    $(".delete-lit").on("click", function(event) {
    
        var href = $(this).parent().attr("href");
    
        event.preventDefault();
        $(".modal").show();
        $(".modal .modal-title").text("Eliminar factura");
        $(".modal .modal-body").text("¿Estás seguro que quieres eliminar ésta factura?");
        $(".modal .modal-dialog").css({"top": "100px"});
    
        $(".modal-footer #cancel, .modal .close").on("click", function() {
            $(".modal").hide();
        });
    
        $(".modal-footer #accept").click(function() {
            $(".modal").hide();
            window.location.replace(href);
        });
    
    });

    function hideForms() {
        $(".search-forms .search-number-bill").hide();
        $(".search-forms .search-description").hide();
        $(".search-forms .search-client").hide();
        $(".search-forms .search-date").hide();
    }

    $(".panel-search #select-search").off().change(function () {
        hideForms();
        switch(Number($(this).val())) {
            case 1:
                console.log("entraaaa")
                $(".search-forms .search-number-bill").show();
            break;
            case 2:
                $(".search-forms .search-description").show();
            break;
            case 3:
                $(".search-forms .search-client").show();
            break;
            case 4:
                $(".search-forms .search-date").show();
            break;
        }
    });

    $(".search-forms .search-number-bill").show();

});


