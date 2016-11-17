<?php get_header(); ?>

<div class="body-2">

    <?php
        global $header_style;
        $header_style = 2;
        get_template_part( 'header-page' );
    ?>

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
        <div class="our-team">
            <div class="row">
                <div class="team-h1">
                    <div class="col-xs-12">
                        <h1><?php the_title(); ?></h1>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="team">
                    <div id="owl-team" class="owl-carousel owl-theme">
                        <?php $team_members = get_field('team_members'); ?>
                        <?php foreach($team_members as $member): ?>
                        <div class="item">
                            <img src="<?php echo $member['photo']['sizes']['thumbnail']; ?>" alt="" width="270px" height="306px">
                            <span><?php echo $member['role']; ?></span>
                            <h3><?php echo $member['name']; ?></h3>
                            <p><?php echo $member['description']; ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>