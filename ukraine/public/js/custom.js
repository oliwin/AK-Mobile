var url = 'http://ukraine.webtm.ru/public/';

var template = '<tr id="result_%id%">\
<td>\
<input type="checkbox" class="check" name="item[%id%][]" value="">\
    </td>\
    <td>\
    %id%\
    </td>\
    <td>\
    %name%\
</td>\
<td>\
№ %type_work%\
</td>\
<td>\
%group%\
</td>\
<td>\
<strong>\
%code%\
</strong>\
</td>\
<td>\
%position%\
</td>\
<td>\
%enterprise%\
</td>\
<td>\
<span class="status yellow"> В обработке</span></td>\
<td>\
<a class="btn btn-primary" href="http://ukraine.webtm.ru/public/cabinet/test/%id%">Детально</a>\
</td></tr>';

/******************* Template js parser *************************************/
var parseTpl = function (tpl, vars) {
    this.rplc = function (needle, subject, where) {
        where = where.replace(needle, subject);

        return (where.indexOf(needle) != -1 ? arguments.callee(arguments[0], arguments[1], arguments[2]) : where.replace(needle, subject));
    }
    for (var index in vars) {
        if (typeof vars[index] == "undefined" || vars[index] == null) {
            tpl = this.rplc('%' + index + '%', '', tpl);
        } else {
            tpl = this.rplc('%' + index + '%', vars[index], tpl);
        }
    }
    return tpl;
}
/******************* End template js parser *************************************/

/* Sync */
function Sync() {
    alert("Done");
    if (confirmation("Синхронизировать?")) {
    }
}

function loadGraphFactory() {

    var id = $("#enterprise").val();
    var day = $("#day").val();
    var month = $("#month").val();
    var year = $("#year").val();

    $.get(
        url + "cabinet/statistic/graph",
        {id: id, day: day, month: month, year: year},
        function (data) {
            alert("d");
        },
        'json'
    );
}

/* Bootstrap modal */
$(document).ready(function () {

    setInterval(function () {
        $.get(url + 'counter', function (data) {
            $('.conclusions').text(data.conclusions);
        });
    }, 20000);


    $('#myModal').on('hidden.bs.modal', function () {
        $("#modalSuccess").modal('show');
    });
});

$(function () {
    $('#datetimepicker').datetimepicker(
        {pickTime: false, language: 'ru'}
    );

    /* Check IDN */

    $("#IDN").blur(function () {

        var idn = $("#IDN").val();

        $.get(
            url + "check/applicant",     // url
            {idn: idn},          // data
            function (data) {               // success
                console.log(data);

                if (data !== null) {

                    var date = data.datebirth;
                    date = date.split('-');

                    $('#name').val(data.name);
                    $('#secondname').val(data.secondname);
                    $('#patronymic').val(data.patronymic);
                    $('#profession').val(data.profession);
                    $('#selectDate').val(date[0]);
                    $('#month').val(date[1]);
                    $('#year').val(date[2]);
                    $('#type_work').val(data.type_work);
                    $('#status_pass').val(data.status_pass);
                    $('#payment').val(data.payment_type);

                    if (data.sex == 1) {
                        $('#male').attr("checked", true);
                    }

                    if (data.sex == 2) {
                        $('#female').attr("checked", true);
                    }

                } else {

                    alert("Пользователь с таким идентификатор не существует!");
                }
            },
            'json'
        );

        return false;
    });
});

/* Print functions */

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

function print() {

    $("#registered-clients-table").print({
        globalStyles: true,
        mediaPrint: true,
        stylesheet: null,
        noPrintSelector: ".no-print",
        iframe: false,
        append: null,
        prepend: null,
        manuallyCopyFormValues: true,
        deferred: $.Deferred(),
        timeout: 750,
        title: "Список зарегистрированных",
        doctype: '<!doctype html>'
    });
}

