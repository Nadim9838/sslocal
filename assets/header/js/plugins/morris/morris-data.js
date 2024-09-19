$(function() {

    Morris.Area({
        element: 'morris-area-chart',
        data: [{
            y: '2010 Q1',
            a: 1
        }, {
            y: '2010 Q2',
            a: 2
        }, {
            y: '2010 Q3',
            a: 3
        }, {
            y: '2010 Q4',
            a: 4
        }, {
            y: '2011 Q1',
            a: 5
        }, {
            y: '2011 Q2',
            a: 6
        }, {
            y: '2011 Q3',
            a: 7
        }, {
            y: '2011 Q4',
            a: 8
        }, {
            y: '2012 Q1',
            a: 9
        }, {
            y: '2012 Q2',
            a: 10
        }],
        xkey: 'y',
        ykeys: ['a'],
		ymin:1,
		ymax:31,
        labels: ['a'],
        pointSize: 4,
        hideHover: 'auto',
        resize: true
    });

});
