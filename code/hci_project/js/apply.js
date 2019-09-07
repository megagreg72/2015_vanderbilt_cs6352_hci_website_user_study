$(document).ready(function () {

$('form').each(function() {  // attach to all form elements on page
$(this).validate({
//$('.application_form').validate( {
  debug: true,
  rules: {
    opening_id: {
      required: true,
      rangelength: [1, 1024]
    },  
    summoner_name: {
      required: true,
      rangelength: [1, 1024]
    }
  },
  messages: {
  },
  submitHandler: function(form) {
    var $form = $(form);
    // let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");
    // let's disable the inputs for the duration of the ajax request
    $inputs.prop("disabled", true);
    // check valid LoL summoners, add LoL data for those summoners
    var formData = getFormData(form);
    apply(formData, function(summoner_data){
        var dataForPhp = formData;
        dataForPhp['summoner_data'] = summoner_data;
        $.ajax({
          url: "apply.php",
          type: "post",
          data: dataForPhp
        })
        .done(function(ret){
          alert("Application successful.  If and when the team accepts your application, they should message you in game.  You can only have one pending application at a time; if you had another pending application, it has been removed.")
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
  }
});

//end of loop over all forms
});
// end of $(document).ready(function () {
});

function getFormData(form){
   var data = {};
   data["opening_id"] = form.opening_id.value;
   data["summoner_name"] = form.summoner_name.value;
   return data;
}

function apply(formData, callbackFunction, failCallback) {
  // validate that this is a real LoL summoner
  var summonerName = formData["summoner_name"];
  var promise = getSummonerData(summonerName); 
  promise.done( function(summoner_data){
    //alert("got it");
    callbackFunction(summoner_data);
  });
  promise.fail(function(textStatus){
    //alert('xhr:' + xhr);
    alert('textStatus:' + textStatus);
    failCallback(textStatus);
  });
}
