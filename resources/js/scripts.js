jQuery(document).ready(function(){

  if($('#dropzone').length){
      Dropzone.autoDiscover = false;
      var getUrl = window.location;
      var baseUrl = getUrl.protocol + "//" + getUrl.host;
      console.log(baseUrl + '/api/upload_csv');
      var myDropzoneSend = new Dropzone(
        '#dropzone', {
        autoProcessQueue: true,
        uploadMultiple: false,
        parallelUploads: 1,
        paramName: "file",
        acceptedFiles: ".csv",
        maxFilesize: null,
        maxFiles: 1,
        chunking: false,
        url: baseUrl +  '/api/upload_csv',
        init: function () {
          this.on("addedfiles", function(files) {
            $('#modal-progress').modal('toggle');
            $('.modal-backdrop').css('opacity', 1);
          });
          this.on("success", function (file, result) {
            $('#modal-progress').modal('toggle');
            $('.modal-backdrop').css('opacity', 0.5);
            $('#modal-success').modal('toggle');
            this.removeAllFiles(true);
          });
          this.on("error", function (file, response, test) {
            $('#modal-progress').modal('toggle');
            $('.modal-backdrop').css('opacity', 0.5);
            $('#modal-error').modal('toggle');
            this.removeAllFiles(true);
          });
        }
      });
  }

  $('.clickable-row').click(function () {
      window.location = $(this).data('href');
  });


  $( "#filter" ).change(function() {
    var value = this.value;
    if(value == 'week'){
      var scores_data = weekly_scores;
      var durations_data = weekly_durations;
    } else {
      var scores_data = monthly_scores;
      var durations_data = monthly_durations;
    }

    var options = {
      exportEnabled: true,
      animationEnabled: true,
      axisX: {
        title: "Date"
      },
      axisY: {
        title: "Average User Score",
        titleFontColor: "#4F81BC",
        lineColor: "#4F81BC",
        labelFontColor: "#4F81BC",
        tickColor: "#4F81BC"
      },
      axisY2: {
        title: "Total Call Duration",
        titleFontColor: "#C0504E",
        lineColor: "#C0504E",
        labelFontColor: "#C0504E",
        tickColor: "#C0504E"
      },
      toolTip: {
        shared: true
      },
      legend: {
        cursor: "pointer",
        itemclick: toggleDataSeries
      },
      data: [{
        type: "spline",
        name: "User Score",
        showInLegend: true,
        xValueFormatString: "MMM YYYY",
        yValueFormatString: "#,##0 Units",
        dataPoints: scores_data,
      },
      {
        type: "spline",
        name: "Call Duration",
        axisYType: "secondary",
        showInLegend: true,
        xValueFormatString: "MMM YYYY",
        yValueFormatString: "#,##0.# Seconds",
        dataPoints: durations_data,
      }]
    };
    $("#chartContainer").CanvasJSChart(options);

    function toggleDataSeries(e) {
      if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
      } else {
        e.dataSeries.visible = true;
      }
      e.chart.render();
    }

  });

  if($('#chartContainer').length){
    var options = {
      exportEnabled: true,
      animationEnabled: true,
      axisX: {
        title: "Date"
      },
      axisY: {
        title: "Average User Score",
        titleFontColor: "#4F81BC",
        lineColor: "#4F81BC",
        labelFontColor: "#4F81BC",
        tickColor: "#4F81BC"
      },
      axisY2: {
        title: "Total Call Duration",
        titleFontColor: "#C0504E",
        lineColor: "#C0504E",
        labelFontColor: "#C0504E",
        tickColor: "#C0504E"
      },
      toolTip: {
        shared: true
      },
      legend: {
        cursor: "pointer",
        itemclick: toggleDataSeries
      },
      data: [{
        type: "spline",
        name: "User Score",
        showInLegend: true,
        xValueFormatString: "MMM YYYY",
        yValueFormatString: "#,##0 Units",
        dataPoints: weekly_scores,
      },
      {
        type: "spline",
        name: "Call Duration",
        axisYType: "secondary",
        showInLegend: true,
        xValueFormatString: "MMM YYYY",
        yValueFormatString: "$#,##0.#",
        dataPoints: weekly_durations,
      }]
    };
    $("#chartContainer").CanvasJSChart(options);

    function toggleDataSeries(e) {
      if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
      } else {
        e.dataSeries.visible = true;
      }
      e.chart.render();
    }
  }

});
