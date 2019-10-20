$('#signup').submit( function(){
    $.ajax({
    method:"POST",
    url:"api/api-signup.php",
    data:$('#signup').serialize(),
    dataType:"JSON"
    }).
    done(function(response){
        if(response.status == 0){
            $('#ErrorSignupName').text(response.message);
        }else{
            $('#ErrorSignupName').text('')
        }
        if(response.status == -1){
            $('#ErrorSignupMail').text(response.message);
            $('#signup').css("border-bottom-left-radius", "0px");
        }else{
            $('#ErrorSignupMail').text('')
        }
        if(response.status == -2){
            $('#ErrorSignupPassword').text(response.message); 
            $('#signup').css("border-bottom-left-radius", "0px");
         }else{
            $('#ErrorSignupPassword').text('')
        }
        if(response.status == 1){
            displayLogin()
         }
        }).
        fail(function(response){
            $('#ErrorSignupName').text(response.message);
            $('#ErrorSignupPassword').text(response.message);
            console.log(response)
        })
        return false
    })