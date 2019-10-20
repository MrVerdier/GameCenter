$( document ).ready(function() {



  if( $('input[type=checkbox]').prop('checked')){
    $('body').addClass('body-night')
    $('nav').addClass('menu-night')
    $('p').addClass('text-color-night')
  }else{
    console.log('using normal mode')
    $('body').remove('body-night')
  }

  $('.page').hide()
  $('nav').hide()
  $('.search-results').hide();
  $('#logo').hide()
  
  setTimeout(function(){

    $('#profile').show()
    $('nav').show()
    $('#logo').show()
    $('#loader').hide()

    $('nav').addClass('slide-in-left')
    $('.st0').addClass('svgAnimation')
  }, 0) // EDIT THIS TO 1500 BEFORE LAUNCH!!! 

});

// *********************** NAVIGATION ***********************

$('.nav-link').click( function(){
    $('.nav-item').removeClass('active') // remove the active
    $('.nav-item').removeClass('small-active') // remove the active
    $('.page').hide() // hide all pages

    if($('nav div').hasClass('small-menu')){
      $(this).addClass('small-active')
    }else if($(this).hasClass('nav-item')){    
      $(this).addClass('active')
    }
    
    if($(this).hasClass('includes-searchbar')){
      $('nav').addClass('nav-search-padding')
    }else{
      $('nav').removeClass('nav-search-padding')
    }
    
    let sPageToShow = $(this).attr('data-showPage') // get name of page to show
    $('#'+sPageToShow).show() // show page by # ID

    $('#logo').removeClass('logoToMiddle')
    $('#logo').addClass('logoToCorner')

    if(sPageToShow == 'home'){
      $('#logo').removeClass('logoToCorner')
      $('#logo').addClass('logoToMiddle')
    } 
  })

// **********************************************

function hideMenu(){
  $('.content-container').toggleClass('full-width')
  $('.iframe-container').toggleClass('full-width')
  $('.frm-search input').toggleClass('search-slide-out')
  $('#friendProfileGames').toggleClass('grid-3-4 grid-4-3')
  $('#myFriends').toggleClass('slide-out-left-friends')

  $('.small-nav-button').toggleClass('large-nav-button')
  $('nav').toggleClass('slide-out-left slide-in-left')
  $('.nav-link').toggleClass('small-menu')
  $('.nav-link div').toggleClass('small-menu-align-icons')
  $('.nav-link').removeClass('small-active')
  
  $('.switch').toggleClass('switch-small')
  $('#profileContainer').toggleClass('profile-nav-small')

  
  console.log('hiding menu')
}

// *********************** NIGHT MODE ***********************

function switchMode(){
  $('body').toggleClass('body-night')
  $('nav').toggleClass('menu-night')
  $('p').toggleClass('text-color-night')
  console.log('Switching mode')
}

// ******************** PROFILE **************************

$('#updateProfileDescription').click(function(){
  $.ajax({
      method: 'POST',
      url: 'api/api-update-profile-description.php',
      data: $('#updateDescription').serialize()
  }).done(function(response){
    $('#updateDescription').hide();
    $('#expandDescriptonBox').show();

    if(response != $('#profileDescription')){
      $('#profileDescription').html(response)
  }

  }).fail(function(responseFail){
    console.log('fail')
  })
  return false
});

function expandDescriptionBox(){
  $('#expandDescriptonBox').hide();
  $('#updateDescription').show();
}

function cancelOperation(){
  $('#expandDescriptonBox').show();
  $('#updateDescription').hide();
}

function changeProfileImageModal(){
  Swal.fire({
    title: '<strong>Choose an image to upload</strong>',
    html:
      '<form id="changeImageForm" action="api/api-upload-user-image.php" method="post" enctype="multipart/form-data">' +
      '<input type="file" name="fileToUpload" id="fileToUpload">' +
      '<input class="upload" type="submit" value="Upload Image" name="submit">' +
      '<output id="list"></output>',
    showCloseButton: false,
    showCancelButton: true,
    showConfirmButton: false,
    focusConfirm: false,
  })
}

// ******************** SHOWROOM **************************


function uploadImageToShowroom(){
  Swal.fire({
    title: '<strong>Choose an image to upload</strong>',
    html:
      '<form action="api/api-showroom-upload-image.php" method="post" enctype="multipart/form-data">' +
      '<input type="file" name="fileToUpload" id="fileToUpload">' +
      '<input class="upload" type="submit" value="Upload Image" name="submit">' +
      '<output id="list"></output>',
    showCloseButton: false,
    showCancelButton: true,
    showConfirmButton: false,
    focusConfirm: false,
  })
}


