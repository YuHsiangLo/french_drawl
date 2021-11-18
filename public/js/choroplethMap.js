class ChoroplethMap {

    constructor(_config) {
        this.config = {
            parentElement: _config.parentElement,
            containerWidth: _config.containerWidth || 1000,
            containerHeight: _config.containerHeight || 600,
        };

        this.initVis();
    }

    initVis() {
        let vis = this;

        vis.svg = d3.select(vis.config.parentElement)
            .attr('width', vis.config.containerWidth)
            .attr('height', vis.config.containerHeight);

        vis.chart = vis.svg.append('g')
            .attr('transform', 'translate(20,400), scale(0.8,0.8)');

        // We initialize a geographic path generator, that is similar to shape generators that you have used before (e.g. d3.line())
        // We define a projection: https://github.com/d3/d3-geo/blob/v1.11.9/README.md#geoAlbers
        vis.path = d3.geoPath().projection(d3.geoAlbers());
    }

    update() {
        let vis = this;


        // Add color scale
        const minPop = d3.min(vis.population, d => {
            const columns = Object.keys(d);
            return d3.min(columns.slice(1).map(c => d[c]));
        });

        const maxPop = d3.max(vis.population, d => {
            const columns = Object.keys(d);
            return d3.max(columns.slice(1).map(c => d[c]));
        });

        vis.colorScale = d3.scaleSequential()
            .domain([minPop, maxPop])
            .interpolator(d3.interpolateBlues);

        // Select data for specific year (could be done in task1.js too)
        vis.yearData = vis.population.filter(d => d.year === vis.selectedYear)[0];

        vis.render();
    }

    render() {
        let vis = this;

        const provinces = topojson.feature(vis.canada_geo, vis.canada_geo.objects.provinces);

        provinces.features.forEach(d => {
            d.properties.projected = d3.geoAlbers()(d3.geoCentroid(d));
        });

        let geoPath = vis.chart.selectAll('.geo-path')
            .data(provinces.features);

        let geoPathEnter = geoPath.enter().append('path')
            .attr('class', 'geo-path')
            .attr('d', vis.path);

        geoPath.merge(geoPathEnter)
            .transition()
            .attr('fill', d => vis.colorScale(vis.yearData[d.id]));

        // Add labels for each province with the population value
        const label = vis.chart.selectAll('.pop-label').data(provinces.features);
        const labelEnter = label.enter().append('text')
            .attr('class', 'pop-label');

        label
            .merge(labelEnter)
            .attr('x', d => d.properties.projected[0])
            .attr('y', d => d.properties.projected[1])
            .text(d => d3.format('.2s')(vis.yearData[d.id]));
    }
}
