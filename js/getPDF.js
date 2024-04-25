function generatePDF(filename = 'Компания', format = 'PNG', quality = 0.7) {
    const pdf = new jsPDF('l', 'px', undefined, false);
    
    $("canvas").each(function (index) {

        // Получаем контекст холста
        var canvas = $(this)[0];

        var scaleFactor = 1; // Фактор масштабирования
        var imgWidth = canvas.width * scaleFactor;
        var imgHeight = canvas.height * scaleFactor;

        // Размещаем изображение по центру страницы
        var xPos = (pdf.internal.pageSize.getWidth() - imgWidth) / 2;
        var yPos = (pdf.internal.pageSize.getHeight() - imgHeight) / 2;

        // pdf.addImage($(this)[0], 'PNG', 10, 50);
        pdf.addImage($(this)[0], 'PNG', xPos, yPos, imgWidth, imgHeight);
        pdf.addPage();
    
    });
    
    pdf.save(filename+'.pdf');
}

