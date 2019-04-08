<template>
    <main class="main mt-6">

        <div class="container-fluid">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-chart">
                                <div class="card-header">
                                    <h4>Ingresos</h4>
                                </div>
                                <div class="card-content">
                                    <div class="ct-chart">
                                        <canvas id="ingresos"></canvas>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p>Ingresos de insumos por mes</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-chart">
                                <div class="card-header">
                                    <h4>Entrega</h4>
                                </div>
                                <div class="card-content">
                                    <div class="ct-chart">
                                        <canvas id="entrega"></canvas>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p>Insumos entregados por mes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    export default {
        data() {
            
            return{

            varIngreso:null,
            charIngreso:null,
            ingresos:[],
            varTotalIngreso:[],
            varMesIngreso:[],


            //ventas


            ventas:[],
            varVentas:null,
            charVentas:null,
            varTotalVentas:[],
            varMesVenta:[]
            }
            
        },
        methods:{
            getIngreso(){
                axios.get("api/escritorio").then(({data})=>{(this.ingresos = data)
                let me=this;
                this.ingresos.map(function(x){
                    me.varTotalIngreso.push(x.total);
                    me.varMesIngreso.push(x.mes);
                });
                this.varIngreso=document.getElementById('ingresos').getContext('2d');

                    this.charIngreso = new Chart(this.varIngreso, {
                        
                        type: 'bar',
                        data: {
                            labels: this.varMesIngreso,
                            datasets: [{
                                label: 'Ingresos del mes',
                                data: this.varTotalIngreso,
                                backgroundColor: [
                                    
                                    'rgba(54, 162, 235, 0.2)',
                                   
                                ],
                                borderColor: [
                                    
                                    'rgba(54, 162, 235, 1)',
                                    
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                       
                                    }
                                }]
                            }
                        }
                    });
                    
               
                 });

                    
                },

                
           getVentas(){
                 axios.get("api/escritorio/venta").then(({data})=>{(this.ventas = data)
                let me=this;
                this.ventas.map(function(x){
                    me.varTotalVentas.push(x.total);
                    me.varMesVenta.push(x.mes);
                });
                 this.varVentas=document.getElementById('entrega').getContext('2d');

                    this.charVentas = new Chart(this.varVentas, {
                        
                        type: 'bar',
                        data: {
                            labels: this.varMesVenta,
                            datasets: [{
                                label: 'Entregas del mes',
                                data: this.varTotalVentas,
                                backgroundColor: [
                                    
                                    'rgba(54, 162, 235, 0.2)',
                                   
                                ],
                                borderColor: [
                                    
                                    'rgba(54, 162, 235, 1)',
                                    
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                       
                                    }
                                }]
                            }
                        }
                    });
                 });
               
               
           } 
            },
            
        
        mounted(){
            this.getIngreso();
            this.getVentas();
            //this.loadIngresos();
        }
            
    }
</script>
