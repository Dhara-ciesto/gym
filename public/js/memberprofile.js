 function emailafterpacsdck(invoiceid,userid)
    {
    var invoiceid=invoiceid;
    var userid=userid;

    $.ajax({
        url : "/emailafterpack",
        type: "POST",
        data : {_token: $('input[name="_token"]').val(),invoiceid:invoiceid,userid:userid},
        success : function(data){
         if(data == true){
          alert('SMS SuccessFully Send');
         }
        },
    });

           alert('SMS and Email Send');

  }


       $("#viewmeasurement").click(function(){
        // alert('sdfsd');
  $(".viewmeasurement").toggle();
});

       $("#buttons a").click(function() {

    var id = $(this).attr("id");
    // alert(id);
    $("#pages div").css("display", "none");

    $("#pages div#" + id + "").css("display", "block");
});
 $("#buttons2 a").click(function() {

    var id = $(this).attr("id");
    // alert(id);
    $("#pages2 div").css("display", "none");

    $("#pages2 div#" + id + "").css("display", "block");
});

   $('#package').on('click', function(){
   $(this).find('li').removeClass('active');
  $('#package').removeClass('active');
  });


function viewdietplan(plannameid,memberid){

// alert(workoutid);
// alert(memberid);
var _token = $('input[name="_token"]').val();
  $.ajax({
                                   url:"/dietmemberload",
                                   method:"GET",
                                       data:{plannameid:plannameid,memberid:memberid, _token:_token},
                                 // <td> From:'item.diet_planname.fromdate+'</td><td>'item.diet_planname.todate+'</td>
                                  success:function(data) {
                                      //alert(data);
                                     $("#diethistory tbody tr:not(:first)").empty();
                                     // $('#dietmodal').modal('show');
                                    var seq1 = '';
                                    var seq2 = '';
                                   $.each(data, function(i, item){
                                    //alert(item.member_diet_plan);
                                    seq1=item.dietsequence;
                                    if (seq2!= item.dietsequence) {
                                      // console.log(item.created_at);
                                            var d = new Date(item.created_at);
                                           d1 = d.getDate();
                                        var day =  d.getDay();
                                        var month =  d.getMonth()+ Number(1);
                                        var year =  d.getFullYear();
                                           var  wrktm = '<tr class="txtdietdetail" style="border-bottom:3px;">><td colspan="2"> Name:  '+item.diet_planname.dietplanname+' </td><td colspan="6">  Assigned On :'+d1+'-'+month+'-'+year+' &nbsp; &nbsp; &nbsp;From : ';if(item.fromdate){
                                              var d = new Date(item.fromdate);
                                              var d1 = d.getDate();
                                              var day =  d.getDay();
                                              var month =  d.getMonth()+ Number(1);
                                              var year =  d.getFullYear();
                                              var frdate=''+d1+'-'+month+'-'+year+'';
                                            wrktm+=frdate;
                                           }else{
                                               wrktm+='';
                                           }
                                            wrktm+='&nbsp; &nbsp; To : ';
                                            if(item.todate){
                                              var d = new Date(item.todate);
                                              var d1 = d.getDate();
                                              var day =  d.getDay();
                                              var month =  d.getMonth()+ Number(1);
                                              var year =  d.getFullYear();
                                              var tdate=''+d1+'-'+month+'-'+year+'';
                                            wrktm+=tdate;
                                           }else{
                                               wrktm+='';
                                           }
                                           wrktm+=' </th></tr>';
                                      }
                                      else{
                                        wrktm = '';
                                      }
                                       wrktm +='<tr class="txtdietdetail" style="border-bottom:3px;"><th>';
                                         if (item.dietday==1)
                                        wrktm+= ' Monday</th>';
                                        if (item.dietday==2)
                                          wrktm+= ' Tuesday</th>';
                                         if (item.dietday==3)
                                          wrktm+= ' Wednesday</th>';
                                         if (item.dietday==4)
                                          wrktm+= ' Thursday</th>';
                                         if (item.dietday==5)
                                          wrktm+= ' Friday</th>';
                                         if (item.dietday==6)
                                          wrktm+= ' Saturday</th>';
                                        if (item.dietday==7)
                                          wrktm+= ' Sunday</th>';
                                         wrktm+= '<th scope="row">'+item.meal_master.mealname+'</th>';
                                         if(item.diettime){
                                          wrktm+= '<td>'+item.diettime+'</td>';
                                         }
                                         else{
                                           wrktm+= '<td>00:00:00</td>';
                                         }

                                        if (item.compulsary==1)
                                        wrktm+= ' <td>Yes</td><td>';
                                        else
                                          wrktm+= ' <td>No</td><td>';

                                       if(item.remark != null && item.remark !='')
                                        wrktm+= item.remark+' </td>';
                                        else
                                           wrktm+=' </td>';

                                        if (item.status==0)
                                        wrktm+= ' <td>Inactive</td>';
                                        else
                                          wrktm+= ' <td>Active</td>';
                                        // wrktm+='<td>'+item.created_at+'</td></tr>';


                                      seq2= item.dietsequence;
                                            $('.txtdietdetail:last').after(wrktm);

                                      });

                                  },
                                   dataType:'json',

                              });
}

