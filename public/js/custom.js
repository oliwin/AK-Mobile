/* Custom.js File */

/* Load prototype fields by click on ptototype item */

var config = {
    'path': 'http://localhost:8888/public/',
    'routes': {
        'prototype_fields': 'prototype/fields/',
        'fields_multi': 'fields/prototype/'
    }
};

var num = 0;

$(document).on('click', '.add-more', function () {
    $(".item-row:first").clone().prependTo(".input-append");
    $(".item-row:first").find("input:last").val('');
    num++;
});

$(function () {

    $('.prototype-list input:radio').click(function () {

        var value = $(this).val();

        $.get(
            config['path'] + config['routes']['prototype_fields'] + value,
            function (data) {
                $("#FieldsInPrototype .list").html(data);
            },
            'html'
        );

    });

    // Select type parameters with loading fields

    $('.select-parameter-type select').on('change', function () {

        var parent_id = 0;
        var type = $(this).val();

        if ($('#parent_id').length) {
            parent_id = $("#parent_id").val();
        }

        if (type == "1") {
            $('.fields-object').hide();
            $('.fields-array').hide();
        }

        if (type == "3") {
            $('.fields-object').hide();
        }

        if (type == "2") {
            $('.fields-object').hide();
            $('.fields-array').show();
        }

        $.get(
            config['path'] + config['routes']['fields_multi'] + type,
            function (data) {
                $(".content-fields-multi").html(data).show();
            },
            'html'
        );
    })

    /* Confirmation click */

    $('.delete').click(function () {
        if (window.confirm('Are you sure？')) {
            return true;
        }

        return false;
    });

});
