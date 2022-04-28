$("#search_audit").on("input", function() {
   var value = $(this).val().toLowerCase();
   $("#table_audits tbody tr").filter(function() {
     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
   });
 });