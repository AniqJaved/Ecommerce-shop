$(document).ready(function () {
    //Check if admin password is correct
    $("#current_pwd").keyup(function () {
        var current_pwd = $("#current_pwd").val();
        $.ajax({
            type:'post',
            url:'/admin/check-current-pwd',
            data:{current_pwd:current_pwd},
            success:function(resp){
                if (resp=="false"){
                    $("#chkCurrentPwd").html("<font color=red  >Current Password is incorrect</font>");
                }
                else if (resp=="true"){
                    $("#chkCurrentPwd").html("<font color=green >Current Password is correct</font>");
                }
            },error:function () {
                alert("Error");
            }
        });
    });


    // $(".updateStatus").click(function () {
    //     var status = $(this).text();
    //     var section_id = $(this).attr("section_id");
    //     alert(status);
    //     alert(section_id);
    //     $.ajax({
    //         type:'post',
    //         url:'/admin/update-section-status',
    //         data:{status:status},
    //         success:function (resp) {
    //              alert(resp['status']);
    //              alert(resp['section_id']);
    //         },error:function () {
    //             alert("Error");
    //         }
    //        });
    // });


});
