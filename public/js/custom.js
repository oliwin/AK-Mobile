/* Custom.js File */

/* Load prototype fields by click on ptototype item */

var config = {
   'path' : 'http://localhost:8888/dev/laravel/public/',
   'routes' : {
     'prototype_fields' : 'prototype/fields/'
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
});
