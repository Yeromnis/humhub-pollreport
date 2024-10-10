$( document ).ready(function() {

    $('#polls').on("change", function(event) {
        pollId = $('#polls').val();
        getPollVotes(pollId);
   } );

});


function getPollVotes(pollId) {
    $("#pollanswers").empty();
    $("#btnExport").attr("href", null);
    if (pollId < 1) return;
    $.ajax({
      url: ajaxUrl,
      type: 'GET',
      data: { pollid: pollId },
      success: function(res) {
        var json = $.parseJSON(res);
        $("#pollanswers").html(json.gridview);
        if (json.csv.length > 0)
          $("#btnExport").attr("href", "data:text/plain;charset=utf-8,"+json.csv);
      },
      error: function(e) {
          alert(ajaxError);
      }
    });
  }
