<!DOCTYPE HTML>
<html>
  <head>

    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
  </head>
  <body class="lead">
    <h3> From:
    <div id="datetimepicker" class="input-append date">
        @if(count($dateFrom)>0)
        <input type="text" name="From" value="{{ $dateFrom }}"></input>
        @endif
        
        @if(count($dateFrom)<=0)
        <input type="text" name="From" ></input>
        @endif

      <span class="add-on">
        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
      </span>
    </div>
    </h3>
    <script type="text/javascript"
     src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
    </script>
    <script type="text/javascript"
     src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
    </script>
    <script type="text/javascript">
      $('#datetimepicker').datetimepicker({



        format: 'dd-MM-yyyy hh:mm',
        language: 'en',
        collapse: false,
        maskInput: false,
        pickSeconds: false
      });
    </script>
  </body>
<html>
