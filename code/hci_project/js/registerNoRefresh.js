var myDynamicForm_numMembers = 1;
var myDynamicForm_numOpenings = 1;

$(document).ready(function () {

$('#btnDelMember').prop('disabled', true);
$('#btnDelOpening').prop('disabled', true);

function dynamicFormAddHelper(idStr) {
    var numInputs = $('.' + idStr + "-group").length;    // how many "duplicatable" input fields we currently have
    
    // var newInputNum = new Number(numInputs + 1);        // the numeric ID of the new input field being added
    var newInputNum = numInputs + 1;
    var oldElem = $('#' + idStr + numInputs);
    //alert(oldElem.html());
    // create the new element via clone(), and manipulate it's ID using newNum value
    var newElem = oldElem.clone().attr('id', idStr + newInputNum);

    // manipulate the name/id values of the input inside the new element
    newElem.children(':first').attr('name', idStr + newInputNum);

    // insert the new element after the last "duplicatable" input field
    oldElem.after(newElem);

    //alert(newElem.html());
    
    return newInputNum;
}

function dynamicFormDelHelper(idStr){
    var num = $('.' + idStr + "-group").length;    // how many "duplicatable" input fields we currently have
    $('#' + idStr + num).remove();        // remove the last element

    num = num - 1;
    return num;
}

document.getElementById("btnAddMember").onclick = function () {
    var idStr = 'member';
    myDynamicForm_numMembers = dynamicFormAddHelper(idStr);

    // enable the "remove" button
    $('#btnDelMember').prop('disabled', false);

    if (myDynamicForm_numMembers + (myDynamicForm_numOpenings || 1)  >= 9){
        $('#btnAddMember').prop('disabled', true);
        $('#btnAddOpening').prop('disabled', true);
    }
}

document.getElementById("btnAddOpening").onclick = function () {
    var idStr = 'opening';
    myDynamicForm_numOpenings = dynamicFormAddHelper(idStr);

    // enable the "remove" button
    $('#btnDelOpening').prop('disabled', false);

    if ((myDynamicForm_numMembers || 1) + myDynamicForm_numOpenings >= 9){
        $('#btnAddMember').prop('disabled', true);
        $('#btnAddOpening').prop('disabled', true);
    }
}

document.getElementById("btnDelMember").onclick = function () {
    var idStr = 'member';
    var newNum = dynamicFormDelHelper(idStr);

    // enable the "add" button
    $('#btnAddMember').prop('disabled', false);
    $('#btnAddOpening').prop('disabled', false);

    // if only one element remains, disable the "remove" button
    if (newNum == 1)
        $('#btnDelMember').prop('disabled', true);
}

document.getElementById("btnDelOpening").onclick = function () {
    var idStr = 'opening';
    var newNum = dynamicFormDelHelper(idStr);

    // enable the "add" button
    $('#btnAddOpening').prop('disabled', false);
    $('#btnAddMember').prop('disabled', false);

    // if mnly one element remains, disable the "remove" button
    if (newNum == 1)
        $('#btnDelOpening').prop('disabled', true);
}

$('#registration_form').validate( {
  debug: true,
  rules: {
    name: {
      required: true,
      rangelength: [1, 64]
    },  
    description: {
      required: true,
      rangelength: [1, 1024]
    },
    member1: {
      required: true,
      rangelength: [1, 64]
    },
    opening1: {
      required: true,
      rangelength: [1, 64]
    },
    email: {
      required: true,
      rangelength: [3, 64],
      email: true
    },
    password: {
      required: true,
      rangelength: [6,128]
    },
    confirmpwd: {
      required: true,
      equalTo: "#password"
    }
  },
  messages: {
    //name: "Please enter the name of your new team.",
    //description: "Please enter a brief description of your team.",
    //email: "Please enter a valid email.",
    //password: "Please enter a password.",
    comfirmpwd: "Passwords must match.",
  },
  submitHandler: function(form) {
    var $form = $(form);
    // let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");
    //var serializedData = $form.serialize();
    // let's disable the inputs for the duration of the ajax request
    $inputs.prop("disabled", true);

    // check valid LoL summoners, add LoL data for those summoners, 
    // and hash password
    //request1 = $.when(register2(form));

    // submit the whole form for entry into databases
    //request2 = $.ajax({
    //  url: "registerNoRefresh2.php",
    //  type: "post",
    //  data: $(form).serialize()
    //});
    
    register2(form, function(summoner_data){
        var dataForPhp = getFormData(form);
        dataForPhp['summoner_data'] = summoner_data;
        $.ajax({
          url: "registerNoRefresh2.php",
          type: "post",
          data: dataForPhp
        })
        .done(function(ret){
          //alert("php returned: " + ret['message']);
        })
        .fail(function(ret){
          alert("php call failed with message: " + ret['responseText']);
        });
        $inputs.prop("disabled", false);
    },
    function(){
      // do nothing, let user respond to alerts.
      $inputs.prop("disabled", false);
    });
   /*
      .then( function(data, textStatus, jqXHR){
        return $.ajax({
          url: "registerNoRefresh2.php",
          type: "post",
          data: $(form).serialize()
        })
      })
      .always(function () {
        // reenable the inputs
        $inputs.prop("disabled", false);
      });
   /*
    
    
/*
    request1.then(
    function (response, textStatus, jqXHR) {
      console.log("Hooray, it worked!");
      alert("success awesome");
      $('#callback-results').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Well done!</strong> You successfully read this important alert message.</div>');
      return request2;
    })
    //function (jqXHR, textStatus, errorThrown){
    //  console.error("The following error occured: " + textStatus, errorThrown);
    //})
    .then(function (response, textStatus, jqXHR) {
      console.log("Hooray, this also worked!");
      alert("success even more super awesome");
      $('#callback-results').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Well done!</strong> You successfully read this important alert message.</div>');
      },
      function (jqXHR, textStatus, errorThrown){
        console.error("The following error occured: " + textStatus, errorThrown);
    });

    request1.always(function () {
      // reenable the inputs
      $inputs.prop("disabled", false);
    });
*/
  }
});

// end of $(document).ready(function () {
});

