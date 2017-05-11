/* Custom.js File */

/* Load prototype fields by click on ptototype item */

var config = {
   'path' : 'http://localhost:8888/dev/laravel/public/',
   'routes' : {
     'prototype_fields' : 'prototype/fields/',
     'fields_multi' : 'fields/type/multi/'
   }
};

$(function() {
  $('.prototype_item input:radio').click(function() {

      var value = $(this).val();

      $.get(
        config['path'] + config['routes']['prototype_fields'] + value,
        function(data) {
          $("#FieldsInPrototype .list").html('');

          $.each(data, function(index, value) {
            var content = "<div><span>" + value.name + "</span><input type='text' name='fields[" + value.id + "]' value='" + value.default + "'/></div>";
            $("#FieldsInPrototype .list").append(content);
          });

        },
        'json'
      );

    });

    // Select type parameter with loading fields

    $('.select-parameter-type select').on('change', function() {
        var value = $(this).val();

            if(value == 1){

                //$('.input-disable').attr("disabled", true);

                $.get(
                  config['path'] + config['routes']['fields_multi'] + value,
                  function(data) {
                      $(".content-fields-multi").html(data);
                  },
                  'html'
                );

              } else {
                //$('.input-disable').attr("disabled", false);
              }
    })

});
