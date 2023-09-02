
var cejasmy={};






//<!-- Listener de recepción de ID de operación -->
window.addEventListener("message", function receiveMessage(event) {
    e = event;
    if(e.data !== "merchantValidation"){
        sendPaymentRequest(e.data.idOper);
    }
    storeIdOper(event, "token", "errorCode", merchantValidation);
});




/*
 * Events listener
 */
$(document).ready(function(){
    


    if(getCookie('customer_id')!=null){
        connectDisconnet();
        getCustomerData(getCookie('customer_id'));
    }
    


    $('#logIcon').on('click',showLogin);
    $('.forgot-password').on('click', showForgotPassword);
    $('.login-account').on('click', showLogin);
    $('.register-account').on('click', showRegister);
    $('.fullscreen').on('click',hideAllFullscreen);
    $('.fullscreen .card-body').on('click',preventHide);
    $('#loggedIcon').on('click',showCalendar);
    $('#loginButton').on('click',login);
    $('#registerButton').on('click',register);
    $('#logout').on('click',logout);
    $('#calendar_close').on('click', function (e) {
        e.preventDefault();
        e.cancelBubble = true;
        $(this).parents('.fullscreen').first().fadeOut();
    });
    $('#reset-password').on('click',resetPassword);

    
    
                                   
    

    
});




//$('form input').on('focusout', validateField);
$('#cardPayment').on('click', function (e) {
    if ($('input[name="appointment"]').val() != "") {
        
        $('#bizum-form').addClass('hidden');
        $('#card-form').removeClass('hidden');
        //$('#doReservation').toggleClass('hidden');
    } else {
        $('input[name="appointment"]').next().toggleClass('hidden');
    }
})
$('#bizumPayment').on('click', function (e) {
    if ($('input[name="appointment"]').val() != "") {
        $('#card-form').addClass('hidden');
        $('#bizum-form').removeClass('hidden');
        //$('#doReservation').toggleClass('hidden');

    } else {
        $('input[name="appointment"]').next().toggleClass('hidden');
    }
})

$('#bookappointment_step1 button[type="submit"]').on('click', function (e) {
    e.preventDefault();
    e.cancelBubble = true;
    var flag = true;
    target = e.currentTarget;
    $('#bookappointment_step1').find('input').each(function (n, t) {
        if (!validateFields(t)) {
            flag = false;
        }
    });
    console.log(flag);
    if (flag) {
        // CONSULTA REST - Create a customer
        url = "./REST/guest/create/";
        var data = { // plein object
            firstname: $('#firstNameCustomer').val(),
            email: $('#emailCustomer').val(),
            phone: $('#phoneCustomer').val()
        }
        $.post(url, data, function (resp, status, xhr) {
            datos = resp;
            estado = status;
            otro = xhr;

            fullscreen = $(document).find('.fullscreen').first();
            fullscreen.find('input[name="name"]').val($(document).find('#firstNameCustomer').val());
            fullscreen.find('input[name="phone"]').val($(document).find('#phoneCustomer').val());
            fullscreen.find('input[name="email"]').val($(document).find('#emailCustomer').val());
            
            fullscreen.toggleClass('hidden');
            
        }).done(function (resp) {
            
            customer = resp.id_customer;
            cejasmy = {
                "customer" : {
                    "customer_id" : customer,
                    "firstname" : data.firstname,
                    "phone" : data.phone,
                    "email" : data.email
                }
            };
        });

    }
});

$('#doPayment').on('click', function (e) {
    e.preventDefault();
    e.cancelBubble = true;

    /*$url = "http://localhost/cejasmy/REST/cart/product/add/";
    data = {
        'cart_id':1,
        'product_id':1,
        'price':30,
        'customer_id':1,
        'date': $('.event.reserved').attr('time')
    }
    $.post($url, data, function(resp){
        respuesta = resp;
        if(resp.success!="false"){
            alert("Reserva hecha!");
        }else{
            alert("Ha ocurrido un error");
        }
    })*/

})

