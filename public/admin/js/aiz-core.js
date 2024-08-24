//custom jquery method for toggle attr
$.fn.toggleAttr = function (attr, attr1, attr2) {
    return this.each(function () {
        var self = $(this);
        if (self.attr(attr) == attr1) self.attr(attr, attr2);
        else self.attr(attr, attr1);
    });
};
(function ($) {
    // USE STRICT
    "use strict";


    AIZ.plugins = {
        metismenu: function () {
            $('[data-toggle="aiz-side-menu"]').metisMenu();
        },
        bootstrapSelect: function (refresh = "") {
            $(".aiz-selectpicker").each(function (el) {
                var $this = $(this);
                if (!$this.parent().hasClass("bootstrap-select")) {
                    var selected = $this.data("selected");
                    if (typeof selected !== "undefined") {
                        $this.val(selected);
                    }
                    $this.selectpicker({
                        size: 5,
                        noneSelectedText: AIZ.local.nothing_selected,
                        virtualScroll: false,
                    });
                }
                if (refresh === "refresh") {
                    $this.selectpicker("refresh");
                }
                if (refresh === "destroy") {
                    $this.selectpicker("destroy");
                }
            });
        },
        tagify: function () {
            $(".aiz-tag-input")
                .not(".tagify")
                .each(function () {
                    var $this = $(this);

                    var maxTags = $this.data("max-tags");
                    var whitelist = $this.data("whitelist");
                    var onchange = $this.data("on-change");

                    maxTags = !maxTags ? Infinity : maxTags;
                    whitelist = !whitelist ? [] : whitelist;

                    $this.tagify({
                        maxTags: maxTags,
                        whitelist: whitelist,
                        dropdown: {
                            enabled: 1,
                        },
                    });
                    try {
                        callback = eval(onchange);
                    } catch (e) {
                        var callback = "";
                    }
                    if (typeof callback == "function") {
                        $this.on("removeTag", function () {
                            callback();
                        });
                        $this.on("add", function () {
                            callback();
                        });
                    }
                });
        },
        textEditor: function () {
            $(".aiz-text-editor").each(function (el) {
                var $this = $(this);
                var buttons = $this.data("buttons");
                var minHeight = $this.data("min-height");
                var placeholder = $this.attr("placeholder");
                var format = $this.data("format");

                buttons = !buttons
                    ? [
                          ["font", ["bold", "underline", "italic", "clear"]],
                          ["para", ["ul", "ol", "paragraph"]],
                          ["style", ["style"]],
                          ["color", ["color"]],
                          ["table", ["table"]],
                          ["insert", ["link", "picture", "video"]],
                          ["view", ["fullscreen", "undo", "redo"]],
                      ]
                    : buttons;
                placeholder = !placeholder ? "" : placeholder;
                minHeight = !minHeight ? 200 : minHeight;
                format = typeof format == "undefined" ? false : format;

                $this.summernote({
                    toolbar: buttons,
                    placeholder: placeholder,
                    disableDragAndDrop: true,
                    height: minHeight,
                    callbacks: {
                        onImageUpload: function (data) {
                            data.pop();
                        },
                        onPaste: function (e) {
                            if (format) {
                                var bufferText = (
                                    (e.originalEvent || e).clipboardData ||
                                    window.clipboardData
                                ).getData("Text");
                                e.preventDefault();
                                document.execCommand(
                                    "insertText",
                                    false,
                                    bufferText
                                );
                            }
                        },
                    },
                });

                var nativeHtmlBuilderFunc = $this.summernote(
                    "module",
                    "videoDialog"
                ).createVideoNode;

                $this.summernote("module", "videoDialog").createVideoNode =
                    function (url) {
                        var wrap = $(
                            '<div class="embed-responsive embed-responsive-16by9"></div>'
                        );
                        var html = nativeHtmlBuilderFunc(url);
                        html = $(html).addClass("embed-responsive-item");
                        return wrap.append(html)[0];
                    };
            });
        },
        dateRange: function () {
            $(".aiz-date-range").each(function () {
                var $this = $(this);
                var today = moment().startOf("day");
                var value = $this.val();
                var startDate = false;
                var minDate = false;
                var maxDate = false;
                var advncdRange = false;
                var ranges = {
                    Today: [moment(), moment()],
                    Yesterday: [
                        moment().subtract(1, "days"),
                        moment().subtract(1, "days"),
                    ],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [
                        moment().startOf("month"),
                        moment().endOf("month"),
                    ],
                    "Last Month": [
                        moment().subtract(1, "month").startOf("month"),
                        moment().subtract(1, "month").endOf("month"),
                    ],
                };

                var single = $this.data("single");
                var monthYearDrop = $this.data("show-dropdown");
                var format = $this.data("format");
                var separator = $this.data("separator");
                var pastDisable = $this.data("past-disable");
                var futureDisable = $this.data("future-disable");
                var timePicker = $this.data("time-picker");
                var timePickerIncrement = $this.data("time-gap");
                var advncdRange = $this.data("advanced-range");

                single = !single ? false : single;
                monthYearDrop = !monthYearDrop ? false : monthYearDrop;
                format = !format ? "YYYY-MM-DD" : format;
                separator = !separator ? " / " : separator;
                minDate = !pastDisable ? minDate : today;
                maxDate = !futureDisable ? maxDate : today;
                timePicker = !timePicker ? false : timePicker;
                timePickerIncrement = !timePickerIncrement
                    ? 1
                    : timePickerIncrement;
                ranges = !advncdRange ? "" : ranges;

                $this.daterangepicker({
                    singleDatePicker: single,
                    showDropdowns: monthYearDrop,
                    minDate: minDate,
                    maxDate: maxDate,
                    timePickerIncrement: timePickerIncrement,
                    autoUpdateInput: false,
                    ranges: ranges,
                    locale: {
                        format: format,
                        separator: separator,
                        applyLabel: "Select",
                        cancelLabel: "Clear",
                    },
                });
                if (single) {
                    $this.on("apply.daterangepicker", function (ev, picker) {
                        $this.val(picker.startDate.format(format));
                    });
                } else {
                    $this.on("apply.daterangepicker", function (ev, picker) {
                        $this.val(
                            picker.startDate.format(format) +
                                separator +
                                picker.endDate.format(format)
                        );
                    });
                }

                $this.on("cancel.daterangepicker", function (ev, picker) {
                    $this.val("");
                });
            });
        },
        timePicker: function () {
            $(".aiz-time-picker").each(function () {
                var $this = $(this);

                var minuteStep = $this.data("minute-step");
                var defaultTime = $this.data("default");

                minuteStep = !minuteStep ? 10 : minuteStep;
                defaultTime = !defaultTime ? "00:00" : defaultTime;

                $this.timepicker({
                    template: "dropdown",
                    minuteStep: minuteStep,
                    defaultTime: defaultTime,
                    icons: {
                        up: "las la-angle-up",
                        down: "las la-angle-down",
                    },
                    showInputs: false,
                });
            });
        },
        colorPicker: function () {
            $(".aiz-color-picker").on("change", function () {
                var $this = $(this);
                let value = $this.val();
                $this.parent().parent().siblings(".aiz-color-input").val(value);
            });
            $(".aiz-color-input").on("change", function () {
                var $this = $(this);
                let value = $this.val();
                $(this)
                    .siblings(".input-group-append")
                    .children(".input-group-text")
                    .children(".aiz-color-picker")
                    .val(value);
            });
        },
        fooTable: function () {
            $(".aiz-table").each(function () {
                var $this = $(this);

                var empty = $this.data("empty");
                empty = !empty ? AIZ.local.nothing_found : empty;

                $this.footable({
                    breakpoints: {
                        xs: 576,
                        sm: 768,
                        md: 992,
                        lg: 1200,
                        xl: 1400,
                    },
                    cascade: true,
                    on: {
                        "ready.ft.table": function (e, ft) {
                            AIZ.extra.deleteConfirm();
                            AIZ.plugins.bootstrapSelect("refresh");
                        },
                    },
                    empty: empty,
                });
            });
        },
        notify: function (type = "dark", message = "") {
            $.notify(
                {
                    // options
                    message: message,
                },
                {
                    // settings
                    showProgressbar: true,
                    delay: 2500,
                    mouse_over: "pause",
                    placement: {
                        from: "bottom",
                        align: "left",
                    },
                    animate: {
                        enter: "animated fadeInUp",
                        exit: "animated fadeOutDown",
                    },
                    type: type,
                    template:
                        '<div data-notify="container" class="aiz-notify alert alert-{0}" role="alert">' +
                        '<button type="button" aria-hidden="true" data-notify="dismiss" class="close"><i class="las la-times"></i></button>' +
                        '<span data-notify="message">{2}</span>' +
                        '<div class="progress" data-notify="progressbar">' +
                        '<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                        "</div>" +
                        "</div>",
                }
            );
        },
        aizUppy: function () {
            if ($("#aiz-upload-files").length > 0) {
                var uppy = Uppy.Core({
                    autoProceed: true,
                });
                uppy.use(Uppy.Dashboard, {
                    target: "#aiz-upload-files",
                    inline: true,
                    showLinkToFileUploadResult: false,
                    showProgressDetails: true,
                    hideCancelButton: true,
                    hidePauseResumeButton: true,
                    hideUploadButton: true,
                    proudlyDisplayPoweredByUppy: false,
                    locale: {
                        strings: {
                            addMoreFiles: AIZ.local.add_more_files,
                            addingMoreFiles: AIZ.local.adding_more_files,
                            dropPaste:
                                AIZ.local.drop_files_here_paste_or +
                                " %{browse}",
                            browse: AIZ.local.browse,
                            uploadComplete: AIZ.local.upload_complete,
                            uploadPaused: AIZ.local.upload_paused,
                            resumeUpload: AIZ.local.resume_upload,
                            pauseUpload: AIZ.local.pause_upload,
                            retryUpload: AIZ.local.retry_upload,
                            cancelUpload: AIZ.local.cancel_upload,
                            xFilesSelected: {
                                0: "%{smart_count} " + AIZ.local.file_selected,
                                1: "%{smart_count} " + AIZ.local.files_selected,
                            },
                            uploadingXFiles: {
                                0:
                                    AIZ.local.uploading +
                                    " %{smart_count} " +
                                    AIZ.local.file,
                                1:
                                    AIZ.local.uploading +
                                    " %{smart_count} " +
                                    AIZ.local.files,
                            },
                            processingXFiles: {
                                0:
                                    AIZ.local.processing +
                                    " %{smart_count} " +
                                    AIZ.local.file,
                                1:
                                    AIZ.local.processing +
                                    " %{smart_count} " +
                                    AIZ.local.files,
                            },
                            uploading: AIZ.local.uploading,
                            complete: AIZ.local.complete,
                        },
                    },
                });
                uppy.use(Uppy.XHRUpload, {
                    endpoint: AIZ.data.appUrl + "/aiz-uploader/upload",
                    fieldName: "aiz_file",
                    formData: true,
                    headers: {
                        "X-CSRF-TOKEN": AIZ.data.csrf,
                    },
                });
                uppy.on("upload-success", function () {
                    AIZ.uploader.getAllUploads(
                        AIZ.data.appUrl + "/aiz-uploader/get-uploaded-files"
                    );
                });
            }
        },
        tooltip: function () {
            $("body")
                .tooltip({ selector: '[data-toggle="tooltip"]' })
                .click(function () {
                    $('[data-toggle="tooltip"]').tooltip("hide");
                });
        },
        countDown: function () {
            if ($(".aiz-count-down").length > 0) {
                $(".aiz-count-down").each(function () {
                    var $this = $(this);
                    var date = $this.data("date");
                    // console.log(date)

                    $this
                        .countdown(date)
                        .on("update.countdown", function (event) {
                            var $this = $(this).html(
                                event.strftime(
                                    "" +
                                        '<div class="countdown-item"><span class="countdown-digit">%-D</span></div><span class="countdown-separator">:</span>' +
                                        '<div class="countdown-item"><span class="countdown-digit">%H</span></div><span class="countdown-separator">:</span>' +
                                        '<div class="countdown-item"><span class="countdown-digit">%M</span></div><span class="countdown-separator">:</span>' +
                                        '<div class="countdown-item"><span class="countdown-digit">%S</span></div>'
                                )
                            );
                        });
                });
            }
        },
        countDownCircle: function () {
            let html =
                '<div id="time"><div class="circle"><svg><circle cx="30" cy="30" r="30"></circle><circle cx="30" cy="30" r="30" id="dd"></circle></svg><div id="days">00 <br><span>Days</span></div></div>' +
                '<div class="circle"><svg><circle cx="30" cy="30" r="30"></circle><circle cx="30" cy="30" r="30" id="hh"></circle></svg><div id="hours">00 <br><span>Hrs</span></div></div>' +
                '<div class="circle"><svg><circle cx="30" cy="30" r="30"></circle><circle cx="30" cy="30" r="30" id="mm"></circle></svg><div id="minutes">00 <br><span>Min</span></div></div>' +
                '<div class="circle"><svg><circle cx="30" cy="30" r="30"></circle><circle cx="30" cy="30" r="30" id="ss"></circle></svg><div id="seconds">00 <br><span>Sec</span></div></div></div>';

            if ($(".aiz-count-down-circle").length > 0) {
                $(".aiz-count-down-circle").each(function () {
                    var $this = $(this);
                    $this.html(html);

                    let days = $this.find("#days");
                    let hours = $this.find("#hours");
                    let minutes = $this.find("#minutes");
                    let seconds = $this.find("#seconds");

                    let dd = $this.find("#dd");
                    let hh = $this.find("#hh");
                    let mm = $this.find("#mm");
                    let ss = $this.find("#ss");

                    // Date Format mm/dd/yyyy
                    var endDate = $this.attr("end-date");
                    let now = new Date(endDate).getTime();
                    let x = setInterval(function () {
                        let CountDown = new Date().getTime();
                        let distance = now - CountDown;
                        if (distance > 0) {
                            // Time calculation for days, hours, minutes & seconds
                            let d = Math.floor(
                                distance / (1000 * 60 * 60 * 24)
                            );
                            let h = Math.floor(
                                (distance % (1000 * 60 * 60 * 24)) /
                                    (1000 * 60 * 60)
                            );
                            let m = Math.floor(
                                (distance % (1000 * 60 * 60)) / (1000 * 60)
                            );
                            let s = Math.floor((distance % (1000 * 60)) / 1000);

                            // Output the results in elements with id
                            days.html(d + "<br><span>Days</span>");
                            hours.html(h + "<br><span>Hrs</span>");
                            minutes.html(m + "<br><span>Min</span>");
                            seconds.html(s + "<br><span>Sec</span>");

                            // Animate stroke
                            dd.css("strokeDashoffset", 190 - (190 * d) / 365); // 365 days in a year
                            hh.css("strokeDashoffset", 190 - (190 * h) / 24); // 24 hours in a day
                            mm.css("strokeDashoffset", 190 - (190 * m) / 60); // 60 minutes in an hour
                            ss.css("strokeDashoffset", 190 - (190 * s) / 60); // 60 seconds in a minute
                        } else {
                            // If Countdown is over
                            clearInterval(x);
                        }
                    });
                });
            }
        },
        slickCarousel: function () {
            $(".aiz-carousel")
                .not(".slick-initialized")
                .each(function () {
                    var $this = $(this);

                    var slidesPerViewXs = $this.data("xs-items");
                    var slidesPerViewSm = $this.data("sm-items");
                    var slidesPerViewMd = $this.data("md-items");
                    var slidesPerViewLg = $this.data("lg-items");
                    var slidesPerViewXl = $this.data("xl-items");
                    var slidesPerView = $this.data("items");

                    var slidesCenterMode = $this.data("center");
                    var slidesArrows = $this.data("arrows");
                    var slidesDots = $this.data("dots");
                    var slidesRows = $this.data("rows");
                    var slidesAutoplay = $this.data("autoplay");
                    var slidesAutoplaySpeed = $this.data("autoplay-speed");
                    var slidesFade = $this.data("fade");
                    var asNavFor = $this.data("nav-for");
                    var infinite = $this.data("infinite");
                    var focusOnSelect = $this.data("focus-select");
                    var adaptiveHeight = $this.data("auto-height");

                    var vertical = $this.data("vertical");
                    var verticalXs = $this.data("vertical-xs");
                    var verticalSm = $this.data("vertical-sm");
                    var verticalMd = $this.data("vertical-md");
                    var verticalLg = $this.data("vertical-lg");
                    var verticalXl = $this.data("vertical-xl");

                    slidesPerView = !slidesPerView ? 1 : slidesPerView;
                    slidesPerViewXl = !slidesPerViewXl
                        ? slidesPerView
                        : slidesPerViewXl;
                    slidesPerViewLg = !slidesPerViewLg
                        ? slidesPerViewXl
                        : slidesPerViewLg;
                    slidesPerViewMd = !slidesPerViewMd
                        ? slidesPerViewLg
                        : slidesPerViewMd;
                    slidesPerViewSm = !slidesPerViewSm
                        ? slidesPerViewMd
                        : slidesPerViewSm;
                    slidesPerViewXs = !slidesPerViewXs
                        ? slidesPerViewSm
                        : slidesPerViewXs;

                    vertical = !vertical ? false : vertical;
                    verticalXl =
                        typeof verticalXl == "undefined"
                            ? vertical
                            : verticalXl;
                    verticalLg =
                        typeof verticalLg == "undefined"
                            ? verticalXl
                            : verticalLg;
                    verticalMd =
                        typeof verticalMd == "undefined"
                            ? verticalLg
                            : verticalMd;
                    verticalSm =
                        typeof verticalSm == "undefined"
                            ? verticalMd
                            : verticalSm;
                    verticalXs =
                        typeof verticalXs == "undefined"
                            ? verticalSm
                            : verticalXs;

                    slidesCenterMode = !slidesCenterMode
                        ? false
                        : slidesCenterMode;
                    slidesArrows = !slidesArrows ? false : slidesArrows;
                    slidesDots = !slidesDots ? false : slidesDots;
                    slidesRows = !slidesRows ? 1 : slidesRows;
                    slidesAutoplay = !slidesAutoplay ? false : slidesAutoplay;
                    slidesAutoplaySpeed = !slidesAutoplaySpeed
                        ? "5000"
                        : slidesAutoplaySpeed;
                    slidesFade = !slidesFade ? false : slidesFade;
                    asNavFor = !asNavFor ? null : asNavFor;
                    infinite = !infinite ? false : infinite;
                    focusOnSelect = !focusOnSelect ? false : focusOnSelect;
                    adaptiveHeight = !adaptiveHeight ? false : adaptiveHeight;

                    var slidesRtl =
                        $("html").attr("dir") === "rtl" && !vertical
                            ? true
                            : false;
                    var slidesRtlXL =
                        $("html").attr("dir") === "rtl" && !verticalXl
                            ? true
                            : false;
                    var slidesRtlLg =
                        $("html").attr("dir") === "rtl" && !verticalLg
                            ? true
                            : false;
                    var slidesRtlMd =
                        $("html").attr("dir") === "rtl" && !verticalMd
                            ? true
                            : false;
                    var slidesRtlSm =
                        $("html").attr("dir") === "rtl" && !verticalSm
                            ? true
                            : false;
                    var slidesRtlXs =
                        $("html").attr("dir") === "rtl" && !verticalXs
                            ? true
                            : false;

                    $this.slick({
                        slidesToShow: slidesPerView,
                        autoplay: slidesAutoplay,
                        autoplaySpeed: slidesAutoplaySpeed,
                        dots: slidesDots,
                        arrows: slidesArrows,
                        infinite: infinite,
                        vertical: vertical,
                        rtl: slidesRtl,
                        rows: slidesRows,
                        centerPadding: "0px",
                        centerMode: slidesCenterMode,
                        fade: slidesFade,
                        asNavFor: asNavFor,
                        focusOnSelect: focusOnSelect,
                        adaptiveHeight: adaptiveHeight,
                        slidesToScroll: 1,
                        prevArrow:
                            '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
                        nextArrow:
                            '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
                        responsive: [
                            {
                                breakpoint: 1500,
                                settings: {
                                    slidesToShow: slidesPerViewXl,
                                    vertical: verticalXl,
                                    rtl: slidesRtlXL,
                                },
                            },
                            {
                                breakpoint: 1200,
                                settings: {
                                    slidesToShow: slidesPerViewLg,
                                    vertical: verticalLg,
                                    rtl: slidesRtlLg,
                                },
                            },
                            {
                                breakpoint: 992,
                                settings: {
                                    slidesToShow: slidesPerViewMd,
                                    vertical: verticalMd,
                                    rtl: slidesRtlMd,
                                },
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: slidesPerViewSm,
                                    vertical: verticalSm,
                                    rtl: slidesRtlSm,
                                },
                            },
                            {
                                breakpoint: 576,
                                settings: {
                                    slidesToShow: slidesPerViewXs,
                                    vertical: verticalXs,
                                    rtl: slidesRtlXs,
                                },
                            },
                        ],
                    });
                });
        },
        chart: function (selector, config) {
            if (!$(selector).length) return;

            $(selector).each(function () {
                var $this = $(this);

                var aizChart = new Chart($this, config);
            });
        },
        noUiSlider: function () {
            if ($(".aiz-range-slider")[0]) {
                $(".aiz-range-slider").each(function () {
                    var c = document.getElementById("input-slider-range"),
                        d = document.getElementById(
                            "input-slider-range-value-low"
                        ),
                        e = document.getElementById(
                            "input-slider-range-value-high"
                        ),
                        f = [d, e];

                    noUiSlider.create(c, {
                        start: [
                            parseInt(d.getAttribute("data-range-value-low")),
                            parseInt(e.getAttribute("data-range-value-high")),
                        ],
                        connect: !0,
                        range: {
                            min: parseInt(
                                c.getAttribute("data-range-value-min")
                            ),
                            max: parseInt(
                                c.getAttribute("data-range-value-max")
                            ),
                        },
                    }),
                        c.noUiSlider.on("update", function (a, b) {
                            f[b].textContent = a[b];
                        }),
                        c.noUiSlider.on("change", function (a, b) {
                            rangefilter(a);
                        });
                });
            }
        },
        zoom: function () {
            if ($(".img-zoom")[0]) {
                $(".img-zoom").zoom({
                    magnify: 1.5,
                });
                if (
                    "ontouchstart" in window ||
                    navigator.maxTouchPoints > 0 ||
                    navigator.msMaxTouchPoints > 0
                ) {
                    $(".img-zoom").trigger("zoom.destroy");
                }
            }
        },
        jsSocials: function () {
            if ($(".aiz-share")[0]) {
                $(".aiz-share").jsSocials({
                    showLabel: false,
                    showCount: false,
                    shares: [
                        {
                            share: "email",
                            logo: "lar la-envelope",
                        },
                        {
                            share: "twitter",
                            logo: "lab la-twitter",
                        },
                        {
                            share: "facebook",
                            logo: "lab la-facebook-f",
                        },
                        {
                            share: "linkedin",
                            logo: "lab la-linkedin-in",
                        },
                        {
                            share: "whatsapp",
                            logo: "lab la-whatsapp",
                        },
                    ],
                });
            }
        },
        particles: function () {
            particlesJS(
                "particles-js",

                {
                    particles: {
                        number: {
                            value: 80,
                            density: {
                                enable: true,
                                value_area: 800,
                            },
                        },
                        color: {
                            value: "#dfdfe6",
                        },
                        shape: {
                            type: "circle",
                            stroke: {
                                width: 0,
                                color: "#000000",
                            },
                            polygon: {
                                nb_sides: 5,
                            },
                            image: {
                                src: "img/github.svg",
                                width: 100,
                                height: 100,
                            },
                        },
                        opacity: {
                            value: 0.5,
                            random: false,
                            anim: {
                                enable: false,
                                speed: 1,
                                opacity_min: 0.1,
                                sync: false,
                            },
                        },
                        size: {
                            value: 5,
                            random: true,
                            anim: {
                                enable: false,
                                speed: 40,
                                size_min: 0.1,
                                sync: false,
                            },
                        },
                        line_linked: {
                            enable: true,
                            distance: 150,
                            color: "#dfdfe6",
                            opacity: 0.4,
                            width: 1,
                        },
                        move: {
                            enable: true,
                            speed: 6,
                            direction: "none",
                            random: false,
                            straight: false,
                            out_mode: "out",
                            attract: {
                                enable: false,
                                rotateX: 600,
                                rotateY: 1200,
                            },
                        },
                    },
                    interactivity: {
                        detect_on: "canvas",
                        events: {
                            onhover: {
                                enable: true,
                                mode: "repulse",
                            },
                            onclick: {
                                enable: true,
                                mode: "push",
                            },
                            resize: true,
                        },
                        modes: {
                            grab: {
                                distance: 400,
                                line_linked: {
                                    opacity: 1,
                                },
                            },
                            bubble: {
                                distance: 400,
                                size: 40,
                                duration: 2,
                                opacity: 8,
                                speed: 3,
                            },
                            repulse: {
                                distance: 200,
                            },
                            push: {
                                particles_nb: 4,
                            },
                            remove: {
                                particles_nb: 2,
                            },
                        },
                    },
                    retina_detect: true,
                    config_demo: {
                        hide_card: false,
                        background_color: "#b61924",
                        background_image: "",
                        background_position: "50% 50%",
                        background_repeat: "no-repeat",
                        background_size: "cover",
                    },
                }
            );
        },
    };
    AIZ.extra = {
        refreshToken: function () {
            $.get(AIZ.data.appUrl + "/refresh-csrf").done(function (data) {
                AIZ.data.csrf = data;
            });
            // console.log(AIZ.data.csrf);
        },
        mobileNavToggle: function () {
            if (window.matchMedia("(max-width: 1200px)").matches) {
                $("body").addClass("side-menu-closed");
            }
            $('[data-toggle="aiz-mobile-nav"]').on("click", function () {
                if ($("body").hasClass("side-menu-open")) {
                    $("body")
                        .addClass("side-menu-closed")
                        .removeClass("side-menu-open");
                } else if ($("body").hasClass("side-menu-closed")) {
                    $("body")
                        .removeClass("side-menu-closed")
                        .addClass("side-menu-open");
                } else {
                    $("body")
                        .removeClass("side-menu-open")
                        .addClass("side-menu-closed");
                }
            });
            $(".aiz-sidebar-overlay").on("click", function () {
                $("body")
                    .removeClass("side-menu-open")
                    .addClass("side-menu-closed");
            });
        },
        initActiveMenu: function () {
            $('[data-toggle="aiz-side-menu"] a').each(function () {
                var pageUrl = window.location.href.split(/[?#]/)[0];
                if (this.href == pageUrl || $(this).hasClass("active")) {
                    $(this).addClass("active");
                    $(this).closest(".aiz-side-nav-item").addClass("mm-active");
                    $(this)
                        .closest(".level-2")
                        .siblings("a")
                        .addClass("level-2-active");
                    $(this)
                        .closest(".level-3")
                        .siblings("a")
                        .addClass("level-3-active");
                }
            });
        },
        deleteConfirm: function () {
            $(".confirm-delete").click(function (e) {
                e.preventDefault();
                var url = $(this).data("href");
                $("#delete-modal").modal("show");
                $("#delete-link").attr("href", url);
            });

            $(".confirm-cancel").click(function (e) {
                e.preventDefault();
                var url = $(this).data("href");
                $("#cancel-modal").modal("show");
                $("#cancel-link").attr("href", url);
            });

            $(".confirm-complete").click(function (e) {
                e.preventDefault();
                var url = $(this).data("href");
                $("#complete-modal").modal("show");
                $("#comfirm-link").attr("href", url);
            });

            $(".confirm-alert").click(function (e) {
                e.preventDefault();
                var url = $(this).data("href");
                var target = $(this).data("target");
                $(target).modal("show");
                $(target).find(".comfirm-link").attr("href", url);
                $("#comfirm-link").attr("href", url);
            });
        },
        bytesToSize: function (bytes) {
            var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
            if (bytes == 0) return "0 Byte";
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
            return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
        },
        multiModal: function () {
            $(document).on("show.bs.modal", ".modal", function (event) {
                var zIndex = 1040 + 10 * $(".modal:visible").length;
                $(this).css("z-index", zIndex);
                setTimeout(function () {
                    $(".modal-backdrop")
                        .not(".modal-stack")
                        .css("z-index", zIndex - 1)
                        .addClass("modal-stack");
                }, 0);
            });
            $(document).on("hidden.bs.modal", function () {
                if ($(".modal.show").length > 0) {
                    $("body").addClass("modal-open");
                }
            });
        },
        bsCustomFile: function () {
            $(".custom-file input").change(function (e) {
                var files = [];
                for (var i = 0; i < $(this)[0].files.length; i++) {
                    files.push($(this)[0].files[i].name);
                }
                if (files.length === 1) {
                    $(this).next(".custom-file-name").html(files[0]);
                } else if (files.length > 1) {
                    $(this)
                        .next(".custom-file-name")
                        .html(files.length + " " + AIZ.local.files_selected);
                } else {
                    $(this)
                        .next(".custom-file-name")
                        .html(AIZ.local.choose_file);
                }
            });
        },
        stopPropagation: function () {
            $(document).on("click", ".stop-propagation", function (e) {
                e.stopPropagation();
            });
        },
        outsideClickHide: function () {
            $(document).on("click", function (e) {
                $(".document-click-d-none").addClass("d-none");
            });
        },
        inputRating: function () {
            $(".rating-input").each(function () {
                $(this)
                    .find("label")
                    .on({
                        mouseover: function (event) {
                            $(this).find("i").addClass("hover");
                            $(this).prevAll().find("i").addClass("hover");
                        },
                        mouseleave: function (event) {
                            $(this).find("i").removeClass("hover");
                            $(this).prevAll().find("i").removeClass("hover");
                        },
                        click: function (event) {
                            $(this).siblings().find("i").removeClass("active");
                            $(this).find("i").addClass("active");
                            $(this).prevAll().find("i").addClass("active");
                        },
                    });
                if ($(this).find("input").is(":checked")) {
                    $(this)
                        .find("label")
                        .siblings()
                        .find("i")
                        .removeClass("active");
                    $(this)
                        .find("input:checked")
                        .closest("label")
                        .find("i")
                        .addClass("active");
                    $(this)
                        .find("input:checked")
                        .closest("label")
                        .prevAll()
                        .find("i")
                        .addClass("active");
                }
            });
        },
        scrollToBottom: function () {
            $(".scroll-to-btm").each(function (i, el) {
                el.scrollTop = el.scrollHeight;
            });
        },
        classToggle: function () {
            $(document).on(
                "click",
                '[data-toggle="class-toggle"]',
                function () {
                    var $this = $(this);
                    var target = $this.data("target");
                    var sameTriggers = $this.data("same");
                    var backdrop = $(this).data("backdrop");

                    if ($(target).hasClass("active")) {
                        $(target).removeClass("active");
                        $(sameTriggers).removeClass("active");
                        $this.removeClass("active");
                        $("body").removeClass("overflow-hidden");
                    } else {
                        $(target).addClass("active");
                        $this.addClass("active");
                        if (backdrop == "static") {
                            $("body").addClass("overflow-hidden");
                        }
                    }
                }
            );
        },
        collapseSidebar: function () {
            $(document).on(
                "click",
                '[data-toggle="collapse-sidebar"]',
                function (i, el) {
                    var $this = $(this);
                    var target = $(this).data("target");
                    var sameTriggers = $(this).data("siblings");

                    // var showOverlay = $this.data('overlay');
                    // var overlayMarkup = '<div class="overlay overlay-fixed dark c-pointer" data-toggle="collapse-sidebar" data-target="'+target+'"></div>';

                    // showOverlay = !showOverlay ? true : showOverlay;

                    // if (showOverlay && $(target).siblings('.overlay').length !== 1) {
                    //     $(target).after(overlayMarkup);
                    // }

                    e.preventDefault();
                    if ($(target).hasClass("opened")) {
                        $(target).removeClass("opened");
                        $(sameTriggers).removeClass("opened");
                        $($this).removeClass("opened");
                    } else {
                        $(target).addClass("opened");
                        $($this).addClass("opened");
                    }
                }
            );
        },
        autoScroll: function () {
            if ($(".aiz-auto-scroll").length > 0) {
                $(".aiz-auto-scroll").each(function () {
                    var options = $(this).data("options");

                    options = !options
                        ? '{"delay" : 2000 ,"amount" : 70 }'
                        : options;

                    options = JSON.parse(options);

                    this.delay = parseInt(options["delay"]) || 2000;
                    this.amount = parseInt(options["amount"]) || 70;
                    this.autoScroll = $(this);
                    this.iScrollHeight = this.autoScroll.prop("scrollHeight");
                    this.iScrollTop = this.autoScroll.prop("scrollTop");
                    this.iHeight = this.autoScroll.height();

                    var self = this;
                    this.timerId = setInterval(function () {
                        if (
                            self.iScrollTop + self.iHeight <
                            self.iScrollHeight
                        ) {
                            self.iScrollTop = self.autoScroll.prop("scrollTop");
                            self.iScrollTop += self.amount;
                            self.autoScroll.animate(
                                { scrollTop: self.iScrollTop },
                                "slow",
                                "linear"
                            );
                        } else {
                            self.iScrollTop -= self.iScrollTop;
                            self.autoScroll.animate(
                                { scrollTop: "0px" },
                                "fast",
                                "swing"
                            );
                        }
                    }, self.delay);
                });
            }
        },
        addMore: function () {
            $('[data-toggle="add-more"]').each(function () {
                var $this = $(this);
                var content = $this.data("content");
                var target = $this.data("target");

                $this.on("click", function (e) {
                    e.preventDefault();
                    $(target).append(content);
                    AIZ.plugins.bootstrapSelect();
                });
            });
        },
        removeParent: function () {
            $(document).on(
                "click",
                '[data-toggle="remove-parent"]',
                function () {
                    var $this = $(this);
                    var parent = $this.data("parent");
                    $this.closest(parent).remove();
                }
            );
        },
        selectHideShow: function () {
            $('[data-show="selectShow"]').each(function () {
                var target = $(this).data("target");
                $(this).on("change", function () {
                    var value = $(this).val();
                    // console.log(value);
                    $(target)
                        .children()
                        .not("." + value)
                        .addClass("d-none");
                    $(target)
                        .find("." + value)
                        .removeClass("d-none");
                });
            });
        },
        plusMinus: function () {
            $(".aiz-plus-minus input").each(function () {
                var $this = $(this);
                var min = parseInt($(this).attr("min"));
                var max = parseInt($(this).attr("max"));
                var value = parseInt($(this).val());
                if (value <= min) {
                    $this
                        .siblings('[data-type="minus"]')
                        .attr("disabled", true);
                } else if (
                    $this.siblings('[data-type="minus"]').attr("disabled")
                ) {
                    $this
                        .siblings('[data-type="minus"]')
                        .removeAttr("disabled");
                }
                if (value >= max) {
                    $this.siblings('[data-type="plus"]').attr("disabled", true);
                } else if (
                    $this.siblings('[data-type="plus"]').attr("disabled")
                ) {
                    $this.siblings('[data-type="plus"]').removeAttr("disabled");
                }
            });
            $(".aiz-plus-minus button")
                .off("click")
                .on("click", function (e) {
                    e.preventDefault();

                    var fieldName = $(this).attr("data-field");
                    var type = $(this).attr("data-type");
                    var input = $("input[name='" + fieldName + "']");
                    var currentVal = parseInt(input.val());

                    if (!isNaN(currentVal)) {
                        if (type == "minus") {
                            if (currentVal > input.attr("min")) {
                                input.val(currentVal - 1).change();
                            }
                            if (parseInt(input.val()) == input.attr("min")) {
                                $(this).attr("disabled", true);
                            }
                        } else if (type == "plus") {
                            if (currentVal < input.attr("max")) {
                                input.val(currentVal + 1).change();
                            }
                            if (parseInt(input.val()) == input.attr("max")) {
                                $(this).attr("disabled", true);
                            }
                        }
                    } else {
                        input.val(0);
                    }
                });
            $(".aiz-plus-minus input")
                .off("change")
                .on("change", function () {
                    var minValue = parseInt($(this).attr("min"));
                    var maxValue = parseInt($(this).attr("max"));
                    var valueCurrent = parseInt($(this).val());

                    name = $(this).attr("name");
                    if (valueCurrent >= minValue) {
                        $(this)
                            .siblings("[data-type='minus']")
                            .removeAttr("disabled");
                    } else {
                        alert(
                            translate(
                                "Sorry, the minimum limit has been reached"
                            )
                        );
                        $(this).val(minValue);
                    }
                    if (valueCurrent <= maxValue) {
                        $(this)
                            .siblings("[data-type='plus']")
                            .removeAttr("disabled");
                    } else {
                        alert(
                            translate(
                                "Sorry, the maximum limit has been reached"
                            )
                        );
                        $(this).val(maxValue);
                    }

                    if (typeof getVariantPrice === "function") {
                        getVariantPrice();
                    }
                });
        },
        hovCategoryMenu: function () {
            $("#category-menu-icon, #category-sidebar")
                .on("mouseover", function (event) {
                    $("#hover-category-menu")
                        .addClass("active")
                        .removeClass("d-none");
                })
                .on("mouseout", function (event) {
                    $("#hover-category-menu")
                        .addClass("d-none")
                        .removeClass("active");
                });
        },
        clickCategoryMenu: function () {
            var menu = $("#click-category-menu");
            menu.hide();
            menu.removeClass("d-none");
            $("#category-menu-bar").on("click", function (event) {
                menu.slideToggle(500);
                if ($("#category-menu-bar-icon").hasClass("show")) {
                    $("#category-menu-bar-icon").removeClass("show");
                } else {
                    $("#category-menu-bar-icon").addClass("show");
                }
            });
        },
        hovUserTopMenu: function () {
            $("#nav-user-info")
                .on("mouseover", function (event) {
                    $(".hover-user-top-menu").addClass("active");
                })
                .on("mouseout", function (event) {
                    $(".hover-user-top-menu").removeClass("active");
                });
        },
        trimAppUrl: function () {
            if (AIZ.data.appUrl.slice(-1) == "/") {
                AIZ.data.appUrl = AIZ.data.appUrl.slice(
                    0,
                    AIZ.data.appUrl.length - 1
                );
                // console.log(AIZ.data.appUrl);
            }
        },
        setCookie: function (cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        },
        getCookie: function (cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(";");
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) === " ") {
                    c = c.substring(1);
                }
                if (c.indexOf(name) === 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        },
        acceptCookie: function () {
            if (!AIZ.extra.getCookie("acceptCookies")) {
                $(".aiz-cookie-alert").addClass("show");
            }
            $(".aiz-cookie-accept").on("click", function () {
                AIZ.extra.setCookie("acceptCookies", true, 60);
                $(".aiz-cookie-alert").removeClass("show");
            });
        },
        setSession: function () {
            $(".set-session").each(function () {
                var $this = $(this);
                var key = $this.data("key");
                var value = $this.data("value");

                const now = new Date();
                const item = {
                    value: value,
                    expiry: now.getTime() + 3600000,
                };

                $this.on("click", function () {
                    localStorage.setItem(key, JSON.stringify(item));
                });
            });
        },
        showSessionPopup: function () {
            $(".removable-session").each(function () {
                var $this = $(this);
                var key = $this.data("key");
                var value = $this.data("value");
                var item = {};
                if (localStorage.getItem(key)) {
                    item = localStorage.getItem(key);
                    item = JSON.parse(item);
                }
                const now = new Date();
                if (
                    typeof item.expiry == "undefined" ||
                    now.getTime() > item.expiry
                ) {
                    $this.removeClass("d-none");
                }
            });
        },
    };

    setInterval(function () {
        AIZ.extra.refreshToken();
    }, 3600000);

    // init aiz plugins, extra options
    AIZ.extra.initActiveMenu();
    AIZ.extra.mobileNavToggle();
    AIZ.extra.deleteConfirm();
    AIZ.extra.multiModal();
    AIZ.extra.inputRating();
    AIZ.extra.bsCustomFile();
    AIZ.extra.stopPropagation();
    AIZ.extra.outsideClickHide();
    AIZ.extra.scrollToBottom();
    AIZ.extra.classToggle();
    AIZ.extra.collapseSidebar();
    AIZ.extra.autoScroll();
    AIZ.extra.addMore();
    AIZ.extra.removeParent();
    AIZ.extra.selectHideShow();
    AIZ.extra.plusMinus();
    AIZ.extra.hovCategoryMenu();
    AIZ.extra.clickCategoryMenu();
    AIZ.extra.hovUserTopMenu();
    AIZ.extra.trimAppUrl();
    AIZ.extra.acceptCookie();
    AIZ.extra.setSession();
    AIZ.extra.showSessionPopup();

    AIZ.plugins.metismenu();
    AIZ.plugins.bootstrapSelect();
    AIZ.plugins.tagify();
    AIZ.plugins.textEditor();
    AIZ.plugins.tooltip();
    AIZ.plugins.countDown();
    AIZ.plugins.countDownCircle();
    AIZ.plugins.dateRange();
    AIZ.plugins.timePicker();
    AIZ.plugins.colorPicker();
    AIZ.plugins.fooTable();
    AIZ.plugins.slickCarousel();
    AIZ.plugins.noUiSlider();
    AIZ.plugins.zoom();
    AIZ.plugins.jsSocials();

    // initialization of aiz uploader
    AIZ.uploader.initForInput();
    AIZ.uploader.removeAttachment();
    AIZ.uploader.previewGenerate();

    // $(document).ajaxComplete(function(){
    //     AIZ.plugins.bootstrapSelect('refresh');
    // });

    var spinner =
        '<div class="h-100 d-flex align-items-center justify-content-center">' +
        '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>' +
        "</div>";
    top_category_products_tab("all");
    inhouse_top_brands("all");
    inhouse_top_categories("all");
    top_sellers_products_tab('all');
    top_brands_products_tab('all');

    $(".top_category_products_tab").click(function () {
        top_category_products_tab($(this).data("target"));
    });

    $(".inhouse_top_brands").click(function () {
        inhouse_top_brands($(this).data("target"));
    });

    $(".inhouse_top_categories").click(function () {
        inhouse_top_categories($(this).data("target"));
    });

    $(".top_sellers_products_tab").click(function () {
        top_sellers_products_tab($(this).data("target"));
    });

    $(".top_brands_products_tab").click(function () {
        top_brands_products_tab($(this).data("target"));
    });

    function top_category_products_tab(interval_type) {
        $("#top-category-products-section").html(spinner);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            url:
                AIZ.data.appUrl +
                "/admin/dashboard/top-category-products-section",
            data: {
                interval_type: interval_type,
            },
            success: function (data) {
                $("#top-category-products-section").html(data);
                AIZ.plugins.slickCarousel();
            },
        });
    }

    function inhouse_top_brands(interval_type) {
        $("#inhouse-top-brands").html(spinner);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            url: AIZ.data.appUrl + "/admin/dashboard/inhouse-top-brands",
            data: {
                interval_type: interval_type,
            },
            success: function (data) {
                $("#inhouse-top-brands").html(data);
            },
        });
    }

    function inhouse_top_categories(interval_type) {
        $("#inhouse-top-categories").html(spinner);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            url: AIZ.data.appUrl + "/admin/dashboard/inhouse-top-categories",
            data: {
                interval_type: interval_type,
            },
            success: function (data) {
                $("#inhouse-top-categories").html(data);
            },
        });
    }

    function top_sellers_products_tab(interval_type) {
        $("#top-sellers-products-section").html(spinner);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            url:
                AIZ.data.appUrl +
                "/admin/dashboard/top-sellers-products-section",
            data: {
                interval_type: interval_type,
            },
            success: function (data) {
                $("#top-sellers-products-section").html(data);
                AIZ.plugins.slickCarousel();
            },
        });
    }

    function top_brands_products_tab(interval_type) {
        $("#top-brands-products-section").html(spinner);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            url:
                AIZ.data.appUrl +
                "/admin/dashboard/top-brands-products-section",
            data: {
                interval_type: interval_type,
            },
            success: function (data) {
                $("#top-brands-products-section").html(data);
                AIZ.plugins.slickCarousel();
            },
        });
    }


})(jQuery);
