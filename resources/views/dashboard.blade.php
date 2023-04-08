<x-app-layout>
    <x-slot name="header_content">
        <h2>Tablero de Control</h2>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Layout</a></div>
            <div class="breadcrumb-item">Graficas</div>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg padre">
        <br>
        <h3 class="text-center">TABLERO CONTROL GERENCIAL</h3>           

            <div class="row" >                
                <div class="col-md-6 mb-3">                    
                    <div class="grafica">
                        <canvas id="oild"></canvas>
                    </div>
                </div>                
                <div class="col-md-6 mb-3">                    
                    <div class="grafica">
                        <canvas id="gasM" ></canvas>
                    </div>
                </div>                
            </div>


        
        <br><br>
    </div>


  @push('styles')
    <style>
     .padre{
      width:100% !important;
      height:100% !important;
      max-width: 100% !important;
      background:white !important;  
      display: flex;
      flex-direction: column;
      padding: 10px !important;
      border:10px !important;
      border-radius: 20px !important;
      border-color:  #284094 !important;
      border-width:5px !important;
      border-style:solid !important;
    }
    .grafica{
      border-color:  #ff0000 !important;
      border-width:2px !important;
      border-style:solid !important;
      border-radius: 10px !important;
      max-height: 300px !important;
    }
    .grafica12{
      border-color:  #ff0000 !important;
      border-width:2px !important;
      border-style:solid !important;
      border-radius: 10px !important;
      width:100% !important;
      height:300px !important;
      max-height: 300px !important;
    
    }
    </style>
    
@endpush
 
 
@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.1.1/dist/chart.umd.min.js"></script>
<script>

 var valores=[];
 var rgbValues = [];
 var meses=[];


    document.addEventListener('DOMContentLoaded', function(){

        const generateRandomColor = () => {
                const r = Math.floor(Math.random() * 256);
                const g = Math.floor(Math.random() * 256);
                const b = Math.floor(Math.random() * 256);

                const rbgColor = `rgb(${r},${g},${b})`;
                return rbgColor;
        };

            //Grafico Produccion Oil Mensual
            $.ajax({
                url: '{{url("/produccion-oil-mensual/")}}',
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": 1
                },            
                success: function (res) { 
                var arreglo=JSON.parse(res);   
                meses=[];
                valores=[];            
          
                for (var x=0; x<arreglo.length;x++){
                    meses.push(arreglo[x].meses);
                    valores.push(arreglo[x].oil);
                    
                }  
                for (i = 0; i < valores.length; i++) {
                    rgbValues[i]=generateRandomColor();             
                };         
                oilMensual();        
    
                }           
            })
            //Grafico Produccion Gas Mensual
            $.ajax({
                url: '{{url("/produccion-gas-mensual/")}}',
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": 1
                },            
                success: function (res) { 
                var arreglo=JSON.parse(res); 
                meses=[];
                valores=[];            
                for (var x=0; x<arreglo.length;x++){
                    meses.push(arreglo[x].meses);
                    valores.push(arreglo[x].gas);
                    
                }    
                for (i = 0; i < valores.length; i++) {
                    rgbValues[i]=generateRandomColor();             
                };       
                gasMensual();        
    
                }           
            })


            function oilMensual(){
                const data = {
                labels: meses,
                datasets: [{
                    label: 'Producción Mensual de Oil Deshidratado',
                    backgroundColor: rgbValues,
                    borderColor:  rgbValues,
                    data: valores,
                }]
                };
    
                const config = {
                    type: 'bar',
                    data: data,
                    options: {}
                };
            
                const myChart = new Chart(
                    document.getElementById('oild'),
                    config
                );


            } 

            function gasMensual(){
                const data = {
                labels: meses,
                datasets: [{
                    label: 'Producción Mensual de Gas',
                    backgroundColor: rgbValues,
                    borderColor:  rgbValues,
                    data: valores,
                }]
                };
                 console.log(rgbValues);
                const config = {
                    type: 'bar',
                    data: data,
                    options: {}
                };
            
                const myChart = new Chart(
                    document.getElementById('gasM'),
                    config
                );


            } 


    })
</script>
@endpush 
</x-app-layout>
