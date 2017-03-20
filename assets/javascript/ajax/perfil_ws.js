$(document).ready(function() {

    var acoes_perfil = {
       inicializa : function() {
            acoes_perfil.mascaras();
           acoes_perfil.dropdown_nivel();
           acoes_perfil.dropdown_idioma();
           acoes_perfil.navegacao_form();
           acoes_perfil.formatacao_checkbox();
           acoes_perfil.grafico_pontuacao();
           acoes_perfil.grafico_submissoes_por_linguagem();
           acoes_perfil.grafico_submissoes_por_resposta();
           acoes_perfil.grafico_submissoes_por_categoria();
           acoes_perfil.grafico_qtd_submissoes();
           acoes_perfil.grafico_nivel();
       },
       mascaras : function() {
           $(".telefone").inputmask({mask: "99 9999-9999", greedy: false});
       },
       dropdown_nivel : function(){
            if($('#nivel').length) {
                //* slider with select
                var max = $( "input[name='qtd_niveis']" ).val();
                var select = $( "#nivel" );
                var slider = $( "<div id='ui_slider3'></div>" ).insertAfter( select ).slider({
                    min: 1,
                    max: max,
                    range: "min",
                    value: select[ 0 ].selectedIndex + 1,
                    slide: function( event, ui ) {
                        select[ 0 ].selectedIndex = ui.value - 1;
                    }
                });
                $( "#nivel" ).change(function() {
                    slider.slider( "value", this.selectedIndex + 1 );
                });
            }
       },
       dropdown_idioma: function() {
           $( ".idioma_item" ).on( "click", function() {
                var key = $(this).data("key");
                var item_html = $(this).html() + '<b class="caret"></b>';
                $( "#com_idioma" ).val(key);
                $( "#idioma_selecionado" ).html(item_html);
            });
       },
       navegacao_form: function(){
            if($('.btn-tab').length){
                $('.btn-tab').click(function (e) {
                    e.preventDefault();
                    var valido = $("#form_estilo_aprendizagem").valid();
                    
                    if(valido) {
                        
                        if($(this).attr('id') == 'btn-concluir'){
                            acoes_perfil.enviar_form();
                        }
                        $('#form_estilo_aprendizagem li.active').removeClass('active');
                        var href = $(this).attr('href');
                        $('a[href="' + href + '"]').closest('li').addClass('active');
                        $(this).tab('show');
                    }
                });  
            }        
       },
       formatacao_checkbox: function(){
            if($('.icheck').length){
               $(document).find('.icheck').each(function() {
                   var cor = $(this).data('icheck-color');

                   $(this).iCheck({
                        checkboxClass: 'icheckbox_square-' + cor,
                        radioClass: 'iradio_square-' + cor,
                        increaseArea: '20%' // optional
                    }); 
                });
            }
       },
       enviar_form : function(){
            var url = $('#form_estilo_aprendizagem').attr('action');
            var formData = $('#form_estilo_aprendizagem').serialize();
            
            $.ajax({
                 url: url,
                 type: 'POST',
                 dataType: 'json',
                 data: formData,
                 success: function (dados) {
                     
                     $('#panel-resultado').html('');
                     
                     for(var indice in dados) {
                         
                         var divRow = document.createElement('div');
                         divRow.className = 'row';
                         
                         for(var j in dados[indice]) {

                            var classe1,classe2;
                            if(j % 2 == 0){
                                classe1 = ' bs-callout-info';
                                classe2 = ' text-primary';
                            }
                            else {
                                classe1 = ' bs-callout-danger';
                                classe2 = ' text-danger';
                            }

                            var divCol1 = document.createElement('div');
                            divCol1.className = 'col-md-6';

                            var divCallout1 = document.createElement('div');
                            divCallout1.className = 'bs-callout' + classe1;

                            var divLinha1 = document.createElement('div');
                            divLinha1.className = 'row';

                            var divColuna1 = document.createElement('div');
                            divColuna1.className = 'col-md-8';

                            var titulo1 = document.createElement('h4');
                            titulo1.innerHTML = dados[indice][j].nome;
                            divColuna1.appendChild(titulo1);

                            var descricao1 = document.createElement('p');
                            descricao1.innerHTML = dados[indice][j].descricao;
                            divColuna1.appendChild(descricao1);

                            divLinha1.appendChild(divColuna1);

                            var divColuna2 = document.createElement('div');
                            divColuna2.className = 'col-md-4';
                            divColuna2.style = 'padding: 0px;';

                            var divGrafico = document.createElement('div');
                            divGrafico.className = 'row grafico-pontuacao';
                            divGrafico.setAttribute('data-pontuacao', dados[indice][j].pontuacao/11);

                            divColuna2.appendChild(divGrafico);

                            var divPontuacao = document.createElement('div');
                            divPontuacao.className = 'row';

                            var pontuacao = document.createElement('p');
                            pontuacao.className = 'text-center' + classe2;
                            pontuacao.innerHTML = dados[indice][j].pontuacao + ' ' + dados[indice][j].ponto;

                            divPontuacao.appendChild(pontuacao);

                            divColuna2.appendChild(divPontuacao);

                            divLinha1.appendChild(divColuna2);

                            divCallout1.appendChild(divLinha1);

                            divCol1.appendChild(divCallout1);

                            divRow.appendChild(divCol1);

                         }
                         
                         $('#panel-resultado').append(divRow);
                    }
                    
                    acoes_perfil.grafico_pontuacao();
            },
            error: function(){
                console.log("error in ajax form submission");
            }
        });
       },
       grafico_pontuacao : function(){
            if($('.grafico-pontuacao').length) {

                var foreground = [], text = [], arc = [], svg = [], meter = [], pontuacao = [], progress = [];

                var width = 150,
                    height = 150,
                    twoPi = 2 * Math.PI,
                    total = 100,
                    formatPercent = d3.format(".0%");

                $('.grafico-pontuacao').each(function(indice, val) {

                    progress[indice] = 0;

                    pontuacao[indice] = parseFloat($(this).data('pontuacao'));

                    var cor = $(this).closest('.bs-callout').css('border-left-color');

                    arc[indice] = d3.svg.arc()
                        .startAngle(0)
                        .innerRadius(40)
                        .outerRadius(55)
                    ;

                    svg[indice] = d3.select(this).append("svg")
                        .attr("width", width)
                        .attr("height", height)
                        .attr('fill', cor)
                        .append("g")
                        .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

                    meter[indice] = svg[indice].append("g")
                        .attr("class", "progress-meter")
                        .attr('fill', cor);

                    meter[indice].append("path")
                        .attr("class", "background")
                        .attr("d", arc[indice].endAngle(twoPi));

                    foreground[indice] = meter[indice].append("path")
                        .attr("class", "foreground");

                    text[indice] = meter[indice].append("text")
                        .attr("text-anchor", "middle")
                        .attr("y", 10);

                    foreground[indice].attr("d", arc[indice].endAngle(twoPi * pontuacao[indice]));
                    text[indice].text(formatPercent(pontuacao[indice]));

        //            setTimeout(function(){
        //                
        //                var i = d3.interpolate(progress[indice], pontuacao[indice]);
        //
        //                d3.transition().duration(1200).tween("progress", function () {
        //                    return function (t) {
        //                        progress[indice] = i(t);
        //                        foreground[indice].attr("d", arc[indice].endAngle(twoPi * progress[indice]));
        //                        text[indice].text(formatPercent(progress[indice]));
        //                    };
        //                });
        //                
        //            }, 500);

                });
            }
       },
       grafico_submissoes_por_linguagem: function(){
           var url = $('#base_url').val() + 'ws/ajax/grafico_submissoes_competidor_por_linguagem';
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {},
                success: function (dados) {

                    //Width and height
                    var w = '250';//$("#grafico_submissoes_competidor_por_linguagem").width();
                    var h = w;
                    var barPadding = 1;
                    var dataset = dados.valores;
                    
                    var svg = d3.select("#grafico_submissoes_competidor_por_linguagem")
                    .append("svg")
                    .attr("width", w)
                    .attr("height", h);

                    svg.selectAll("rect")
                    .data(dataset)
                    .enter()
                    .append("rect")
                    .attr("x", function(d, i) {
                        return i * (w / dataset.length);
                    })
                    .attr("y", function(d) {
                        return h - (d * 4);
                    })
                    .attr("width", w / dataset.length - barPadding)
                    .attr("height", function(d) {
                        return d * 4;
                    })
                    .attr("fill", function(d) {
                        var cores = ['rgb(105,180,10)','rgb(0,204,204)','rgb(204,0,102)','rgb(255,178,102)'];
                        return cores[d%4];
                    });

                    svg.selectAll("text")
                    .data(dataset)
                    .enter()
                    .append("text")
                    .text(function(d,i) {
                        return dados.labels[i] + ' - ' + dados.valores[i] + ' questões';
                    })
                    .attr("x", function(d, i) {
                        return i * (w / dataset.length) + 5;
                    })
                    .attr("y", function(d) {
                        return h-d-15;//h - (d * 4) + 15;
                    })
                    .attr("font-family", "sans-serif")
                    .attr("font-size", "11px")
                    .attr("fill", "#000");

                },
                error: function () {
                    console.log("error in ajax form submission");
                }
            });
       },
       grafico_submissoes_por_resposta: function() {
            var url = $('#base_url').val() + 'ws/ajax/grafico_submissoes_competidor_por_resposta';
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {},
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
                    width = '250',//$("#chart").width() - margin.left - margin.right,
                            height = width - margin.top - margin.bottom,
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
        },
       grafico_submissoes_por_categoria: function(){
           var url = $('#base_url').val() + 'ws/ajax/grafico_submissoes_competidor_por_categoria';
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {},
                success: function (dados) {
                    
                    var width = 250,
                        height = 250,
                        radius = Math.min(width, height) / 2;

                    var color = d3.scale.ordinal()
                        .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

                    var arc = d3.svg.arc()
                        .outerRadius(radius - 10)
                        .innerRadius(radius - 70);

                    var pie = d3.layout.pie()
                        .sort(null);

                    var svg = d3.select("#grafico_submissoes_competidor_por_categoria").append("svg")
                        .attr("width", width)
                        .attr("height", height)
                      .append("g")
                        .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

                      var g = svg.selectAll(".arc")
                          .data(pie(dados.valores))
                        .enter().append("g")
                          .attr("class", "arc");

                      g.append("path")
                          .attr("d", arc)
                          .style("fill", function(d,i) { return color(dados.labels[i]); });

                      g.append("text")
                          .attr("transform", function(d) { 
                              var coordenadas = arc.centroid(d);
                              coordenadas[0] -= 20;
                              return "translate(" + coordenadas + ")"; 
                          })
                          .attr("dy", ".35em")
                          .attr("fill","#DCDCDC")
                          .text(function(d,i) { return dados.labels[i]; });
                  
                    g.append("text")
                          .attr("transform", function(d) { 
                              var coordenadas  = (arc.centroid(d));
                              coordenadas[0] -= 20;
                              coordenadas[1] += 15;
                              return "translate(" + coordenadas + ")"; 
                          })
                          .attr("dy", ".35em")
                          .attr("fill","#DCDCDC")
                          .text(function(d,i) { return dados.valores[i] + ((dados.valores[i] != 1) ? ' questões' : ' questão'); });

                },
                error: function () {
                    console.log("error in ajax form submission");
                }
            });
       },
       grafico_qtd_submissoes: function(){
           var url = $('#base_url').val() + 'ws/ajax/grafico_submissoes_competidor_por_data';
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {},
                success: function (dados) {
                 
                 // Parse the date / time
                    var parseDate = d3.time.format("%d-%m-%Y").parse;
                 
                 // Get the data
                    var data = [];
                    for(var i =0 ; i< dados.valores.length;i++) {
                        var d = {};
                        d.date = parseDate(dados.labels[i]);
                        d.close = parseInt(dados.valores[i]) + ((i > 0) ? data[i-1].close : 0);
                        data.push(d);
                    }
                 
                    // Set the dimensions of the canvas / graph
                    var margin = {top: 30, right: 20, bottom: 30, left: 50},
                        width = 300 - margin.left - margin.right,
                        height = 250 - margin.top - margin.bottom;

                    // Set the ranges
                    var x = d3.time.scale().range([0, width]);
                    var y = d3.scale.linear().range([height, 0]);

                    // Define the axes
                    var xAxis = d3.svg.axis().scale(x)
                        .orient("bottom").ticks(5)
                        .tickFormat(d3.time.format("%d-%m-%Y"));

                    var yAxis = d3.svg.axis().scale(y)
                        .orient("left").ticks(5);

                    // Define the line
                    var valueline = d3.svg.line()
                        .x(function(d) { return x(d.date); })
                        .y(function(d) { return y(d.close); });

                    // Adds the svg canvas
                    var svg = d3.select("#grafico_qtd_submissoes")
                        .append("svg")
                            .attr("width", width + margin.left + margin.right)
                            .attr("height", height + margin.top + margin.bottom)
                        .append("g")
                            .attr("transform", 
                                  "translate(" + margin.left + "," + margin.top + ")");

                        // Scale the range of the data
                        x.domain(d3.extent(data, function(d) { return d.date; }));
                        y.domain([0, d3.max(data, function(d) { return d.close; })]);

                        // Add the valueline path.
                        svg.append("path")
                            .attr("class", "line")
                            .attr('fill','rgb(105, 180, 15)')
                            .attr("d", valueline(data));

                        // Add the X Axis
                        svg.append("g")
                            .attr("class", "x axis")
                            .attr("transform", "translate(0," + height + ")")
                            .style({ 'stroke': 'Black', 'fill': 'none', 'stroke-width': '1px'})
                            .call(xAxis)
                            .selectAll("text")
                            .style({'font-size': '8px', 'stroke-width': '0.5px'});

                        // Add the Y Axis
                        svg.append("g")
                            .attr("class", "y axis")
                            .style({ 'stroke': 'Black', 'fill': 'none', 'stroke-width': '1px'})
                            .call(yAxis)
                            .selectAll("text")
                            .style({'font-size': '10px', 'stroke-width': '0.5px'});

                }
            });
       },
       grafico_nivel: function(){
           if($(".bar").length){
                $(".bar").peity("bar", { fill: function(value,i,all) { return ((value > this.$el.attr('data-nivel')) ? "#F8F8FF" : "magenta")},"delimiter" : "," });
            }   
       }
    };
    
    acoes_perfil.inicializa();
});
