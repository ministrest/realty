(function( $ ) {
    $.widget( "ui.combobox", {
        _create: function() {
            var self = this,
                select = this.element.hide(),
                selected = select.children( ":selected" ),
                value = selected.val().trim() ? selected.text().trim() : "",
                check = " disabled";
            if($("#streets").val()>0)  check = "";
            var input = this.input = $( "<input id='streets2'"+check+" placeholder='Не выбрано'>" )
                .insertAfter( select )
                .val( value )
                .autocomplete({
                    delay: 0,
                    minLength: 0,
                    source: function( request, response ) {
                        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                        response( select.children( "option" ).map(function() {
                            var text = $( this ).text();
                            if ( this.value && ( !request.term || matcher.test(text) ) )
                                return {
                                    label: text.replace(
                                        new RegExp(
                                            "(?![^&;]+;)(?!<[^<>]*)(" +
                                            $.ui.autocomplete.escapeRegex(request.term) +
                                            ")(?![^<>]*>)(?![^&;]+;)", "gi"
                                        ), '$1' ),
                                    value: text,
                                    option: this
                                };
                        }) );
                    },
                    select: function( event, ui ) {
                        ui.item.option.selected = true;
                        self._trigger( "selected", event, {
                            item: ui.item.option
                        });
                    },
                    change: function( event, ui ) {
                        if ( !ui.item ) {
                            var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
                                valid = false;
                            select.children( "option" ).each(function() {
                                if ( $( this ).text().match( matcher ) ) {
                                    this.selected = valid = true;
                                    return false;
                                }
                            });
                            if ( !valid ) {
                                // remove invalid value, as it didn't match anything
                                $( this ).val( "" );
                                select.val( "" );
                                input.data( "autocomplete" ).term = "";
                                return false;
                            }
                        }

                        $('#h_number').prop( 'value', '' );
                        $('#nonadmin_sublocality').prop( 'value', '' );
                        if($('form').is('#building_form')) {
                            $('#building_form')[0].reset();
                            $('#object_form')[0].reset();
                            $('#advert_form')[0].reset();
                        }
                        var a = $('#streets').val();
                        if(a>0){
                            $('#h_number').prop( 'disabled', false );
                        }else{
                            $('#h_number').prop( 'disabled', true );
                        }
                    }
                })
                .addClass( "ui-widget form-control" );

            input.data( "autocomplete" )._renderItem = function( ul, item ) {
                return $( "<li class='form-control-li'></li>" )
                    .data( "item.autocomplete", item )
                    .append( "<a>" + item.label + "</a>" )
                    .appendTo( ul );
            };
        },

        destroy: function() {
            this.input.remove();
            this.element.show();
            $.Widget.prototype.destroy.call( this );
        }
    });
})( jQuery );
$(document).ready(function() {
    $('#streets').combobox();
});