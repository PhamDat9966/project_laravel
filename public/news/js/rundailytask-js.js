$(document).ready(function() {
     $.ajax({
         url: dailyTaskUrl,
         type: 'GET',
         success: function(response) {
             console.log(response.message);
         },
         error: function(response) {
             console.log('Failed to run daily task.');
         }
     });
 });
