<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <title>Esqueceu a senha</title>
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('css/app-style.css') }}" rel="stylesheet"/>
</head>

<body class="bg-theme bg-theme1">
 <div id="wrapper">
  <div class="height-100v d-flex align-items-center justify-content-center">
    <div class="card card-authentication1 mb-0">
      <div class="card-body">
       <div class="card-content p-2">
        <div class="card-title text-uppercase pb-2">Esqueceu a senha</div>
        <p class="pb-2">Por favor coloque seu Email. Você vai receber um email para criar a nova senha</p>
        
        <form id="recuperarSenhaForm" method="POST" action="{{ route('recuperar-senha') }}">
          @csrf
          <div class="form-group">
            <label for="email">Email</label>
            <div class="position-relative has-icon-right">
              <input type="email" id="email" name="email" class="form-control input-shadow" placeholder="Email" required>
              <div class="form-control-position">
                <i class="bi bi-envelope-open"></i> <!-- Bootstrap icon -->
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-light btn-block mt-3">Enviar</button>
        </form>

        <div id="mensagem" class="mt-3"></div>
       </div>
      </div>
      <div class="card-footer text-center py-3">
        <p class="text-warning mb-0">Volte para o <a href="{{ route('login') }}">Login</a></p>
      </div>
    </div>
  </div>
 </div>

 <script src="{{ asset('js/jquery.min.js') }}"></script>
 <script>
   $(document).ready(function(){
     $('#recuperarSenhaForm').submit(function(e){
       e.preventDefault(); // evita envio padrão

       $.ajax({
         url: "{{ route('recuperar-senha') }}",
         type: 'POST',
         data: $(this).serialize(),
         success: function(response){
           if(response.status){
             $('#mensagem').html('<div class="alert alert-success">Senha redefinida com sucesso!</div>');
           } else {
             $('#mensagem').html('<div class="alert alert-danger">'+response.message+'</div>');
           }
         },
         error: function(){
           $('#mensagem').html('<div class="alert alert-danger">Ocorreu um erro. Tente novamente.</div>');
         }
       });
     });
   });
 </script>
</body>
</html>
