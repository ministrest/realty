$(document).ready(function(){
    $('#number_client').click(function(){
        $(this).removeClass('error_empty');
        $(this).parent().parent().parent().children('div.error_empty_txt').removeClass('visible_field');
    });
    $('#name_client').click(function(){
        $(this).removeClass('error_empty');
        $(this).removeClass('error_wrong');
        $(this).parent().parent().parent().children('div.error_empty_txt').removeClass('visible_field');
    });

    $('#contact_me').click(function(){

        var number_client   = $('#number_client').val();
        if (number_client===""){
            $('#number_client').toggleClass('error_empty');
            $('#number_client').parent().parent().parent().children('div.error_empty_txt').toggleClass('visible_field');
        } else {
            var re = /^\d[\d\(\)\ -]{4,14}\d$/;
            var valid = re.test(number_client);
            if (valid) {
                var name_client = $('#name_client').val();
                if (name_client==="") {
                    $('#name_client').toggleClass('error_empty');
                    $('#name_client').parent().parent().parent().children('div.error_empty_txt').toggleClass('visible_field');
                } else {
                    $.ajax({
                        url: "/contacts",
                        type: "post",
                        dataType: "json",
                        data: {
                            "name_client": name_client,
                            "number_client": number_client,
                        },
                        success: function (data) {
                            $('.messages').html(data.result); // выводим ответ сервера
                            $('.messages').toggleClass('visible_field');
                            $('#contact_form').toggleClass('invisible_field');
                        }
                    });
                }
            } else {
                $('#number_client').toggleClass('error_empty');
                $('#number_client').parent().parent().parent().children('div.error_empty_txt').toggleClass('visible_field');
            }
        }
    });
});