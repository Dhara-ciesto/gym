$(document).ready(function () {
    // **********************************fottab1*********************************

    $(document).on("click", ".addtab1", function () {
        var mycount = $(this).val();
        counttab1++;
        var ap = "";
        if ($("#headeryes").val() == 1) {
            countheader1++;
            ap += '<tbody id="tbody1' + countheader1 + '" >';
        }
        ap += `<tr id="tab1firsttr` + counttab1 + `" class="tab1item">`;
        if ($("#headeryes").val() == 1) {
            ap +=
                `<td><div class="form-group"><button type="button" id="add1" value="` +
                countheader1 +
                `" class="btn bg-green addtab1" ><i class="fa fa-plus">Add</i></button></div></td><td><div class="form-group"><input type="text" name="tab1header` +
                counttab1 +
                `" class="form-control header"  id="tab1header` +
                counttab1 +
                `" placeholder="Enter Header"></div></td>`;
        } else {
            ap += `<td></td><td></td>`;
        }

        if ($("#headeryes").val() == 1) {
            ap += `</tbody>`;
            $("#tbody1" + (countheader1 - 1)).after(ap);
            $("#headeryes").val(0);
        } else {
            $("#tbody1" + mycount).append(ap);
        }

        count2 = counttab1 - 1;
        $("#tab1rmvbtn" + count2).hide();

        $("#mycounttab1").val(counttab1);
    });
});



$(document).ready(function() {
    // **********************************fottab1*********************************

    $(document).on("click", '.addtab1', function() {
        var mycount = $(this).val();
        counttab1++;
        var ap = '';
        if ($("#headeryes").val() == 1) {
            countheader1++;
            ap += '<tbody id="tbody1' + countheader1 + '" >';
        }
        ap += `<tr id="tab1firsttr` + counttab1 + `" class="tab1item">`;
        if ($("#headeryes").val() == 1) {
            ap += `<td><div class="form-group"><button type="button" id="add1" value="` +
                countheader1 +
                `" class="btn bg-green addtab1" ><i class="fa fa-plus">Add</i></button></div></td><td><div class="form-group"><input type="text" name="tab1header` +
                counttab1 + `" class="form-control header"  id="tab1header` + counttab1 +
                `" placeholder="Enter Header"></div></td>`;

        } else {
            ap += `<td></td><td></td>`;
        }
        ap += `<td>`;
        '<?php foreach ($exercise as $exercisetab1){ echo "<option value="` . $exercisetab1->exerciseid . `">` . $exercisetab1->exercisename . `</option>"}?></select></div>';
        // ap += `<td><div class="form-group"><select class="form-control exercisename" name="tab1exercisename[]"><option value="" disabled="" selected="">Please select<option>`;
        //     <?php foreach ($exercise as $exercisetab1)
        //     {echo "<option value="` . $exercisetab1->exerciseid . `">` . $exercisetab1->exercisename . `</option>"}?></select></div>`;
        //     ap +=`</td><td><div class="form-group"><input type="text" id="tab1time`+counttab1+`" name="tab1time[]" class="form-control"></div></td><td><div class="form-group"><input type="text" name="tab1set[]" class="form-control "></div></td><td><div class="form-group"><input id="tab1rep`+counttab1+`"type="text" name="tab1rep[]" class="form-control number exerciseset"></div></td><td><div class="form-group"><input type="text" name="tab1instruction[]" class="form-control"></div></td><td><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab1(`+counttab1+`)" ><i class="fa fa-minus"></i></button></td></tr>`;
        if ($("#headeryes").val() == 1) {
            ap += `</tbody>`;
            $('#tbody1' + (countheader1 - 1)).after(ap);
            $("#headeryes").val(0);
        } else {
            $('#tbody1' + mycount).append(ap);
        }
        count2 = counttab1 - 1;
        $("#tab1rmvbtn" + count2).hide();
        $("#mycounttab1").val(counttab1);
        $("#tab1rep" + counttab1).keypress(function(e) {
            var keyCode = e.which;
            if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                return false;
            }
        });
        $("#tab1time" + counttab1).keypress(function(e) {
            var keyCode = e.which;

            if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                return false;
            }
        });
        $('.exercisename').select2();
    });

});



