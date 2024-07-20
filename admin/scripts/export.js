function exportToExcel(){
  var table2excel = new Table2Excel();
  table2excel.export(document.querySelectorAll("#myTable"));
}



function exportToPDF() {
  var element = document.getElementById('myTable'); // Corrected the ID selector syntax
  var opt = {
    margin: 1,
    filename: 'user_queries.pdf',
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
  };

  // Use html2pdf library to export to PDF
  html2pdf().from(element).set(opt).save();
}
