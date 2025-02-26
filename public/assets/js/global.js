var xhrAjax = null;
const unloadHandler = () => {
    if (xhrAjax !== null) xhrAjax.abort();
};
window.addEventListener("unload", unloadHandler);

$(document).ready(function () {
    setActiveSidebar();
});

$("#confirm_delete").on("show.bs.modal", function (e) {
    $("#btn_delete").attr("href", $(e.relatedTarget).data("bs-href"));
});

$("#btn_delete").on("click", function (e) {
    e.preventDefault();
    $(this).addClass("disabled");
    $(".btn-close").addClass("disabled");
    $(".close_btn").addClass("disabled");
    $(this).html(
        '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Đang thực hiện'
    );
    var url = $(this).attr("href");
    window.location.href = url;
});

$("form").on("submit", function (e) {
    e.preventDefault();
    $('button[type="submit"]').attr("disabled", true);
    $('button[data-bs-dismiss="modal"]').addClass("disabled");
    $(".btn-close").addClass("disabled");
    $('button[type="submit"]').html(
        '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Đang thực hiện'
    );
    this.submit();
});

// thêm * cho các trường require
$("form")
    .find("input[required], select[required], textarea[required]")
    .each(function () {
        var label = $(this).siblings("label");
        var labelText = label.text() + '<span style="color:red"> *</span>';
        label.html(labelText);
    });

const setActiveSidebar = () => {
    const currentPath = window.location.pathname;

    $(".side-nav-item").each(function () {
        const link = $(this).find("a").first();
        if (!link.length) return;

        const href = link.attr("href");
        if (!href) return;

        const parser = document.createElement("a");
        parser.href = href;
        const menuPath = parser.pathname;

        if (currentPath == menuPath) {
            const item = $(this);
            item.addClass("active");

            const parentCollapse = item.closest(".collapse");
            if (parentCollapse.length) {
                item.find(".side-nav-link").addClass("active");
                parentCollapse.addClass("show");
                const parentItem = parentCollapse.closest(".side-nav-item");
                if (parentItem.length) parentItem.addClass("active");
            }

            setTimeout(() => {
                const scrollElement = $(
                    "[data-simplebar] .simplebar-content-wrapper"
                );

                if (scrollElement.length) {
                    const itemTop = item.offset().top;
                    const scrollTop = scrollElement.offset().top;
                    const scrollPosition = itemTop - scrollTop - 100;

                    scrollElement.animate(
                        {
                            scrollTop: scrollPosition,
                        },
                        300
                    );
                }
            }, 200);
        }
    });
};

const updateStatusNotification = (elm) => {
    const url = $(elm).data("bs-href");
    const _token = $('meta[name="csrf-token"]').attr("content");

    if (!url) return;

    const issetAciveClass = $(elm).parent("div").hasClass("active");
    if (!issetAciveClass) return;

    $.ajax({
        type: "post",
        url: url,
        data: {
            _token: _token,
        },
        success: (res, status, xhr) => {
            if (xhr.status === 200) $(elm).parent("div").removeClass("active");

            if ($("#containerNoti").find("div.active").length == 0) {
                $("#noiceNoti")
                    .find(
                        "span.position-absolute.translate-middle.bg-danger.border.border-light.rounded-circle"
                    )
                    .remove();
                $("#noiceNoti")
                    .find("svg.animate-ring")
                    .removeClass("animate-ring");
            }

            let countNoti = $("#linkNotiIndex").find("span.badge").text();
            if (typeof countNoti == "string") countNoti = parseInt(countNoti);
            if (countNoti > 0) {
                countNoti -= 1;
                $("#linkNotiIndex").find("span.badge").text(countNoti);
            }
            if (countNoti == 0) $("#linkNotiIndex").find("span.badge").remove();
        },
        error: (res, status, xhr) => {
            showToast(res.responseText, "err");
        },
    });
};

const showToast = (message, status) => {
    Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "center",
        stopOnFocus: true,
        style: {
            background:
                status == "success"
                    ? "#3ec396"
                    : status == "err"
                    ? "#f36270"
                    : "#f9bc0b",
            color: "#fff",
        },
    }).showToast();
};

