function generatePDF(filename = 'Компания', format = 'PNG', quality = 0.7) {
    // Получаем размеры страницы отчета
    var reportPageHeight = $(document).innerHeight();
    var reportPageWidth = $(document).innerWidth();

    // Создаем новый холст, на который будем наносить все остальные холсты
    var pdfCanvas = $('<canvas />').attr({
    id: "canvaspdf",
    width: reportPageWidth,
    height: reportPageHeight
    });

    // Отслеживаем позицию холста
    var pdfctx = $(pdfCanvas)[0].getContext('2d');
    var pdfctxX = 0;
    var pdfctxY = 0;
    var buffer = 100;

    // Устанавливаем белый цвет фона
    pdfctx.fillStyle = "#ffffff";
    pdfctx.fillRect(0, 0, reportPageWidth, reportPageHeight);

    // Добавляем заголовок
    var title = filename;
    pdfctx.font = "24px Arial";
    pdfctx.fillStyle = "#000000"; // черный цвет текста
    pdfctx.fillText(title, 50, 50); // координаты заголовка

    // Увеличиваем Y-координату для размещения графиков ниже заголовка
    pdfctxY += 100; // Увеличиваем на 100 пикселей

    // Для каждого холста с графиком
    $("canvas").each(function(index) {
    // Получаем высоту/ширину графика
    var canvasHeight = $(this).innerHeight();
    var canvasWidth = $(this).innerWidth();

    // Рисуем график на новом холсте
    pdfctx.drawImage($(this)[0], pdfctxX, pdfctxY, canvasWidth, canvasHeight);
    pdfctxX += canvasWidth + buffer;

    // Наша страница отчета имеет сетку, поэтому воспроизводим ее на новом холсте
    if (index % 2 === 1) {
        pdfctxX = 0;
        pdfctxY += canvasHeight + buffer;
    }
    });

    // Увеличиваем качество графиков (масштабируем коэффициентом 2)
    var scaledWidth = reportPageWidth * 2;
    var scaledHeight = reportPageHeight * 2;

    // Создаем новый PDF и добавляем наш новый холст как изображение
    var pdf = new jsPDF('l', 'pt', [scaledWidth, scaledHeight]);
    pdf.addImage($(pdfCanvas)[0], 'PNG', 0, 0, scaledWidth, scaledHeight);

    // Сохраняем PDF
pdf.save(filename+'.pdf');



// // Создание PDF из текущей страницы
// // Создание PDF из текущей страницы
// function createPDF() {
//     // Создаем новый экземпляр jsPDF
//     const doc = new jsPDF();

//     // Получаем HTML-код текущей страницы
//     const htmlContent = document.body.innerHTML;

//     // Генерируем PDF из HTML-кода
//     doc.html(htmlContent, {
//         callback: function (pdf) {
//             // Устанавливаем размеры страницы
//             const pageSize = pdf.internal.pageSize;
//             const pageWidth = pageSize.width;
//             const pageHeight = pageSize.height;
//             const scaleFactor = Math.min(pageWidth / document.body.scrollWidth, pageHeight / document.body.scrollHeight);

//             // Устанавливаем размеры страницы
//             // pdf.setPageSize([pageWidth * scaleFactor, pageHeight * scaleFactor]);

//             // Сохраняем PDF-файл
//             pdf.save('page.pdf');
//         }
//     });
// }

// // Вызываем функцию для создания PDF
// createPDF();



    // const screenshotDivs = document.querySelectorAll('.diagramms .diagramm-item');

    // if (format === 'PDF') {
    //     const doc = new jsPDF({
    //         orientation: 'landscape',
    //         unit: 'mm',
    //         format: 'a4'
    //     });

    //     function addImagesToPDF(index) {
    //         if (index < screenshotDivs.length) {
    //             const screenshotDiv = screenshotDivs[index];
    //             html2canvas(screenshotDiv, { scale: 1 }).then(canvas => {
    //                 let imgData = canvas.toDataURL('image/png', quality);

    //                 let imgWidth = doc.internal.pageSize.getWidth();
    //                 let imgHeight = canvas.height * imgWidth / canvas.width;

    //                 let position = 0;

    //                 function addImageToPDF() {
    //                     doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight, null, 'FAST');

    //                     position += imgHeight;
    //                     if (position < doc.internal.pageSize.getHeight()) {
    //                         doc.addPage();
    //                         addImageToPDF();
    //                     } else {
    //                         addImagesToPDF(index + 1);
    //                     }
    //                 }

    //                 addImageToPDF();
    //             });
    //         } else {
    //             doc.save(filename + '.pdf');
    //         }
    //     }

    //     addImagesToPDF(0);
    // } else {
    //     // Handle other formats
    // }
}
