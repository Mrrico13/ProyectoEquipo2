        function eliminar(){
          var elimina = $('#id').val();
          if(elimina){
            $.ajax({
              url        :  'elimina.php?id='+id,
              type       :  'post',
              dataType   :  'text',
              success    :  function(res){
                if(res == 1){
                  $('#mensaje').html('Borrado');
                }else{
                  $('#mensaje').html('No borrado');
                }
                setTimeout("$('#mensaje').html('')", 5000);
              },error: function(){
                alert('Error archivo no encontrado...');
              }
            });
            }
          }
