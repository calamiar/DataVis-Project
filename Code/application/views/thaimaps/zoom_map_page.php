<?php $this->load->view('default/header_css'); ?>
<!--bar chart's helper-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>

<!--pie chart's helper-->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

<!--Map chart helper-->
<!--<script src="https://code.highcharts.com/maps/highmaps.js"></script>-->
<script src="https://code.highcharts.com/maps/modules/map.js"></script>
<script src="https://code.highcharts.com/maps/modules/data.js"></script>
<script src="https://code.highcharts.com/maps/modules/data.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/offline-exporting.js"></script>

<!--For calling ajax-->
<script src="<?php echo base_url(); ?>stylesheet/js/ajax_jquery.min.js"></script>

</head>


<body>
    <style>
        #rmap-container {
            height: 700px; 
            min-width: 310px; 
            max-width: 800px; 
            margin: 0 auto; 
        }
        .loading {
            margin-top: 10em;
            text-align: center;
            color: gray;
        }
        /*Bar chart*/
        #pvt2-container {
            height: 350px; 
        }

        /*Pie chart*/
        #prop2-container {
            height: 350px; 
        }

        
    </style>
    <br>
    <div class="row">
        <div class="col-1"></div>
            <div class="col-11">
                <a href="<?php echo base_url() ?>index.php/Thaimaps"><button>Back</button></a>
            </div>
        
    </div>

    <div class="row">

        <div class="col-1"></div>
        <!--Contain region's map data-->
        <div class="col-4 container_w">
            <button type="button" onclick=drawBarchart(<?php echo json_encode($default_year) ?>,<?php echo $this->uri->segment(5); ?>,<?php echo json_encode($region_name) ?>);drawPiechart(<?php echo json_encode($default_waste_year) ?>,<?php echo $this->uri->segment(5); ?>,<?php echo json_encode($region_name) ?>);wastePerHead() >Reset</button>

            <div id="rmap-container"></div>
        </div>

        <div class="col-6">
            <!--upper row-->
            <div class="row">
                <div class="col-5 container_w"> 
                    <div id="pvt2-container"></div>
                </div>
                <div class="col-5 container_w">
                    <div id="prop2-container"></div>
                </div>
            </div>

            <!--lower row-->
            <div class="row">
                <div class="col-10 container_w" style="margin-left: 30px;">
                    <h4 style="color:#e3e5e2; font-size: 18px;">แหล่งข้อมูลอ้างอิง</h4><br>
                    <p style="color:#b5bec7; font-size: 12px;">1. กระทรวงการท่องเที่ยวเเละกีฬา</p>
                    <p style="color:#b5bec7; font-size: 12px;">2. สำนักงานสถิติแห่งชาติ</p>
                    <p style="color:#b5bec7; font-size: 12px;">3. สำนักงานสภาพัฒนาการเศรษฐกิจและสังคมแห่งชาติ</p>
                    <p style="color:#b5bec7; font-size: 12px;">4. กระทรวงทรัพยากรธรรมชาติและสิ่งเเวดล้อม</p>
                    <p style="color:#b5bec7; font-size: 12px;">5. กระทรวงมหาดไทย</p>
                    <p style="color:#b5bec7; font-size: 12px;">6. United Nations Office for the Coordination of Humanitarian Affairs(OCHA)</p>
                    <p style="color:#b5bec7; font-size: 12px;">7. สำนักงานราชบัณฑิตยสภา</p>
                    
                </div>
            </div>
        </div>

        <div class="col-1"></div>
    </div>


    <!--Place for Bar chart test-->

    <script type="text/javascript">
        var year = '<?php echo $year; ?>';
        var region_name = '<?php echo $region_name; ?>';
        $("#pvt2-container").before(drawBarchart(<?php echo json_encode($default_year) ?>, year, region_name));
        function drawBarchart(data_chart, year, province_name) {
            var data = data_chart;
            var year = year;
            Highcharts.chart('pvt2-container', {
                chart: {
                    type: 'column',
                    backgroundColor: 'rgba(0,0,0,0)'
                },
                title: {
                    style: {
                        color: "#a3abb8"
                    },
                    text: 'ปริมาณกลุ่มตัวอย่าง' + province_name
                },
                subtitle: {
                    text: 'จำนวนของประชากร และจำนวนนักท่องเที่ยวของ' + province_name + ' ในปี ' + year
                },
                xAxis: {
                    type: 'category',
                    labels: {
                        rotation: -45,
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Population'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.series.name + '</b><br/>' +
                                'Amount : ' + Highcharts.numberFormat(this.y, 0, '', ',');
                    }
                },
                series: [{
                        name: '',
                        data: data,
                        dataLabels: {
                            enabled: false,
                            rotation: -90,
                            color: '#FFFFFF',
                            align: 'right',
                            format: '{point.y:.1f}', // one decimal
                            y: 10, // 10 pixels down from the top
                            style: {
//                            fontSize: '13px',
//                            fontFamily: 'Verdana, sans-serif'

                            }
                        }
                    }]
            });
        }
    </script>

    <!--Pie chart code's-->
    <script>

        var year = '<?php echo $year; ?>';
        var region_name = '<?php echo $region_name; ?>';

        // Build the chart
        $("#prop2-container").before(drawPiechart(<?php echo json_encode($default_waste_year) ?>, year, region_name));

        function drawPiechart(data_pchart, year, province_name) {
            var data = data_pchart;
            var year = year;
            Highcharts.chart('prop2-container', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    backgroundColor: 'rgba(0,0,0,0)'
                },
                title: {
                    style: {
                        color: "#a3abb8"
                    },
                    text: 'สัดส่วนการก่อให้เกิดขยะของประชากรทั้ง 2 กลุ่ม ของ ' + province_name
                },
                subtitle: {
                    text: 'สัดส่วนการก่อให้เกิดปริมาณขยะใน 1 วันของ ทั้งสองกลุ่มตัวอย่าง ในปี ' + year
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                legend: {
                itemStyle: {
                    font: '9pt Trebuchet MS, Verdana, sans-serif',
                    color: '#777777'
                },
                itemHoverStyle: {
                    color: '#FFF'
                },
                itemHiddenStyle: {
                    color: '#444'
                }
            },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                        name: 'About',
                        colorByPoint: true,
                        data: data
                    }]
            });
        }
    </script>


    <script>
        //This is sendind data for test
        var data = <?php echo json_encode($test); ?>;
        var min_max_val = <?php echo json_encode($min_max_val); ?>;
        var geojson_name = '<?php echo $geojson_name; ?>';
        //var year = '<?php echo $year; ?>';

        //Highcharts.getJSON('https://cdn.jsdelivr.net/gh/highcharts/highcharts@v7.0.0/samples/data/germany.geo.json', function (geojson) {
        Highcharts.getJSON('<?php echo base_url() ?>stylesheet/mapdata/' + geojson_name + '.geojson', function (geojson) {

            // Initiate the chart
            Highcharts.mapChart('rmap-container', {
                chart: {
                    map: geojson,
                    backgroundColor: 'rgba(0,0,0,0)'
                },
                title: {
                    style: {
                        color: "#a3abb8"
                    },
                    text: 'ปริมาณนักท่องเที่ยวใน' + region_name + 'ปี ' + year
                },
                subtitle: {
                    text: 'จำนวนนักท่องเที่ยวทั้งหมดใน' + region_name + 'ของประเทศไทยในปี ' + year + ' กรุณาคลิกเลือกจังหวัดบนแผนที่เพื่อดูรายละเอียดเพิ่มเติม'
                },
                mapNavigation: {
                    enabled: true,
                    buttonOptions: {
                        verticalAlign: 'bottom'
                    }
                },
                colorAxis: {
                    //            tickPixelInterval: 100
                    min: min_max_val.min,
                    max: min_max_val.max,
                    minColor: '#f4f1e9',
                    maxColor: '#2b463c'

                },
                /* for click */
                plotOptions: {
                    series: {
                        point: {
                            events: {
                                /*load: function () {
                                 console.log('test_load');
                                 //drawBarchart(data,year);
                                 },*/
                                click: function () {
                                    load_region_data(year, this.properties.ADM1_PCODE, this.properties.ADM1_TH);
                                    load_regionw_data(year, this.properties.ADM1_PCODE, this.properties.ADM1_TH);
                                    load_regionwh_data(year, this.properties.ADM1_PCODE, this.properties.ADM1_TH);
                                }
                                /*
                                 function load_region_data(year)
                                 $.ajax({
                                 url: "Assign4/fetch_data",
                                 method: "POST",
                                 data: {'year': year},
                                 dataType: "JSON",
                                 success: function (data)
                                 {
                                 console.log(data);
                                 
                                 }
                                 });
                                 //}
                                 */
                            }
                        }
                    }
                },
                series: [{
                        data: data,
                        keys: ['ADM1_PCODE', 'value'],
                        joinBy: 'ADM1_PCODE',
                        name: 'ปริมาณนักท่องเที่ยว',
                        states: {
                            hover: {
                                color: '#a4edba'
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            //                                                    format: '{point.properties.protal}'
                            format: '{point.properties.ADM1_TH}'
                        }
                    }]
            });
        });
        //Ajax for barchart
        function load_region_data(year, province, province_name)
        {
            console.log(year);
            console.log(province);
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/Thaimaps/province_data",
                method: "POST",
                data: {
                    year: year,
                    province: province
                },
                dataType: "JSON",
                success: function (data)
                {

                    console.log(data);
                    drawBarchart(data, year, province_name);
                },
                error: function () {
                    alert('error');
                }
            });
        }
        ;

        //Ajax for Piechart
        function load_regionw_data(year, province, province_name)
        {
            console.log(year);
            console.log(province);
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/Thaimaps/province_waste_data",
                method: "POST",
                data: {
                    year: year,
                    province: province
                },
                dataType: "JSON",
                success: function (data)
                {
                    console.log(data);
                    drawPiechart(data, year, province_name);
                },
                error: function () {
                    alert('error');
                }
            });
        }
        ;


    </script>


</body>

<footer>
</footer>

</html>