const formatNumber = (value) => {
    if (typeof value === "string") {
        return value;
    }
    if (typeof value === "number") {
        if (Number.isInteger(value)) {
            return value.toLocaleString("en-US", {
                minimumFractionDigits: 0,
            });
        } else {
            return value.toLocaleString("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        }
    }
    return "";
};

const destroySumoSelect = (selector) => {
    selector.each(function () {
        if ($(this)[0].sumo) {
            $(this)[0].sumo.unload();
        }
    });
};

const initSumoSelect = (selector, placeholder = "Chọn thông tin") => {
    selector.SumoSelect({
        okCancelInMulti: false,
        csvDispCount: 1,
        selectAll: true,
        search: true,
        searchText: "Nhập tìm kiếm...",
        placeholder: placeholder,
        captionFormat: "Đã chọn {0} lựa chọn",
        captionFormatAllSelected: "Đã chọn tất cả {0} lựa chọn",
        captionFormatAllSelected: "Tất cả",
        locale: ["Xác nhận", "Hủy", "Chọn tất cả"],
    });
};

const destroyDataTable = (element) => {
    if ($.fn.DataTable.isDataTable(element)) {
        element.DataTable().destroy();
    }
};

const createDataTable = (element, option = {}, lang = 'vi') => {
    const lengthMenuAll = lang === 'vi' ? "Tất cả" : "All";
    const language = {
        sLengthMenu: "Hiển thị _MENU_ bản ghi",
        searchPlaceholder: "Nhập từ khóa...",
        info: "Từ _START_ đến _END_ | Tổng số _TOTAL_",
        sInfoEmpty: "Không có dữ liệu",
        sEmptyTable: "Không có dữ liệu",
        sSearch: "Tìm kiếm",
        sZeroRecords: "Không tìm thấy dữ liệu phù hợp",
        sInfoFiltered: "",
        paginate: {
            previous: "<i class='ri-arrow-left-line'>",
            next: "<i class='ri-arrow-right-line'>",
        },
    };
    element.DataTable({
        responsive: !0,
        pageLength: 20,
        order: [],
        lengthMenu: [
            [10, 20, 50, -1],
            [10, 20, 50, lengthMenuAll],
        ],

        ...option,

        language: lang === 'vi' ? language : {},
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    });

    new $.fn.dataTable.FixedHeader(element);
};

const show_loading_Filter = () => {
    const filter = $("#filter");
    const download = $("#export");
    filter.addClass("disabled");
    download.addClass("disabled");
    const text = filter.text();
    filter.html(
        `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> ${text}`
    );
};

const hide_loading_Filter = () => {
    const filter = $("#filter");
    const download = $("#export");
    filter.removeClass("disabled");
    download.removeClass("disabled");
    const text = filter.text();
    filter.html(`<i class="ri-filter-line me-2"></i> ${text}`);
};

const getData = (method = "GET", url, params, token) => {
    return new Promise((resolve, reject) => {
        if (method == "POST") {
            params = { ...params, _token: token };
        }

        xhrAjax = $.ajax({
            type: method,
            url: url,
            data: params,
            success: function (response, status, xhr) {
                resolve(response);
            },
            error: function (xhr, status, error) {
                reject(xhr.responseJSON || error);
            },
        });
    });
};

const downloadFile = (path) => {
    if (path == "") {
        showToast("Không tìm thấy tệp tin", "err");
    } else {
        window.open(path, "_blank");
    }
};

const initializeTooltips = () => {
    var tooltipTriggerList = Array.from(
        document.querySelectorAll('[data-toggle="tooltip"]')
    );
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
};

const showPass = (el, el_icon) => {
    var icon = el_icon.find("i");
    var type = el.attr("type") === "password" ? "text" : "password";
    el.attr("type", type);
    if (type === "password") {
        icon.removeClass("ri-eye-line").addClass("ri-eye-close-line");
    } else {
        icon.removeClass("ri-eye-close-line").addClass("ri-eye-line");
    }
};

const dmY_To_Ymd = (dateStr) => {
    const [day, month, year] = dateStr.split("-");
    const formattedDate = `${year}-${month}-${day}`;
    return formattedDate;
};

const formatISODateTime = (isoString) => {
    const date = new Date(isoString);

    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0"); // Tháng bắt đầu từ 0 nên +1
    const year = date.getFullYear();

    const hours = String(date.getHours()).padStart(2, "0");
    const minutes = String(date.getMinutes()).padStart(2, "0");
    const seconds = String(date.getSeconds()).padStart(2, "0");

    return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
};

const formatTime = (time) => {
    const date = new Date(time);
    return date.toLocaleDateString("vi-VN", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
    });
};

const buttonLoading = (eleButton) => {
    eleButton.prop("disabled", true);
    eleButton.html(
        /*html*/
        `<p class="mb-0"><span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...</p>`
    );
};

const buttonReset = (eleButton, text = "Xác nhận") => {
    eleButton.prop("disabled", false);
    eleButton.html(text);
};

const moreTitles = (eles) => {
    if (!eles || !eles.length) return;
    eles.each((_, moreTitle) => {
        const parent = moreTitle.parentElement;
        const child = parent.children[0];
        const textShort = child.innerText;
        const textFull = child.title;
        moreTitle.addEventListener("click", () => {
            if (child.innerText.length <= 50) {
                child.innerText = textFull;
            } else {
                child.innerText = textShort;
            }
        });
    });
};

const countTimeDeadline = (eles, text = "Hết hạn") => {
    eles.each((_, time) => {
        if (!time.dataset.time) return;
        var countDownDate = new Date(time.dataset.time).getTime();
        var x = setInterval(() => {
            var now = new Date().getTime();
            var distance = countDownDate - now;

            const TIME_MAX = 3 * 60 * 60 * 1000;
            if (distance < TIME_MAX) {
                // nếu còn 3h thì high thẻ cha lần thứ 2, chuyển màu chữ của dòng thành màu đó thêm !important
                time.parentElement.parentElement.classList.add("light");
            }

            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor(
                (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
            );
            var minutes = Math.floor(
                (distance % (1000 * 60 * 60)) / (1000 * 60)
            );
            time.innerHTML = days + "d " + hours + "h " + minutes + "m ";
            if (distance < 0) {
                clearInterval(x);
                time.innerHTML = text;
            }
        }, 1000);
    });
};
