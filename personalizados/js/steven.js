
// Funciones Steven
function checkenvio(unidad_medida_idunidad_medida,id_producto,id_venta,estado) {

  Swal.fire({
    title: '¿Verificar domicilio?',
    text: "No podrás revocar esta acción, ¿está seguro?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Enviado',
    cancelButtonText: 'Cancelar'
  }).then((result) => {



    if (result.isConfirmed) {
      var datos = {
            "unidad_medida":unidad_medida_idunidad_medida,
            "id_producto":id_producto,
            "id_venta":id_venta,
            "estado":estado
          }

          $.ajax({
            type: "POST",
            url: "controlador/checkenvio.php",
            data:datos,
            success:function(d){

              Swal.fire(
                'Enviado!',
                'Se ha realizado el domicilio con éxito',
                'success'
              );
              tabla_envios();
              
            }
            
            })
    }
  })
}

function eliminarenvio(id_venta) {
  Swal.fire({
    title: '¿Terminar domicilio?',
    text: "No podrás revocar esta acción, ¿está seguro?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Terminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
          var datos = {
            "id_venta":id_venta
          }

          $.ajax({
            type: "POST",
            url: "controlador/terminar_envio.php",
            data:datos,
            success:function(d){

              Swal.fire(
                'Enviado!',
                'Se ha terminado el domicilio con éxito',
                'success'
              );
              tabla_envios()
              
              
            }
            
            })
    }
  })
}



function abonar(cantidad_abonada,idventas,cantidad_debida) {

  


  Swal.fire({
    title: 'Abonar a la deuda',
    text: "No podrás revocar esta acción, ¿está seguro?",
    icon: 'warning',
    html: '<input class="form-control" type="number" id="abono" min="0">',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Abonar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {

    if (result.isConfirmed) {

      var datos = {
        "abono":$("#abono").val(),
        "cantidad_abonada":cantidad_abonada,
        "idventas":idventas,
        "cantidad_debida":cantidad_debida
      }
      if(document.getElementById("abono").value == ""){
        alert("por favor ingrese la cantidad a abonar");
        document.getElementById("abono").focus();
        return false;
      }
      $.ajax({
        type: "POST",
        url: "controlador/abonar.php",
        data:datos,
        success:function(d){

          Swal.fire(
            'Abonado!',
            'Se ha abonado con éxito, se debe devolver:' + d,
            'success'
          );
          tabla_deudores()
          
        }
        
        })

      
    }
  })
}

function eliminardeudor(idventas) {
  Swal.fire({
    title: 'Terminar deuda/deudor',
    text: "No podrás revocar esta acción, ¿está seguro?",
    icon: 'warning',
    
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Terminar deuda',
    cancelButtonText: 'Cancelar'
  }).then((result) => {

    if (result.isConfirmed) {

      var datos = {
        "idventas":idventas
      }

      $.ajax({
        type: "POST",
        url: "controlador/terminar_deuda.php",
        data:datos,
        success:function(d){

          Swal.fire(
            'Terminado!',
            'Se ha terminado la deuda con éxito',
            'success'
          );
          tabla_deudores()
          
        }
        
        })

      
    }
  })
}


function tabla_deudores() {

  $.ajax({
    type: "POST",
    url: "controlador/tabla_deudores.php",
    success:function(d) {
        
        $("#tabla_deudores").html(d);
    }
  })
  
}

function tabla_envios() {

  $.ajax({
    type: "POST",
    url: "controlador/tabla_envios.php",
    success:function(d) {
        
        $("#tabla_envios").html(d);

    }
  })
  
}

function cantidadEN_envios(inventario_idinventario,ventas_idventas,cantidad_vendida) {
  var input_id = "cantidad_enviada" + inventario_idinventario + ventas_idventas + cantidad_vendida;
  var cantidad_enviada = $("#" + input_id).val();
 // alert(input_id);
  
  var datos = {
    "inventario_idinventario":inventario_idinventario,
    "ventas_idventas":ventas_idventas,
    "cantidad_vendida":cantidad_vendida,
    "cantidad_enviada":cantidad_enviada
  }

  $.ajax({
    type: "POST",
    url: "controlador/cantidadEN_envios.php",
    data:datos,
    success:function(d) {//alert("ID inventario: " + inventario_idinventario + "idventas" + ventas_idventas + "cantidad" + cantidad_vendida + "can env:" + cantidad_enviada)
      tabla_envios()
    }
  })
 
}

function alertas() {

  

  $.ajax({
    type: "POST",
    url: "controlador/alert_deudores.php",
    success:function(d) {
      $('#Numero_alertas').html(d);
      
    }
  })
  
}

function MostrarAlertas() {

  $.ajax({
    type: "POST",
    url: "controlador/alert_deu_cont.php",
    success:function(d) {
      $('#MostrarAlertas').html(d);
    }
  })
  
}

function info_cliente(Nombre,telefono,direccion,correo,documento) {

  


  Swal.fire({
    title: 'Información del cliente',
    html: 'Nombre: '+Nombre+'<br>'+
    'Telefono: '+telefono+'<br>'+
    'Dirección: '+direccion+'<br>'+
    'Correo: '+correo+'<br>'+
    'Documento: '+documento+'<br>',
    
    cancelButtonText: 'Cerrar'
  })
}

function historial_abono(idventas) {

  var datos = {
    "idventas":idventas
  }
  $.ajax({
    type: "POST",
    url: "controlador/historial_abono.php",
    data:datos,
    success:function(d) {
        
      Swal.fire({
        html: d,
        icon: 'warning'
      })
    }
  })
  
}

// Fin funciones Steven