function view(workoutid,memberid){
    var workoutid = workoutid;
    var memberid = memberid;
    var options = {
                "backdrop" : "static",
                "show":true
            }
    var _token = $('input[name="_token"]').val();
      $.ajax({
                                       url:"/workoutmemberload",
                                       method:"POST",
                                           data:{workoutid:workoutid,memberid:memberid, _token:_token},

                                  success:function(data) {
                                    // alert(data);
                                       $("#exercisehistory tbody tr:not(:first)").empty();
                                     // $('#workoutmodal').modal('show');
                                     $.each(data, function(i, item){

                                        var wrktm='<tr class="workoutmember" style="border-bottom:3px;">';
                                        wrktm +='<th>';
                                         if (item.exerciseday==1)
                                        wrktm+= ' Monday</th>';
                                        if (item.exerciseday==2)
                                          wrktm+= ' Tuesday</th>';
                                         if (item.exerciseday==3)
                                          wrktm+= ' Wednesday</th>';
                                         if (item.exerciseday==4)
                                          wrktm+= ' Thursday</th>';
                                         if (item.exerciseday==5)
                                          wrktm+= ' Friday</th>';
                                         if (item.exerciseday==6)
                                          wrktm+= ' Saturday</th>';
                                        if (item.exerciseday==7)
                                          wrktm+= ' Sunday</th>';
                                          if(item.header!=null){
                                          wrktm+='<td>'+item.header+'</td>';
                                          }else{
                                            wrktm+='<td></td>';
                                          }
                                          wrktm+='<td>'+item.exercise.exercisename+'</td><td>';
                                         if(item.memberexercisetime!=null){
                                           wrktm+= item.memberexercisetime;
                                        }
                                        else{
                                          wrktm+=' ';
                                        }
                                        wrktm+='</td><td>';
                                        if(item.memberexerciseset!=null){
                                           wrktm+= item.memberexerciseset;
                                        }
                                        else{
                                          wrktm+=' ';
                                        }
                                        wrktm+=' </td><td>';
                                        if(item.memberexerciserep!=null){
                                           wrktm+= item.memberexerciserep;
                                        }
                                        else{
                                          wrktm+=' ';
                                        }
                                        wrktm+=' </td><td>';

                                          if(item.memberexerciseins!=null){
                                           wrktm+= item.memberexerciseins;
                                        }
                                        else{
                                          wrktm+=' ';
                                        }
                                       wrktm+=' </td>';

                                        if (item.status==0)
                                        wrktm+= ' <td>Inactive</td>';
                                        else
                                          wrktm+= ' <td>Active</td>';
                                        wrktm+=' </tr>';
                                             $('.workoutmember:last').after(wrktm);
                                    });
                                  },
                                     dataType:'json',

          });
 }


var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
    if(animating) return false;
    animating = true;

    current_fs = $(this).parent();
    next_fs = $(this).parent().next();

    //activate next step on progressbar using the index of next_fs
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    //show the next fieldset
    next_fs.show();
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale current_fs down to 80%
            scale = 1 - (1 - now) * 0.2;
            //2. bring next_fs from the right(50%)
            left = (now * 50)+"%";
            //3. increase opacity of next_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({
        'transform': 'scale('+scale+')',
        'position': 'absolute'
      });
            next_fs.css({'left': left, 'opacity': opacity});
        },
        duration: 800,
        complete: function(){
            current_fs.hide();
            animating = false;
        },
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
    });
});

