$('.button-device-edit').on('click',function(){
    $('.button-device-add').trigger('click');
});


$('.button-device-add').on('click',function(){
    var id = $(this).data('id');

    if(id != undefined){
        var form = $('#editor-device').clone();
        form.removeClass('hidden');
        form.find('form').prop('action','/admin/device/edit/'+id);
        form.find('#device-reset-key').prop('id','');
        form.find('#device-active').prop('checked',true).prop('id','');
        form.find('#device-name').val($(this).data('name')).prop('id','');
        form.find('#device-key').val($(this).data('access-key')).prop('readonly',true).prop('id','');

        $('#device-full-column-'+id).prepend(form);            

    } else {
        var form = $('#editor-device');
        form.removeClass('hidden');
        form.find('form').prop('action','/admin/device/edit')
//        form.find('#device-reset-key')('checked',true).prop('readonly',true);
//        form.find('#device-active').prop('checked',true).prop('readonly',true);
//        form.find('#device-key').prop('disabled',true);
        form.find('#device-key').addClass('hidden');
        form.find('#device-active').addClass('hidden');
        form.find('#device-reset-key').addClass('hidden');
    }
});

$('.button-config').on('click',function(){
    var text = 'testing 1 2 3';
        this.href = 'data:text/plain;charset=utf-8,'
          + encodeURIComponent(text);
});