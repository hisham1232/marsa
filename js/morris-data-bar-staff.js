// Dashboard 1 Morris-chart
$(function () {
    "use strict";
    // Morris bar chart
    var janSTL = $('.janSTL').val();
    var janSL = $('.janSL').val();

    var febSTL = $('.febSTL').val();
    var febSL = $('.febSL').val();

    var marSTL = $('.marSTL').val();
    var marSL = $('.marSL').val();

    var aprSTL = $('.aprSTL').val();
    var aprSL = $('.aprSL').val();

    var maySTL = $('.maySTL').val();
    var maySL = $('.maySL').val();

    var junSTL = $('.junSTL').val();
    var junSL = $('.junSL').val();

    var julSTL = $('.julSTL').val();
    var julSL = $('.julSL').val();

    var augSTL = $('.augSTL').val();
    var augSL = $('.augSL').val();

    var sepSTL = $('.sepSTL').val();
    var sepSL = $('.sepSL').val();

    var octSTL = $('.octSTL').val();
    var octSL = $('.octSL').val();

    var novSTL = $('.novSTL').val();
    var novSL = $('.novSL').val();

    var decSTL = $('.decSTL').val();
    var decSL = $('.decSL').val();
    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: 'January',
            a: janSTL,
            b: janSL
        }, {
            y: 'February',
            a: febSTL,
            b: febSL
        }, {
            y: 'March',
            a: marSTL,
            b: marSL
        }, {
            y: 'April',
            a: aprSTL,
            b: aprSL
        }, {
            y: 'May',
            a: maySTL,
            b: maySL
        }, {
            y: 'June',
            a: junSTL,
            b: junSL
        }, {
            y: 'July',
            a: julSTL,
            b: julSL
        }, {
            y: 'August',
            a: augSTL,
            b: augSL
        }, {
            y: 'September',
            a: sepSTL,
            b: sepSL
        }, {
            y: 'October',
            a: octSTL,
            b: octSL
        }, {
            y: 'November',
            a: novSTL,
            b: novSL
        }, {
            y: 'December',
            a: decSTL,
            b: decSL
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Standard Leave Filed', 'Short Leave Filed'],
        barColors: ['#009efb', '#55ce63'],
        hideHover: 'auto',
        gridLineColor: '#eef0f2',
        resize: true
    });
});