$(document).ready(function(){
    $('#loginButton').on("click", login);
    $('#buttonProducts').on('click',showProducts);
    $('#buttonClients').on('click',showClients);
    $('#buttonAppointments').on('click',showAppointments);
    $('#buttonOrders').on('click',showOrders);
    $('#buttonComments').on('click',showComments);
    $('#buttonEmployees').on('click',showEmployees);
    $('#buttonInvoices').on('click',showInvoices);


    initDashbooard();
})




// FUNCTIONS
function showProducts(e){
  e.preventDefault();
  e.stopPropagation();
  htmlContent = "<h1 class='h3 mb-2 text-gray-800'>Productos</h1>"+
  "<p class='mb-4'>Todos los productos de su tienda.</p>"+
  "<div  class='display'>"+
      "<div class='card shadow mb-4'>"+
          "<div class='card-header py-3'>"+
              "<h6 class='m-0 font-weight-bold text-primary'>DataTables Example</h6>"+
          "</div>"+
          "<div class='card-body'>"+
              "<div class='table-responsive'>"+
                  "<table class='table table-bordered' id='productsTable' width='100%' cellspacing='0'>"+
                  "<thead>"+
                      "<tr>"+
                          "<th>Id producto</th>"+
                          "<th>Nombre</th>"+
                          "<th>Descripción</th>"+
                          "<th>Precio</th>"+
                          "<th>Acciones</th>"+
                      "</tr>"+
                  "</thead>"+
                 
                  "</table>"+
              "</div>"+
          "</div>"+
      "</div>"+
  "</div>";
  $('.container-fluid').html(htmlContent);
  url="../REST/products/read/";
  data={
    getAll:"true"
  };
  $.post(url,data, function(resp){
    products = resp.products;
    
    new $('#productsTable').DataTable({
      data:resp.products,
      columns:[
        {data:'id_product'},
        {data:'name'},
        {data:'description'},
        {data:'price'},
        {data:'actions'}
      ],
      dom: 'r',
      buttons: [
        {
            extend: 'copy',
            text: '<u>C</u>opy',
            key: {
                key: 'c',
                altKey: true
            }
        }
      ],
      createdRow: function (row, data, dataIndex) {
        // Agregar botones a la última columna de cada fila
        var buttonsHtml = '<button class="editar" data-id="' + data.id_product + '">Editar</button>' +
                          '<button class="borrar" data-id="' + data.id_product + '">Borrar</button>';
        $('td', row).eq(-1).append(buttonsHtml);
    }
    });
  })
}

function showClients(e){
  e.preventDefault();
  e.stopPropagation();
  htmlContent = "<h1 class='h3 mb-2 text-gray-800'>Productos</h1>"+
  "<p class='mb-4'>Todos los productos de su tienda.</p>"+
  "<div  class='display'>"+
      "<div class='card shadow mb-4'>"+
          "<div class='card-header py-3'>"+
              "<h6 class='m-0 font-weight-bold text-primary'>DataTables Example</h6>"+
          "</div>"+
          "<div class='card-body'>"+
              "<div class='table-responsive'>"+
                  "<table class='table table-bordered' id='clientsTable' width='100%' cellspacing='0'>"+
                  "<thead>"+
                      "<tr>"+
                          "<th>Id</th>"+
                          "<th>Nombre</th>"+
                          "<th>Apellidos</th>"+
                          "<th>Email</th>"+
                          "<th>Telefono</th>"+
                          "<th>Fecha de nacimiento</th>"+
                          "<th>Newsletter</th>"+
                          "<th>Creado</th>"+
                          "<th>Acciones</th>"+
                      "</tr>"+
                  "</thead>"+
                 
                  "</table>"+
              "</div>"+
          "</div>"+
      "</div>"+
  "</div>";
  $('.container-fluid').html(htmlContent);
  url="../REST/customers/read/index.php?getAll=true";
  data={
    getAll:"true"
  };
  $.post(url,data, function(resp){
    customers = resp.customers;
    
    new $('#clientsTable').DataTable({
      data:customers,
      columns:[
        {data:'id_customer'},
        {data:'firstname'},
        {data:'lastname'},
        {data:'email'},
        {data:'phone'},
        {data:'birthday'},
        {data:'newsletter'},
        {data:'date_add'},
        {data:'actions'}
      ],
      dom: 'r',
      buttons: [
        {
            extend: 'copy',
            text: '<u>C</u>opy',
            key: {
                key: 'c',
                altKey: true
            }
        }
      ],
      createdRow: function (row, data, dataIndex) {
        // Agregar botones a la última columna de cada fila
        var buttonsHtml = '<button class="editar" data-id="' + data.id_product + '">Editar</button>' +
                          '<button class="borrar" data-id="' + data.id_product + '">Borrar</button>';
        $('td', row).eq(-1).append(buttonsHtml);
    }
    });
  })
}


