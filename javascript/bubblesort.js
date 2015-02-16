
// ======================================= AJAX functions =======================================

/**
 * Shuffle the data and update the graph
 */
function ajaxGetShuffle()
{
    $.ajax({
        type: "POST",
        url: "ajax/bubblesort.php",
        async: false,
        data: {method: "getShuffle"},
        success: function(response)
        {
            if (response['status'] == 'Success')
            {
                $("#buttonStep").removeAttr('disabled');
                $("#buttonPlay").removeAttr('disabled');
                $("#buttonPlayFast").removeAttr('disabled');
                updateGraph(response['data']);
            }
            else
            {
                alert (response['error']);
            }
        },
        error: function()
        {
            alert('An error has occured');
        }
    });
}

/**
 * Update the graph
 */
function ajaxGet()
{
    $.ajax({
        type: "POST",
        url: "ajax/bubblesort.php",
        async: false,
        data: {method: "get"},
        success: function(response)
        {
            if (response['status'] == 'Success')
            {
                updateGraph(response['data']);
            }
            else
            {
                alert (response['error']);
            }
        },
        error: function()
        {
            alert('An error has occured');
        }
    });
}

/**
 * Execute one step and update the graph
 */
function ajaxGetStep()
{
    $.ajax({
        type: "POST",
        url: "ajax/bubblesort.php",
        async: false,
        data: {method: "getStep"},
        success: function(response)
        {
            if (response['status'] == 'Success')
            {
                updateGraph(response['data']);
            }
            else
            {
                alert (response['error']);
            }
        },
        error: function()
        {
            alert('An error has occured');
        }
    });
}

/**
 * Run the entire sort until completion, the speed value determines the wait in-between each step
 * @param speed
 */
function play(speed)
{
    $("#buttonStep").attr('disabled','disabled');
    $("#buttonShuffle").attr('disabled','disabled');
    $("#buttonPlay").attr('disabled','disabled');
    $("#buttonPlayFast").attr('disabled','disabled');

    $.ajax({
        type: "POST",
        url: "ajax/bubblesort.php",
        async: false,
        data: {method: "getStep"},
        success: function(response)
        {
            if (response['status'] == 'Success')
            {
                var done = updateGraph(response['data']);

                if (!done)
                {
                    setTimeout(function()
                    {
                        play(speed);
                    },speed);
                }
                else
                {
                    $("#buttonShuffle").removeAttr('disabled');
                }
            }
            else
            {
                alert (response['error']);
            }
        },
        error: function()
        {
            alert('An error has occured');
        }
    });
}

// ======================================= Routines =======================================

/**
 * Updates the graph along with related conditions
 * @param data
 */
function updateGraph(data)
{
    $("#inputStep").val(data['step']);
    $("#inputIteration").val(data['iteration']);
    $("#inputSwap").val(data['total_swaps']);

    if (data['done'])
    {
        $("#buttonStep").attr('disabled','disabled');
        $("#buttonPlay").attr('disabled','disabled');
        $("#buttonPlayFast").attr('disabled','disabled');
    }

    setChart(data['rows']);

    return (data['done']);
}

/**
 * Receives the rows and creates the chart according to them
 * @param rows [value, color]
 */
function setChart(rows)
{
    var dataSet = [];
    var ticks = [];

    var i = 0;
    rows.forEach(function(row)
    {
        dataSet.push({data: [[row[0],i++]], color: row[1]});
        ticks.push([i-1, row[0]]);
    });

    //var ticks = [[0, 1], [1, 2], [2, 3], [3, 4], [4, 5], [5, 6], [6, 7], [7, 8], [8, 9], [9, 10]];

    var options = {
        series: {
            bars: {
                show: true
            }
        },
        bars: {
            align: "center",
            barWidth: 0.5,
            horizontal: true,
            fillColor: { colors: [{ opacity: 0.5 }, { opacity: 1}] },
            lineWidth: 1
        },
        xaxis: {
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 10,
            max: 100,
            tickColor: "#5E5E5E",
            color: "black"
        },
        yaxis: {
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial',
            axisLabelPadding: 3,
            tickColor: "#5E5E5E",
            ticks: ticks,
            color: "black"
        },
        legend: {
            noColumns: 0,
            labelBoxBorderColor: "#858585",
            position: "ne"
        },
        grid: {
            hoverable: true,
            borderWidth: 2,
            backgroundColor: { colors: ["#171717", "#4F4F4F"] }
        }
    };

    $.plot($("#bubblesort_chart"), dataSet, options);
}

// ======================================= Events =======================================

$(document).ready(function ()
{
    $("#buttonStep").removeAttr('disabled');
    $("#buttonShuffle").removeAttr('disabled');
    $("#buttonPlay").removeAttr('disabled');
    $("#buttonPlayFast").removeAttr('disabled');

    ajaxGet();
});



