const $date = $(".date"),
    $daysContainer = $(".days"),
    $prev = $(".prev"),
    $next = $(".next"),
    $todayBtn = $(".today-btn"),
    $gotoBtn = $(".goto-btn"),
    $dateInput = $(".date-input"),
    $add_staff_btn = $("#btn_add_staff"),
    $remove_staff_btn = $("#btn_delete_staff"),
    $btn_setting_onduty = $("#btn_setting_onduty");

let today = new Date();
let activeDay;
let month = today.getMonth();
let year = today.getFullYear();
let fulldate = null;
let url_remove = null;

const months = [
    "Tháng 1",
    "Tháng 2",
    "Tháng 3",
    "Tháng 4",
    "Tháng 5",
    "Tháng 6",
    "Tháng 7",
    "Tháng 8",
    "Tháng 9",
    "Tháng 10",
    "Tháng 11",
    "Tháng 12",
];

const eventsArr = [];

function initCalendar() {
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const prevLastDay = new Date(year, month, 0);
    const prevDays = prevLastDay.getDate();
    const lastDate = lastDay.getDate();
    const day = firstDay.getDay();
    const nextDays = 7 - lastDay.getDay() - 1;

    $date.html(months[month] + "/" + year);

    let days = "";

    for (let x = day; x > 0; x--) {
        days += `<div class="day prev-date">${prevDays - x + 1}</div>`;
    }

    for (let i = 1; i <= lastDate; i++) {
        if (
            i === new Date().getDate() &&
            year === new Date().getFullYear() &&
            month === new Date().getMonth()
        ) {
            activeDay = i;
            loadEvents(i);
            days += `<div class="day today active">${i}</div>`;
        } else {
            days += `<div class="day ">${i}</div>`;
        }
    }

    for (let j = 1; j <= nextDays; j++) {
        days += `<div class="day next-date">${j}</div>`;
    }

    $daysContainer.html(days);
    addListner();
}

function prevMonth() {
    month--;
    if (month < 0) {
        month = 11;
        year--;
    }
    initCalendar();
}

function nextMonth() {
    month++;
    if (month > 11) {
        month = 0;
        year++;
    }
    initCalendar();
}

$prev.on("click", prevMonth);
$next.on("click", nextMonth);

initCalendar();

function addListner() {
    $(".day").each(function () {
        $(this).on("click", function (e) {
            activeDay = Number($(this).html());

            $(".day").removeClass("active");

            if ($(this).hasClass("prev-date")) {
                prevMonth();
                setTimeout(function () {
                    $(".day").each(function () {
                        if (
                            !$(this).hasClass("prev-date") &&
                            $(this).html() === e.target.innerHTML
                        ) {
                            $(this).addClass("active");
                        }
                    });
                }, 100);
            } else if ($(this).hasClass("next-date")) {
                nextMonth();
                setTimeout(function () {
                    $(".day").each(function () {
                        if (
                            !$(this).hasClass("next-date") &&
                            $(this).html() === e.target.innerHTML
                        ) {
                            $(this).addClass("active");
                        }
                    });
                }, 100);
            } else {
                $(this).addClass("active");
            }

            loadEvents(Number($(this).html()));
        });
    });
}

$todayBtn.on("click", function () {
    today = new Date();
    month = today.getMonth();
    year = today.getFullYear();
    initCalendar();
});

$dateInput.on("input", function (e) {
    let inputValue = $dateInput.val().replace(/[^0-9/]/g, "");
    $dateInput.val(inputValue);
    if (inputValue.length === 2) {
        $dateInput.val(inputValue + "/");
    }
    if (inputValue.length > 7) {
        $dateInput.val(inputValue.slice(0, 7));
    }
    if (e.inputType === "deleteContentBackward") {
        if (inputValue.length === 3) {
            $dateInput.val(inputValue.slice(0, 2));
        }
    }
});

$gotoBtn.on("click", gotoDate);

