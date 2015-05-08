    <div class="row-fluid">
        <div class="span3">
            Provinsi
        </div>
        <div class="span1">:</div>
        <div class="span8" style="text-align:left">
            <?php echo $model->City->Province->name ?>
        </div>
    </div> 
    <div class="row-fluid">
        <div class="span3">
            Kota
        </div>
        <div class="span1">:</div>
        <div class="span8" style="text-align:left">
            <?php echo $model->City->name ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            Alamat
        </div>
        <div class="span1">:</div>
        <div class="span8" style="text-align:left">
            <?php echo $model->address ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            Telephone
        </div>
        <div class="span1">:</div>
        <div class="span8" style="text-align:left">
            <?php echo $model->phone ?>
        </div>
    </div> 
