@extends('home')

@section('content_right_block')
   <div class="row">
       <div class="graphs-content">

       <div class="graph-filter row">
           <h4>Количество обслуживаний</h4>
           <div class="col-md-12">
               <div class="col-md-3">
                   {{ Form::select('factory', $users, null, ["class" => "form-control", "id" => "enterprise"]) }}
               </div>
               <div class="col-md-2" style="width: 100px">
                   <select id="day" name="day" style="width:auto;" class="form-control selectWidth">
                       <option value="0">День</option>
                       @for ($i = 1; $i <= 31; $i++)
                           <option value="@if($i < 10)0{{$i}}@else{{$i}}@endif" class="">{{$i}}</option>
                       @endfor
                   </select>
               </div>
               <div class="col-md-2" style="width: 100px">

                   <select id="month" name="month" style="width:auto;" class="form-control selectWidth">
                       <option value="0">Месяц</option>
                       @for ($i = 1; $i <= 12; $i++)
                           <option value="@if($i < 10)0{{$i}}@else{{$i}}@endif" class="">{{$i}}</option>
                       @endfor
                   </select>
               </div>
               <div class="col-md-2" style="width: 120px">
                   {!! Form::selectRange('year', 1900, date("Y"), date("Y"), ["class" => 'form-control', 'id' => 'year']) !!}
               </div>
               <div class="col-md-3">
                   <a href="#" class="btn btn-default" onclick="loadGraphFactory();">Применить</a>
               </div>
           </div>
       </div>

       <div class="col-md-12">
           <!-- Styles -->
           <style>
               #chartdiv {
                   width		: 100%;
                   height		: 500px;
                   font-size	: 11px;
               }
           </style>

           <!-- Resources -->
           <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
           <script src="https://www.amcharts.com/lib/3/serial.js"></script>
           <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
           <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
           <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

           <!-- Chart code -->
           <script>
               var chart = AmCharts.makeChart( "chartdiv", {
                   "type": "serial",
                   "theme": "light",
                   "dataProvider": [ {
                       "country": "USA",
                       "visits": 2025
                   }, {
                       "country": "China",
                       "visits": 1882
                   }, {
                       "country": "Japan",
                       "visits": 1809
                   }, {
                       "country": "Germany",
                       "visits": 1322
                   }, {
                       "country": "UK",
                       "visits": 1122
                   }, {
                       "country": "France",
                       "visits": 1114
                   }, {
                       "country": "India",
                       "visits": 984
                   }, {
                       "country": "Spain",
                       "visits": 711
                   }, {
                       "country": "Netherlands",
                       "visits": 665
                   }, {
                       "country": "Russia",
                       "visits": 580
                   }, {
                       "country": "South Korea",
                       "visits": 443
                   }, {
                       "country": "Canada",
                       "visits": 441
                   }, {
                       "country": "Brazil",
                       "visits": 395
                   } ],
                   "valueAxes": [ {
                       "gridColor": "#FFFFFF",
                       "gridAlpha": 0.2,
                       "dashLength": 0
                   } ],
                   "gridAboveGraphs": true,
                   "startDuration": 1,
                   "graphs": [ {
                       "balloonText": "[[category]]: <b>[[value]]</b>",
                       "fillAlphas": 0.8,
                       "lineAlpha": 0.2,
                       "type": "column",
                       "valueField": "visits"
                   } ],
                   "chartCursor": {
                       "categoryBalloonEnabled": false,
                       "cursorAlpha": 0,
                       "zoomable": false
                   },
                   "categoryField": "country",
                   "categoryAxis": {
                       "gridPosition": "start",
                       "gridAlpha": 0,
                       "tickPosition": "start",
                       "tickLength": 20
                   },
                   "export": {
                       "enabled": true
                   }

               } );
           </script>

           <!-- HTML -->
           <div id="chartdiv"></div>
       </div>
       <div class="col-md-12">
           <!-- Chart code -->
           <script>
               var chart = AmCharts.makeChart("chartdiv2", {
                   "type": "serial",
                   "theme": "light",
                   "legend": {
                       "horizontalGap": 10,
                       "maxColumns": 1,
                       "position": "right",
                       "useGraphSettings": true,
                       "markerSize": 10
                   },
                   "dataProvider": [{
                       "year": 2003,
                       "europe": 2.5,
                       "namerica": 2.5,
                       "asia": 2.1,
                       "lamerica": 0.3,
                       "meast": 0.2,
                       "africa": 0.1
                   }, {
                       "year": 2004,
                       "europe": 2.6,
                       "namerica": 2.7,
                       "asia": 2.2,
                       "lamerica": 0.3,
                       "meast": 0.3,
                       "africa": 0.1
                   }, {
                       "year": 2005,
                       "europe": 2.8,
                       "namerica": 2.9,
                       "asia": 2.4,
                       "lamerica": 0.3,
                       "meast": 0.3,
                       "africa": 0.1
                   }],
                   "valueAxes": [{
                       "stackType": "regular",
                       "axisAlpha": 0.3,
                       "gridAlpha": 0
                   }],
                   "graphs": [{
                       "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                       "fillAlphas": 0.8,
                       "labelText": "[[value]]",
                       "lineAlpha": 0.3,
                       "title": "Europe",
                       "type": "column",
                       "color": "#000000",
                       "valueField": "europe"
                   }, {
                       "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                       "fillAlphas": 0.8,
                       "labelText": "[[value]]",
                       "lineAlpha": 0.3,
                       "title": "North America",
                       "type": "column",
                       "color": "#000000",
                       "valueField": "namerica"
                   }, {
                       "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                       "fillAlphas": 0.8,
                       "labelText": "[[value]]",
                       "lineAlpha": 0.3,
                       "title": "Asia-Pacific",
                       "type": "column",
                       "color": "#000000",
                       "valueField": "asia"
                   }, {
                       "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                       "fillAlphas": 0.8,
                       "labelText": "[[value]]",
                       "lineAlpha": 0.3,
                       "title": "Latin America",
                       "type": "column",
                       "color": "#000000",
                       "valueField": "lamerica"
                   }, {
                       "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                       "fillAlphas": 0.8,
                       "labelText": "[[value]]",
                       "lineAlpha": 0.3,
                       "title": "Middle-East",
                       "type": "column",
                       "color": "#000000",
                       "valueField": "meast"
                   }, {
                       "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
                       "fillAlphas": 0.8,
                       "labelText": "[[value]]",
                       "lineAlpha": 0.3,
                       "title": "Africa",
                       "type": "column",
                       "color": "#000000",
                       "valueField": "africa"
                   }],
                   "categoryField": "year",
                   "categoryAxis": {
                       "gridPosition": "start",
                       "axisAlpha": 0,
                       "gridAlpha": 0,
                       "position": "left"
                   },
                   "export": {
                       "enabled": true
                   }

               });
           </script>

           <!-- HTML -->
           <div id="chartdiv2"></div>
       </div>
       </div>
   </div>
@endsection