function getFormData(form){
   var data = {};
   data["name"] = form.name.value;
   data["description"] = form.description.value;
   data["email"] = form.email.value;
   data["p"] = form.p.value;
   for(var i=0; i<myDynamicForm_numMembers; i++){
     var memberStr = "member" + (i+1);
     // shoudlnt have to check this, but weird this happen
     // if a 2nd team is regestered without refreshing
     if(memberStr in form){
       data[memberStr] = form[memberStr].value;
     }
   }
   for(var i=0; i<myDynamicForm_numOpenings; i++){
     var openingStr = "opening" + (i+1);
     if(openingStr in form){
       data[openingStr] = form[openingStr].value;
     }
   }
   return data;
}

function register2(form, callbackFunction, failCallback) {
    var dfd = $.Deferred();

    var p;
    //var oldP = document.getElementById("hashedPassword");
    var oldP = $("#hashedPassword");
    if(oldP.length > 0){
      p = oldP;
    }
    else{
      p = document.createElement("input");
      // Add the new element to our form. 
      form.appendChild(p);
      p.id = "hashedPassword"
      p.name = "p";
      p.type = "hidden";
    }
    p.value = hex_sha512(form.password.value);
    // Make sure the plaintext password doesn't get sent. 
    form.password.value = "";
    form.confirmpwd.value = "";

    // validate that each member is a real LoL summoner
    var members = [];
    for(var i = 1; i<=myDynamicForm_numMembers; i++){
      var elementName = "member" + i;
      members[i-1] = form["" + elementName].value;
    }
    var openings = [];
    for(var i = 1; i<=myDynamicForm_numOpenings; i++){
      var elementName = "opening" + i;
      openings[i-1] = form["" + elementName].value;
    }

    var promises = [];
    var out_data = {};
    var callbackCount = 0;
    for(var i = 0; i<members.length; i++){
      var summonerName = members[i];
      promises[i] = getSummonerData(summonerName); 
      promises[i].done( function(summoner_data){
        //alert("got one");
        out_data[callbackCount++] = summoner_data;
/*
        var dataElement = document.createElement("input");
        // Add the new element to our form. 
        form.appendChild(dataElement);
        dataElement.name = "member" + i + "_data";
        dataElement.type = "hidden";
        var json_str = JSON.stringify(summoner_data);
        dataElement.value = json_str;
*/
      });
      promises[i].fail(function(errorMessage){
        alert(errorMessage);   
      });
    }
    
    $.when.apply($, promises).done( function()
    {
      //alert("All done!");
      callbackFunction(out_data);
     /*
      for(var i = 0; i < promises.length; i++){
        var promise = promises[i];
        promise.done( function(summoner_data){
          var dataElement = document.createElement("input");
          // Add the new element to our form. 
          form.appendChild(dataElement);
          dataElement.name = "member" + i + "_data";
          dataElement.type = "hidden";
          dataElement.value = JSON.stringify(summoner_data);
        });
      }
    */
      //dfd.resolve();
    })
    .fail( function(jqXHR, textStatus)
    {
      
      alert("Please try again.");
      failCallback(jqXHR, textStatus);
      //dfd.reject("Failure validating form."
      //+ "Caused by: " + textStatus);
    });
    //return out_data;
}