function gotoDate() {
    const dateArr = $dateInput.val().split("/");
    if (dateArr.length === 2) {
        if (dateArr[0] > 0 && dateArr[0] < 13 && dateArr[1].length === 4) {
            month = dateArr[0] - 1;
            year = dateArr[1];
            initCalendar();
            return;
        }
    }
    showToast("Dữ liệu không hợp lệ", "err");
}

function loadEvents(date) {
    const day = year + "-" + (month + 1) + "-" + date;
    fulldate = day;
    $('#body_data').html('');
    $.ajax({
        method: "GET",
        url: "admin/onduty/getData",
        data: {day: day}
    }).done(function (data) {
        if (data.html == "") {
            showToast("Không có dữ liệu nhân sự trực nhật", "err");
        }
        $('#body_data').html(data.html);
        initializeTooltips();

        var arr_staff = $('#arr_staff')[0];
        $(arr_staff).find('option').each(function () {
            if (data.arr_staff.includes(parseInt($(this).val()))) {
                $(this).prop('selected', true);
            } else {
                $(this).prop('selected', false);
            }
        });
        $('#arr_staff')[0].sumo.reload();
    });
}

$add_staff_btn.on("click", function () {
    var arr_id = $('#arr_staff').val();
    if (arr_id.length == 0) {
        showToast("Vui lòng chọn nhân sự", "err");
        return;
    }
    $.ajax({
        method: "POST",
        url: "admin/onduty/addData",
        data: {day: fulldate, arr_id: arr_id, _token: $('meta[name="csrf-token"]').attr('content')}
    }).done(function (data) {
        if (data == 1) {
            showToast("Thêm nhân sự thành công", "success");
            $('#form_add_staff').modal('hide')
            loadEvents(activeDay);
        } else {
            showToast("Có lỗi xảy ra", "err");
        }
    });
});

$("#delete_onduty").on("show.bs.modal", function (e) {
    url_remove = $(e.relatedTarget).data("bs-href");
});

$remove_staff_btn.on("click", function () {
    if (!url_remove) {
        showToast("Có lỗi xảy ra", "err");
        return;
    }

    $.ajax({
        method: "GET",
        url: url_remove,
    }).done(function (data) {
        if (data == 1) {
            showToast("Xóa nhân sự thành công", "success");
            $('#delete_onduty').modal('hide')
            loadEvents(activeDay);
        } else {
            showToast("Có lỗi xảy ra", "err");
        }
    });
});

$btn_setting_onduty.click(function () {
    var arr_t2 = $('#arr_t2').val();
    var arr_t3 = $('#arr_t3').val();
    var arr_t4 = $('#arr_t4').val();
    var arr_t5 = $('#arr_t5').val();
    var arr_t6 = $('#arr_t6').val();
    var arr_t7 = $('#arr_t7').val();

    if (arr_t2.length == 0 || arr_t3.length == 0 || arr_t4.length == 0 || arr_t5.length == 0 || arr_t6.length == 0 || arr_t7.length == 0) {
        showToast("Vui lòng chọn đầy đủ thông tin", "err");
        return;
    }

    $(this).addClass("disabled");
    $(".btn-close").addClass("disabled");
    $(".close_btn").addClass("disabled");
    $(this).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Đang thực hiện');

    $.ajax({
        method: "POST",
        url: "admin/onduty/setup",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            arr_t2: arr_t2,
            arr_t3: arr_t3,
            arr_t4: arr_t4,
            arr_t5: arr_t5,
            arr_t6: arr_t6,
            arr_t7: arr_t7,
        }
    }).done(function (data) {
        if (data == 1) {
            showToast("Cài đặt dữ liệu thành công", "success");
            $('#onduty_settings').modal('hide')
            loadEvents(activeDay);

            $('#btn_setting_onduty').removeClass("disabled");
            $(".btn-close").removeClass("disabled");
            $(".close_btn").removeClass("disabled");
            $('#btn_setting_onduty').html('Xác nhận');
        } else {
            showToast("Có lỗi xảy ra", "err");
        }
    });
})




