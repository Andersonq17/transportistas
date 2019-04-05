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
            varMesIngreso:[]
            }
        },
        methods:{
            getIngreso(){
                axios.get("api/escritorio").then(({ data })=>(this.ingresos = data));
                this.loadIngresos();
            },

            loadIngresos(){
                this.ingresos.map(function(x){
                    this.varTotalIngreso.push(x.total);
                    this.varMesIngreso.push(x.mes);
                });
                this.varIngreso=document.getElementById('ingresos').getContext('2d');

                    this.charIngreso = new Chart(this.varIngreso, {
                        
                        type: 'bar',
            
                        data: {
                            labels: this.varMesIngreso,
                            datasets: [{
                                label: 'Ingresos',
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderColor: 'rgb(255, 99, 132)',
                                data: this.varTotalIngreso,
                                borderWidth: 1,
                            }]
                        },

                        // Configuration options go here
                        options: {
                            ticks:{
                                beginAtZero:true,
                            }
                            
                        }
                    });
            }
        },
        
        mounted(){
            this.getIngreso();
        }
            
    }
</script>