function showAppointments(e){
  e.preventDefault();
  e.stopPropagation();
  htmlContent = "<h1 class='h3 mb-2 text-gray-800'>Productos</h1>"+
  "<p class='mb-4'>Todos los productos de su tienda.</p>"+
  "<div  class='display'>"+
      "<div class='card shadow mb-4'>"+
          "<div class='card-header py-3'>"+
              "<h6 class='m-0 font-weight-bold text-primary'>DataTables Example</h6>"+
          "</div>"+
          "<div class='card-body'>"+
              "<div class='table-responsive'>"+
                  "<table class='table table-bordered' id='appointmentsTable' width='100%' cellspacing='0'>"+
                  "<thead>"+
                      "<tr>"+
                          "<th>Id</th>"+
                          "<th>Nombre</th>"+
                          "<th>Apellidos</th>"+
                          "<th>Cita</th>"+
                          "<th>Turno</th>"+
                          "<th>Acciones</th>"+
                      "</tr>"+
                  "</thead>"+
                 
                  "</table>"+
              "</div>"+
          "</div>"+
      "</div>"+
  "</div>";
  $('.container-fluid').html(htmlContent);
  url="../REST/appointment/read/";
  data={
    getAllData:"true"
  };
  $.post(url,data, function(resp){
    appointments = resp.appointments;
    
    new $('#appointmentsTable').DataTable({
      data:appointments,
      columns:[
        {data:'id_appointment'},
        {data:'firstname'},
        {data:'lastname'},
        {data:'date_upd'},
        {data:'turn'},
        {data:'actions'}
      ],
      dom: 'r',
      buttons: [
        {
            extend: 'copy',
            text: '<u>C</u>opy',
            key: {
                key: 'c',
                altKey: true
            }
        }
      ],
      createdRow: function (row, data, dataIndex) {
        // Agregar botones a la última columna de cada fila
        var buttonsHtml = '<button class="editar" data-id="' + data.id_product + '">Editar</button>' +
                          '<button class="borrar" data-id="' + data.id_product + '">Borrar</button>';
        $('td', row).eq(-1).append(buttonsHtml);
    }
    });
  })
}

function showOrders(e){
  e.preventDefault();
  e.stopPropagation();
  htmlContent = "<h1 class='h3 mb-2 text-gray-800'>Productos</h1>"+
  "<p class='mb-4'>Todos los productos de su tienda.</p>"+
  "<div  class='display'>"+
      "<div class='card shadow mb-4'>"+
          "<div class='card-header py-3'>"+
              "<h6 class='m-0 font-weight-bold text-primary'>DataTables Example</h6>"+
          "</div>"+
          "<div class='card-body'>"+
              "<div class='table-responsive'>"+
                  "<table class='table table-bordered' id='ordersTable' width='100%' cellspacing='0'>"+
                  "<thead>"+
                      "<tr>"+
                          "<th>Id</th>"+
                          "<th>Nombre</th>"+
                          "<th>Apellidos</th>"+
                          "<th>Producto</th>"+
                          "<th>Referencia</th>"+
                          "<th>Creado</th>"+
                          "<th>Total</th>"+
                          "<th>Acciones</th>"+
                      "</tr>"+
                  "</thead>"+
                 
                  "</table>"+
              "</div>"+
          "</div>"+
      "</div>"+
  "</div>";
  $('.container-fluid').html(htmlContent);
  url="../REST/orders/read/";
  data={
    getAllData:"true"
  };
  $.post(url,data, function(resp){
    orders = resp.orders;
    
    new $('#ordersTable').DataTable({
      data:orders,
      columns:[
        {data:'id_order'},
        {data:'firstname'},
        {data:'lastname'},
        {data:'name'},
        {data:'ref'},
        {data:'created'},
        {data:'price'},
        {data:'actions'}
      ],
      dom: 'r',
      buttons: [
        {
            extend: 'copy',
            text: '<u>C</u>opy',
            key: {
                key: 'c',
                altKey: true
            }
        }
      ],
      createdRow: function (row, data, dataIndex) {
        // Agregar botones a la última columna de cada fila
        var buttonsHtml = '<button class="editar" data-id="' + data.id_product + '">Editar</button>' +
                          '<button class="borrar" data-id="' + data.id_product + '">Borrar</button>';
        $('td', row).eq(-1).append(buttonsHtml);
    }
    });
  })

  
}


