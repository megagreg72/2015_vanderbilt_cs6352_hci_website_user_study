$(document).ready(function () {

var myDynamicForm_numMembers;
var myDynamicForm_numOpenings;

function dynamicFormAddHelper(idStr) {
    var numInputs = $('.clonedInput_' + idStr).length;    // how many "duplicatable" input fields we currently have
    
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
    var num = $('.clonedInput_' + idStr).length;    // how many "duplicatable" input fields we currently have
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

    // if only one element remains, disable the "remove" button
    if (newNum == 1)
        $('#btnDelOpening').prop('disabled', true);
}

$('#btnDelMember').prop('disabled', true);
$('#btnDelOpening').prop('disabled', true);

});
