<?php global $currency; ?>
<?php $search = new \Xata\Search(); ?>

<form action="<?php echo home_url('realty'); ?>" method="get">

    <div class="input-line2 search-line">
        <div class="container">
            <div class="row">
                <div class="select-line">
                    <div class="container">
                        <div class="row selects">
                            <div class="col-sm-4">
                                <select class="s-select1" name="operation">
                                    <option value="sell" <?php if($search->getOperation() == 'sell') echo 'selected'; ?>><?php _e('Купить', 'imperia'); ?></option>
                                    <option value="rent" <?php if($search->getOperation() == 'rent') echo 'selected'; ?>><?php _e('Аренда', 'imperia'); ?></option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select class="s-select2" name="type">
                                    <option value="apartment" <?php if($search->getType() == 'apartment') echo 'selected'; ?>><?php _e('Квартира', 'imperia'); ?></option>
                                    <option value="commerce" <?php if($search->getType() == 'commerce') echo 'selected'; ?>><?php _e('Коммерция', 'imperia'); ?></option>
                                    <option value="house" <?php if($search->getType() == 'house') echo 'selected'; ?>><?php _e('Дом', 'imperia'); ?></option>
                                    <option value="territory" <?php if($search->getType() == 'territory') echo 'selected'; ?>><?php _e('Земельный участок', 'imperia'); ?></option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <?php echo $search->getRegionsSelect(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filters" id="filters" data-show="false">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                        <div class="col-xs-7 col-sm-7 col-md-7">
                            <div class="form-horizontal">
                                <div class="form-group form_group_custom">
                                    <label for="square"><?php _e('Площадь от', 'imperia'); ?></label>
                                    <input type="text" name="area_from" class="form-control" id="square" placeholder="0 м" value="<?php $area_from = "area_from"; cookieSetter($area_from, $_REQUEST[$area_from]); ?>">
                                </div>
                                <div class="form-group form_group_custom">
                                    <label for="floor"><?php _e('Этаж от', 'imperia'); ?></label>
<!--                                    <input type="text" name="floor_from" class="form-control" id="floor" placeholder="0" value="--><?php //$aid = $_REQUEST['floor_from']; echo $aid; ?><!--">-->
                                    <input type="text" name="floor_from" class="form-control" id="floor" placeholder="0" value="<?php $floor_from = "floor_from"; cookieSetter($floor_from, $_REQUEST[$floor_from]); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-5 col-sm-5 col-md-5">
                            <div class="form-horizontal">
                                <div class="form-group form_group_custom">
                                    <label for="to"><?php _e('до', 'imperia'); ?></label>
<!--                                    <input type="text" name="area_to" class="form-control" id="to" placeholder="0 м" value="--><?php //$aid = $_REQUEST['area_to']; echo $aid; ?><!--">-->
                                    <input type="text" name="area_to" class="form-control" id="to" placeholder="0 м" value="<?php $area_to = "area_to"; cookieSetter($area_to, $_REQUEST[$area_to]); ?>">
                                </div>
                                <div class="form-group form_group_custom">
                                    <label for="to"><?php _e('до', 'imperia'); ?></label>
                                    <input type="text" name="floor_to" class="form-control" id="to" placeholder="0" value="<?php $floor_to = "floor_to"; cookieSetter($floor_to, $_REQUEST[$floor_to]); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-1"></div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                        <div class="col-xs-7 col-sm-7 col-md-7">
                            <div class="form-horizontal">
                                <div class="form-group form_group_custom">
                                    <label for="price"><?php _e('Цена от', 'imperia'); ?></label>
                                    <input type="text" name="price_from" class="form-control" id="price" placeholder="0 грн" value="<?php $price_from = "price_from"; cookieSetter($price_from, $_REQUEST[$price_from]); ?>">
                                </div>
                                <div class="form-group form_group_custom">
                                    <label class="nmb-rooms" for="rooms"><?php _e('Количество <br> комнат от', 'imperia'); ?></label>
                                    <input type="text" name="rooms_from" class="form-control" id="rooms" placeholder="0" value="<?php $rooms_from = "rooms_from"; cookieSetter($rooms_from, $_REQUEST[$rooms_from]); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-5 col-sm-5 col-md-5">
                            <div class="form-horizontal">
                                <div class="form-group form_group_custom">
                                    <label for="to"><?php _e('до', 'imperia'); ?></label>
                                    <input type="text" name="price_to" class="form-control" id="to" placeholder="0 грн" value="<?php $price_to = "price_to"; cookieSetter($price_to, $_REQUEST[$price_to]); ?>">
                                </div>
                                <div class="form-group form_group_custom">
                                    <label for="to"><?php _e('до', 'imperia'); ?></label>
                                    <input type="text" name="rooms_to" class="form-control" id="to" placeholder="0" value="<?php $rooms_to = "rooms_to"; cookieSetter($rooms_to, $_REQUEST[$rooms_to]); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-2">
                        <div class="form-horizontal">
                            <div class="form-group form_group_custom currency">
                                <?php echo $currency->getCurrencySelect('form-currency'); ?>
                                <a class="clean" href="<?php echo home_url('realty?operation=sell&type=apartment&region_id=0&area_from=&floor_from=&area_to=&floor_to=&price_from=&rooms_from=&price_to=&rooms_to='); ?>"><?php _e('Очистить', 'imperia'); ?></a>
                                <p class="x"> </p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="toggle-filter1">
                    Розширений пошук <span class="glyphicon glyphicon-chevron-down"></span>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                    <a class="find form_submit"><?php _e('Искать', 'imperia'); ?></a>
                </div>

            </div>
        </div>
    </div>
</form>