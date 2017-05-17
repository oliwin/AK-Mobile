/* Custom.js File */

/* Load prototype fields by click on ptototype item */

var config = {
    'path': 'http://localhost:8080/public/',
    'routes': {
        'prototype_fields': 'prototype/fields/',
        'fields_multi': 'fields/type/'
    }
};

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

    // Select type parameter with loading fields

    $('.select-parameter-type select').on('change', function () {

        var value = $(this).val();
        var parent_id = $("#parent_id").val();

        if (value == '2') {
            $(".content-fields-multi").hide();
            return false;
        }

        $.get(
            config['path'] + config['routes']['fields_multi'] + parent_id,
            function (data) {
                $(".content-fields-multi").html(data).show();
            },
            'html'
        );
    })

    /* Confirmation click */

    $('.delete').click(function() {
        if (window.confirm('Are you sure？')) {
            return true;
        }

        return false;
    });

});
