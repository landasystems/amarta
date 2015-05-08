<center><h3>Slip Gaji</h3></center>

<?php
$this->setPageTitle('Salaries');
$this->breadcrumbs = array(
    'Salaries' => array('index'),
    'Create',
);
?>

<div class="form">
    <?php
    $user = user()->id;
    $desc = '';
    $date = date('d M Y');
    ?>

    <div class="box gradient invoice">
        <div class="content ">        
            <table style="width: 100%">
                <tr>
                    <td style="width: 50%;vertical-align: top">
                        <div class="row-fluid">
                            <div class="span5">
                                Nama Karyawan
                            </div>
                            <div class="span1">:</div>
                            <div class="span6" style="text-align:left">
                                <?php echo user()->name . ' | ' . user()->roles_name ?>
                            </div>
                        </div> 
                        <div class="row-fluid">
                            <div class="span5">
                                Estimasi Gaji diambil / tanggal
                            </div>
                            <div class="span1">:</div>
                            <div class="span6" style="text-align:left">
                                <?php echo date('d F Y') ?>
                            </div>
                        </div>                         
                    </td>                            
                    <td style="width: 50%;vertical-align: top;text-align: center">

                    </td>                            
                </tr>
            </table>  
            <div class="content_detail">
                <?php
                $user_id = user()->id;
                $max_date = date('Y/m/d 24:00');
                if (!empty($user_id)) {
                    $filter = ' and time_end <= "' . $max_date . '" ';
                    $filter .= ' and end_user_id !=0 ';
//                    $filter .= ' and is_qc=1 ';
                    $filter .= ' and is_payment=0 ';
                    $process = WorkorderProcess::model()->findAll(array('condition' => 'start_user_id=' . $user_id . $filter));
                    echo $this->renderPartial('_salarySlipDet', array('process' => $process));
                } else {
                    echo $this->renderPartial('_salarySlipDet', array());
                }
                ?>
            </div>
        </div>

        <div class="clearfix"></div>

    </div>
</div>

<a href="<?php echo url('/') ?>" class="btn btn-block"><span class="icon16 icomoon-icon-enter white"></span> Kembali Ke Menu Utama</a>