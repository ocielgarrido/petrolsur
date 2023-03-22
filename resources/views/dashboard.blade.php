<x-app-layout>
    <x-slot name="header_content">
        <h2>Tablero de Control</h2>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Layout</a></div>
            <div class="breadcrumb-item">Default Layout</div>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="container-md border-top border-3 mt-3 pt-3">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h3 class="text-primary w-50">Produccíon oil día mensual</h3>
                    
                    <div id="container_oil_mensual"></div>
                </div>                                
                <div class="col-md-6 mb-3">
                    <h3 class="text-primary">Produccíon oil x mes </h3>
                    <div id="container_oil_anio"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h3 class="text-primary">Produccíon Gas mensual </h3>
                    <div>
                        
                    </div>
                </div>
                                    
                <div class="col-md-6 mb-3">
                    <h3 class="text-primary">Produccíon Gas x mes </h3>
                   
                </div>
                
            </div>
            
        </div>
    </div>

    <script type="text/javascript">
       var graficoOilAnio ='';
        Highcharts.chart('container_oil_anio', {
            title: {
                text: 'Meses'
            },
        //     subtitle: {
        //    //     text: 'Source: positronx.io'
        //     },
            xAxis: {
                categories: ['Ene', 'Feb', 'Maz', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep','Oct', 'Nov', 'Dic']
            },
            yAxis: {
                title: {
                    text: 'Produción Petróleo'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true
                }
            },
            series: [{
                name: 'New Users',
             //   data: userData
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });
    </script>
    
</x-app-layout>