$('#doReservation').on('click', function (e) {
    e.preventDefault();
    e.cancelBubble = true;

    // Check if the appointment is set
    if ($('#bookappointment_step2').find('input[name="appointment"]').val() != "") {
        // Shows payment selection form section
        $('#bizumPayment').trigger('click');
        $('.payment-selection').toggleClass('hidden');
        $(this).toggleClass('hidden');
        url = "./REST/cart/create/";
        data = {
            "customer_id" : cejasmy.customer.id_customer,
            
        }
        $.post(url,data, function(resp){
            respuesta = resp;
            data = {
                    "product_id" : 1,
                    "price" : 30,
                    "date" : $('input[name="appointment"]').val(), 
                    "cart_id" : respuesta.id_cart,
                    "customer_id" : cejasmy.customer.id_customer

            };
            cejasmy.cart={
                "id_cart" : resp.id_cart,
                "ref" : "REF" + Math.floor((Math.random() * 1000) + 1) + randomRef(),
            }
            setCardForm();
            $.post('./REST/cart/product/add/',data, function(r){
                respuesta = r;
            })
        })

    } else {
        validateFields(e);
    };
})




function register(e){
    e.preventDefault();
    var form = $(e.currentTarget).parents('form').first();
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
        let url = './REST/customers/create/';
        $.post(url,fields,function(resp){
            try{
                resp = JSON.parse(resp);
                
            }catch(e){

            }
            if(resp.success=="true"){
                cejasmy={
                    customer : {
                        customer_id : resp.id_customer
                    }
                };
                hideAllFullscreen();
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
        //hostName = "https://cejasmy.com/REST/login/index.php";
        let url = form.attr('action');
        $.post(url,fields,function(resp){
            try{
                resp = JSON.parse(resp);
            }catch(e){

            }
            if(resp.login=="true"){
                
                connectDisconnet();
                $('.login-holder').parents('.fullscreen').delay(500).fadeOut();
                
                setCookie('customer_id',resp.id_customer,3);
                getCustomerData(resp.id_customer);
                
            }else{
                $('.message-warning').html('No coincide usuario y contraseña.').fadeIn();
            }

        }).done(function(resp){

        })
    }
}
/*
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


function showLogin(e){
    e.preventDefault();
    hideAllFullscreen();
    $('.login-holder').parent('.fullscreen').first().fadeIn();
}
function showRegister(e){
    e.preventDefault();
    hideAllFullscreen();
    $('.register-holder').parent('.fullscreen').first().fadeIn();
}
function showForgotPassword(e){
    e.preventDefault();
    hideAllFullscreen();
    $('.password-holder').parent('.fullscreen').first().fadeIn();
}
function hideAllFullscreen(){
    $('.fullscreen').fadeOut();
}

function preventHide(e){
    e.preventDefault();
    e.cancelBubble=true;
    e.stopPropagation();
}

function showCalendar(){
    $('#calendar').parents('.fullscreen').first().fadeIn();
}

function connectDisconnet(){
    $('#logIcon').parent().toggleClass('hidden');
    $('#loggedIcon').parent().toggleClass('hidden');
    $('#logout').parent().toggleClass('hidden');
}

function logout(){
    connectDisconnet();
    deleteCookie('customer_id');
    cejasmy = {};
}

function resetPassword(e){
    target = $(e.currentTarget).parents('form').first();
    url = target.attr('action');
    data = {
        "email" : target.find('input[type="email"]').val()
    }
    $.post(url,data, function(resp){
        r=resp;
        hideAllFullscreen();
    })
}



/// FUNCIONES PARA EL MANEJO DE COOKIES

function deleteCookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  }

function updateCookie(name, value, daysToExpire) {
    setCookie(name, value, daysToExpire);
}
  

function getCookie(name) {
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookies = decodedCookie.split(";");
  
    for (let i = 0; i < cookies.length; i++) {
      const cookie = cookies[i].trim();
      if (cookie.startsWith(name + "=")) {
        return cookie.substring(name.length + 1, cookie.length);
      }
    }
  
    return null;
  }

function setCookie(name, value, daysToExpire) {
    const expirationDate = new Date();
    expirationDate.setTime(expirationDate.getTime() + (daysToExpire * 24 * 60 * 60 * 1000));
    const expires = "expires=" + expirationDate.toUTCString();
    document.cookie = name + "=" + value + "; " + expires + "; path=/";
}



//// Funciones REST

function getCustomerData(id){
    $.post('./REST/customers/read/', {"id_customer":id}, function(resp){
        cejasmy.customer = resp.customer;
        setCustomerDataForm();
    })
}


//// REDSYS AND PAYMENT functions

/*function setCardForm(merchantOrder) {
    getCardInput('card-number', "", "0000 0000 0000 0000", "");
    getExpirationInput('card-expiration', "", "12/27");
    getCVVInput('cvv', "", '123');
    getPayButton('boton', "", 'PAGAR', "999008881", 1, merchantOrder);
}*/




function setCardForm(){
    var insiteJSON = {
        "id": "card-form",
        "fuc": "999008881",
        "terminal": "1",
        "order": cejasmy.cart.ref,
        "estiloReducioo": "true",
        "estiloInsite": "twoRows",
        "buttonValue": "Pagar",
        "styleButton": "background-color:#B8B80B ;color:white;border-color:#B8B80B;width:100%;border-radius:0.375rem;"
    }
    //getInSiteForm('card-form', 'background-color:#be0761', '', '', '', 'Reservar', '999008881', '1', 'ped4227', 'ES', true, false, 'twoRows');
    getInSiteFormJSON(insiteJSON);
}

function merchantValidation(e) {
    //Insertar validaciones…
    dataJSON = {
        "DS_MERCHANT_AMOUNT": "3000",
        "DS_MERCHANT_CURRENCY": "978",
        "DS_MERCHANT_CVV2": "123",
        "DS_MERCHANT_EXPIRYDATE": "1249",
        "DS_MERCHANT_MERCHANTCODE": "999008881",
        "DS_MERCHANT_ORDER": cejasmy.cart.ref,
        "DS_MERCHANT_PAN": "4548 8100 0000 0003",
        "DS_MERCHANT_TERMINAL": "1",
        "DS_MERCHANT_TRANSACTIONTYPE": "0"
    }

    base64 = btoa(dataJSON);
    idOp = $('#token').val();
    if(base64==idOp){

    }
    return true;
    
}

function pedido() {
    url = "./REST/orders/create/";
    data ={
        "id_cart" : cejasmy.cart.id_cart,
        "ref" : cejasmy.cart.ref,
    };
    $.post(url,data,function(resp){
        var respuesta = resp;
        cejasmy.order=resp.order;
    });
}

function sendPaymentRequest(idOp){
    if(idOp!=-1){
        url = "./REST/payments/create/";
        data ={
            "idOp" : idOp,
            "ref" : cejasmy.cart.ref,
            "amount" : "3000",
            "cardData" : {
                "number" : $('#card-number').val(),
                "expiration" : $('#card-expiration').val(),
                "cvv" : $('#card-cvv').val()
            }
        }
        $.post(url,data,function(resp){
            if(resp.success="true"){
                return true;
            }else{
                return false;
            }
        })
    }else{
        return false;
    }
}


//// AUX functions

function setCustomerDataForm(){
    //$('#doReservation').trigger('click');
    let nombre = cejasmy.customer.firstname+' '+cejasmy.customer.lastname;
    $('#bookappointment_step2 input[name="name"]').val(nombre);
    $('#bookappointment_step2 input[name="phone"]').val(cejasmy.customer.phone);
    $('#bookappointment_step2 input[name="email"]').val(cejasmy.customer.email);
    $('#firstNameCustomer').val(nombre);
    $('#phoneCustomer').val(cejasmy.customer.phone);
    $('#emailCustomer').val(cejasmy.customer.email);
}
function shuffle(string) {
    var parts = string.split('');
    for (var i = parts.length; i > 0;) {
        var random = parseInt(Math.random() * i);
        var temp = parts[--i];
        parts[i] = parts[random];
        parts[random] = temp;
    }
    return parts.join('');
}

function randomRef(){
    string = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    string = string.repeat(10);
    string = shuffle(string);
    return string.substring(0,12);
}