function handleFileSelect(evt) {
  var files = evt.target.files; // FileList object

  // Loop through the FileList and render image files as thumbnails.
  for (var i = 0, f; f = files[i]; i++) {

    // Only process image files.
    if (!f.type.match('image.*')) {
      continue;
    }

    var reader = new FileReader();

    // Closure to capture the file information.
    reader.onload = (function(theFile) {
      return function(e) {
        // Render thumbnail.
        var span = document.createElement('span');
        span.innerHTML = ['<img class="thumb" src="', e.target.result,
                          '" title="', escape(theFile.name), '"/>'].join('');
        document.getElementById('list').insertBefore(span, null);
      };
    })(f);

    // Read in the image file as a data URL.
    reader.readAsDataURL(f);
  }
}

function deleteFromShowroomConfirm(e){

  let oParent = e.parentElement
  let imageSource = oParent.querySelector('img').src
  let imageName = oParent.querySelector('img').dataset.image

  Swal.fire({
    title: 'Are you sure?',
    text: "Do you want to delete from your library",
    imageUrl: imageSource,
    imageAlt: 'A tall image',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
    customClass: {
      image: 'image-modal'
    }
  }).then((result) => {   
    if (result.value) {
      Swal.fire(
        'BOOM!',
        'The game has been deleted from you library.',
        'success',
        deleteFromShowroom(imageName)
      )
    }
  })
  }
  
  function deleteFromShowroom(imageName){

    $.ajax({
        method: 'GET',
        url: 'api/api-delete-showroom-image.php',
        data: {
          image: imageName
        }
    }).done(function(){
        location.reload();
    }).fail(function(){
        console.log('fail')
    })
    return false
    
  };

// document.getElementById('fileToUpload').addEventListener('change', handleFileSelect, false);



// ******************* SEARCH/ADD/DELETE GAMES ************************

$('#games').on('input', '.txt-search', function(){

  //check if name is empty
  var name = $('#findGames').val();
      if (name == '') {
      //show nothing in html (otherwise whole list will be shown)
      $("#gamesSearchResults").html('');
      $('#gamesSearchResults').hide();
      $('#gameSearchHeadline').show();

  }
  //else if name is not empty, show the name
  else{
  $.ajax({
      method: 'GET',
      url: 'api/api-search-games.php',
      cache: false,
      data: {
          txtSearch: name
      }
  }).done(function(response){
      //set as .html -> it is echo'ing a <div>, not just .text
      $("#gamesSearchResults").html(response).show();
      $('#gameSearchHeadline').hide();
      console.log('game found')

  }).fail(function(){
      console.log('fail')
  })
  return false
  }
});


// *******************************************


function addToLibraryConfirm(e){

let oParent = e.parentElement
let gameTitle = oParent.querySelector('h3').innerText
let gameImage = oParent.querySelector('img').src

Swal.fire({
  title: 'Are you sure?',
  text: "Do you want to add "+gameTitle+" to your library",
  imageUrl: gameImage,
  imageAlt: 'A tall image',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, add it!',
  customClass: {
    image: 'image-modal'
  }
}).then((result) => {
  if (result.value) {
    Swal.fire(
      'BOOM!',
      'The game has been added to you library.',
      'success',
      addToLibrary(gameTitle)
    )
  }
})
}

function addToLibrary(gameTitle){
  console.log('game added')
  $.ajax({
      method: 'GET',
      url: 'api/api-add-game.php',
      data: {
        game: gameTitle
      }
  }).done(function(response){
      console.log(response)
      checkGames()
  }).fail(function(){
      console.log('fail')
  })
  return false
  
};


// *******************************************

function checkGames(){
    $.ajax({
      method: 'GET',
      url: 'api/api-display-my-games.php',
  }).done(function(response){

      if(response != $('#myGames') || response != $('#myGamesProfile')){
          $('#myGames').html(response)
          $('#myGamesProfile').html(response)
      }

  }).fail(function(){
      console.log('fail')
  })
  return false
  }

  // *******************************************

  function deleteFromLibraryConfirm(e){
    let oParent = e.parentElement
    let gameTitle = oParent.querySelector('h3').innerText
    let gameImage = oParent.querySelector('img').src

    console.log(gameImage)

    Swal.fire({
      title: 'Are you sure?',
      text: "Do you want to delete "+gameTitle+" from your library",
      imageUrl: gameImage,
      imageAlt: 'A tall image',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      customClass: {
        image: 'image-modal'
      }
    }).then((result) => {
      if (result.value) {
        Swal.fire(
          'BOOM!',
          'The game has been deleted from you library.',
          'success',
          deleteFromLibrary(gameTitle)
        )
      }
    })
    }
    
    function deleteFromLibrary(gameTitle){

      $.ajax({
          method: 'GET',
          url: 'api/api-delete-game.php',
          data: {
            game: gameTitle
          }
      }).done(function(response){
          checkGames()
      }).fail(function(){
          console.log('fail')
      })
      return false
      
    };

