
// Initialize chart
let choroplethMap = new ChoroplethMap({ parentElement: '#map' });

// Load data
Promise.all([
    d3.json('../data/canada_provinces.topo.json'),
    d3.csv('../data/canada_historical_population.csv')
]).then(files => {
    let population = files[1];

    // Change all values to numbers
    population.forEach(d => {
        const columns = Object.keys(d);
        for (const col of columns) {
            d[col] = +d[col];
        }
    });

    choroplethMap.canada_geo = files[0];
    choroplethMap.population = population;
    choroplethMap.selectedYear = 1991;
    choroplethMap.update();
});

$('#year-slider').on('input', function() {

    const year = $(this).val();
    $('#year-selection').text(year);

    choroplethMap.selectedYear = +year;
    choroplethMap.update();
});

//reference 1: https://bl.ocks.org/officeofjane/47d2b0bfeecfcb41d2212d06d095c763
//reference 2: https://www.w3schools.com/jsref/met_win_setinterval.asp
let Timer;
$('#play-button').on('click', function() {
    clearInterval(Timer);

    if ($('#play-button').text() === 'Play') {
        Timer = setInterval(function() {
            const slider = $('#year-slider');
            let year = +slider.prop('value') + 1;
            if (year > +slider.prop('max')) {
                year = +slider.prop('min');
            }
            slider.prop('value', year);
            $('#year-selection').text(year);

            choroplethMap.selectedYear = year;
            choroplethMap.update();
        }, 250);

        $('#play-button').text('Pause');
        $('#play-button').css('background-color', '#d05667');

    } else if ($('#play-button').text() === 'Pause') {
        $('#play-button').text('Play');
        $('#play-button').css('background-color', '#a0bc3d');
    }
});
