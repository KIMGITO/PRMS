// searching by filtering from table

$(document).ready(function() {
    var typingTimer;
    var doneTypingInterval = 500; 
    
    $("#searchBtn").on('click',function(){
      filterUsers();
    });
     //search after typping has stopped for 1/2 a sec
    $('#searchInput').on('input', function() {
      clearTimeout(typingTimer);
      typingTimer = setTimeout(function() {

          filterUsers();
      }, doneTypingInterval);

    
      function filterUsers(){
        $("#tableComment").empty();
              var searchText = $('#searchInput').val();
              var searchQuery = searchText.toLowerCase();
              if(searchText.length > 1){
                var resultsCount = 0;
                $('#userList tr').each(function() {
                  var rowText = $(this).text().toLowerCase();
                  if (rowText.indexOf(searchQuery) !== -1) {
                      $(this).show(); 
                      resultsCount++;
                  } else {
                      $(this).hide();
                  }
                });
                if(resultsCount > 0){
                  $("#tableComment").append(`<p class="text-primary fw-semibold"> Showing ${resultsCount} result${(resultsCount>1)?"s":""} for <span class="text-success"><u>${searchText}</u></span>.</p>`)
                }else{
                  $("#tableComment").append(`<p class="text-danger fw-semibold"> No results for <span class="text-success"><u>${searchText}</u></span>.</p>`)
                }
              }else{
                $('#userList tr').show();
              }  
      }
    });
  });


// add and remove Plaintiffs 
$(document).ready(function(){
  var count = 1;
  // add Plaintiffs
    $("#addPlaintiffs").on('click',function(){
      var currentInput = $(`#plaintiff-${count}`).val()
      if(currentInput == ""){
        displayError(`#p${count}`,'This field cant be empty');
        return;
      }else{
        $(`#p${count}`).find('.text-danger').remove();
      }
      if(currentInput.indexOf(' ') == -1){
        displayError(`#p${count}`,'Name should be separated by a space');
        return;
      }else{
        $(`#p${count}`).find('.text-danger').remove();
      }
      count++;
      

      if(count > 2){
        var i =1;
        while(i < count-1){
          $(`#p${i}`).addClass('d-none')
          i++;
        }
      }
      $("#plaintiffsField").append(
        `<div id="p${count}">
          <label for="plaintiff-${count}"class="form-label text-capitalize">Name ${count} </label>
          <input type="text" class="form-control bg-light-success plaintiff" name ="plaintiff" id="plaintiff-${count}" aria-describedby="textHelp">
        </div>`
      )
  });

  var inputsArry = [];
  var combinedValue;

  $(document).on('input','.plaintiff',function(){
    inputs = $('.plaintiff').map(function() {
      return $(this).val();
  }).get();
  
    inputsArry = inputs;
    combinedValue = inputs.join(',');
    
    $.each(inputsArry, function(index,value){
      if(value.trim() == ""){
        // alert(`index ${index} is empty`);
        displayError(`#p${index+1}`,'This field cant be empty');
      }
    });

  $("#plaintiffsCombined").val(combinedValue)
  console.log(inputsArry)
  
  })

  //  remove Plaintiffs
  $("#minusPlaintiffs").on('click',function(){
    if(count > 1){
      $("#plaintiffsField").children(':last-child').remove();
      count--;

      inputs = $('.plaintiff').map(function() {
        return $(this).val();
      }).get();
      inputsArry = inputs;
      combinedValue = inputs.join(',');
      $("#plaintiffsCombined").val(combinedValue)
    }
    $(`#p${count}`).removeClass('d-none');
    $(`#p${count-1}`).removeClass('d-none');
});
});

//add and remove Defendants
$(document).ready(function(){
  var count = 1;
  // add defendants
    $("#addDefendants").on('click',function(){
      var currentInput = $(`#defendant-${count}`).val()
      if(currentInput == ""){
        displayError(`#d${count}`,'This field cant be empty');
        return;
      }else{
        $(`#d${count}`).find('.text-danger').remove();
      }
      if(currentInput.indexOf(' ') == -1){
        displayError(`#d${count}`,'Name should be separated by a space');
        return;
      }else{
        $(`#d${count}`).find('.text-danger').remove();
      }
      count++;
      

      if(count > 2){
        var i =1;
        while(i < count-1){
          $(`#d${i}`).addClass('d-none')
          i++;
        }
      }
      $("#defendantsField").append(
        `<div id="d${count}">
          <label for="defendant-${count}"class="form-label text-capitalize">Name ${count} </label>
          <input type="text" class="form-control bg-light-success defendant" name ="defendant" id="defendant-${count}" aria-describedby="textHelp">
        </div>`
      )
  });

  var inputsArry = [];
  var combinedValue;

  $(document).on('input','.defendant',function(){
    inputs = $('.defendant').map(function() {
      return $(this).val();
  }).get();
  
    inputsArry = inputs;
    combinedValue = inputs.join(',');
    
    $.each(inputsArry, function(index,value){
      if(value.trim() == ""){
        // alert(`index ${index} is empty`);
        displayError(`#d${index+1}`,'This field cant be empty');
      }
    });

  $("#defendantsCombined").val(combinedValue)
  console.log(inputsArry)
  
  })

  //  remove defendants
  $("#minusDefendants").on('click',function(){
    if(count > 1){
      $("#defendantsField").children(':last-child').remove();
      count--;

      inputs = $('.defendant').map(function() {
        return $(this).val();
      }).get();
      inputsArry = inputs;
      combinedValue = inputs.join(',');
      $("#defendantsCombined").val(combinedValue)
    }
    $(`#d${count}`).removeClass('d-none');
    $(`#d${count-1}`).removeClass('d-none');
});
});
   

function displayError(target, message) {
  var errorMessage = $(`<p class="text-sm text-danger">${message}</p>`)
  $(target).find('.text-danger').remove();
  $(target).append(errorMessage);

  setTimeout(function() {
    errorMessage.fadeOut('slow', function() {
        $(this).remove();
    });
}, 5000);
};


  $(document).ready(function() {
    $('#search').focus();
    var input = $('#search')[0];
        var len = input.value.length;
        input.setSelectionRange(len, len);
    var typingTimer;
    var doneTypingInterval = 500; 
 
    $('#search').on('input', function() {
      clearTimeout(typingTimer);
      typingTimer = setTimeout(function() {

          search();
      }, doneTypingInterval);
    });


    function search(){
      $('#searchForm').submit();
    }
  });


  //sorting jq

  $(document).ready(function(){
    var sort = $("#sort");

    $('#asc').on('click', function(){
        sort.val('asc');
    });
    $('#des').on('click', function(){
      sort.val('desc');
    });

    $("#sortBtn").on('click',function(){
      if(!$('#confirm').is(':hidden')){
        var from = $("#fromDate").val();
        var to =$("#toDate").val();

        var query = `${sort.val()}:${from.trim()}:${to.trim()}`;

        if(query.trim() !== ""){
          query = query.trim().replace(/ /g, ':');
          $('#search').val(`filter=${query}`);
          $("#searchForm").submit();
        }
      }

      $("#sortCard").toggleClass('d-none');
      $('#sort, #confirm').toggle();
    });
  });


  function confirmDelete(id,item = 'item') {
    if (confirm(`Are you sure you want to delete this ${item}?`)) {
    $(`#form-${id}`).submit()
    } else {
      return;
    }
  }

