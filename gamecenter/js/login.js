   $('#login').submit( function(){
        $.ajax({
        method:"GET",
        url:"api/api-login.php",
        data:$('#login').serialize(),
        dataType:"JSON"
        }).
        done(function(response){
        if(response.status == 0){
            $('#ErrorLoginName').text(response.message);
            $('#ErrorLoginPassword').text(response.message);
            return
        }
        if(response.status == -1){
            $('#ErrorLoginPassword').text(response.message);
            return
        }
        if(response.status == -2){
            $('#ErrorLoginName').text(response.message);
            return
         }
        if(response.status == 1){
            location.href = 'index.php'
         }
        }).
        fail(function(response){
            $('#ErrorLoginName').text(response.message);
            $('#ErrorLoginPassword').text(response.message);
            console.log(response)
        })
        return false
    })