function showComments(e){
  e.preventDefault();
  e.stopPropagation();
  htmlContent = "<h1 class='h3 mb-2 text-gray-800'>Comentarios</h1>"+
  "<p class='mb-4'>Todos los comentarios sobre sus productos.</p>"+
  "<div  class='display'>"+
      "<div class='card shadow mb-4'>"+
          "<div class='card-header py-3'>"+
              "<h6 class='m-0 font-weight-bold text-primary'>Puedes hacer que los comentarios sean moderados por tí.</h6>"+
          "</div>"+
          "<div class='card-body'>"+
              "<div class='table-responsive'>"+
                  "<table class='table table-bordered' id='commentsTable' width='100%' cellspacing='0'>"+
                  "<thead>"+
                      "<tr>"+
                          "<th>Id</th>"+
                          "<th>Nombre</th>"+
                          "<th>Apellidos</th>"+
                          "<th>Producto</th>"+
                          "<th>Título</th>"+
                          "<th>Comentario</th>"+
                          "<th>Rate</th>"+
                          "<th>Público</th>"+
                          "<th>Creado</th>"+
                          "<th>Acciones</th>"+
                      "</tr>"+
                  "</thead>"+
                 
                  "</table>"+
              "</div>"+
          "</div>"+
      "</div>"+
  "</div>";
  $('.container-fluid').html(htmlContent);
  url="../REST/comments/read/";
  data={
    getAllData:"true"
  };
  $.post(url,data, function(resp){
    comments = resp.comments;
    
    new $('#commentsTable').DataTable({
      data:comments,
      columns:[
        {data:'id_product_comment'},
        {data:'firstname'},
        {data:'lastname'},
        {data:'name'},
        {data:'title'},
        {data:'content'},
        {data:'grade'},
        {data:'validate'},
        {data:'date_add'},
        {data:'actions'}
      ],
      dom: 'r',
      buttons: [
        {
            extend: 'copy',
            text: '<u>C</u>opy',
            key: {
                key: 'c',
                altKey: true
            }
        }
      ],
      createdRow: function (row, data, dataIndex) {
        // Agregar botones a la última columna de cada fila
        var buttonsHtml = '<button class="editar" data-id="' + data.id_product + '">Editar</button>' +
                          '<button class="borrar" data-id="' + data.id_product + '">Borrar</button>';
        $('td', row).eq(-1).append(buttonsHtml);
    }
    });
  })

  
}

function showEmployees(e){
  e.preventDefault();
  e.stopPropagation();
  htmlContent = "<h1 class='h3 mb-2 text-gray-800'>Empleados</h1>"+
  "<p class='mb-4'>Todos tus empleados.</p>"+
  "<div  class='display'>"+
      "<div class='card shadow mb-4'>"+
          "<div class='card-header py-3'>"+
              "<h6 class='m-0 font-weight-bold text-primary'>Tus empleados.</h6>"+
          "</div>"+
          "<div class='card-body'>"+
              "<div class='table-responsive'>"+
                  "<table class='table table-bordered' id='employeesTable' width='100%' cellspacing='0'>"+
                  "<thead>"+
                      "<tr>"+
                          "<th>Id</th>"+
                          "<th>Nombre</th>"+
                          "<th>Apellidos</th>"+
                          "<th>Email</th>"+
                          "<th>Fecha de nacimiento</th>"+
                          "<th>Activo</th>"+
                          "<th>Borrado</th>"+
                          "<th>Creado</th>"+
                          "<th>Actualizado</th>"+
                          "<th>Acciones</th>"+
                      "</tr>"+
                  "</thead>"+
                 
                  "</table>"+
              "</div>"+
          "</div>"+
      "</div>"+
  "</div>";
  $('.container-fluid').html(htmlContent);
  url="../REST/employees/read/";
  data={
    getAllData:"true"
  };
  $.post(url,data, function(resp){
    comments = resp.comments;
    
    new $('#employeesTable').DataTable({
      data:comments,
      columns:[
        {data:'id_employee'},
        {data:'firstname'},
        {data:'lastname'},
        {data:'email'},
        {data:'birthday'},
        {data:'active'},
        {data:'deleted'},
        {data:'date_add'},
        {data:'date_upd'},
        {data:'actions'}
      ],
      dom: 'r',
      buttons: [
        {
            extend: 'copy',
            text: '<u>C</u>opy',
            key: {
                key: 'c',
                altKey: true
            }
        }
      ],
      createdRow: function (row, data, dataIndex) {
        // Agregar botones a la última columna de cada fila
        var buttonsHtml = '<button class="editar" data-id="' + data.id_product + '">Editar</button>' +
                          '<button class="borrar" data-id="' + data.id_product + '">Borrar</button>';
        $('td', row).eq(-1).append(buttonsHtml);
    }
    });
  })

  
}

