$('#role').on('change', function () {
    let val = $(this).val();
    if(val === 'admin' || val==='master'){
        $("#provider-group").addClass('d-none');
    }else{
        $("#provider-group").removeClass('d-none');
    }
});

$('.week_check').on('change', function () {
    let id = $(this).data('id');
    let check = $(this).prop('checked');
    if(check){
        let val = $('#week_'+id).val();
        $('#week_'+id).data('save', val);
        $('#week_'+id).val('00:00-00:00');
        $('#week_'+id).addClass('bg-warning');
    }else{
        let save = $('#week_'+id).data('save');
        $('#week_'+id).val(save);
        $('#week_'+id).removeClass('bg-warning');
    }
});
