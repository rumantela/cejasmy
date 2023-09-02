$(document).ready(function(){
    $('#loginButton').on("click", login);
})




// FUNCTIONS

function login(e){
    e.preventDefault();
    $data = {
        'email' : $('#InputEmail').val(),
        'password' : $('#InputPassword').val()
    }
    $.post("http://localhost/cejasmy/admin/REST/login/",$data, function(resp){
        respuesta = resp;
        setCookie('id_employee',resp.id_employee,1);
        window.location.assign('http://localhost/cejasmy/admin/');
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