function showInvoices(e){
  e.preventDefault();
  e.stopPropagation();
  htmlContent = "<h1 class='h3 mb-2 text-gray-800'>Facturas</h1>"+
  "<p class='mb-4'>Todas tus facturas</p>"+
  "<div  class='display'>"+
      "<div class='card shadow mb-4'>"+
          "<div class='card-header py-3'>"+
              "<h6 class='m-0 font-weight-bold text-primary'>Todas las facturas.</h6>"+
          "</div>"+
          "<div class='card-body'>"+
              "<div class='table-responsive'>"+
                  "<table class='table table-bordered' id='invoicesTable' width='100%' cellspacing='0'>"+
                  "<thead>"+
                      "<tr>"+
                          "<th>Id</th>"+
                          "<th>Nombre</th>"+
                          "<th>Apellidos</th>"+
                          "<th>Producto</th>"+
                          "<th>Precio</th>"+
                          "<th>Referencia</th>"+
                          "<th>Creado</th>"+
                          "<th>Acciones</th>"+
                      "</tr>"+
                  "</thead>"+
                 
                  "</table>"+
              "</div>"+
          "</div>"+
      "</div>"+
  "</div>";
  $('.container-fluid').html(htmlContent);
  url="../REST/invoices/read/";
  data={
    getAllData:"true"
  };
  $.post(url,data, function(resp){
    invoices = resp.invoices;
    
    new $('#invoicesTable').DataTable({
      data:invoices,
      columns:[
        {data:'id_invoice'},
        {data:'firstname'},
        {data:'lastname'},
        {data:'name'},
        {data:'price'},
        {data:'ref'},
        {data:'date_add'},
        {data:'actions'}
      ],
      dom: 'r',
      buttons: [
        {
            extend: 'copy',
            text: '<u>C</u>opy',
            key: {
                key: 'c',
                altKey: true
            }
        }
      ],
      createdRow: function (row, data, dataIndex) {
        // Agregar botones a la última columna de cada fila
        var buttonsHtml = '<button class="editar" data-id="' + data.id_product + '">Editar</button>' +
                          '<button class="borrar" data-id="' + data.id_product + '">Borrar</button>';
        $('td', row).eq(-1).append(buttonsHtml);
    }
    });
  })

  
}

function initDashbooard(){
  url="../REST/dashboard/read";
  data={
    "getAll" : "true"
  };
  $.post(url,data,function(resp){
    if(resp.success=="true"){
      $('#dashboardMonthEarnings').find('.value-holder').html(resp.data.monthEarnings.amount);
      $('#dashboardYearEarnings').find('.value-holder').html(resp.data.yearEarnings.amount);
      $('#dashboardAppointments').find('.value-holder').html(resp.data.appointments.all);
      $('#dashboardAppointments').find('.value-bar').attr('style',"width: " + (100*resp.data.appointments.paid/resp.data.appointments.all) + "%;");
      setChart(Object.values(resp.data.allEarnings));
    }
  })
}

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



/// CHARTS




function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

function setChart(data){
  // Clear data object
  dataset = [];
  for(let i=0; i<12;i++){
    if(data[i].amount!=null){
      dataset[i] = data[i].amount;
    }else{
      dataset[i] = 0;
    }
  }

  // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';
  // Area Chart Example
  var ctx = document.getElementById("myAreaChart");
  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [{
        label: "Earnings",
        lineTension: 0.3,
        backgroundColor: "rgba(78, 115, 223, 0.05)",
        borderColor: "rgba(78, 115, 223, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(78, 115, 223, 1)",
        pointBorderColor: "rgba(78, 115, 223, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: dataset,
      }],
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      scales: {
        xAxes: [{
          time: {
            unit: 'date'
          },
          gridLines: {
            display: false,
            drawBorder: false
          },
          ticks: {
            maxTicksLimit: 7
          }
        }],
        yAxes: [{
          ticks: {
            maxTicksLimit: 5,
            padding: 10,
            // Include a dollar sign in the ticks
            callback: function(value, index, values) {
              return '$' + number_format(value);
            }
          },
          gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
          }
        }],
      },
      legend: {
        display: false
      },
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: 'index',
        caretPadding: 10,
        callbacks: {
          label: function(tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
          }
        }
      }
    }
  });
}
