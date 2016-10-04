jQuery.fn.extend({
	addMod: function($this, key, val) {
		var className = (val == null) ? $this+'_'+key : $this+'_'+key+'_'+val;
		$(this).addClass(className);
	},
	delMod: function($this, key, val) {
		var className = (val == null) ? $this+'_'+key : $this+'_'+key+'_'+val;
		$(this).removeClass(className);
	},
	hasMod: function($this, key, val) {
		var className = (val == null) ? $this+'_'+key : $this+'_'+key+'_'+val;
		return $(this).hasClass(className);
	}
});
(function( $ ){
	var methods = {
		// Функция обработки наведения на элемент
		hover: function(className) {
			$('.'+className).hover(
				function(){$(this).addMod(className, 'hovered')},
				function(){$(this).delMod(className, 'hovered')}
			);
			$('.'+className+'__item').hover(
				function(){$(this).addMod(className+'__item', 'hovered')},
				function(){$(this).delMod(className+'__item', 'hovered')}
			);
		},
		// функция обработки получения фокуса
		focus: function(className) {
			$('.'+className+'__control').focusin(
				function(){$(this).closest('.'+className).addMod(className, 'focused')
			}).focusout(
				function(){$(this).closest('.'+className).delMod(className, 'focused')
			});
		},
		// функция обработки стирания
		clear: function(className) {
			$('.'+className+'__control').keyup(function(){
				var rm = $(this).next('.'+className+'__clear');
				if ($(this).val() != '' && !rm.hasMod(className, 'clear', 'visible')) {
					rm.addMod(className, 'clear', 'visible');
				}
				if ($(this).val() == '') {
					rm.removeClass('input__clear_visible');
				}
			}).each(function() {
				var rm = $(this).next('.'+className+'__clear');
				if ($(this).val() != '') {
					rm.addMod(className, 'clear', 'visible');
				}
				rm.on('click', function(){
					$(this).prev('.'+className+'__control').val('').focus();
					$(this).delMod(className, 'clear', 'visible');
				});
			});
		},
		// функция обработки нажания
		press: function(className) {
			$('.'+className).mousedown(function(){
				$(this).addMod(className, 'pressed');
				if($(this).hasMod(className, 'togglable', 'check')) {
					$(this).toggleClass(className+'_checked');
				}
				if($(this).hasMod(className, 'togglable', 'radio')) {
					$(this).addMod(className, 'checked');
				}

			});
		}
	};

	$.fn.bem = function(className, methodsList) {
		for(var i = 0; i < methodsList.length; i++) {
			if (methods[methodsList[i]]) {
				methods[methodsList[i]].apply( this, Array.prototype.slice.call( arguments, 0 ));
			}
		}
		return this;
	};
})( jQuery );