function sesion() {

    $.ajax({
      type: "POST",
      url: "controlador/sesion.php",
      success:function(d) {
        if (d == "ECHAR") {
          window.location.href = './index.html';
        } else {
          $("#sesion").html(d);
        }
      }
    })
    
  }
  
  function Prueba() {
      
      alert("hola")

    $.ajax({
      type: "POST",
      url: "controlador/Prueba.php",
      success:function(d) {
          alert("adios") //Hasta aqui funciona bien
          alert(d);
      }
    })
    
  }

  function cerrar_sesion(id,nombre) {

    $.ajax({
      type: "POST",
      url: "controlador/menu_usuario.php",
      success:function(d) {

        Swal.fire({
          html: d,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          confirmButtonText: 'Salir'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: "POST",
              url: "controlador/cerrar_sesion.php",
              success:function(d) {
                window.location.href = './index.html';
              }
            })
          }
        })
        
      }
    })
    
  }
  
  function registro() {

    var datos = {
      "usuario":$("#usuario").val(),
      "contraseña":$("#contraseña").val()
    }

    $.ajax({
      type: "POST",
      url: "controlador/registro.php",
      data:datos,
      success:function(d) {
          
          alert(d)
  
          if (d == "Si") {

            let timerInterval
            Swal.fire({
              icon: 'success',
              title: 'Identificado!',
              html: 'Se permitira el ingreso en <b></b> Milisegundos! No haga click fuera del cuadro de dialogo.',
              timer: 1500,
              timerProgressBar: true,
              didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                  b.textContent = Swal.getTimerLeft()
                }, 100)
              },
              willClose: () => {
                clearInterval(timerInterval)
              }
            }).then((result) => {
              /* Read more about handling dismissals below */
              if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer');
                window.location.href = './ventas.html';
              }
            })
            
          } else {

            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'El usuario o contraseña son incorrectas!',
              showConfirmButton: false,
              timer: 1500
            }).then((result) => {
              /* Read more about handling dismissals below */
              if (result.dismiss === Swal.DismissReason.timer) {
                
              }
            })

          }
      }
    })


    
  }