$(".previous").click(function(){
    if(animating) return false;
    animating = true;

    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    //de-activate current step on progressbar
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

    //show the previous fieldset
    previous_fs.show();
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale previous_fs from 80% to 100%
            scale = 0.8 + (1 - now) * 0.2;
            //2. take current_fs to the right(50%) - from 0%
            left = ((1-now) * 50)+"%";
            //3. increase opacity of previous_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({'left': left});
            previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
        },
        duration: 800,
        complete: function(){
            current_fs.hide();
            animating = false;
        },
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
    });
});


  $(function () {
    $('#example1').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false
    });
  });


      var  filesname=[];
      var olddata=$('#oldfiles').val();
console.log(olddata);
if(olddata){


    var olddata = jQuery.parseJSON(olddata);
   $.each(olddata, function(index, value) {
    filesname.push(value);
   });
}

  $('#files').on('change',function(){

     var files = $('#files').prop("files");

      var names = $.map(files, function(val) { return val.name; });
      // console.log(files);
    if(names){
         // alert(names);
           var names = document.getElementById('files');
             // alert(names.files.length);
                  if (names.files.length > 0) {


                    // RUN A LOOP TO CHECK EACH SELECTED FILE.
                      for (var i = 0; i <= names.files.length-1; i++) {
                          // alert(fname);

                          var fname = names.files.item(i).name;      // THE NAME OF THE FILE.
                          var fsize = names.files.item(i).size;
                           // THE SIZE OF THE FILE.
                           var username='<?php echo $member->username;?>';
                             fname= fname+'_'+username;
                         // alert(fname);
                           filesname.push(fname);

                                 // console.log(filesname);
                                    var save= JSON.stringify(filesname);
                           $('#allfiles').val(save);

                         //    var ap=' <li class="li1"><a class="files" >'+fname+'</a><span class="closebtns">&times;</span></li>';
                         // $('.li1:last').after(ap);
                      }
                  }
    }
});