// ******************* SEARCH/ADD/DELETE FRIENDS ************************


$('#friends').on('input', '.txt-search', function(){
  //check if name is empty
  var name = $('#findFriends').val();
      if (name == '') {
      //show nothing in html (otherwise whole list will be shown)
      $("#friendsSearchResults").html('');
      $('#friendsSearchResults').hide();
  }
  //else if name is not empty, show the name
  else{
  $.ajax({
      method: 'GET',
      url: 'api/api-search-friends.php',
      cache: false,
      data: {
          txtSearch: name
      }
  }).done(function(response){
      //set as .html -> it is echo'ing a <div>, not just .text
      $(".lower-background-friends").hide();
      $("#friendProfile").hide();
      $("#friendsSearchResults").html(response).show();

  }).fail(function(){
      console.log('fail')
  })
  return false
  }
});


  // *******************************************

  function sendFriendRequestConfirm(e, id){

    let oParent = e.parentElement
    let friendName = oParent.querySelector('h3').innerText
    let userImage = oParent.querySelector('img').src

      $.ajax({
          method: 'GET',
          url: 'api/api-send-friend-request.php',
          data: {
            requestUser: id
          },
          dataType: "JSON"
      }).done(function(response){
        if (response.status == 0){
          Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: 'You are already friends! (Or waiting to be)',
          })
          return
        }
        Swal.fire({
          title: 'Friend request sent',
          text: 'Now we wait for '+friendName+' to accept (hopefully)',
          imageUrl: userImage,
          imageAlt: 'A tall image',
          customClass: {
            image: 'image-modal'
          }
        })
          console.log(response)
      }).fail(function(){
          console.log('Friend request not sent')
      })
      return false
      
    }

  // *******************************************
    $("#myFriendRequest").removeClass('friend-request-active')

    function reactToFriendRequest(id, status){
      $.ajax({
          method: 'POST',
          url: 'api/api-set-friend-status.php',
          data: {
            friendUserId: id,
            setStatus: status,
          }
      }).done(function(response){
          checkFriends()
          $("#requestId"+id).remove()

         if( $("#myFriendRequest").not(":has(div)")){
           $('#requestHeadline').hide()
           $('#requestHeadlineAlt').show()
         }

      }).fail(function(){
          console.log('fail')
      })
      return false
    };

 // *******************************************

  function checkFriends(){
  
    $.ajax({
        method: 'GET',
        url: 'api/api-display-my-friends.php',
    }).done(function(response){

        if(response != $('#myFriends')){
            $('#myFriends').html(response)
        }

    }).fail(function(){
        console.log('fail')
    })
    return false
    }
    

  // *******************************************

  function viewFriendProfile(id_test){
    $('.lower-background-friends').css('margin', '-45px -50px 0 -50px')
    $("#friendProfileGames").html('');
    $("#friendsSearchResults").html('');
    
    $.ajax({
      method: 'GET',
      url: 'api/api-display-friend-profile.php',
      data: {
        profileId: id_test
      }
    }).done(function(response){
      $(".lower-background-friends").show();
      $("#friendProfile").show();
      $("#friendProfile").html(response);
    }).fail(function(){
        console.log('fail')
    })
    return false
  }
   
  // *******************************************

  function showAllFriendGames(id){
      $.ajax({
        method: 'GET',
        url: 'api/api-display-friend-profile-games.php',
        data: {
          profileId: id
        }
    }).done(function(response){
      $("#friendProfileGames").html(response);
    }).fail(function(){
        console.log('fail')
    })
    return false
  }
  // *******************************************

  function showAllFriendGamesInCommon(id){
      $.ajax({
        method: 'GET',
        url: 'api/api-display-friend-profile-games-in-common.php',
        data: {
          profileId: id
        },
        cache: false
    }).done(function(response){
      $("#friendProfileGames").html(response);
    }).fail(function(){
        console.log('fail')
    })
    return false
  }

    // *******************************************

    function showImages(id){
        $.ajax({
          method: 'GET',
          url: 'api/api-display-friend-images.php',
          data: {
            profileId: id
          }
      }).done(function(response){
        $("#friendProfileGames").html(response);
      }).fail(function(){
          console.log('fail')
      })
      return false
    }

    
    // *******************************************

    function toggleActive(e) {
      $('.friends-details div').removeClass('active-alt');
      $(e).addClass('active-alt');
    }

// ******************** LOG OUT **************************  

  function logOutUser(){
    console.log('logging out')
    $.ajax({
      method:"GET",
      url:"api/api-logout.php",
      }).
      done(function(){
      location.href = 'login.php'  
      }).
      fail(function(){
      console.log('logout error')
      })
      return false
  }