/* File uplaod */
// When the server is ready...
$(function () {
    'use strict';

    // Define the url to send the image data to
    var url = 'loadResultTest';
    var uploaded = 0;

    // Call the fileupload widget and set some parameters
    $('.fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {

            $.each(data.result.codes, function (i, val) {

                $('#row-uploaded').text(++uploaded);
                $('#result_' + val).addClass("loaded_result_row");
                $('#result_' + val).find(".status").removeClass().addClass("green status btn").text("Загружено");

            });
        },

        fail: function (e, data) {

            var response = jQuery.parseJSON(data.jqXHR.responseText).error;

            $('#ModalMessage').modal('show');
            $('#ModalMessage').find('.modal-title').text("Системное уведомление");
            $('#ModalMessage').find("ul").html('').append("<li>" + response + "</li>");

            $('.progress-bar').css("width", "0%");

            /*var list = $("#ModalMessage").find('ul');

            $.each(data.result.error, function (i, v) {
                list.append('<li>№' + v.id + " " + v.name + '</li>');
            });*/
        },

        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    });
});


function selectedCheckboxes() {

    $("input[class='check']:checked").each(function () {
        if (this.checked) {
            $(this).closest("tr").removeClass("no-print");
        } else {
            $(this).closest("tr").addClass("no-print");
        }
    });
}

function refreshSelectedCheckbox(th) {

    var number = selectedCheckboxCount();

    if (number > 0) {

        $("#button-selected-change").prop("disabled", false);
        $("#button-selected").prop("disabled", false);
    } else {
        $("#button-selected-change").prop("disabled", true);
        $("#button-selected").prop("disabled", true);
    }

    $("#button-selected").find("span").text(number);
}

function selectedCheckboxCount() {
    return $('input[class="check"]:checked').length;
}

/* Checkboxes */
$(function () {

    $("#button-selected-change").click(function (e) {

        $('#fountainG').show();
        e.preventDefault();

        var selected = [];
        $("input[class='check']:checked").each(function () {
            selected.push($(this).val());
        });

        if (selected.length > 0) {

            $('#button-selected-change').find('.ccc').hide();
            $.ajax({
                type: 'POST',
                url: url + 'cabinet/test/change',
                data: {"selected": selected, _token: window.Laravel.csrfToken},
                success: function (data, textStatus, xhr) {

                    if (xhr.status == 200) {
                        $.each(data.results, function (i, val) {

                            $('#result_' + val.id).addClass("opacity-loaded");

                            setTimeout(function () {
                                $('#result_' + val.id).fadeOut();
                            }, 1100);

                        });

                        $('#fountainG').hide();
                        $('#button-selected-change').find('.ccc').show();
                        selected = [];
                    }

                }
            });
        }

    });

    $("#button-selected").click(function (e) {

        $('#fountainG').show();
        e.preventDefault();

        var selected = [];
        $("input[class='check']:checked").each(function () {
            selected.push($(this).val());
        });

        if (selected.length > 0) {

            $('#button-selected').find('.ccc').hide();
            $.ajax({
                type: 'POST',
                url: url + 'cabinet/send/results',
                data: {"selected": selected, _token: window.Laravel.csrfToken},
                success: function (data, textStatus, xhr) {

                    if (xhr.status == 200) {
                        $.each(data.results, function (i, val) {

                            $('#result_' + val.client_id).addClass("opacity-loaded");

                            setTimeout(function () {
                                $('#result_' + val.client_id).fadeOut();
                            }, 1100);

                        });

                        $('#row-sent').text(data.total);
                        $('#button-selected').text("Отправлено").prop("disabled", true);
                        $('#fountainG').hide();
                        $('#button-selected').find('.ccc').show();
                        selected = [];

                        if(data.total > 0) {
                            $("#collapseTwo span.conclusions").text(data.total).show();
                        }
                    }

                }
            });
        }
    });

    $("#status_pass").change(function () {

        var selected = 2
        var selected_default = 1
        var val = $(this).val();

        if (val == selected) {
            $("#payment").val(selected)
        } else {
            $("#payment").val(selected_default)
        }
    });

    $("#checkAll").click(function (e) {
        e.preventDefault();
        $(".check").prop('checked', true);

        refreshSelectedCheckbox(this);
    });

    $("#uncCheckAll").click(function (e) {
        e.preventDefault();
        $(".check").prop('checked', false);

        refreshSelectedCheckbox(this);
    });

    $(".check").change(function () {
        refreshSelectedCheckbox(this);
        selectedCheckboxes();
    });


    function confirmation(title) {
        return confirm(title);
    }


});

