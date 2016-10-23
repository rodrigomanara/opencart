<?php

$var_div =  '
<div id="rule">
<div class="col-md-6">
<div class="title"> Rules </div>
<div class="form-group">
<label for="exampleInputEmail1">Minimum Spent </label>
<div class="col-sm-10">
<input   type="text" name="ByValueSpent_[rule][subTotal][min][]"class="form-control" id="exampleInputEmail1" placeholder="">
</div>
</div>
<div class="form-group">
<label for="exampleInputEmail1">Max Spent </label>
<div class="col-sm-10">
<input  type="text" name="ByValueSpent_[rule][subTotal][max][]"class="form-control" id="exampleInputEmail1" placeholder="">
</div>
</div>
<div class="form-group">
<label for="exampleInputEmail1">Cost Value</label>
<div class="col-sm-10">
<input  type="text" name="ByValueSpent_[rule][cost][value][]"class="form-control" id="exampleInputEmail1" placeholder="">
</div>
</div>
<div class="form-group">
<label for="exampleInputEmail1">Cost Type</label>
<div class="col-sm-10">
<input  type="text" name="ByValueSpent_[rule][cost][title][]"class="form-control" id="exampleInputEmail1" placeholder="">
</div>
</div>
<button type="button" class="btn btn-danger" id="rule_remove"><i class="fa fa-minus"></i> remove</button>
</div>
</div>

';

$var_div = preg_replace('/\s+/', ' ',$var_div);
?>




<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-subTotal" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div>
                    <button class="btn btn-success" id="add_rules"><i class="fa fa-plus"></i> <?php echo $text_add_new_rule; ?></button>
                </div>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-subTotal" class="form-horizontal">
                    <div class="row">

                        <ul class="nav nav-tabs" role="tablist">
                            <li role="main" class="active"><a href="#main" aria-controls="main" role="tab" data-toggle="tab">Rules</a></li>
                            <li role="tax"><a href="#tax" aria-controls="tax" role="tab" data-toggle="tab">Tax</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane" id="tax">
                                <table>
                                    <tr>
                                        <td><?php echo $entry_tax_class; ?></td>
                                        <td><select name="ByValueSpent_tax_class_id">
                                                <option value="0"><?php echo $text_none; ?></option>
                                                <?php   foreach ($tax_classes as $tax_class) { ?>
                                                <?php if ($tax_class['tax_class_id'] == $ByValueSpent_tax_class_id) { ?>
                                                <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                                                <?php } else { ?>
                                                <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $entry_geo_zone; ?></td>
                                        <td><select name="ByValueSpent_geo_zone_id">
                                                <option value="0"><?php echo $text_all_zones; ?></option>
                                                <?php foreach ($geo_zones as $geo_zone) { ?>
                                                <?php if ($geo_zone['geo_zone_id'] == $ByValueSpent_geo_zone_id) { ?>
                                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                                                <?php } else { ?>
                                                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                                                <?php } ?>
                                                <?php } ?>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $entry_status; ?></td>
                                        <td><select name="ByValueSpent_status">
                                                <?php if ($ByValueSpent_status) { ?>
                                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                                <option value="0"><?php echo $text_disabled; ?></option>
                                                <?php } else { ?>
                                                <option value="1"><?php echo $text_enabled; ?></option>
                                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                                <?php } ?>
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $entry_sort_order; ?></td>
                                        <td><input type="text" name="ByValueSpent_sort_order" value="<?php echo $ByValueSpent_sort_order; ?>" size="1" /></td>
                                    </tr>
                                </table>

                            </div>
                            <div role="tabpanel" class="tab-pane active" id="main">

                                <?php if(empty($ByValueSpent_rule)){ 

                                echo $var_div;

                                }else{  foreach($ByValueSpent_rule as $rules){ ?>
                                <div id="rule">
                                    <div class="col-md-6">
                                        <div class="title"> Rules </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Minimum Spent (min)</label>
                                            <div class="col-sm-10">
                                                <input  value="<?php echo $rules->subTotal->min ;?>" type="text" name="ByValueSpent_[rule][subTotal][min][]"class="form-control" id="exampleInputEmail1" placeholder="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Max Spent (max)</label>
                                            <div class="col-sm-10">
                                                <input value="<?php echo $rules->subTotal->max ;?>" type="text" name="ByValueSpent_[rule][subTotal][max][]"class="form-control" id="exampleInputEmail1" placeholder="l">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Cost Value</label>
                                            <div class="col-sm-10">
                                                <input value="<?php echo $rules->cost->value ;?>" type="text" name="ByValueSpent_[rule][cost][value][]"class="form-control" id="exampleInputEmail1" placeholder="l">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Cost Type</label>
                                            <div class="col-sm-10">
                                                <input value="<?php echo $rules->cost->title ;?>" type="text" name="ByValueSpent_[rule][cost][title][]"class="form-control" id="exampleInputEmail1" placeholder="l">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger" id="rule_remove"><i class="fa fa-minus"></i> remove</button>
                                    </div>
                                </div>    
                                <?php }
                                }
                                ?>
                            </div>
                        </div>
                    </div>             
            </div>    
            </form>
        </div>    
    </div>
</div>
<script>
    $(function () {
        $('#add_rules').click(function () {
            $('#rule').last().before('<?php echo $var_div; ?>');


            $('[id=rule_remove]').click(function () {
                $(this).parent().remove();
            })
        });

        $('[id=rule_remove]').click(function () {
            $(this).parent().remove();
        })

    })
</script>
<?php echo $footer; ?> 