<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de venta</title>
    <style>
        body {
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif; 
        font-size: 14px;
        /*font-family: SourceSansPro;*/
        }
 
        #logo{
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        }
 
        #imagen{
        width: 400px;
        }

        td{
            text-align:center;
        }
 
        #datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        /*text-align: justify;*/
        }
 
        #encabezado{
        text-align: center;
        margin-left: 10%;
        margin-right: 35%;
        font-size: 15px;
        }
 
        #fact{
        /*position: relative;*/
        float: right;
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 20px;
        }
 
        section{
        clear: left;
        }
 
        #cliente{
        text-align: left;
        }
 
        #facliente{
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }
 
        #fac, #fv, #fa{
        color: #FFFFFF;
        font-size: 15px;
        }
 
        #facliente thead{
        padding: 20px;
        background: #2183E3;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;  
        }
 
        #facvendedor{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }
 
        #facvendedor thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }
 
        #facarticulo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }
 
        #facarticulo thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }
 
        #gracias{
        text-align: center; 
        }
    </style>
    <body>
        @foreach ($data as $v)
        <header>
            <div id="logo">
                <img src="./img/banner.png" alt="banner" id="imagen">
            </div>
           
            <div id="fact">
               {{$v->tipo_comprobante}}
                <p>{{$v->num_comprobante}}</p>
            </div>
        </header>
        <br>
        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Unidad de Transporte</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><p id="cliente"><br>
                            Marca: {{$v->marca}} <br>
                            Modelo: {{$v->modelo}} <br>
                            Placa: {{$v->placa}} <br>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        @endforeach
        <br>
        <section>
            <div>
                <table id="facvendedor">
                    <thead>
                        <tr id="fv">
                            <th>Autorizado por :</th>
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$v->name}}</td>
                            <td>{{$v->created_at}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <br>
        <section>
            <div>
                <table id="facarticulo">
                    <thead>
                        <tr id="fa">
                            <th>Cant</th>
                            <th>Marca</th>
                            <th>Tipo</th>
                            <th>Medidas</th>
                            <th>Amperaje</th>
                            <th>Tipo Aceite</th>
                            <th>Precio Unit</th>
                            <th>Precio Total</th>
                        </tr>
                    </thead>
                    <tbody>
                     @foreach ($data2 as $det)
                        <tr>
                            <td>{{$det->cantidad}}</td>
                            <td>{{$det->marca}}</td>
                            <td>{{$det->tipo}}</td>
                            <td>{{$det->medida}}</td>
                            <td>{{$det->amperaje}}</td>
                            <td>{{$det->tipoA}}</td>
                            <td>{{$det->precio}}</td>
                            <td>{{$det->precio*$det->cantidad}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @foreach($data as $v)
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>SUBTOTAL</th>
                            <td>Bs.S {{round($v->total -($v->total*$v->impuesto),2)}}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Impuesto (16%)</th>
                            <td>Bs.S {{round($v->total*$v->impuesto,2)}}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>TOTAL</th>
                            <td>Bs.S {{$v->total}}</td>
                        </tr>
                        @endforeach
                    </tfoot>
                </table>
            </div>
        </section>
        <br>
        <br>
        <footer>
            <div id="gracias">
                <p><b>Gracias por su compra!</b></p>
            </div>
        </footer>
    </body>
</html>