$(document).ready(function() {
    $.ajax({
        url: "https://euw.api.pvp.net/api/lol/euw/v1.4/summoner/by-name/froggen?api_key=a31d004f-fdc9-470e-84b2-5c8a9ced62b1"
    }).then(function(data) {
       $('.greeting-id').append(data.froggen.id);
    });
});
