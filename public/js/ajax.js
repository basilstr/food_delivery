function setUserStatus(id) {
    var status = $('#btn_active_'+id).data( "status" );
    $.ajax({
        type:'POST',
        url:'/user/active',
        data: {id: id, status: status},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(data){
            if(data.success == 'fail'){
                alert('Error save user');
            }else {
                $('#btn_active_' + id).html(data.icon);
                $('#btn_active_' + id).removeClass();
                $('#btn_active_' + id).addClass(data.btn_class);
                $('#btn_active_' + id).data("status", data.status);
                $('#btn_active_' + id).prop("title", data.title);
            }
        }
    });
}

function setClientStatus(id) {
    var status = $('#btn_active_'+id).data( "status" );
    $.ajax({
        type:'POST',
        url:'/client/active',
        data: {id: id, status: status},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(data){
            if(data.success == 'fail'){
                alert('Error save user');
            }else {
                $('#btn_active_' + id).html(data.icon);
                $('#btn_active_' + id).removeClass();
                $('#btn_active_' + id).addClass(data.btn_class);
                $('#btn_active_' + id).data("status", data.status);
                $('#btn_active_' + id).prop("title", data.title);
            }
        }
    });
}

function setCourierStatus(id) {
    var status = $('#btn_active_'+id).data( "status" );
    $.ajax({
        type:'POST',
        url:'/courier/active',
        data: {id: id, status: status},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(data){
            if(data.success == 'fail'){
                alert('Error save user');
            }else {
                $('#btn_active_' + id).html(data.icon);
                $('#btn_active_' + id).removeClass();
                $('#btn_active_' + id).addClass(data.btn_class);
                $('#btn_active_' + id).data("status", data.status);
                $('#btn_active_' + id).prop("title", data.title);
            }
        }
    });
}

function addIngredient(id)
{
    var list = [];
    $('#ingredient input:checked').each(function() {
        list.push($(this).val());
    });
    $.ajax({
        type:'POST',
        url:'/provider/ingredient/store',
        data: {id:id, list: list},
        dataType: "json",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(data){
            if(data.success == 'fail'){
                alert(data.msg);
            }else {
                window.location.href = '/provider/ingredient/'+id;
            }
        }
    });

}

function loadIngredient(id)
{
    if(hasChangeForm('ingredient_form')) {
        $.ajax({
            type: 'POST',
            url: '/provider/ingredient/create',
            data: {id: id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                $('#list-ingredient').html(data);
                $('#modal-lg').modal();
            }
        });
    }
}

function saveFood(status)
{
    console.log(status);
    if(status === 1) $('#status').val(3); // на модерації
    $('#food_form').submit();
}

function hasChangeForm(id_form)
{
    var elementsById = document.getElementById(id_form);
    if(elementsById) {
        var elements = elementsById.elements;
        var isChange = false;
        for (var i = 0, element; element = elements[i++];) {
            if($(element).attr('type') == "submit") continue;
            if($(element).attr('type') == "hidden") continue;
            if($(element).attr('type') == "checkbox"){
                var check = '';
                if($(element).attr('checked')) {
                    check = '1'
                }
                if(check != $(element).data("default")){
                    isChange = true;
                }
            }else {
                console.log('no checkbox');
                if($(element).val() != $(element).data("default")){
                    isChange = true;
                }
            }
        }
        if (isChange) return confirm("На сторінці є не збережені зміни!\nЯкщо їх не потрібно зберегти натисніть OK.");
    }
    return true;
}

jQuery(document).ready(function($) {
    $('#food_form').on('click', '#button', function(e) {
        e.preventDefault();
        $('#modal-lg').modal();
    })
});