$(function() {
    var Accordion = function(el, multiple) {
        this.el = el || {};
        this.multiple = multiple || false;

        var links = this.el.find('.article-title');
        links.on('click', {
            el: this.el,
            multiple: this.multiple
        }, this.dropdown)
    }

    Accordion.prototype.dropdown = function(e) {
        var $el = e.data.el;
        $this = $(this),
            $next = $this.next();

        $next.slideToggle();
        $this.parent().toggleClass('open');

        if (!e.data.multiple) {
            $el.find('.accordion-content').not($next).slideUp().parent().removeClass('open');
        };
    }
    var accordion = new Accordion($('.accordion-container'), false);
});

  $('#radioBtn a').on('click', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel);

    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('notActive').addClass('notnotActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notnotActive').addClass('notActive');
});


            $('#package').on('click',function(){
              // alert("dd");
              $('#pkgd').trigger('click');
            });

  $(document).ready (function(){

                $("#ak").fadeTo(15000, 1000).slideUp(1000, function(){
               $("#ak").slideUp(10000);

                });
 });

                          $("#setusersave").click(function(){

                           var setusername = $('#setusername').val();
                           var setuserid = $('#setuserid').val();
                           var setuserrefid = $('#setuserrefid').val();
                           var setuserexpiry = $('#setuserexpiry').val();
                           var setuserstatus = $('#setuserstatus').val();
                           var devicemobileno = $('#devicemobileno').val();
                          var _token = $('input[name="_token"]').val();

                           $.ajax({
                             url:"/setuser",
                             method:"POST",
                             data:{setusername:setusername,setuserstatus:setuserstatus,setuserexpiry:setuserexpiry,setuserrefid:setuserrefid,setuserid:setuserid,devicemobileno:devicemobileno, _token:_token},
                             success:function(data)
                             {

                                 alert(data);
                                window.location.reload();
                            },

                          });
                         });

                          $("#enrolluser").click(function(){


                           var setuserid = $('#setuserid').val();
                           var devicemobileno = $('#devicemobileno').val();
                           var _token = $('input[name="_token"]').val();

                           $.ajax({
                             url:"/enrolluser",
                             method:"POST",
                             data:{setuserid:setuserid,devicemobileno:devicemobileno,_token:_token},
                             success:function(data)
                             {

                                 alert(data);
                                 window.location.reload();
                            },

                          });
                         });

                          $("#enrollnewcard").click(function(){


                           var setuserid = $('#setuserid').val();
                           var devicemobileno = $('#devicemobileno').val();
                           var _token = $('input[name="_token"]').val();

                           $.ajax({
                             url:"/enrolluser",
                             method:"POST",
                             data:{setuserid:setuserid,devicemobileno:devicemobileno,_token:_token},
                             success:function(data)
                             {

                                 alert(data);
                                 window.location.reload();
                            },

                          });
                         });

                          $("#enrollcard").click(function(){


                           var setuserid = $('#setuserid').val();
                           var devicemobileno = $('#devicemobileno').val();
                           var _token = $('input[name="_token"]').val();

                           $.ajax({
                             url:"/enrollcard",
                             method:"POST",
                             data:{setuserid:setuserid,devicemobileno:devicemobileno,_token:_token},
                             success:function(data)
                             {

                                alert(data);
                                window.location.reload();
                            },

                          });
                         });

                          $("#reassigncard").click(function(){


                           var setuserid = $('#setuserid').val();
                           var devicemobileno = $('#devicemobileno').val();
                           var _token = $('input[name="_token"]').val();

                           $.ajax({
                             url:"/reassigncard",
                             method:"POST",
                             data:{setuserid:setuserid,devicemobileno:devicemobileno,_token:_token},
                             success:function(data)
                             {

                                 alert(data);
                                 window.location.reload();
                            },

                          });
                         });

                          $("#deactiveuser").click(function(){


                           var setuserid = $('#setuserid').val();
                           var devicemobileno = $('#devicemobileno').val();
                           var _token = $('input[name="_token"]').val();

                           $.ajax({
                             url:"/deactivedeviceuser",
                             method:"POST",
                             data:{setuserid:setuserid,devicemobileno:devicemobileno,_token:_token},
                             success:function(data)
                             {

                                  alert(data);
                                 window.location.reload();
                            },

                          });
                         });

                          $("#activeuser").click(function(){


                           var setuserid = $('#setuserid').val();
                           var devicemobileno = $('#devicemobileno').val();
                           var activuserdate = $('#activationdate').val();
                           var _token = $('input[name="_token"]').val();

                           $.ajax({
                             url:"/activedeviceuser",
                             method:"POST",
                             data:{setuserid:setuserid,devicemobileno:devicemobileno,activuserdate:activuserdate,_token:_token},
                             success:function(data)
                             {

                                alert(data);
                                window.location.reload();
                            },

                          });
                         });





var image='';
 // Configure a few settings and attach camera
 function configure(){
  Webcam.set({
   width: 320,
   height: 240,
   image_format: 'jpeg',
   jpeg_quality: 90
  });
  Webcam.attach( '#my_camera' );
 }
 // A button for taking snaps


 // preload shutter audio clip
 // var shutter = new Audio();
 // shutter.autoplay = false;
 // shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : 'shutter.mp3';

 function take_snapshot() {


  // take snapshot and get image data
  Webcam.snap( function(data_uri) {
  // display results in page
  document.getElementById('results').innerHTML =
   '<img id="imageprev" src="'+data_uri+'"/>';

   image=data_uri;
    $("#profileimagesave").css('display','block');

  } );

  Webcam.reset();
 }

