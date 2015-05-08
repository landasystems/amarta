<?php if (!empty($model)) { ?>
    <hr style="margin-bottom:0px">
    <legend>Destination </legend>
    <div class="row-fluid">
        <div class="span3">
            Name
        </div>
        <div class="span1">:</div>
        <div class="span8" style="text-align:left">
            <?php echo $model->name ?>
        </div>
    </div> 
    <div class="row-fluid">
        <div class="span3">
            Province
        </div>
        <div class="span1">:</div>
        <div class="span8" style="text-align:left">
            <?php echo $model->City->Province->name ?>
        </div>
    </div> 
    <div class="row-fluid">
        <div class="span3">
            City
        </div>
        <div class="span1">:</div>
        <div class="span8" style="text-align:left">
            <?php echo $model->City->name ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            Address
        </div>
        <div class="span1">:</div>
        <div class="span8" style="text-align:left">
            <?php echo $model->address ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            Phone
        </div>
        <div class="span1">:</div>
        <div class="span8" style="text-align:left">
            <?php echo $model->phone ?>
        </div>
    </div> 
    <?php
} else {
    ?>
    <hr style="margin-bottom:0px">
    <legend>Destination </legend>
    <div class="row-fluid">
        <div class="span3">
            Name
        </div>
        <div class="span1">:</div>
        <div class="span8" style="text-align:left">            
        </div>
    </div> 
    <div class="row-fluid">
        <div class="span3">
            Province
        </div>
        <div class="span1">:</div>
        <div class="span8" style="text-align:left">            
        </div>
    </div> 
    <div class="row-fluid">
        <div class="span3">
            City
        </div>
        <div class="span1">:</div>
        <div class="span8" style="text-align:left">            
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            Address
        </div>
        <div class="span1">:</div>
        <div class="span8" style="text-align:left">            
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            Phone
        </div>
        <div class="span1">:</div>
        <div class="span8" style="text-align:left">            
        </div>
    </div>   
<?php } ?>
    