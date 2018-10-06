//== Class definition
var MorrisChartsDemo = function() {

    //== Private functions
    
    var demo1 = function() {
        // LINE CHART
        new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'm_morris_1',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: [{
                    y: '2006',
                    a: 49.95,
                    b: 21.91,
                    c: 19.8
                },
                {
                    y: '2007',
                    a: 51.02,
                    b: 22.29,
                    c: 19.8
                },
                {
                    y: '2008',
                    a: 53.2,
                    b: 27.67,
                    c: 19.8
                },
                {
                    y: '2009',
                    a: 49.75,
                    b: 26.14,
                    c: 19.8
                },
                {
                    y: '2010',
                    a: 60.25,
                    b: 10.76,
                    c: 19.8
                }
            ],
            // The name of the data record attribute that contains x-values.
            xkey: 'y',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['a', 'b', 'c'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Open rate', 'Click rate', 'Industry avg. open rate'],
            lineColors: ['#8EC2BD','#1F86B7', '#F45F33'],
            smooth: true,
            postUnits: '%',
            resize: true
        });
    }



    return {
        // public functions
        init: function() {
            if( $('#m_morris_1').length ) {
                demo1();
            }

        }
    };
}();

jQuery(document).ready(function() {
    MorrisChartsDemo.init();
});