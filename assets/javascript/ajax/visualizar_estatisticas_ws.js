$(document).ready(function () {
    
    var acoes_visualizar_estatisticas = {
        inicializa: function(){
            acoes_visualizar_estatisticas.grafico_submissoes_por_linguagem();
            acoes_visualizar_estatisticas.grafico_submissoes_por_resposta();
        },
        grafico_submissoes_por_linguagem : function() {
            
            var url = $('#base_url').val() + 'ws/ajax/grafico_submissoes_por_linguagem';
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {'problema': $('input[name="problema_id"]').val()},
                success: function (dados) {
                    
                    //Width and height
                    var w = $("#grafico_barras").width();
                    var h = w;
                    console.log(dados);
                    Morris.Bar({
                      element: 'grafico_barras',
                      data: [
                        {x: '2011 Q1', y: 0},
                        {x: '2011 Q2', y: 1},
                        {x: '2011 Q3', y: 2},
                        {x: '2011 Q4', y: 3},
                        {x: '2012 Q1', y: 4},
                        {x: '2012 Q2', y: 5},
                        {x: '2012 Q3', y: 6},
                        {x: '2012 Q4', y: 7},
                        {x: '2013 Q1', y: 8}
                      ],
                      xkey: 'x',
                      ykeys: ['y'],
                      labels: ['Y'],
                      barColors: function (row, series, type) {
                        if (type === 'bar') {
                          var red = Math.ceil(255 * row.y / this.ymax);
                          return 'rgb(' + red + ',0,0)';
                        }
                        else {
                          return '#000';
                        }
                      }
                    });
                    
                },
                error: function () {
                    console.log("error in ajax form submission");
                }
            });
        },
        grafico_submissoes_por_resposta : function() {
            var url = $('#base_url').val() + 'ws/ajax/grafico_submissoes_por_resposta';
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {'problema': $('input[name="problema_id"]').val()},
                success: function (dados) {

                    /*Returns an event handler for fading a given chord group*/
                    function fade(opacity) {
                        return function (d, i) {
                            svg.selectAll("path.chord")
                                    .filter(function (d) {
                                        return d.source.index != i && d.target.index != i;
                                    })
                                    .transition()
                                    .style("stroke-opacity", opacity)
                                    .style("fill-opacity", opacity);
                        };
                    }
                    ;/*fade*/

                    /*Returns an array of tick angles and labels, given a group*/
                    function groupTicks(d) {
                        var k = (d.endAngle - d.startAngle) / d.value;
                        return d3.range(0, d.value, 1).map(function (v, i) {
                            
                            return {
                                angle: v * k + d.startAngle,
                                label: (v+1) * k + d.startAngle < d.endAngle ? null : v + "%"
                                //label: i % 5 ? null : v + "%"
                            };
                        });
                    }
                    ;/*groupTicks*/

                    /*Taken from https://groups.google.com/forum/#!msg/d3-js/WC_7Xi6VV50/j1HK0vIWI-EJ
                     //Calls a function only after the total transition ends*/
                    function endall(transition, callback) {
                        var n = 0;
                        transition
                                .each(function () {
                                    ++n;
                                })
                                .each("end", function () {
                                    if (!--n)
                                        callback.apply(this, arguments);
                                });
                    }
                    ;/*endall*/

                    /*Taken from http://bl.ocks.org/mbostock/7555321
                     //Wraps SVG text*/
                    function wrap(text, width) {
                        var text = d3.select(this[0][0]),
                                words = text.text().split(/\s+/).reverse(),
                                word,
                                line = [],
                                lineNumber = 0,
                                lineHeight = 4.4,
                                y = text.attr("y"),
                                x = text.attr("x"),
                                dy = parseFloat(text.attr("dy")),
                                tspan = text.text(null).append("tspan").attr("x", x).attr("y", y).attr("dy", dy + "em");

                        while (word = words.pop()) {
                            line.push(word);
                            tspan.text(line.join(" "));
                            if (tspan.node().getComputedTextLength() > width) {
                                line.pop();
                                tspan.text(line.join(" "));
                                line = [word];
                                tspan = text.append("tspan").attr("x", x).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
                            }
                            ;
                        }
                        ;
                    }
                    ;

                    /*Run the progress bar during an animation*/
                    function runProgressBar(time) {

                        /*Make the progress div visible*/
                        d3.selectAll("#progress")
                                .style("visibility", "visible");

                        /*Linearly increase the width of the bar
                         //After it is done, hide div again*/
                        d3.selectAll(".prgsFront")
                                .transition().duration(time).ease("linear")
                                .attr("width", prgsWidth)
                                .call(endall, function () {
                                    d3.selectAll("#progress")
                                            .style("visibility", "hidden");
                                });

                        /*Reset to zero width*/
                        d3.selectAll(".prgsFront")
                                .attr("width", 0);

                    }
                    ;/*runProgressBar*/

                    /*//////////////////////////////////////////////////////////
                     ////////////////// Set up the Data /////////////////////////
                     //////////////////////////////////////////////////////////*/

                    var NameProvider = dados.labels;
                    var matrix = dados.porcentagens;
                    /*Sums up to exactly 100*/

                    var colors = ["#C4C4C4", "#69B40F", "#EC1D25", "#C8125C", "#008FC8", "#10218B", "#134B24", "#9A6C69"];

                    /*Initiate the color scale*/
                    var fill = d3.scale.ordinal()
                            .domain(d3.range(NameProvider.length))
                            .range(colors);

                    /*//////////////////////////////////////////////////////////
                     /////////////// Initiate Chord Diagram /////////////////////
                     //////////////////////////////////////////////////////////*/

                    var margin = {top: 30, right: 50, bottom: 30, left: 50},
                    width = $("#chart").width() - margin.left - margin.right,
                            height = ($("#chart").width()) - margin.top - margin.bottom,
                            innerRadius = Math.min(width, height) * .39,
                            outerRadius = innerRadius * 1.06;

                    /*Initiate the SVG*/
                    var svg = d3.select("#chart").append("svg:svg")
                            .attr("width", width + margin.left + margin.right)
                            .attr("height", height + margin.top + margin.bottom)
                            .append("svg:g")
                            .attr("transform", "translate(" + (margin.left + width / 2) + "," + (margin.top + height / 2) + ")");


                    var chord = d3.layout.chord()
                            .padding(.04)
                            .sortSubgroups(d3.descending) /*sort the chords inside an arc from high to low*/
                            .sortChords(d3.descending) /*which chord should be shown on top when chords cross. Now the biggest chord is at the bottom*/
                            .matrix(matrix);


                    /*//////////////////////////////////////////////////////////
                     ////////////////// Draw outer Arcs /////////////////////////
                     //////////////////////////////////////////////////////////*/

                    var arc = d3.svg.arc()
                            .innerRadius(innerRadius)
                            .outerRadius(outerRadius);

                    var g = svg.selectAll("g.group")
                            .data(chord.groups)
                            .enter().append("svg:g")
                            .attr("class", function (d) {
                                return "group " + NameProvider[d.index];
                            });

                    g.append("svg:path")
                            .attr("class", "arc")
                            .style("stroke", function (d) {
                                return fill(d.index);
                            })
                            //.style("stroke-width","5")
                            .style("fill", function (d) {
                                return fill(d.index);
                            })
                            .attr("d", arc)
                            .style("opacity", 0)
                            .transition().duration(1000)
                            .style("opacity", 0.8);

                    /*//////////////////////////////////////////////////////////
                     ////////////////// Initiate Ticks //////////////////////////
                     //////////////////////////////////////////////////////////*/

                    var ticks = svg.selectAll("g.group").append("svg:g")
                            .attr("class", function (d) {
                                return "ticks " + NameProvider[d.index];
                            })
                            .selectAll("g.ticks")
                            .attr("class", "ticks")
                            .data(groupTicks)
                            .enter().append("svg:g")
                            .attr("transform", function (d) {
                                return "rotate(" + (d.angle * 180 / Math.PI - 90) + ")"
                                        + "translate(" + outerRadius + 40 + ",0)";
                            });

                    /*Append the tick around the arcs*/
                    ticks.append("svg:line")
                            .attr("x1", 1)
                            .attr("y1", 0)
                            .attr("x2", 5)
                            .attr("y2", 0)
                            .attr("class", "ticks")
                            .style("stroke", "#FFF");

                    /*Add the labels for the %'s*/
                    ticks.append("svg:text")
                            .attr("x", 8)
                            .attr("dy", ".35em")
                            .attr("class", "tickLabels")
                            .attr("font-size", "11px")
                            .attr("transform", function (d) {
                                return d.angle > Math.PI ? "rotate(180)translate(-16)" : null;
                            })
                            .style("text-anchor", function (d) {
                                return d.angle > Math.PI ? "end" : null;
                            })
                            .text(function (d) {
                                return d.label;
                            })
                            .attr('opacity', 0);

                    /*//////////////////////////////////////////////////////////
                     ////////////////// Initiate Names //////////////////////////
                     //////////////////////////////////////////////////////////*/

                    g.append("svg:text")
                            .each(function (d) {
                                d.angle = (d.startAngle + d.endAngle) / 2;
                            })
                            .attr("dy", ".35em")
                            .attr("class", "titles")
                            .attr("font-size", '10px')
                            .attr("text-anchor", function (d) {
                                return d.angle > Math.PI ? "end" : null;
                            })
                            .attr("transform", function (d) {
                                return "rotate(" + (d.angle * 180 / Math.PI - 90) + ")"
                                        + "translate(" + (innerRadius + 10) + ")"
                                        + (d.angle > Math.PI ? "rotate(180)" : "");
                            })
                            .attr('opacity', 0)
                            .style("fill", function (d) {
                                return fill(d.index);
                            })
                            .html(function (d, i) {
                                var text = NameProvider[i].split(' ');
                                var label = '';
                                $.each(text,function(i,val){
                                    label += '<tspan x="0" y="' + i*10 + '">' + val + '</tspan>';
                                });
                                return label;
                            });

                    /*//////////////////////////////////////////////////////////
                     //////////////// Initiate inner chords /////////////////////
                     //////////////////////////////////////////////////////////*/

                    var chords = svg.selectAll("path.chord")
                            .data(chord.chords)
                            .enter().append("svg:path")
                            .attr("class", "chord")
                            .style("stroke", function (d) {
                                return d3.rgb(fill(d.source.index)).darker();
                            })
                            .style("fill", function (d) {
                                return fill(d.source.index);
                            })
                            .attr("d", d3.svg.chord().radius(innerRadius))
                            .attr('opacity', 0);

                    /*//////////////////////////////////////////////////////////	
                     ///////////// Initiate Progress Bar ////////////////////////
                     //////////////////////////////////////////////////////////*/
                    /*Initiate variables for bar*/
                    var progressColor = ["#D1D1D1", "#949494"],
                            progressClass = ["prgsBehind", "prgsFront"],
                            prgsWidth = 0.4 * 650,
                            prgsHeight = 3;
                    /*Create SVG to visualize bar in*/
                    var progressBar = d3.select("#progress").append("svg")
                            .attr("width", prgsWidth)
                            .attr("height", 3 * prgsHeight);
                    /*Create two bars of which one has a width of zero*/
                    progressBar.selectAll("rect")
                            .data([prgsWidth, 0])
                            .enter()
                            .append("rect")
                            .attr("class", function (d, i) {
                                return progressClass[i];
                            })
                            .attr("x", 0)
                            .attr("y", 0)
                            .attr("width", function (d) {
                                return d;
                            })
                            .attr("height", prgsHeight)
                            .attr("fill", function (d, i) {
                                return progressColor[i];
                            });

                    /*//////////////////////////////////////////////////////////	
                     /////////// Initiate the Center Texts //////////////////////
                     //////////////////////////////////////////////////////////*/
                    /*Create wrapper for center text*/
                    var textCenter = svg.append("g")
                            .attr("class", "explanationWrapper");

                    /*//////////////////////////////////////////////////////////	
                     //Show Arc of Apple
                     //////////////////////////////////////////////////////////*/


                        /*Show and run the progressBar*/
                        runProgressBar(time = 700 * 2);

                        /*Initiate all arcs but only show the Apple arc (d.index = 0)*/
                        g.append("svg:path")
                                .style("stroke", function (d) {
                                    return fill(d.index);
                                })
                                .style("fill", function (d) {
                                    return fill(d.index);
                                })
                                //.style("stroke-width","5")
                                .transition().duration(700)
                                .attr("d", arc)
                                .attrTween("d", function (d) {
                                    if (d.index == 0) {
                                        var i = d3.interpolate(d.startAngle, d.endAngle);
                                        return function (t) {
                                            d.endAngle = i(t);
                                            return arc(d);
                                        }
                                    }
                                });

                        /*Show the tick around the Apple arc*/
                        d3.selectAll("g.group").selectAll("line")
                                .transition().delay(700).duration(1000)
                                .style("stroke", function (d, i, j) {
                                    return j ? 0 : "#000";
                                });

                        /*Add the labels for the %'s at Apple*/
                        d3.selectAll("g.group").selectAll(".tickLabels")
                                .transition().delay(700).duration(2000)
                                .attr("opacity", function (d, i, j) {
                                    return j ? 0 : 1;
                                });

                        /*Show the Apple name*/
                        d3.selectAll(".titles")
                                .transition().duration(2000)
                                .attr("opacity", function (d, i) {
                                    return d.index ? 0 : 1;
                                });


                    /*///////////////////////////////////////////////////////////  
                     //Draw the other arcs as well
                     //////////////////////////////////////////////////////////*/

                        var arcDelay = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
                        //var arcDelay = [0, 1, 2, 12, 13, 23, 33, 34, 35, 40, 47];
                        /*Show and run the progressBar*/
                        runProgressBar(time = 700 * (arcDelay[(arcDelay.length - 1)]));

                        /*Fill in the other arcs*/
                        svg.selectAll("g.group").select("path")
                                .transition().delay(function (d, i) {
                            return 700 * arcDelay[i];
                        }).duration(1000)
                                .attrTween("d", function (d) {
                                    if (d.index != 0) {
                                        var i = d3.interpolate(d.startAngle, d.endAngle);
                                        return function (t) {
                                            d.endAngle = i(t);
                                            return arc(d);
                                        }
                                    }
                                });

                        /*Make the other strokes black as well*/
                        svg.selectAll("g.group")
                                .transition().delay(function (d, i) {
                            return 700 * arcDelay[i];
                        }).duration(700)
                                .selectAll("g").selectAll("line").style("stroke", "#000");
                        /*Same for the %'s*/
                        svg.selectAll("g.group")
                                .transition().delay(function (d, i) {
                            return 700 * arcDelay[i];
                        }).duration(700)
                                .selectAll("g").selectAll("text").style("opacity", 1);
                        /*And the Names of each Arc*/
                        svg.selectAll("g.group")
                                .transition().delay(function (d, i) {
                            return 700 * arcDelay[i];
                        }).duration(700)
                                .selectAll("text").style("opacity", 1);



                },
                error: function () {
                    console.log("error in ajax form submission");
                }
            });
        }
    };
    
    acoes_visualizar_estatisticas.inicializa();
});