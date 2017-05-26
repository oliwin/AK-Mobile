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

/* Add element of array in objects/create */

$(document).on('click', '.add-more-element-array', function () {
    $(".parameters-list-array li:first").clone().prependTo(".parameters-list-array");
    $(".parameters-list-array li:first").find("input:last").val('');
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

        $('.parameters-type-value').hide();
        $('#parameters-type-value option[value="boolean"]').show();


        if ($('#parent_id').length) {
            parent_id = $("#parent_id").val();
        }

        if (type == "1") {
            $('.fields-object').hide();
            $('.fields-array').hide();
            $('.parameters-type-value').show();

            $('#parameters-type-value option[value="boolean"]').hide();
            $('#parameters-type-value option[value="vector2"]').hide();
            $('#parameters-type-value option[value="vector3"]').hide();
        }

        if (type == "3") {
            $('.fields-object').hide();
            $('.parameters-type-value').show();

            $('#parameters-type-value option[value="vector2"]').hide();
            $('#parameters-type-value option[value="vector3"]').hide();
        }

        if (type == "2") {
            $('.fields-object').hide();
            $('.fields-array').show();
        }

        if (type == "5") {
            $('.parameters-type-value').show();
        }

        $.get(
            config['path'] + config['routes']['fields_multi'] + type,
            function (data) {
                $(".content-fields-multi").html(data).show();
            },
            'html'
        );
    });

    /* Confirmation click */

    $('.delete').click(function () {
        if (window.confirm('Are you sure？')) {
            return true;
        }

        return false;
    });

});
