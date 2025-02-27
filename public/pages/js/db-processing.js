const table = $(".fixed-header-datatable");

const renderTable = (data) => {
    $("#body_data").html(data);
    createDataTable(table);
    initializeTooltips();
};

$(document).ready(async function () {
    renderTable(await loadData());
});
