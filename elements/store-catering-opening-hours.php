<?php
if(isset($data[0]['store_open_close_day_time_catering']) or isset($data[0]['store_open_close_day_time']))
{
    // echo '<pre>'; print_r($allDayOpen); exit;
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <label class="radio-inline">
                <input type="radio" name="openingDaysCatering" value="1" <?php echo (isset($allDayOpenCatering) && !empty($allDayOpenCatering)) ? "checked" : '' ?>>All Days
            </label>
            <label class="radio-inline">
                <input type="radio" name="openingDaysCatering" value="2" <?php echo (!isset($allDayOpenCatering)) ? "checked" : '' ?>>Week Days
            </label>
        </div>
        <div class="panel-body">
            <div class="row catall1" style="<?php echo (isset($allDayOpenCatering) && !empty($allDayOpenCatering)) ? '' : 'display: none'; ?>" >
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="allOpenCatering">Opening Time:</label>
                        <select class="form-control input-sm" id="allOpenCatering">
                            <option value="">Select Opening Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $allDayOpenCatering)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="allCloseCatering">Closing Time:</label>
                        <select class="form-control input-sm" id="allCloseCatering">
                            <option value="">Select Closing Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $allDayCloseCatering) == str_replace(':', '', $value['close_time'])) echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row catall2" style="<?php echo (!isset($allDayOpenCatering)) ? '' : 'display: none' ?>">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="monOpenCatering">Monday Opening Time:</label>
                        <select class="form-control input-sm" id="monOpenCatering">
                            <option value="">Monday Opening Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $monDayOpenCatering)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="monCloseCatering">Monday Closing Time:</label>
                        <select class="form-control input-sm" id="monCloseCatering">
                            <option value="">Monday Closing Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $monDayCloseCatering) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="tueOpenCatering">Tuesday Opening Time:</label>
                        <select class="form-control input-sm" id="tueOpenCatering">
                            <option value="">Tuesday Opening Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $tueDayOpenCatering)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="tueCloseCatering">Tuesday Closing Time:</label>
                        <select class="form-control input-sm" id="tueCloseCateringCatering">
                            <option value="">Tuesday Closing Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $tueDayCloseCatering) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="wedOpenCatering">Wednesday Opening Time:</label>
                        <select class="form-control input-sm" id="wedOpenCatering">
                            <option value="">Wednesday Opening Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $wedDayOpenCatering)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="wedCloseCatering">Wednesday Closing Time:</label>
                        <select class="form-control input-sm" id="wedCloseCatering">
                            <option value="">Wednesday Closing Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $wedDayCloseCatering) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="thuOpenCatering">Thursday Opening Time:</label>
                        <select class="form-control input-sm" id="thuOpenCatering">
                            <option value="">Thursday Opening Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $thuDayOpenCatering)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="thuCloseCatering">Thursday Closing Time:</label>
                        <select class="form-control input-sm" id="thuCloseCatering">
                            <option value="">Thursday Closing Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $thuDayCloseCatering) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="friOpenCatering">Friday Opening Time:</label>
                        <select class="form-control input-sm" id="friOpenCatering">
                            <option value="">Friday Opening Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $friDayOpenCatering)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="friCloseCatering">Friday Closing Time:</label>
                        <select class="form-control input-sm" id="friCloseCatering">
                            <option value="">Friday Closing Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $friDayCloseCatering) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="satOpenCatering">Saturday Opening Time:</label>
                        <select class="form-control input-sm" id="satOpenCatering">
                            <option value="">Saturday Opening Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $satDayOpenCatering)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="satCloseCatering">Saturday Closing Time:</label>
                        <select class="form-control input-sm" id="satCloseCatering">
                            <option value="">Saturday Closing Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $satDayCloseCatering) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="sunOpenCatering">Sunday Opening Time:</label>
                        <select class="form-control input-sm" id="sunOpenCatering">
                            <option value="">Sunday Opening Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', str_replace(' ', '', $sunDayOpenCatering)) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="sunCloseCatering">Sunday Closing Time:</label>
                        <select class="form-control input-sm" id="sunCloseCatering">
                            <option value="">Sunday Closing Time</option>
                            <?php
                            foreach($openCloseingTimeCatering as $key =>$value) {
                                ?>
                                <option value="<?php echo $value['close_time']; ?>" <?php if(str_replace(':', '', $sunDayCloseCatering) == str_replace(':', '', $value['close_time']))echo "selected='selected'"; ?>><?php echo $value['close_time']?></option>
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
                <input type="radio" name="openingDaysCatering" value="1" checked>All Days
            </label>
            <label class="radio-inline">
                <input type="radio" name="openingDaysCatering" value="2">Week Days
            </label>
        </div>
        <div class="panel-body">
            <?php
            $strOptionsForOpenCloseingTime = '';
            foreach($openCloseingTimeCatering as $key =>$value) {
                $strOptionsForOpenCloseingTime .= "<option value='{$value['close_time']}'>{$value['close_time']}</option>";
            }
            ?>
            <div class="row catall1">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="allOpenCatering">Opening Time:</label>
                        <select class="form-control input-sm" id="allOpenCatering">
                            <option value="">Select Opening Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="allCloseCatering">Closing Time:</label>
                        <select class="form-control input-sm" id="allCloseCatering">
                            <option value="">Select Closing Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row catall2" style="display: none;">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="monOpen">Monday Opening Time:</label>
                        <select class="form-control input-sm" id="monOpenCatering">
                            <option value="">Monday Opening Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="monClose">Monday Closing Time:</label>
                        <select class="form-control input-sm" id="monCloseCatering">
                            <option value="">Monday Closing Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="tueOpen">Tuesday Opening Time:</label>
                        <select class="form-control input-sm" id="tueOpenCatering">
                            <option value="">Tuesday Opening Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="tueClose">Tuesday Closing Time:</label>
                        <select class="form-control input-sm" id="tueCloseCatering">
                            <option value="">Tuesday Closing Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="wedOpen">Wednesday Opening Time:</label>
                        <select class="form-control input-sm" id="wedOpenCatering">
                            <option value="">Wednesday Opening Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="wedClose">Wednesday Closing Time:</label>
                        <select class="form-control input-sm" id="wedCloseCatering">
                            <option value="">Wednesday Closing Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="thuOpen">Thursday Opening Time:</label>
                        <select class="form-control input-sm" id="thuOpenCatering">
                            <option value="">Thursday Opening Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="thuClose">Thursday Closing Time:</label>
                        <select class="form-control input-sm" id="thuCloseCatering">
                            <option value="">Thursday Closing Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="friOpen">Friday Opening Time:</label>
                        <select class="form-control input-sm" id="friOpenCatering">
                            <option value="">Friday Opening Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="friClose">Friday Closing Time:</label>
                        <select class="form-control input-sm" id="friCloseCatering">
                            <option value="">Friday Closing Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="satOpen">Saturday Opening Time:</label>
                        <select class="form-control input-sm" id="satOpenCatering">
                            <option value="">Saturday Opening Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="satClose">Saturday Closing Time:</label>
                        <select class="form-control input-sm" id="satCloseCatering">
                            <option value="">Saturday Closing Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="sunOpen">Sunday Opening Time:</label>
                        <select class="form-control input-sm" id="sunOpenCatering">
                            <option value="">Sunday Opening Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="sunClose">Sunday Closing Time:</label>
                        <select class="form-control input-sm" id="sunCloseCatering">
                            <option value="">Sunday Closing Time</option>
                            <?php echo $strOptionsForOpenCloseingTime; ?>
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