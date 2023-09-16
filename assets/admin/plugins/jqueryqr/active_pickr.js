
  function initColorPicker(container) {
    var $element = container + ' .bm-color-picker';
    var $input = jQuery($element).siblings('.color-input');
    var picker = Pickr.create({
        container: container,
        el: $element,
        theme: 'monolith',
        comparison: false,
        closeOnScroll: true,
        position: 'bottom-start',
        default: $input.val() || '#333333',
        components: {
            preview: false,
            opacity: false,
            hue: true,
            interaction: {
                input: true
            }
        }
    });
    picker.on('change', function (color, instance) {
        $input.val(color.toHEXA().toString()).trigger('change');
    });
}

function readImageURL(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#' + id).attr('src', e.target.result);
            $('#' + id).show();
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        $('#' + id).hide();
    }
}