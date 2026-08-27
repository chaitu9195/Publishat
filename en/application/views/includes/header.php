<?php
$Upgraded = $this->session->userdata('Upgraded'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/service-3.1.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/html2canvas.js"></script>


<nav class="navbar navbar-default">
    <div class="container mfull">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <div class="settings">
                <span id="msettings"><i class="fa fa-ellipsis-v"></i></span>
                <ul class="msets">
                    <li><a href="#" onclick="getsettings()"><i class="fa fa-cog" aria-hidden="true"></i> &nbsp;Account Settings </a></li>
                    <li><a href="#" onclick="acc_summary()"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;Account Summary </a></li>
                    <!-- <li><a href="#"><i class="fa fa-user-plus"></i> Invite a Friend </a></li>-->
                    <li><a href="#" onclick="dkart()"><i class="fa fa-shopping-basket" aria-hidden="true"></i> &nbsp;D-Cart</a></li>
                    <li><a href="#" onclick="getlog()"><i class="fa fa-archive" aria-hidden="true"></i> &nbsp;Activity Log</a></li>
                    <li><a href="#" onclick="getPrintHistory()"><i class="fa fa-print" aria-hidden="true"></i> &nbsp;Print Job History</a></li>
                    <li><a href="<?php echo base_url(); ?>web/logout"><i class="fa fa-power-off" aria-hidden="true"></i> &nbsp;Logout </a></li>
                </ul>
            </div>
            <?php $domain = $_SERVER['SERVER_NAME']; ?>
            <a class="navbar-brand " href="<?php echo base_url(); ?>web/">
                <?php
                $domain = $_SERVER['SERVER_NAME'];
                if (
                    $domain == 'publishat.com' ||
                    $domain == 'www.publishat.com'
                ) { ?>
                <span class="h1 active" style="color:white">Publishat</span>
                <?php } elseif (
                    $domain == 'mydzvault.com' ||
                    $domain == 'www.mydzvault.com'
                ) { ?>
                <span class="h1 active" style="color:white;font-family:serif">myDZvault</span>
                <?php  } else { ?>
                <span class="h1 active" style="color:white;font-family:serif">Ntotalworld</span>
                <?php }
                ?>

                <!-- <img src="https://www.publishat.com/img/logo.png" class="img-responsive xs-hidden sm-hidden "/> --> </a>

            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#paymentModal" style="margin: 19px 0px 0px 0px;font-weight:bold;">Pro</button>

        </div>
        <!-- 
      <form class="navbar-form navbar-left search-bar">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search">
          <div class="input-group-btn">
            <button class="btn btn-default" type="submit">
              <i class="glyphicon glyphicon-search"></i>
            </button>
          </div>
        </div>
      </form>
-->
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="main_navbar">
            <ul class="nav navbar-nav">

                <?php
                $i = 0;
                foreach ($data as $mod) {
                    $module = ucfirst($mod['Module']); ?>
                <li class="dropdown" id="<?= strtolower($module) ?>">
                    <a href="#/<?= strtolower(
                        $module,
                    ) ?>" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if (
                            $module == 'Academic'
                        ) { ?> <i class="fa fa-graduation-cap" aria-hidden="true"></i> <?php } elseif (
                            $module == 'Professional'
                        ) { ?> <i class="fa fa-briefcase" aria-hidden="true"></i> <?php } elseif (
                            $module == 'Personal'
                        ) { ?> <i class="fa fa-user" aria-hidden="true"></i> <?php } elseif (
                            $module == 'Health'
                        ) { ?> <i class="fa fa-stethoscope" aria-hidden="true"></i> <?php } elseif (
                            $module == 'Financial'
                        ) { ?> <i class="fa fa-bar-chart" aria-hidden="true"></i> <?php } elseif (
                            $module == 'Legal'
                        ) { ?> <i class="fa fa-gavel" aria-hidden="true"></i> <?php } ?>
                        <span class="hidden-xs"><?= $module ?></span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="<?= strtolower(
                        $module,
                    ) ?>_child">
                        <?php foreach ((array) $submod as $nav) {
                            if ($mod['Module'] == $nav['Module']) {

                                $module = $nav['Module'];
                                if (lcfirst($module) == 'health') {
                                    $module = 'medical';
                                }
                                ?>
                        <li id="<?= $nav['Setting'] ?>">
                            <span class="add-icon">
                                <a href="javascript:void(0)" class="text" onclick="getVal('<?= $nav[
                                    'RecordTypeId'
                                ] ?>','<?= strtolower($module) ?>')">
                                    <?= $nav[
                                        'Setting'
                                    ] ?> <b title="No of files" id="">(<?= $rec_count[
     $nav['RecordTypeId']
 ] ?>)</b>
                                    <!--<?= $nav[
                                        'Setting'
                                    ] ?>  <b title="No of files" id=""></b>-->
                                </a>
                                <a href="javascript:void(0)" title="New Record" class="icon" onclick="getNew('<?= $nav[
                                    'RecordTypeId'
                                ] ?>','<?= strtolower($module) ?>')">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i>
                                </a> <a href="javascript:void(0)" class="icon" onclick="getFolder('<?= $nav[
                                    'RecordTypeId'
                                ] ?>','<?= $nav[
    'Setting'
] ?>','<?= $module ?>')">
                                    <i class="fa fa-folder " aria-hidden="true"></i></a>
                            </span>
                        </li>
                        <?php $i++;
                            }
                        } ?>
                    </ul>
                </li>
                <?php
                }
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" area-expanded="false"><span class="visible-xs"><i class="fa fa-cog"></i> <span class="hidden-xs">Settings</span> <span class="caret"></span> </span> <i class="fa fa-cog fa-2x hidden-xs"></i><span class="caret hidden-xs"></span> </a>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick="getsettings()"><i class="fa fa-cog" aria-hidden="true"></i> &nbsp;Account Settings </a></li>
                        <li><a href="#" onclick="acc_summary()"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;Account Summary </a></li>
                        <!-- <li><a href="#"><i class="fa fa-user-plus"></i> Invite a Friend </a></li>-->
                        <li><a href="#" onclick="dkart()"><i class="fa fa-shopping-basket" aria-hidden="true"></i> &nbsp;D-Cart</a></li>
                        <li><a href="#" onclick="getlog()"><i class="fa fa-archive" aria-hidden="true"></i> &nbsp;Activity Log</a></li>
                        <li><a href="#" onclick="getPrintHistory()"><i class="fa fa-print" aria-hidden="true"></i> &nbsp;Print Job History</a></li>
                        <!--<li><a href = "#" onclick="captureFullPage()"><i class="fa fa-archive" aria-hidden="true"></i> &nbsp;Screen shot</a></li>-->
                        <?php
                        $user_id = $this->session->userdata('user_id');
                        if (
                            $user_id == '59907aac88424a8f66ca48ef' ||
                            $user_id == '59907aac88424a8f66ca4962' ||
                            $user_id == '59907ad188424a8f66ca89b1'
                        ) { ?>
                        <li><a href="#" onclick="article_write()"><i class="fa fa-file-text" aria-hidden="true"></i> &nbsp; Post Article</a></li>
                        <?php }
                        ?>
                        <li><a href="<?php echo base_url(); ?>web/logout"><i class="fa fa-power-off" aria-hidden="true"></i> &nbsp;Logout </a></li>
                    </ul>
                </li>

            </ul>

        </div><!-- /.navbar-collapse -->

        <!-- mobile menu starts here -->
        <div class="formobile">
            <ul class="menu">

                <?php
                $i = 0;
                foreach ($data as $mod) {
                    $module = ucfirst($mod['Module']); ?>
                <li>
                    <a href="#">
                        <?php if (
                            $module == 'Academic'
                        ) { ?> <i class="fa fa-graduation-cap" aria-hidden="true"></i> <?php } elseif (
                            $module == 'Professional'
                        ) { ?> <i class="fa fa-briefcase" aria-hidden="true"></i> <?php } elseif (
                            $module == 'Personal'
                        ) { ?> <i class="fa fa-user" aria-hidden="true"></i> <?php } elseif (
                            $module == 'Health'
                        ) { ?> <i class="fa fa-stethoscope" aria-hidden="true"></i> <?php } elseif (
                            $module == 'Financial'
                        ) { ?> <i class="fa fa-bar-chart" aria-hidden="true"></i> <?php } elseif (
                            $module == 'Legal'
                        ) { ?> <i class="fa fa-gavel" aria-hidden="true"></i> <?php } ?>
                        <h6><?= $module ?></h6>
                    </a>
                    <ul>
                        <?php foreach ((array) $submod as $nav) {
                            if ($mod['Module'] == $nav['Module']) {

                                $module = $nav['Module'];
                                if (lcfirst($module) == 'health') {
                                    $module = 'medical';
                                }
                                ?>
                        <li>
                            <span href="#" onclick="getVal('<?= $nav[
                                'RecordTypeId'
                            ] ?>','<?= strtolower($module) ?>')">
                                <?= $nav[
                                    'Setting'
                                ] ?> <b title="No of files" id="">(<?= $rec_count[
     $i
 ] ?>)</b>
                            </span>
                            <input type="hidden" id="recordTypeId<?= $nav[
                                'RecordTypeId'
                            ] ?>" value="<?= $rec_count[$i] ?>">
                            <span href="#" title="New Record" class="icon" onclick="getNew('<?= $nav[
                                'RecordTypeId'
                            ] ?>','<?= strtolower($module) ?>')">
                                <i class="fa fa-plus-square" aria-hidden="true"></i>
                            </span> <span href="#" class="icon" style='margin-right:60px' onclick="getFolder('<?= $nav[
                                'RecordTypeId'
                            ] ?>','<?= $nav[
    'Setting'
] ?>','<?= $module ?>')"><i class="fa fa-folder " aria-hidden="true"></i></span>
                            <script> </script>
                        </li>
                        <?php $i++;
                            }
                        } ?>
                    </ul>
                </li>
                <?php
                }
                ?>

                <!--<li >
          <a href="#" ><span class="visible-xs"><i class="fa fa-cog"></i> Settings <span class="caret"></span> </span> <i class="fa fa-cog fa-2x hidden-xs"></i><span class="caret hidden-xs"></span> </a>
          <ul >
          <li><a href = "#"><i class="fa fa-user" aria-hidden="true"></i> &nbsp;Account Summary </a></li>
          <li><a href="#"><i class="fa fa-user-plus"></i> Invite a Friend </a></li>
          <li><a href = "#"><i class="fa fa-bell" aria-hidden="true"></i> &nbsp;Alerts </a></li>
          <li><a href="logout"><i class="fa fa-power-off" aria-hidden="true"></i> &nbsp;Logout </a></li>
          </ul>
        </li>-->
            </ul>

        </div><!-- mobile nav menu end -->
    </div><!-- /.container-fluid -->
</nav>


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <form action"" method="post" class="commentsform">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <img src="" id="modal_img" style="width:100%">
                </div>
                <div class="form-group ">
                    <textarea class="form-control" placeholder="Please write your comments..." style="width: 92%;margin: 1.5%;"></textarea>
                </div>
                <input type="submit" class="btn btn-primary col-md-offset-6 postbutton" value="POST" style="margin-bottom:1%">
            </div>
        </form>
    </div>
</div>