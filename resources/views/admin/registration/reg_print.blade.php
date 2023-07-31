<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Example of Auto Loading Bootstrap Modal on Page Load</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#myModal").modal('show');
   

  //    if($('#print').click(function(){

  //       window.location.replace("{{route('registration#tologin')}}");
  //       //window.open('{{route('registration#tologin')}}');

  //     $("#myModal").modal('hide');
  // }));
  });
 
</script>
</head>
<body>
<div id="myModal" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
                <h4 class="modal-title">Registration Details</h4>
            </div>
            <div class="modal-body">
   
                     <a class="btn btn-primary" href="{{route('generate-registrationpdf')}}">Print Receipt</a>  

                      <a class="btn btn-primary" href="{{url('regposture/'.$regresend->id)}}">Go For Posture Assessment </a>  

                    <a class="btn btn-success" href="{{url('registrationdetails')}}">View All Registration Details</a>

                   
              
            </div>
        </div>
    </div>
</div>
</body>
</html>                            