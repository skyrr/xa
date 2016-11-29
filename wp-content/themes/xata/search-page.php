<?php global $currency; ?>
<?php $search = new \Xata\Search(); ?>

<form action="<?php echo home_url('realty'); ?>" method="get">
    <div class="selection">
        <div class="input-line1">
            <div class="selects1">
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
        <div class="search-line">
            <div class="container">
                <div class="row">
                    <div class="filters" id="filters" data-show="false">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                            <div class="col-xs-7 col-sm-7 col-md-7">
                                <div class="form-horizontal">
                                    <div class="form-group form_group_custom">
                                        <label for="square"><?php _e('Площадь от', 'imperia'); ?></label>
                                        <input type="text" name="area_from" class="form-control" id="square" placeholder="0 м" value="<?php echo $search->getAreaFrom(); ?>">
                                    </div>
                                    <div class="form-group form_group_custom">
                                        <label for="floor"><?php _e('Этаж от', 'imperia'); ?></label>
                                        <input type="text" name="floor_from" class="form-control" id="floor" placeholder="0" value="<?php echo $search->getFloorFrom(); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-5 col-sm-5 col-md-5">
                                <div class="form-horizontal">
                                    <div class="form-group form_group_custom">
                                        <label for="to"><?php _e('до', 'imperia'); ?></label>
                                        <input type="text" name="area_to" class="form-control" id="to" placeholder="0 м" value="<?php echo $search->getAreaTo(); ?>">
                                    </div>
                                    <div class="form-group form_group_custom">
                                        <label for="to"><?php _e('до', 'imperia'); ?></label>
                                        <input type="text" name="floor_to" class="form-control" id="to" placeholder="0" value="<?php echo $search->getFloorTo(); ?>">
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
                                        <input type="text" name="price_from" class="form-control" id="price" placeholder="0 грн" value="<?php echo $search->getPriceFrom(); ?>">
                                    </div>
                                    <div class="form-group form_group_custom">
                                        <label class="nmb-rooms" for="rooms"><?php _e('Количество <br> комнат от', 'imperia'); ?></label>
                                        <input type="text" name="rooms_from" class="form-control" id="rooms" placeholder="0" value="<?php echo $search->getRoomsFrom(); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-5 col-sm-5 col-md-5">
                                <div class="form-horizontal">
                                    <div class="form-group form_group_custom">
                                        <label for="to"><?php _e('до', 'imperia'); ?></label>
                                        <input type="text" name="price_to" class="form-control" id="to" placeholder="0 грн" value="<?php echo $search->getPriceTo(); ?>">
                                    </div>
                                    <div class="form-group form_group_custom">
                                        <label for="to"><?php _e('до', 'imperia'); ?></label>
                                        <input type="text" name="rooms_to" class="form-control" id="to" placeholder="0" value="<?php echo $search->getRoomsTo(); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-2">
                            <div class="form-horizontal">
                                <div class="form-group form_group_custom currency">
                                    <?php echo $currency->getCurrencySelect('form-currency'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="toggle-filter">
                        Розширений пошук <span class="glyphicon glyphicon-chevron-down"></span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                        <a class="find form_submit"><?php _e('Искать', 'imperia'); ?></a>
                        <p class="x"> </p>
                        <a class="clean" href="<?php echo home_url('realty'); ?>"><?php _e('Очистить', 'imperia'); ?></a>
                    </div>
                </div>
        </div>
    </div>
</form>