$(document).ready(function () {
  $('table.datatable').each(function () {
    const tabela = $(this);
    if (!$.fn.DataTable.isDataTable(tabela)) {
      tabela.DataTable({
        dom: "<'d-flex justify-content-between align-items-center flex-wrap mb-3'<'d-flex align-items-center gap-2'lf>B>rtip",
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-PT.json',
          emptyTable: 'Nenhum registro encontrado.'
        },
        stripeClasses: []
      });
    }
  });
});