function saveSnap(data_uri){

   var base64image = document.getElementById("imageprev").src;
  // alert(base64image);
  $(".image-tag").val(base64image);
  // alert(image);


}

       function   chekform(){
  var len = document.getElementById('MobileNo').value;

if(len.length < 10){
  alert ( "Please Enter valid Phone number" );
  return false;
}
           var lenh = document.getElementById('HomePhoneNumber').value;
 if(lenh){
  if(lenh.length < 10){
  alert ( "Please Enter valid Home Phone Number" );
  return false;
}
 }

 var leno = document.getElementById('OfficePhoneNumber').value;
 if(leno){
if(leno.length < 10){
  alert ( "Please Enter valid Office Phone Number" );
  return false;
}
}
var lene = document.getElementById('EmergancyPhoneNumber').value;
if(lene){
if(lene.length < 10){
  alert ( "Please Enter valid Emergancy Phone Number" );
  return false;
}
}
}
           var gb='';
             function fun(f){
            gb=f;
          }
          function datadisplay(y){



            fun(y);

         var id=y;

             var _token = $('input[name="_token"]').val();
            if(id)
             {
             $.ajax({


            url:"/NotesController/viewnote",
            method:"POST",
            data:{id:id, _token:_token},
            success:function(result)
            {
              var data=result;

          $('#notesdetails').text(data.notes);
        $('#notedetail').text(data.notes);
        // alert(data.images);
        if(data.images){

         // alert(data.images);
     var im = JSON.parse(data.images);

      // alert(im);
     $('#imagePreview').empty();

     // Loop through all selected options
     for (var i = 0; i < im.length; i++) {
      // $('#imagePreview').empty();
     // $("#imagePreview").append($('<img>', {src: im[i]}));
     $("#imagePreview").append('<a href="../files/'+im[i]+'" target="_blank"><img src="../files/'+im[i]+'"  alt="Image Alternative text" title="'+im[i]+'" height="100px" /></a>');
     }


        }
        else{
         $('#imagePreview').empty();
        }

        // alert(id);
        // $('#noteidforimage').val(id);
            },
            dataType:"json"
           })
      }


          }

    function imagenote (e){
      var note = e;

      $('#noteid').val(note);
    }
          $('#savenotes').on('click',function(){
            var note=$('#notes').val();
            var user=$('#recipient-name').val();
             var _token = $('input[name="_token"]').val();
            if(note)
             {
             $.ajax({
                 url:"/NotesController/addnote",
                type: "POST",
                  data:{note:note,user:user, _token:_token},
                  success:function(result)
                  {
                    var data=result;
                     $('#exampleModal').attr("style", "display:none").removeClass('in');
                     location.reload();

                  },
                  dataType:"json"
                 })
            }
          });


          $(function() {
            $('#exampleModaledit').bind('show',function(){

                $("#notesdetails").val('bosta');
            });
          });


          $('#updatenote').on('click',function(){
            var note=$('#notesdetails').val();
            var user=$('#recipient-name').val();


             var id = gb;


             var _token = $('input[name="_token"]').val();

            if(note)
             {
             $.ajax({
                url:"/NotesController/editnote",
                  method:"POST",
                  data:{id:id,note:note,user:user, _token:_token},
                  success:function(result)
                  {
                    var data=result;
                     $('#exampleModaledit').attr("style", "display:none").removeClass('in');
                     location.reload();

                  },
                  dataType:"json"
                 })
             location.reload();
            }
          });


          function notedelete(noteid){
                var note = noteid;
        // alert(note);
            var user=$('#recipient-name').val();
             var _token = $('input[name="_token"]').val();
            if(note)
             {
             $.ajax({
                  url:"/NotesController/deletenote",
                  method:"POST",
                  data:{note:note, _token:_token},
                  success:function(result)
                  {
                    var data=result;

                  },
                  dataType:"json"
                 })
             location.reload();
            }

         }

                  function fetchlogs(id){

                      $('#userfetchlogs').val(id);
                      var userfetchlogs = $('#userfetchlogs').val();
                      var _token = $('input[name="_token"]').val();
                      $('#tbody').empty();
                      $.ajax({
                             url:"/userfetchlogs",
                             method:"POST",
                             data:{userfetchlogs:userfetchlogs, _token:_token},
                             success:function(data)
                             {

                              var html="";
                              // var data = [];
                              var checkout="";
                              $.each(data,function(i,item){

                                for (var i=0; i<item['checkin'].length; i++) {

                                   // console.log(item);
                                  for(var j=0; j<item['checkout'].length; j++)
                                  {
                                   if(item['checkin'][i].date==item['checkout'][j].date)
                                   {
                                     checkout = item['checkout'][j].time;
                                     console.log(checkout);

                                   }

                                   }
                               html +="<tr>"+"<td>"+item['checkin'][i].date+"</td>"+"<td>"+item['checkin'][i].time+"</td>"+"<td>"+checkout+"</td>"+"</tr>";
                               //alert('response');
                                  }
                              });
                              // $('#t1').html(data[1]);
                              $('#tbody').append(html);

                            },
                            dataType:'json'

                          });

                  }

              $("#fromtime").on("change", function(){
         var from=$("#fromtime").prop('selectedIndex');
         // alert(from);
         $('#totime option').eq(from).prop('selected', true);
    });
  $("#totime").on("change", function(){
         var to=$("#totime").prop('selectedIndex');
         // alert(from);
         $('#fromtime option').eq(to).prop('selected', true);
    });

