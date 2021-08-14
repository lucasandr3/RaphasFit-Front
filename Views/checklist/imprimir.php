<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <title>Vick Logística</title>
</head>
<body>
    
<div class="row">
        <div class="col-12">
            <div class="card m-b-30">

                <div class="card-body">
                
                <div class="" style="border:1px solid #545454;padding:10px;">
                    <div class="row">
                    <div class="col-md-12" style="margin-top:0px;display: flex;justify-content: center;">  
                        <span class="text-capitalize" style="font-size:23px;"><b style="font-weight:bold;">
                            <img src="<?=BASE_URL?>assets/img/logo.jpeg" width="80" height="70">
                            <span>Inspeção Caminhão Canavieiro</span>
                        </span>
                    </div>
                    </div>
                    
                </div>

                <div class="" style="border:1px solid #545454;padding:10px;">      
                    <div class="row">
                        <div class="col-md-12" style="display: flex;justify-content: center;margin-left:20px;">
                            <?php foreach(json_decode($checklist['checklist_json']) as $cc) : ?>
                            <span class="text-capitalize" style="font-size:13px;"><strong style="font-weight:bold;color: #0e0e0e;">Área:</strong> Transporte</span>  
                            <span class="text-capitalize" style="font-size:13px"><strong style="font-weight:bold;color: #0e0e0e;">Nº Frota:</strong> <?=$cc->frota?>&nbsp;&nbsp;&nbsp;</span>
                            <span style="font-size:13px"><strong style="font-weight:bold;color: #0e0e0e;">Placa:</strong> <?=$cc->placa?>&nbsp;&nbsp;&nbsp;</span>
                            <span class="text-capitalize" style="font-size:13px"><strong style="font-weight:bold;color: #0e0e0e;">Data do checklist:</strong> <?=date('d/m/y', strtotime($checklist['date_final']))?> ás <?=date('H:i:s', strtotime($checklist['date_final']))?> hs</span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div> 
                <!-- <br> -->

                    <div class="row">
                    <div class="col-md-12 text-center">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="background-color:#797979;font-weight:bold;font-size:15px;color:white;border:1px;padding:15px;">Itens Verificados</th>
                                    <th style="background-color:#797979;font-weight:bold;font-size:15px;color:white;border:1px;border-left: 1px solid #8c8c8c!important;padding:15px;">Resposta</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach(json_decode($checklist['checklist_json']) as $ccc): ?>  
                                   <tr>
                                        <td>Validade da Licença / CNH</td>
                                        <td><?=$ccc->cnh?></td>
                                   </tr>
                                   <tr>
                                        <td>Estado geral de Limpeza</td>
                                        <td><?=$ccc->limpeza?></td>
                                   </tr>
                                   <tr>
                                        <td>Nível de Óleo do Motor</td>
                                        <td><?=$ccc->oleomotor?>%</td>
                                   </tr>
                                   <tr>
                                        <td>Nível liquído de Arrefecimento</td>
                                        <td><?=$ccc->arrefecimento?>%</td>
                                   </tr>
                                   <tr>
                                        <td>Nível de Óleo da Transmissão</td>
                                        <td><?=$ccc->oleotrans?>%</td>
                                   </tr>
                                   <tr>
                                        <td>Vazamento de Óleo ?</td>
                                        <td><?=$ccc->vazamento?></td>
                                   </tr>
                                   <tr>
                                        <td>Extintor de Incêndio, Manômetro e Lacre</td>
                                        <td><?=$ccc->extintor?></td>
                                   </tr>
                                   <tr>
                                        <td>Fárois, Luzes e Laternas de Sinalização</td>
                                        <td><?=$ccc->luzes?></td>
                                   </tr>
                                   <tr>
                                        <td>Mangueiras da caixa hidráulica e da linha de ar da carreta.</td>
                                        <td><?=$ccc->mangueiras?></td>
                                   </tr>
                                   <tr>
                                        <td>Pneus e rodas</td>
                                        <td><?=$ccc->pneus?></td>
                                   </tr>
                                   <tr>
                                        <td>Chassi</td>
                                        <td><?=$ccc->chassi?></td>
                                   </tr>
                                   <tr>
                                        <td>Escapamento / Emissão de fumaça</td>
                                        <td><?=$ccc->escapamento?></td>
                                   </tr>
                                   <tr>
                                        <td>Cabina em geral</td>
                                        <td><?=$ccc->cabina?></td>
                                   </tr>
                                   <tr>
                                        <td>Cinto de segurança</td>
                                        <td><?=$ccc->cinto?></td>
                                   </tr>
                                   <tr>
                                        <td>Banco / Assento</td>
                                        <td><?=$ccc->banco?></td>
                                   </tr>
                                   <tr>
                                        <td>Pára-brisas / Limpador</td>
                                        <td><?=$ccc->limpador?></td>
                                   </tr>
                                   <tr>
                                        <td>Direção / Articulações</td>
                                        <td><?=$ccc->direcao?></td>
                                   </tr>
                                   <tr>
                                        <td>Sistemas de Freios</td>
                                        <td><?=$ccc->freios?></td>
                                   </tr>
                                   <tr>
                                        <td>Sinal sonoro de ré</td>
                                        <td><?=$ccc->sonoro?></td>
                                   </tr>
                                   <tr>
                                        <td>Ar condicionado</td>
                                        <td><?=$ccc->ar?></td>
                                   </tr>
                                   <tr>
                                        <td>Rádio de comunicação</td>
                                        <td><?=$ccc->radio?></td>
                                   </tr>
                                   <tr>
                                        <td>Marcadores do painel</td>
                                        <td><?=$ccc->painel?></td>
                                   </tr>
                                   <tr>
                                        <td>Tomada de força</td>
                                        <td><?=$ccc->tomada?></td>
                                   </tr>
                                   <tr>
                                        <td>Trava da cabine</td>
                                        <td><?=$ccc->trava?></td>
                                   </tr>
                                   <tr>
                                        <td>Cones e triangulo de sinalização</td>
                                        <td><?=$ccc->cone?></td>
                                   </tr>
                                   <tr>
                                        <td>Cordas de amarração</td>
                                        <td><?=$ccc->cordas?></td>
                                   </tr>
                                   <tr>
                                        <td>Cabos aço Tombamento</td>
                                        <td><?=$ccc->cabo_aco?></td>
                                   </tr>
                                   <tr>
                                        <td>Cabo Aço Limitador Caixote</td>
                                        <td><?=$ccc->aco_limitador?></td>
                                   </tr>
                                   <tr>
                                        <td>Corrente segurança julietas</td>
                                        <td><?=$ccc->corrente?></td>
                                   </tr>
                                   <tr>
                                        <td>Faixas refletivas</td>
                                        <td><?=$ccc->faixas?></td>
                                   </tr>
                                   <tr>
                                        <td>Quinta roda</td>
                                        <td><?=$ccc->quinta_roda?></td>
                                   </tr>
                                   <tr>
                                        <td>Engate Boca de Lobo</td>
                                        <td><?=$ccc->engate?></td>
                                   </tr>
                                   <tr>
                                        <td>Ponteira de Engate</td>
                                        <td><?=$ccc->ponteira?></td>
                                   </tr>
                               
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-left" style="font-size:15px;font-weight:bold;background-color:#797979;color:white;height: 60px !important;"><b>Responsável Pelo Checklist</b>
                                    </td>
                                    <td style="background-color:#797979;font-weight:bold;font-size:15px;color:white;height: 60px !important;"><?= $ccc->responsavel?></td>
                                </tr>
                            </tfoot>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
                <!-- <br> -->

                <div class="" style="border:1px solid #545454;padding:10px;">
                    <div class="row">
                    <div class="col-md-12" style="margin-top:0px;display: flex;justify-content: start;">  
                        <span class="text-capitalize" style="font-size:23px;color:#575962;"><b style="font-weight:bold;">
                            Irregulariedades Mecânicas Identificadas:	 	 	 	 	 	 	 
                        </span>
                    </div>
                    </div>
                </div>

                <div class="" style="border:1px solid #545454;padding:10px;">      
                    <div class="row">
                        <div class="col-md-12" style="margin-top:15px;display: flex;justify-content: start;flex-direction:column;">
                            <?php foreach(json_decode($checklist['checklist_json']) as $cc) : ?>
                            <span class="text-capitalize" style="font-size:13px;"><?=$cc->obs?></span>  
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div> 

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

</div>    

<style>
    .table td {
        border-color: #8c8c8c!important;
    }
    tr {
        text-align:left;
        border: 1px solid #8c8c8c!important;
    }
    td {
        text-transform:capitalize;
        border: 1px;
        padding:10px;
    }
</style>
</body>
</html>