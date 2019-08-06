function update() {
    //alert('Running update.');
    //var ph = $('#phase').val();
    var cpid = $('#cur_phase').val();
    var cma = $('#c_email').val();
    var cadd = $('#c_address').val();
    var cnum = $('#c_number').val();
    var cid = $('#cust_id').val();
    var tok = $('#_token').val();
    var pn = $('#p_name').val();
    var edl = $('#est_day_left').val();
    var pc = $('#p_comment').val();
    var dc = $('#delv_content')[0].checked
    if (dc == true)
        dc = 1;
    else
        dc = 0;
    console.log(cpid);


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/update",
        type: 'POST',
        data: {
            c_email: cma,
            c_address: cadd,
            c_number: cnum,
            cust_id: cid,
            //_token: tok,
            p_name: pn,
            est_day_left: edl,
            p_comment: pc,
            delv_content: dc,
            cur_phase: cpid

            //form: str,
            //phase: ph,
            //_token: '{{csrf_token()}}'
        },
        success: function (response) {
            console.log('Success: ' + response);
            location.href = '/';
            alert('Success');
        },
        error: function (xhr, errorCode, errorThrown) {
            console.log(xhr.responseText);
        }
    })
};

function reload() {
    //alert("Reload called");
    var cid = $('#cust_id').val();
    var pn = $('#p_name').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/reload",
        type: 'POST',
        data: {
            cust_id: cid,
            p_name: pn
        },
        success: function (response) {
            console.log('Success: ' + response);
            location.reload(true);
        },
        error: function (xhr, errorCode, errorThrown) {
            console.log(xhr.responseText);
        }
    })

};
function preview(){
    
    var cma = $('#c_email').val();
    var cn = $('#company_name').val();
    var pn = $('#p_name').val();
    var edl = $('#est_day_left').val();
    var pc = $('#p_comment').val();
    var dc = $('#delv_content')[0].checked
    if (dc == true)
        dc = 1;
    else
        dc = 0;
    


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/template",
        type: 'POST',
        data: {
            to: cma,
            //_token: tok,
            p_name: pn,
            est_day_left: edl,
            comment: pc,
            delv_content: dc,
            company_name:cn

            //form: str,
            //phase: ph,
            //_token: '{{csrf_token()}}'
        },
        success: function (response) {
            //console.log('Success: ' + response);
            var myWindow = window.open("/template", "popUpWindow",'height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=yes');
                myWindow.document.write(response);
            //alert('Success');
        },
        error: function (xhr, errorCode, errorThrown) {
            console.log(xhr.responseText);
        }
    })

};
function sendemail(){
    
    var cma = $('#c_email').val();
    var cn = $('#company_name').val();
    var pn = $('#p_name').val();
    var edl = $('#est_day_left').val();
    var pc = $('#p_comment').val();
    var dc = $('#delv_content')[0].checked
    if (dc == true)
        dc = 1;
    else
        dc = 0;
    


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "/sendEmail",
        type: 'POST',
        data: {
            to: cma,
            //_token: tok,
            p_name: pn,
            est_day_left: edl,
            comment: pc,
            delv_content: dc,
            company_name:cn

            //form: str,
            //phase: ph,
            //_token: '{{csrf_token()}}'
        },
        success: function (response) {
            console.log('Success: ' + response);
            
            //alert('Success');
        },
        error: function (xhr, errorCode, errorThrown) {
            console.log(xhr.responseText);
        }
    })

};
