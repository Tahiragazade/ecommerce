
$(document).on('change', '.count' , function(event, jqXHR, settings) {

    var t = $(this)


    var basket_id = t.parents('tr').find('.basket_id').val()
    var count = t.val()

    $.ajax({
        url: '/ecommerce/frontend/web/index.php?r=site%2Fupdate',
        type: 'POST',
        data: {'count': count,'basket_id': basket_id},
        dataType: 'json',
        success: function(data) {
            if(data.success) {
                $('.price').html(data.totalPrice)
            }
        }
    });

    return false;
});

const checkbox = document.getElementById('shipping')

checkbox.addEventListener('change', (event) => {
  if (event.currentTarget.checked) {
    '<?php  $shipping=10; ?>'
  } else {
    '<?php  $shipping=0; ?>'
  }
})