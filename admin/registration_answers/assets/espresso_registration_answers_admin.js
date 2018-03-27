jQuery(document).ready(function($){


});

google.charts.load('current', {'packages':['corechart', 'bar']});
google.charts.setOnLoadCallback(drawVisualization);


function drawVisualization() {
    for(var key in ee_reg_answers_js_data){
        // skip loop if the property is from prototype
        if (!ee_reg_answers_js_data.hasOwnProperty(key)) continue;
        var chart_data = ee_reg_answers_js_data[key];
        espressoAddChart('chart-' + chart_data.question_id, chart_data.title, chart_data.rows);
    }

}



function espressoAddChart(chart_id,question_title, rows) {
        var data = new google.visualization.DataTable();
        data.addColumn('string','Option');
        data.addColumn('number', 'Count');
        data.addRows(rows);
        var options = {
            legend: {position: 'none'},
            chart:  {
                title: question_title,
            },
            hAxis:  {
                minValue: 0,
            }
        };
        var chart = new google.charts.Bar( document.getElementById( chart_id ) );
        chart.draw( data, google.charts.Bar.convertOptions( options ) );
}
