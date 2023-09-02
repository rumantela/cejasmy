
//document.onreadystatechange
$(document).ready(function(){
    $('#loginButton').on('click',login);
    $('#registerButton').on('click',register);
})

function register(e){
    e.preventDefault();
    var form = $(e.currentTarget).parents().find('form');
    var inputs = $(form).find('input');
    var flag = true;
    var fields = {};
    $(inputs).each(function(n,t){
        if(!validateFields(t)){
            flag=false;
        }
        value = $(t).val();
        field = $(t).attr('name');
        fields[field] = value;
    })
    if(flag){
        let url = form.attr('action');
        $.post(url,fields,function(resp){
            try{
                resp = JSON.parse(resp);
                
            }catch(e){

            }
            if(resp.success=="true"){
                cejasmy.customer.customer_id=resp.id_customer;
                window.location.href=('index.html?logged=true');
            }else{
                $('.message-warning').html('No coincide usuario y contraseña.').fadeIn();
            }

        }).done(function(resp){

        })
    }

}

function login(e){
    e.preventDefault();
    var form = $(e.currentTarget).parent();
    var inputs = $(form).find('input');
    var flag = true;
    var fields = {};
    $(inputs).each(function(n,t){
        if(!validateFields(t)){
            flag=false;
        }
        value = $(t).val();
        field = $(t).attr('name');
        fields[field] = value;
    })
    if(flag){
        let url = form.attr('action');
        $.post(url,fields,function(resp){
            try{
                resp = JSON.parse(resp);
            }catch(e){

            }
            if(resp.login=="true"){
                //$('.message-success').html('Correcto').fadeIn();
                //cejasmy.customer.customer_id=resp.id_customer;
                $('#loggedIcon').parent().toggleClass('hidden');
                $('#logout').parent().toggleClass('hidden');
                $('#logIcon').parent().toggleClass('hidden');
               $('.login-holder').parents('.fullscreen').delay(500).fadeOut();
               
            }else{
                $('.message-warning').html('No coincide usuario y contraseña.').fadeIn();
            }

        }).done(function(resp){

        })
    }
}
/*
 * Formularios. Validación de campos y envío
 * Accede a todos los elementos input y su tipo y hace la validación
 * La validación se hace al pulsar el botón submit del formulario
 * Forms. Fields validation and query.
 * It access all inputs tags and theirs types, it does the validation
 * in affirmative case it does the query. It starts once you press 
 * submit button.
 */

function validateFields(target) {
    target = $(target);
    value = target.val();
    type = target.attr('type');
    flag = true;
    switch (type) {
        case "text":
            if (value == "") {
                target.addClass('is-invalid');
                target.trigger('focus');
                flag = false;
            } else {
                target.removeClass('is-invalid');
                target.addClass('is-valid');
            }
            break;
        case "tel":
            var pattern = new RegExp("[0-9]{9}");
            if (pattern.test(value)) {
                target.removeClass('is-invalid');
                target.addClass('is-valid');
            } else {
                target.addClass('is-invalid');
                target.trigger('focus');
                flag = false;
            }
            break;
        case "email":

            //var pattern = new RegExp("/^\b[a-Z0-9]+@([\w-]+\.)+[\w-]{2,4}$/");
            pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
            if (pattern.test(value)) {
                target.removeClass('is-invalid');
                target.addClass('is-valid');
            } else {
                target.addClass('is-invalid');
                target.trigger('focus');
                flag = false;
            }
            break;
        case "dni":

            //var pattern = new RegExp("/^\b[a-Z0-9]+@([\w-]+\.)+[\w-]{2,4}$/");
            pattern = /^[0-9]{8}[A-Z]{1}/;
            if (pattern.test(value)) {
                target.removeClass('is-invalid');
                target.addClass('is-valid');
            } else {
                target.addClass('is-invalid');
                target.trigger('focus');
                flag = false;
            }
            break;
        case "password":

            //var pattern = new RegExp("/^\b[a-Z0-9]+@([\w-]+\.)+[\w-]{2,4}$/");
            inputs = target.parents('form').first().find('input[type="password"]');
            if(typeof inputs[1] !== "undefined"){
                if($(inputs[0]).val()==$(inputs[1]).val()){
                    target.removeClass('is-invalid');
                    target.addClass('is-valid');
                }else{
                    target.addClass('is-invalid');
                    target.trigger('focus');
                    flag = false;
                }

            }else{
                target.removeClass('is-invalid');
                target.addClass('is-valid');
            }
            break;
    }
    return flag;
}
