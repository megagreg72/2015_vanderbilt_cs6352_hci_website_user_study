
function setIdElement(id){
  $(".summoner-id").append(id);
}

$(document).ready(function() {
  getSummonerId("froggen", setIdElement);
});
