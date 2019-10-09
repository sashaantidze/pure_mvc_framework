function editContactDetail(element){
  var elem = $(element);
  var currentValue = elem.html();
  var fieldName = elem.attr('data-name');
  var rowID = elem.parent().attr("id").split("-")[1];
  var newValInput = '<input type="text" name="'+fieldName+'" value="'+currentValue+'" id="'+fieldName+'" class="form-control" style="display:none;">';

  elem.html(newValInput);
  $('#'+fieldName).fadeIn('fast');
  $('input#'+fieldName).focus();
  $('input#'+fieldName).focusout(function (){
    var newValue = $(this).val().trim();
    updateContactDetail(rowID, fieldName, currentValue, newValue);
  });
  elem.attr('ondblclick', '');

}


function updateContactDetail(id, field, value, newValue){
  var elemId = $('#'+field+'-'+id);
  if(value !== newValue){
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: '/mvc/contacts/updateContact',
      data: {
        contact_id:id,
        field: field,
        value: value,
        newValue: newValue
      },
      beforeSend: function(){
        elemId.addClass('td-loading');
        $('#headerLoader').fadeIn('fast');
        elemId.html('<div class="text-center"><i class="fas fa-spinner fa-2x fa-spin"></i></div><div style="font-size:12px;" class="text-center">Updating..</div>');
      },
      success: function(data){
        console.log(data);
        if(data.success){
          elemId.removeClass('td-loading');
          elemId.html(newValue);
          Swal.fire({
            type: 'success',
            title: data.contact,
            text: data.successMsg,
            showConfirmButton: true,
          });
        }
        else{
          elemId.html(value);
          elemId.removeClass('td-loading');
          if(data.validationErrors){
            var validErrors = '';
            $.each(data.validationErrors, function(key, value){
              validErrors = '<div>'+value+'</div>';
            });
            Swal.fire({
              type: 'error',
              title: 'Something went wrong',
              html: validErrors,
              showConfirmButton: true,
            });
          }
          if(data.errors){
            var errors = '';
            $.each(data.errors, function(key, value){
              errors = '<div>'+value+'</div>';
            });
            Swal.fire({
              type: 'error',
              title: 'Something broke..',
              html: errors,
              allowOutsideClick: false,
              showConfirmButton: true,
              confirmButtonText: '<span onclick=window.location.href="/mvc/contacts">Close <i class="fa fa-lg fa-frown"></i></span>'
            });
          }
        }
        $('#headerLoader').fadeOut('medium');
      }
    });

    elemId.attr("ondblclick", 'editContactDetail(this)');

  }
  else{
    elemId.html(value);
    elemId.attr("ondblclick", 'editContactDetail(this)');
  }
}
