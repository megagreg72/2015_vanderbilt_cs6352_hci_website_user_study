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
// end of $(document).ready(function () {
});



// validation and submitting the form
function formhash(form, password) {
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");

    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent. 
    password.value = "";

    // Finally submit the form. 
    form.submit();
}

function regformhash(form, callbackFunction) {
    var dfd = $.Deferred();

    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");

    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
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
    var out_data = [];
    for(var i = 0; i<members.length; i++){
      var summonerName = members[i];
      promises[i] = getSummonerData(summonerName); 
      promises[i].done( function(summoner_data){
        alert("got one");
        out_data[i] = summoner_data;
        var dataElement = document.createElement("input");
        // Add the new element to our form. 
        form.appendChild(dataElement);
        dataElement.name = "member" + i + "_data";
        dataElement.type = "hidden";
        var json_str = JSON.stringify(summoner_data);
        dataElement.value = json_str;
      });
    }
    
    $.when.apply($, promises).done( function()
    {
      alert("All done!");
      callbackFunction();
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
      dfd.resolve();
    })
    .fail( function(errorStr)
    {
      alert("Failure validating form."
       + "Caused by:" + errorStr);
      //dfd.reject("Failure validating form."
      //+ "Caused by: " + errorStr);
    });
    return out_data;
}
