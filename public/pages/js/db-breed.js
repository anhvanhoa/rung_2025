const table = $(".fixed-header-datatable");

const renderTable = (data) => {
    destroyDataTable(table);
    $("#body_data").html(data);
    createDataTable(table);
    initializeTooltips();
};

$(document).ready(async function () {
    initSumoSelect($("#business_type, #district, #commune"));
    const business_type = $("#business_type").val();
    renderTable(
        await loadData({
            business_type,
        })
    );
});

$("#filter").on("click", async function () {
    show_loading_Filter();
    const business_type = $("#business_type").val();
    const district = $("#district").val();
    const commune = $("#commune").val();
    try {
        const data = await loadData({ business_type, district, commune });
        renderTable(data);
    } catch (error) {
        showToast("error", error.message);
    }
    hide_loading_Filter();
});
