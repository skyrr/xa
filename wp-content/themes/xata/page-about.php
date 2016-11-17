<?php get_header(); ?>

<div class="body-1">

    <?php
        global $header_style;
        $header_style = 1;
        get_template_part( 'header-page' );
    ?>

    <?php $data = get_fields(); ?>

    <div class="container">
        <div class="panel-group" role="tablist">
            <div class="panel1">
                <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
                    <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse" href="#collapseListGroup1" aria-expanded="false" aria-controls="collapseListGroup1">
                            <?php _e('Подбор недвижимости', 'imperia'); ?>
                        </a>
                    </h4>
                </div>
                <div id="collapseListGroup1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseListGroupHeading1" aria-expanded="false" style="height: 0px;">
                    <?php get_template_part( 'search-page' ); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="about">
            <div class="row">
                <div class="about-h1">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <h1><?php echo $data['header']; ?></h1>
                        <span></span>
                    </div>
                    <div class="about-right">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <p><?php echo $data['page_content']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<?php wp_footer(); ?>
</html>