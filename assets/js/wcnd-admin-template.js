(function(window, document, $, undefined) {

    'use strict';

    var scope = {

      // Initializes all functions.

        init: function() {

            scope.onChangeStylingTemplate();
            scope.wpUseColorPicker();

        },

        wpUseColorPicker: function() {

            var colorpicker_wcnd = $('.wcnd_color_picker');
            
            if( colorpicker_wcnd.length ) {

                $('.wcnd_color_picker').wpColorPicker( {
                    change : function (event, ui ) {
                        var ColorDynamic = ui.color.toString();
                        var $this = $(this).parents()[4].firstElementChild.className;
                        console.log( $this );
                        
                        if( $this == 'font-color-wrapper' ) {
                            $('.template_1_the_style .start_styling .wcndcontent_dynamic_data').css( 'color', ColorDynamic);
                        }

                        if( $this == 'background-color-wrapper' ) {
                            $('.template_1_the_style .start_styling').css( 'background-color', ColorDynamic);
                        }

                        if( $this == 'button-background-color-wrapper' ) {
                            $('.template_1_the_style .start_styling a.wcndcontent_dynamic_data').css('background-color',ColorDynamic);
                        }
                        
                    }
                });
            
            }
            
        },

        onChangeStylingTemplate: function() {

            var wcnd_template_list  = $('.templates-list-wrapper .template__content'),
                style_fields        = $('.templates-list-wrapper .css-style-fields'),
                drag_picker         = $('.templates-list-wrapper .iris-picker-inner .ui-draggable'),
                color_picker        = $('.templates-list-wrapper .wp-color-result');

                if( wcnd_template_list.length ) {

                    style_fields.on('input', function() {
                        
                        var $this       = $(this),
                            $this_value = $(this).val();

                            if( $this.hasClass('wcndcontent_dynamic_data') ) {
                                var fontsize = $this_value + 'px';
                                $('.start_styling .wcndcontent_dynamic_data').css( 'font-size', fontsize);
                            }

                    } );

                }

        }

    };


scope.init();



window.onresize = function() {

};



})(window, document, jQuery);