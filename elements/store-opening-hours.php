<?php
if(isset($data[0]['store_open_close_day_time']))
{
    // echo '<pre>'; print_r($allDayOpen); exit;
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <label class="radio-inline">
                <input type="radio" name="openingDays" value="1" <?php echo (isset($allDayOpen) && !empty($allDayOpen)) ? "checked" : '' ?>>All Days
            </label>
            <label class="radio-inline">
                <input type="radio" name="openingDays" value="2" <?php echo (!isset($allDayOpen)) ? "checked" : '' ?>>Week Days
            </label>
        </div>
        <div class="panel-body">
            <div class="row all1" style="<?php echo (isset($allDayOpen) && !empty($allDayOpen)) ? '' : 'display: none'; ?>">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="allOpen">Opening Time:</label>
                        <select class="form-control input-sm" id="allOpen">
                            <option value="">Select Opening Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $allDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="allClose">Closing Time:</label>
                        <select class="form-control input-sm" id="allClose">
                            <option value="">Select Closing Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $allDayClose) == str_replace(':', '', $value['close_time'])) echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row all2" style="<?php echo (!isset($allDayOpen)) ? '' : 'display: none' ?>">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="monOpen">Monday Opening Time:</label>
                        <select class="form-control input-sm" id="monOpen">
                            <option value="">Monday Opening Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $monDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="monClose">Monday Closing Time:</label>
                        <select class="form-control input-sm" id="monClose">
                            <option value="">Monday Closing Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $monDayClose) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="tueOpen">Tuesday Opening Time:</label>
                        <select class="form-control input-sm" id="tueOpen">
                            <option value="">Tuesday Opening Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $tueDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="tueClose">Tuesday Closing Time:</label>
                        <select class="form-control input-sm" id="tueClose">
                            <option value="">Tuesday Closing Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $tueDayClose) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="wedOpen">Wednesday Opening Time:</label>
                        <select class="form-control input-sm" id="wedOpen">
                            <option value="">Wednesday Opening Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $wedDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="wedClose">Wednesday Closing Time:</label>
                        <select class="form-control input-sm" id="wedClose">
                            <option value="">Wednesday Closing Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $wedDayClose) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="thuOpen">Thursday Opening Time:</label>
                        <select class="form-control input-sm" id="thuOpen">
                            <option value="">Thursday Opening Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $thuDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="thuClose">Thursday Closing Time:</label>
                        <select class="form-control input-sm" id="thuClose">
                            <option value="">Thursday Closing Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $thuDayClose) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="friOpen">Friday Opening Time:</label>
                        <select class="form-control input-sm" id="friOpen">
                            <option value="">Friday Opening Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $friDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="friClose">Friday Closing Time:</label>
                        <select class="form-control input-sm" id="friClose">
                            <option value="">Friday Closing Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $friDayClose) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="satOpen">Saturday Opening Time:</label>
                        <select class="form-control input-sm" id="satOpen">
                            <option value="">Saturday Opening Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $satDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="satClose">Saturday Closing Time:</label>
                        <select class="form-control input-sm" id="satClose">
                            <option value="">Saturday Closing Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $satDayClose) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="sunOpen">Sunday Opening Time:</label>
                        <select class="form-control input-sm" id="sunOpen">
                            <option value="">Sunday Opening Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $sunDayOpen)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="sunClose">Sunday Closing Time:</label>
                        <select class="form-control input-sm" id="sunClose">
                            <option value="">Sunday Closing Time</option>
                            <?php
                            foreach($openCloseingTime as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $sunDayClose) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div id='error_storeTime' class="error"></div>
            </div>
   
        </div>
    </div>
    <?php
}
else
{
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <label class="radio-inline">
                <input type="radio" name="openingDays" value="1" checked>All Days
            </label>
            <label class="radio-inline">
                <input type="radio" name="openingDays" value="2">Week Days
            </label>
        </div>
        <div class="panel-body">
            <?php
            $strOptionsForOpenTime = $strOptionsForCloseingTime = '';
            foreach($openCloseingTime as $key =>$value) {
                // Open Time
                $isSelected = '';
                if($value['close_time'] == '10:00:00')
                {
                    $isSelected = "selected";
                }

                $strOptionsForOpenTime .= "<option value='{$value['close_time']}' {$isSelected}>{$value['close_time']}</option>";

                // Close Time
                $isSelected = '';
                if($value['close_time'] == '22:00:00')
                {
                    $isSelected = "selected";
                }

                $strOptionsForCloseingTime .= "<option value='{$value['close_time']}' {$isSelected}>{$value['close_time']}</option>";
            }
            ?>
            <div class="row all1">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="allOpen">Opening Time:</label>
                        <select class="form-control input-sm" id="allOpen">
                            <option value="">Select Opening Time</option>
                            <?php echo $strOptionsForOpenTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="allClose">Closing Time:</label>
                        <select class="form-control input-sm" id="allClose">
                            <option value="">Select Closing Time</option>
                            <?php echo $strOptionsForCloseingTime; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row all2" style="display: none;">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="monOpen">Monday Opening Time:</label>
                        <select class="form-control input-sm" id="monOpen">
                            <option value="">Monday Opening Time</option>
                            <?php echo $strOptionsForOpenTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="monClose">Monday Closing Time:</label>
                        <select class="form-control input-sm" id="monClose">
                            <option value="">Monday Closing Time</option>
                            <?php echo $strOptionsForCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="tueOpen">Tuesday Opening Time:</label>
                        <select class="form-control input-sm" id="tueOpen">
                            <option value="">Tuesday Opening Time</option>
                            <?php echo $strOptionsForOpenTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="tueClose">Tuesday Closing Time:</label>
                        <select class="form-control input-sm" id="tueClose">
                            <option value="">Tuesday Closing Time</option>
                            <?php echo $strOptionsForCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="wedOpen">Wednesday Opening Time:</label>
                        <select class="form-control input-sm" id="wedOpen">
                            <option value="">Wednesday Opening Time</option>
                            <?php echo $strOptionsForOpenTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="wedClose">Wednesday Closing Time:</label>
                        <select class="form-control input-sm" id="wedClose">
                            <option value="">Wednesday Closing Time</option>
                            <?php echo $strOptionsForCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="thuOpen">Thursday Opening Time:</label>
                        <select class="form-control input-sm" id="thuOpen">
                            <option value="">Thursday Opening Time</option>
                            <?php echo $strOptionsForOpenTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="thuClose">Thursday Closing Time:</label>
                        <select class="form-control input-sm" id="thuClose">
                            <option value="">Thursday Closing Time</option>
                            <?php echo $strOptionsForCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="friOpen">Friday Opening Time:</label>
                        <select class="form-control input-sm" id="friOpen">
                            <option value="">Friday Opening Time</option>
                            <?php echo $strOptionsForOpenTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="friClose">Friday Closing Time:</label>
                        <select class="form-control input-sm" id="friClose">
                            <option value="">Friday Closing Time</option>
                            <?php echo $strOptionsForCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="satOpen">Saturday Opening Time:</label>
                        <select class="form-control input-sm" id="satOpen">
                            <option value="">Saturday Opening Time</option>
                            <?php echo $strOptionsForOpenTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="satClose">Saturday Closing Time:</label>
                        <select class="form-control input-sm" id="satClose">
                            <option value="">Saturday Closing Time</option>
                            <?php echo $strOptionsForCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="sunOpen">Sunday Opening Time:</label>
                        <select class="form-control input-sm" id="sunOpen">
                            <option value="">Sunday Opening Time</option>
                            <?php echo $strOptionsForOpenTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="sunClose">Sunday Closing Time:</label>
                        <select class="form-control input-sm" id="sunClose">
                            <option value="">Sunday Closing Time</option>
                            <?php echo $strOptionsForCloseingTime; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div id='error_storeTime' class="error"></div>
            <!-- <div class="form-group">
                <input type="button" value="Continue" name="continue" id="submit-btn" class="form-submit-btn">
            </div> -->
        </div>
    </div>
    <?php
}
?>
<div class="custom-control custom-checkbox">
    <input type="checkbox" name="check_catering_option"  <?php if($data[0]['store_open_close_day_time_catering']!=$data[0]['store_open_close_day_time']) { ?> checked <?php } ?>class="custom-control-input" id="catering_open_close" value="1">
    <label class="custom-control-label" for="catering_open_close">Different open/close time for Catering</label>
</div>