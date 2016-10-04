/*
 Здесь функционал, например
 $('body').bem('menu', ['hover']);
 */
$(document).ready(function () {
    $('body').bem('button', ['hover', 'focus']);
    $('body').bem('menu', ['hover']);
    $('body').bem('input', ['focus']);
    $('body').bem('select', ['focus']);

    $('body').bem('header__city', ['hover']);
    $('body').bem('dropdown__link', ['hover']);
    $('body').bem('menu_left__item', ['hover']);
    $('body').bem('menu_right__item', ['hover']);
    $('body').bem('menu_right__layout', ['hover']);
    $('body').bem('icon_bank', ['hover']);

    $(".button_toggle").click(function () {
        var menu = $(document).find(".menu_h");
        if (menu.css('display') == 'none') menu.slideDown();
        else {
            menu.slideUp();
            setTimeout(function () {
                menu.removeAttr('style');
            }, 500);

        }
    });

    /* questions slider */
    var q2 = $(document).find(".question_2");
    var q1 = $(document).find(".question_1");
    var q = 1;
    setInterval(function () {
        if (q2.css('display') == 'none') {
            if (q < 8) {
                q++;
                var qn = $(document).find(".question_" + q);
                var txt = qn.text();
                q1.text(txt);
            } else {
                q = 1;
                q1.text('С чего начать?')
            }
        }
        else {
            q1.text('С чего начать?')
        }
    }, 3000);


});
function checkSearch() {
    var type_search = $('input[name=option]:checked').val();
    var adv =  $(document).find(".form__advance");
    adv.css("display", 'inline-block');
    if (type_search == 'advance_search') adv.css("display", 'inline-block');
    else adv.css("display", "none");
}