<div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Vick Logística</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="<?=BASE_URL?>">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#"><?=$titulo?></a>
                    </li>
                </ul>
            </div>

    <!-- end page-title -->

    <!-- Mensagem flash -->
    <?php if(isset($_SESSION['alert'])): ?>
    <?php echo $_SESSION['alert']; ?>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-header">

                    <div class="row">
                        <div class="col-10">
                            <h5 class="">Manutenção<b> Nº #<?=$manutencao['id']?></b></h5><br>
                            <div class="btn-group" style="margin-left:0px;margin-bottom:5px;">
                                <a href="<?= BASE_URL ?>checklist/manutencao" class="btn btn-success"
                                style="color:white;"><i class="fa fa-arrow-left"></i> Voltar
                                </a>
                                <a href="<?= BASE_URL ?>checklist/imprimir/<?=$manutencao['id']?>" class="btn btn-primary"
                                style="color:white;" target="_blank"><i class="fa fa-barcode"></i> Imprimir
                                </a>
                                <a href="<?= BASE_URL ?>checklist/pdf/<?=$manutencao['id']?>" class="btn btn-primary"
                                style="color:white;"><i class="fa fa-file-pdf"></i> PDF
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                
                <div class="" style="border:1px solid #cacaca;padding:10px;">
                    <div class="row">
                    <div class="col-md-12" style="margin-top:0px;display: flex;justify-content: start;">  
                        <span class="text-capitalize" style="font-size:23px;"><b style="font-weight:bold;">
                            <img src="<?=BASE_URL?>assets/img/logo.jpeg" width="80" height="70">
                            <?php foreach(json_decode($manutencao['manutencao_json']) as $man): ?>
                                Manutenção - <?=$man->equipamento?>    
                            <?php endforeach; ?>    
                        </span>
                    </div>
                    </div>
                    
                </div>

                <div class="" style="border:1px solid #cacaca;padding:20px;">      
                    <div class="row">
                        <div class="col-md-12" style="display: flex;justify-content: space-between;">
                            <?php foreach(json_decode($manutencao['manutencao_json']) as $mm) : ?>
                            <span class="text-capitalize" style="font-size:13px;"><strong style="font-weight:bold;color: #0e0e0e;">Tipo:</strong> <?=$mm->tipo?></span>  
                            <span class="text-capitalize" style="font-size:13px"><strong style="font-weight:bold;color: #0e0e0e;">Nº Frota:</strong> <?=$mm->frota?>&nbsp;&nbsp;&nbsp;</span>
                            <span class="text-capitalize" style="font-size:13px"><strong style="font-weight:bold;color: #0e0e0e;">Equipamento:</strong> <?=$mm->equipamento?>&nbsp;&nbsp;&nbsp;</span>
                            <span class="text-capitalize" style="font-size:13px"><strong style="font-weight:bold;color: #0e0e0e;">Data:</strong> <?=date('d/m/y', strtotime($mm->hora))?> ás <?=date('H:i:s', strtotime($mm->hora))?> hs</span>
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
                                    <th style="background-color:#797979;font-weight:bold;font-size:15px;color:white;border:1px;">Problema</th>
                                    <th style="background-color:#797979;font-weight:bold;font-size:15px;color:white;border:1px;border-left: 1px solid #8c8c8c!important;">Descrição</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach(json_decode($manutencao['manutencao_json']) as $mmm): ?>  
                                   <tr>
                                        <!-- <td>Validade da Licença / CNH</td> -->
                                        <td><?=$mmm->titulo?></td>
                                        <td><?=$mmm->descricao?></td>
                                   </tr>
                                   <!-- <tr>
                                        <td>Estado geral de Limpeza</td>
                                        <td><?=$mmm->descricao?></td>
                                   </tr> -->
                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <td class="text-left" style="font-size:15px;font-weight:bold;background-color:#797979;color:white;height: 60px !important;"><b>Responsável Pelo Checklist</b>
                                    </td>
                                    <td style="background-color:#797979;font-weight:bold;font-size:15px;color:white;height: 60px !important;"><?= $ccc->responsavel?></td>
                                </tr>
                            </tfoot> -->
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
                <!-- <br> -->

                <!-- <div class="" style="border:1px solid #cacaca;padding:10px;">
                    <div class="row">
                    <div class="col-md-12" style="margin-top:0px;display: flex;justify-content: start;">  
                        <span class="text-capitalize" style="font-size:23px;color:#575962;"><b style="font-weight:bold;">
                            Irregulariedades Mecânicas Identificadas:	 	 	 	 	 	 	 
                        </span>
                    </div>
                    </div>
                </div>

                <div class="" style="border:1px solid #cacaca;padding:10px;">      
                    <div class="row">
                        <div class="col-md-12" style="margin-top:15px;display: flex;justify-content: start;flex-direction:column;">
                            <?php foreach(json_decode($checklist['checklist_json']) as $cc) : ?>
                            <span class="text-capitalize" style="font-size:13px;"><?=$cc->obs?></span>  
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>  -->

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
        height: 30px !important;
    }
</style>