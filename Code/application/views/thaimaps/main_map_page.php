<?php $this->load->view('default/header_css'); ?>

<!--bar chart's helper-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>

<!--pie chart's helper-->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<!--<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>-->

<!--Map helper-->
<!--<script src="https://code.highcharts.com/maps/highmaps.js"></script>-->
<script src="https://code.highcharts.com/maps/modules/map.js"></script>
<script src="https://code.highcharts.com/maps/modules/data.js"></script>
<script src="https://code.highcharts.com/maps/modules/data.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/offline-exporting.js"></script>



</head>


<body>
    <style>

        #chartdiv {
            width: 100%;
            height: 200px;
        }

        #map-container {
            height: 650px; 
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
        #pvt-container {
            height: 350px; 
        }

        /*Pie chart*/
        #prop-container {
            height: 350px; 
        }

        /* stack bar chart */
        #stack_container {
            height: 350px;
        }
        
        .toright {
            margin-left: 30px;
        }


    </style>

    <div class="row">
        <div class="col-1"></div>

        <div class="col-11">

            <br>
            <h2 style="color:#fff;">Dashboard</h2>

            <br>
        </div>

    </div>
    <div class="row">
        <div class="col-1"></div>

        <div class="col-3 container_w">
            <h4 style="color:#e3e5e2; font-size: 18px;">ปัญหาขยะมูลฝอยในประเทศไทย</h4><br>
            <p style="color:#b5bec7; font-size: 12px;">ปัจจุบันประเทศไทยประสบปัญหาขยะตกค้างในประเทศเป็นจำนวนมาก และในแต่ละปีมีขยะมูลฝอยที่เกิดเกิดใหม่มีจำนวนเพิ่มขึ้นอย่างต่อเนื่อง โดยสาเหตุมาจากประชากรและนักท่องเที่ยว </p>
            <p style="color:#b5bec7; font-size: 12px;">แม้ว่าจำนวนนักท่องเที่ยวจะมีจำนวนเพิ่มมากขึ้นอย่างรวดเร็ว แต่จากการวิเคราะห์พบว่าสาเหตุหลักของขยะมูลฝอยยังคงมาจากประชากรในประเทศกว่าร้อยละ 95 และมาจากนักท่องเที่ยวไม่ถึงร้อยละ 5 ยกเว้นจังหวัดที่มีการท่องเที่ยวเป็นเศรษฐกิจหลัก เช่น ภูเก็ต กรุงเทพมหานคร ชลบุรี กระบี่ เป็นต้น ที่มีขยะจากนักท่องเที่ยวประมาณร้อยละ 10</p>
            <p style="color:#b5bec7; font-size: 12px;">นอกจากนี้จากการคาดการณ์พบว่าปริมาณขยะในประเทศไทยยังคงเพิ่มขึ้นอย่างต่อเนื่อง และสาเหตุหลักยังคงมาจากประชากรในประเทศ ดังนั้นการรณรงค์ หรือนโยบายด้านการจัดการขยะจึงต้องเน้นไปที่ประชากรในประเทศเป็นหลัก</p>
        </div>

        <div class="col-6 container_w toright">
            <div id="stack_container"></div>

        </div>
        <div class="col-1"></div>

    </div>

    <div class="row">
        <div class="col-1"></div>

        <!--This is Thailand's map and Dropdown Part-->
        <div class="col-4 container_w">
            <?php
            $attr = array("name" => "select year", "method" => "get");
            echo form_open("Thaimaps", $attr);
            echo form_dropdown('year', $year_list, $year);
            echo form_submit('submit_year', 'Submit');
            echo form_close();
            ?>

            <!--This line is only for map,Please don't touch it!-->   
            <br>
            <div id="map-container"> </div>
        </div>

        <!--This is additional graph-->
        <div class="col-6">
            <!--upper row-->
            <div class="row">
                <div class="col-5 container_w">

                    <!--This col show amount of population and amount of tourist in bar chart-->
                    <div id="pvt-container"></div>


                </div>
                <div class="col-5 container_w">
                    <div id="prop-container"></div>
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
        var data = <?php echo json_encode($people_per_year); ?>;
        var year = <?php echo $year; ?>;
        Highcharts.chart('pvt-container', {
            chart: {
                type: 'column',
                backgroundColor: 'rgba(0,0,0,0)'
            },
            title: {
                style: {
                    color: "#a3abb8"
                },
                text: 'ปริมาณกลุ่มตัวอย่างที่ทำการสำรวจ ในปี ' + year
            },
            subtitle: {
                text: 'จำนวนของประชากรทั้งหมดในประเทศไทย และจำนวนนักท่องเที่ยว'
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif',

                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            legend: {
                enabled: false
            },
//            tooltip: {
//                pointFormat: 'Amount : <b>{point.y:.1f}</b> <br>{point.y:,.0f} <br>{point.y:,.2f}'
//            },
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
    </script>

    <!--Stack bar chart Forecast-->
    <script>
        Highcharts.chart('stack_container', {
            chart: {
                type: 'column',
                backgroundColor: 'rgba(0,0,0,0)'
            },
            title: {
                style: {
                    color: "#a3abb8"
                },
                text: 'คาดการณ์ปริมาณขยะมูลฝอย'
            },
            xAxis: {
                categories: ['2556', '2557', '2558', '2559', '2560', '2561', '2562', '2563', '2564', '2565', '2566']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'ปริมาณขยะ (แสนตัน/ปี)'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (// theme
                                Highcharts.defaultOptions.title.style &&
                                Highcharts.defaultOptions.title.style.color
                                ) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -30,
                verticalAlign: 'top',
                y: 25,
                floating: true,
                backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [
                {
                    name: 'ขยะผู้มาเยือน',
                    data: [5.86, 5.79, 6.37, 6.94, 7.48, 7.86, 8.26, 8.83, 9.44, 10.07, 10.74]
                },
                {
                    name: 'ขยะประชากร',
                    data: [261.88, 256.20, 262.17, 263.64, 266.26, 271.47, 274.39, 277.20, 280.06, 282.95, 285.87]
                }]
        });
    </script>

    <!--Pie chart code's-->
    <script>
        var data = <?php echo json_encode($ppl_waste_year); ?>;
        var year = <?php echo $year; ?>;
        // Build the chart
        Highcharts.chart('prop-container', {
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
                text: 'สัดส่วนการก่อให้เกิดขยะของประชากรทั้ง 2 กลุ่ม ในปี ' + year
            },
            subtitle: {
                text: 'สัดส่วนการก่อให้เกิดปริมาณขยะใน 1 วันของ ทั้งสองกลุ่มตัวอย่าง'
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
    </script>


    <!--Thailand map code-->
    <script>
        // Prepare random data
        //var data = [
        //    ['DE.SH', 728],
        //    ['DE.BE', 710],
        //    ['DE.MV', 963],
        //    ['DE.HB', 541],
        //    ['DE.HH', 622],
        //    ['DE.RP', 866],
        //    ['DE.SL', 398],
        //    ['DE.BY', 785],
        //    ['DE.SN', 223],
        //    ['DE.ST', 605],
        //    ['DE.NW', 237],
        //    ['DE.BW', 157],
        //    ['DE.HE', 134],
        //    ['DE.NI', 136],
        //    ['DE.TH', 704],
        //    ['DE.', 361]
        //];

        //This is sendind data for test
        var data = <?php echo json_encode($test); ?>;
        var min_max_val = <?php echo json_encode($min_max_val); ?>;
        var year = <?php echo $year; ?>;

        Highcharts.getJSON('<?php echo base_url() ?>stylesheet/mapdata/Merge.geojson', function (geojson) {

            // Initiate the chart
            Highcharts.mapChart('map-container', {
                chart: {
                    map: geojson,
                    backgroundColor: 'rgba(0,0,0,0)'

                },
                title: {
                    style: {
                        color: "#a3abb8"
                    },
                    text: 'ปริมาณนักท่องเที่ยวในปี ' + year
                },
                subtitle: {
                    text: 'จำนวนนักท่องเที่ยวทั้งหมดของประเทศไทยในปี ' + year + ' จำแนกโดยระดับภูมิภาค (หน่วย;คนครั้ง) กรุณาคลิกเลือกภูมิภาคบนแผนที่เพื่อดูรายละเอียดเพิ่มเติม'
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
                                click: function () {
                                    //alert(this.properties.ADM1_TH);
                                    //url = 'https://www.google.com';
                                    url = '<?php base_url(); ?>Thaimaps/zoomTourist/' + this.properties.ADM1_PCODE + '/' + this.properties.ADM1_EN + '/' + year;
                                    window.location.href = url;
                                }
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

    </script>



</body>

<footer>
</footer>

</html>
