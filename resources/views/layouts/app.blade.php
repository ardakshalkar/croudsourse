<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    @yield('css')
  </head>
  <body>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
        <li class="active"><a href="{{ route('home') }}">Басты бет <span class="sr-only">(current)</span></a></li>
          <li><a href="#">Шығарманы сақтау</a></li>
          <li><a href="{{ route('audarmas') }}">Аудару</a></li>
        </ul>

        <div class="nav navbar-right">
            @auth
                @if (Auth::user()->anonymous)
                    Аноним # {{ Auth::user()->id }}
                    <a href="{{ route('login') }}">Системаға кір</a> | 
                    <a href="{{ route('register') }}">Тіркел</a>
                @else
                    {{ Auth::user()->name }}
                    <a href="{{ route('logout') }}">Шығу</a>
                @endif
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
      </div>
	  </div>
  </nav>
  <div class="container">
    @yield('content')
  </div>
      <!-- jQuery 3.1.1 -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

      <!-- AdminLTE App -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/js/adminlte.min.js"></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

      <script>
        console.log("scriptfklmdflakmds;fkmasa;okm")
        var timer;
        //tagss это то что хранится в бд в таблтце tag в том же порядке 
        //есть еще шестой "аударма"
        //
        var tagss = ["диктант", "оқушы", "шығарма", "студент", "эссе"];
        function up(){
          timer = setTimeout(function(){
            var keywords = $('#search-input').val();

              var al = document.getElementById("search-results");
              while(al.firstChild){
                al.removeChild(al.firstChild);
              }
            if(keywords.length > 0){
              console.log(tagss);
              for(i in tagss){
                if(tagss[i].includes(keywords)){
                  var d = document.createElement("article");
                  d.id = "hidde";
                  d.style.wigth = "100px";
                  d.style.border = "1px solid #000";
                  var b = document.createElement("b");
                  var br = document.createElement("br");
                  var te = document.createTextNode(tagss[i]);
                  d.appendChild(te);
                  d.dataset.columns = i;
                 // d.value = i;
                  al.appendChild(d);
                  al.appendChild(br)

                  console.log("in search d.val = " + d.dataset.columns);
                }
              }
          //    $('#search-results').html(tagss);
              //document.getElementById('search-results').value = tagss[1];
              // $.ajax({
              //       type: 'POST',
              //       url: "{{ URL::route('create') }}",
              //       data: {
              //           keywords: keywords
              //       },
              //       success: function(data) {
              //         console.log(data);
              //         console.log("success");
              //           // empty
              //       },
              //       error: function(data){
              //         console.log(data);
              //         console.log("error");
              //       },
              //   });
              // $.post('{{ URL::route('create') }}', {keywords: keywords}).error(function(data){console.log("done")}).success(console.log("fail"));
            }
          }, 500);
        }
        function down(){
          
        }
        $(document).click(function(event) {
            var g = $(event.target);
           console.log(g.attr("id"));
            var text = g.text();// var i = $(event.target).value();
            if(g.attr("id") == "hidde"){
                var j = g.attr("data-columns");
                console.log("target val = " + j);
                var res =document.getElementById("hide").children;

                  for(var i = 0; i < res.length; i++){
                    if(res[i].innerHTML == text){
                      return;
                    }
                  }
                      var al = document.getElementById("hide");
                      var d = document.createElement("article");
                   //   d.value = i;
                      d.style.wigth = "100px";
                      d.dataset.columns = j;
                      d.style.margin = "0px";
                      d.style.border = "1px solid #000";
                      var br = document.createElement("br");
                      var te = document.createTextNode(text);
                      d.appendChild(te);
                      al.appendChild(d);
                      al.appendChild(br);
                      var hid = document.getElementById('invisible_id');
                      if(hid.value == "secret"){
                        console.log(hid.value);
                        console.log("secret");
                        hid.value = parseInt(j)+1;

                      }
                      else {hid.value += ", " + (parseInt(j)+1);
                        console.log("hid.vl = " + hid.value);}
                console.log(text);
            }
            else if(g.attr("id") == "minus" || g.attr("id") == "plus"){
              $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
              var tr_id = g.attr("data-columns");
              var v = g.attr("id");
              console.log("minus => " + tr_id);
              $.ajax({
                type: "GET",
                url: '/translations/vote',
                beforeSend: function (xhr) {
                  var token = $('meta[name="csrf_token"]').attr('content');

                  if (token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                  }
                },
                data: { '_token': '{{ csrf_token() }}' , 'tr_id': tr_id, 'val': v},
                dataType: 'JSON',
                

              }).done(function(response){
                if(response['success'] == 1){
                  console.log("here");
                document.getElementById("weightt").innerHTML = response['count'];}

                console.log(response['count']);

               // console.log(x.attr("id"));
              }).fail(function(jqXHR, textStatus){
                console.log(textStatus);
                console.log(jqXHR);

                alert("fail" + textStatus);
              })
            }
        //    console.log(i);


        });
      </script>

      @yield('scripts')
  </body>
</html>
